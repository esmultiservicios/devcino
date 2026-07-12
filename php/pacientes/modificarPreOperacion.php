<?php
session_start();
include "../funtions.php";

header('Content-Type: application/json; charset=utf-8');

$mysqli = connect_mysqli();

function responder($status, $message, $extra = array()) {
    $base = array(
        "status" => $status,
        "title" => $status === "success" ? "Success" : "Error",
        "message" => $message,
        "type" => $status,
        "buttonClass" => $status === "success" ? "btn-primary" : "btn-danger"
    );

    echo json_encode(array_merge($base, $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

function post_text($key, $default = "") {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

function post_int($key, $default = 0) {
    return isset($_POST[$key]) && $_POST[$key] !== ""
        ? (int)$_POST[$key]
        : (int)$default;
}

function post_first_int($keys, $default = 0) {
    foreach ($keys as $key) {
        if (isset($_POST[$key]) && $_POST[$key] !== "") {
            return (int)$_POST[$key];
        }
    }
    return (int)$default;
}

function checkbox_value($key, $default = 2) {
    return isset($_POST[$key]) && $_POST[$key] !== ""
        ? (int)$_POST[$key]
        : (int)$default;
}

function ejecutar_stmt($mysqli, $sql, $types, $params = array()) {
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error preparando consulta: " . $mysqli->error);
    }

    if ($types !== "" && count($params) > 0) {
        $bind = array($types);

        foreach ($params as $index => $value) {
            $bind[] = &$params[$index];
        }

        if (!call_user_func_array(array($stmt, "bind_param"), $bind)) {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception("Error vinculando parámetros: " . $error);
        }
    }

    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        throw new Exception("Error ejecutando consulta: " . $error);
    }

    return $stmt;
}

function nombre_archivo_seguro($nombre) {
    $nombre = basename((string)$nombre);
    $nombre = preg_replace('/[^A-Za-z0-9._-]/', '_', $nombre);
    $nombre = preg_replace('/_+/', '_', $nombre);
    return trim($nombre, '_');
}

function guardar_adjuntos($mysqli, $input, $tabla, $campo_id, $parent_id, $prefijo, $paciente, $fecha_registro) {
    if (
        !isset($_FILES[$input]) ||
        !isset($_FILES[$input]['name']) ||
        !is_array($_FILES[$input]['name'])
    ) {
        return;
    }

    $total = count($_FILES[$input]['name']);

    for ($i = 0; $i < $total; $i++) {
        if (
            empty($_FILES[$input]['name'][$i]) ||
            empty($_FILES[$input]['tmp_name'][$i]) ||
            (
                isset($_FILES[$input]['error'][$i]) &&
                $_FILES[$input]['error'][$i] !== UPLOAD_ERR_OK
            )
        ) {
            continue;
        }

        $original = nombre_archivo_seguro($_FILES[$input]['name'][$i]);

        if ($original === "") {
            continue;
        }

        $paciente_seguro = nombre_archivo_seguro($paciente);
        $filename = $prefijo . "_" . $paciente_seguro . "_" . $original;
        $path = rtrim($_SERVER["DOCUMENT_ROOT"], "/\\") . PRODUCT_PATH . $filename;

        if (!file_exists($path)) {
            if (!move_uploaded_file($_FILES[$input]["tmp_name"][$i], $path)) {
                throw new Exception("No se pudo guardar el archivo adjunto: " . $original);
            }
        }

        $detalle_id = correlativo($campo_id, $tabla);

        $sql = "INSERT INTO " . $tabla . " VALUES (?, ?, ?, ?)";
        $stmt = ejecutar_stmt(
            $mysqli,
            $sql,
            "iiss",
            array((int)$detalle_id, (int)$parent_id, $filename, $fecha_registro)
        );
        $stmt->close();
    }
}

function obtener_paciente($mysqli, $pacientes_id) {
    $stmt = ejecutar_stmt(
        $mysqli,
        "SELECT expediente, CONCAT(nombre, ' ', apellido) AS paciente, identidad
         FROM pacientes
         WHERE pacientes_id = ?
         LIMIT 1",
        "i",
        array($pacientes_id)
    );

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt->close();
        throw new Exception("No se encontró el paciente");
    }

    $fila = $result->fetch_assoc();
    $stmt->close();

    return $fila;
}

function guardar_historial(
    $mysqli,
    $pacientes_id,
    $expediente,
    $modulo,
    $codigo,
    $colaborador_id,
    $servicio_id,
    $fecha,
    $observacion,
    $usuario,
    $fecha_registro
) {
    $historial_id = historial();
    $estado = "Modificar";

    if (strlen($observacion) > 200) {
        $observacion = substr($observacion, 0, 200);
    }

    $stmt = ejecutar_stmt(
        $mysqli,
        "INSERT INTO historial
        (
            historial_id,
            pacientes_id,
            expediente,
            modulo,
            codigo,
            colaborador_id,
            servicio_id,
            fecha,
            status,
            observacion,
            usuario,
            fecha_registro
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
        "iiisiiisssis",
        array(
            (int)$historial_id,
            (int)$pacientes_id,
            (int)$expediente,
            $modulo,
            (int)$codigo,
            (int)$colaborador_id,
            (int)$servicio_id,
            $fecha,
            $estado,
            $observacion,
            (int)$usuario,
            $fecha_registro
        )
    );

    $stmt->close();
}

try {
    $usuario_sistema = isset($_SESSION['colaborador_id'])
        ? (int)$_SESSION['colaborador_id']
        : 0;

    if ($usuario_sistema <= 0) {
        throw new Exception("Sesión expirada o usuario no válido");
    }

    $agenda_id = post_int("agenda_id");
    $pacientes_id = post_int("pacientes_id");
    $servicio_id = post_first_int(array("servicio_preoperatorio_id", "servicio_id"));
    $preoperacion_id = post_int("preoperacion_id");

    if ($pacientes_id <= 0) {
        throw new Exception("No se recibió el paciente");
    }

    if ($servicio_id <= 0) {
        throw new Exception("No se recibió el servicio");
    }

    $fecha = post_text("pre_fecha");
    $edad = post_text("pre_edad_consulta");
    $talla = post_text("pre_talla");
    $peso_actual = post_text("pre_peso_actual");
    $peso_actual_kg = post_text("pre_peso_actual_kg");
    $peso_perdido = post_text("pre_peso_perdido");
    $imc_actual = post_text("pre_imc_actual");
    $resultados = post_text("pre_resultados_examenes");
    $recomendaciones = post_text("pre_recomendaciones");
    $fecha_cirugia = post_text("pre_fecha_cirugia");
    $tipo_cirugia = post_text("pre_tipo_cirugia");
    $psquiatria = checkbox_value("psiquiatra_activo", 2);
    $psicologia = checkbox_value("psicologo_activo", 2);
    $nutricion = checkbox_value("nutricion_activo", 2);
    $medicina_interna = checkbox_value("medicina_interna_activo", 2);
    $fecha_registro = date("Y-m-d H:i:s");

    if ($fecha === "") {
        throw new Exception("Debe completar la fecha de registro");
    }

    if ($fecha_cirugia === "") {
        throw new Exception("Debe completar la fecha de cirugía");
    }

    if ($tipo_cirugia === "") {
        throw new Exception("Debe completar el tipo de cirugía");
    }

    $paciente = obtener_paciente($mysqli, $pacientes_id);

    if ($preoperacion_id <= 0) {
        $stmtBuscar = ejecutar_stmt(
            $mysqli,
            "SELECT preoperacion_id
             FROM preoperacion
             WHERE pacientes_id = ?
               AND colaborador_id = ?
               AND servicio_id = ?
             ORDER BY fecha DESC, preoperacion_id DESC
             LIMIT 1",
            "iii",
            array($pacientes_id, $usuario_sistema, $servicio_id)
        );

        $resultBuscar = $stmtBuscar->get_result();

        if ($resultBuscar->num_rows === 0) {
            $stmtBuscar->close();
            throw new Exception("El registro preoperatorio no existe");
        }

        $filaBuscar = $resultBuscar->fetch_assoc();
        $preoperacion_id = (int)$filaBuscar["preoperacion_id"];
        $stmtBuscar->close();
    }

    $stmt = ejecutar_stmt(
        $mysqli,
        "UPDATE preoperacion
         SET
            talla = ?,
            peso_actual = ?,
            peso_actual_kg = ?,
            peso_perdido = ?,
            imc_actual = ?,
            resultados = ?,
            psquiatria = ?,
            psicologia = ?,
            nutricion = ?,
            medicina_interna = ?,
            recomendaciones = ?,
            fecha_cirugia = ?,
            tipo_cirugia = ?
         WHERE preoperacion_id = ?
           AND pacientes_id = ?",
        "ssssssiiiisssii",
        array(
            $talla,
            $peso_actual,
            $peso_actual_kg,
            $peso_perdido,
            $imc_actual,
            $resultados,
            $psquiatria,
            $psicologia,
            $nutricion,
            $medicina_interna,
            $recomendaciones,
            $fecha_cirugia,
            $tipo_cirugia,
            $preoperacion_id,
            $pacientes_id
        )
    );

    $stmt->close();

    guardar_historial(
        $mysqli,
        $pacientes_id,
        $paciente["expediente"],
        "Pre Operacion",
        $preoperacion_id,
        $usuario_sistema,
        $servicio_id,
        $fecha,
        "Se ha modificado pre operación para el paciente: " .
            $paciente["paciente"] . " NHC: " . $preoperacion_id,
        $usuario_sistema,
        $fecha_registro
    );

    $mysqli->close();

    responder(
        "success",
        "Registro modificado correctamente",
        array("preoperacion_id" => $preoperacion_id)
    );

} catch (Throwable $error) {
    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }

    responder("error", $error->getMessage());
}
