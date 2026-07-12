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

    $atenciones_nutricion_id = post_int("atenciones_nutricion_id");
    $agenda_id = post_int("agenda_id");
    $pacientes_id = post_int("pacientes_id");
    $servicio_id = post_first_int(array("atenciones_servicio_id", "servicio_id"));
    $fecha = post_text("fecha_consulta");
    $edad = post_text("edad_consulta");

    if ($atenciones_nutricion_id <= 0) {
        throw new Exception("No se recibió el código de la atención nutricional");
    }

    if ($pacientes_id <= 0) {
        throw new Exception("No se recibió el paciente");
    }

    if ($servicio_id <= 0) {
        throw new Exception("No se recibió el servicio");
    }

    if ($fecha === "") {
        throw new Exception("Debe completar la fecha de consulta");
    }

    $motivo_consulta = post_text("motivo_consulta");
    $ante_perso = post_text("ante_perso");
    $ante_fam = post_text("ante_fam");
    $alergias = post_text("alergias");
    $adicciones = post_text("adicciones");
    $niveles_estres = post_text("niveles_estres");
    $niveles_actividad_fisica = post_text("niveles_actividad_fisica");
    $intento_perdida_peso = post_text("intento_perdida_peso");
    $antecedentes_quirurgicos = post_text("antecedentes_quirurgicos");
    $observaciones = post_text("observaciones");
    $diagnostico = post_text("diagnostico");
    $indicaciones = post_text("indicaciones");
    $candidato_bariatrica = checkbox_value("candidato_bariatrica", 2);
    $fecha_registro = date("Y-m-d H:i:s");

    $paciente = obtener_paciente($mysqli, $pacientes_id);

    $stmtExiste = ejecutar_stmt(
        $mysqli,
        "SELECT atenciones_nutricion_id
         FROM atenciones_nutricion
         WHERE atenciones_nutricion_id = ?
           AND pacientes_id = ?
         LIMIT 1",
        "ii",
        array($atenciones_nutricion_id, $pacientes_id)
    );

    $resultExiste = $stmtExiste->get_result();

    if ($resultExiste->num_rows === 0) {
        $stmtExiste->close();
        throw new Exception("La atención nutricional indicada no existe");
    }

    $stmtExiste->close();

    $stmt = ejecutar_stmt(
        $mysqli,
        "UPDATE atenciones_nutricion
         SET
            motivo_consulta = ?,
            ante_perso = ?,
            ante_fam = ?,
            alergias = ?,
            adicciones = ?,
            niveles_estres = ?,
            niveles_actividad_fisica = ?,
            intento_perdida_peso = ?,
            antecedentes_quirurgicos = ?,
            observaciones = ?,
            diagnostico = ?,
            indicaciones = ?,
            candidato_bariatrica = ?
         WHERE atenciones_nutricion_id = ?
           AND pacientes_id = ?",
        "ssssssssssssiii",
        array(
            $motivo_consulta,
            $ante_perso,
            $ante_fam,
            $alergias,
            $adicciones,
            $niveles_estres,
            $niveles_actividad_fisica,
            $intento_perdida_peso,
            $antecedentes_quirurgicos,
            $observaciones,
            $diagnostico,
            $indicaciones,
            $candidato_bariatrica,
            $atenciones_nutricion_id,
            $pacientes_id
        )
    );

    $stmt->close();

    guardar_historial(
        $mysqli,
        $pacientes_id,
        $paciente["expediente"],
        "Historia Clinica Nutricion",
        $atenciones_nutricion_id,
        $usuario_sistema,
        $servicio_id,
        $fecha,
        "Se ha modificado la atención nutricional para el paciente: " .
            $paciente["paciente"] . " con identidad n° " . $paciente["identidad"],
        $usuario_sistema,
        $fecha_registro
    );

    $mysqli->close();

    responder(
        "success",
        "Registro modificado correctamente",
        array("atenciones_nutricion_id" => $atenciones_nutricion_id)
    );

} catch (Throwable $error) {
    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }

    responder("error", $error->getMessage());
}
