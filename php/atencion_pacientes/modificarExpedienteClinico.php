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
    $servicio_id = post_first_int(array("servicio_id", "atenciones_servicio_id"));
    $clinico_id = post_int("clinico_id");
    $fecha = post_text("fecha");
    $edad = post_text("edad_consulta");

    if ($pacientes_id <= 0) {
        throw new Exception("No se recibió el paciente");
    }

    if ($servicio_id <= 0) {
        throw new Exception("No se recibió el servicio");
    }

    if ($fecha === "") {
        throw new Exception("Debe completar la fecha de registro");
    }

    $inicio_obesidad = post_text("inicio_obesidad");
    $habito_alimenticio = post_text("habito_alimenticio");
    $tipo_obesidad = post_text("tipo_obesidad");
    $intentos_perdida_peso = post_text("intentos_perdida_peso");
    $peso_maximo_alcansado = post_text("peso_maximo_alcanzado");
    $peso_maximo_alcansado_kg = post_text("peso_maximo_alcanzado_kg");
    $sedentarismo = post_text("sedentarismo");
    $ejercicio = checkbox_value("ejercicio_activo", 2);
    $ejercicio_respuesta = post_text("ejercicio_respuesta");
    $alergias = checkbox_value("alergias_activo", 2);
    $respuesta_alergias = post_text("alergias_respuesta");
    $erge = checkbox_value("erge_activo", 2);
    $respuesta_erge = post_text("erge_respuesta");
    $hta = checkbox_value("hta_activo", 2);
    $respuesta_hta = post_text("hta_respuesta");
    $dislipidemia = checkbox_value("dislipidemia_activo", 2);
    $respuesta_dislipidemia = post_text("dislipidemia_respuesta");
    $higado_graso = checkbox_value("higado_graso_activo", 2);
    $respuesta_higado_graso = post_text("higado_graso_respuesta");
    $saos = checkbox_value("saos_activo", 2);
    $respuesta_saos = post_text("saos_respuesta");
    $hipotiroidismo = checkbox_value("hipotiroidismo_activo", 2);
    $respuesta_hipotiroidismo = post_text("hipotiroidismo_respuesta");
    $articulares = checkbox_value("articulares_activo", 2);
    $respuesta_articulares = post_text("articulares_respuesta");
    $ovarios_poliquisticos = checkbox_value("ovarios_poliquisticos_activo", 2);
    $respuesta_ovarios_poliquisticos = post_text("ovarios_respuesta");
    $varices = checkbox_value("varices_activo", 2);
    $respuesta_varices = post_text("varices_respuesta");
    $tabaquismo = checkbox_value("tabaquismo_activo", 2);
    $respuesta_tabaquismo = post_text("tabaquismo_respuesta");
    $alcohol = checkbox_value("alcohol_activo", 2);
    $respuesta_alcohol = post_text("alcohol_respuesta");
    $drogas = checkbox_value("drogas_activo", 2);
    $respuesta_drogas = post_text("drogas_respuesta");
    $ant_fami_diabetes = checkbox_value("antecedentes_fami_diabetes_activo", 2);
    $respuesta_ant_fami_diabetes = post_text("ant_fam_respuesta");
    $ant_fami_obesidad = checkbox_value("antecedentes_fami_Obesidad_activo", 2);
    $respuesta_ant_fami_obesidad = post_text("ant_fam_obecidad_respuesta");
    $ant_fami_cancer_gastrico = checkbox_value("antecedentes_fami_cancer_gastrico_activo", 2);
    $respuesta_ant_fami_cancer_gastrico = post_text("ant_fam_gastrico_respuesta");
    $ant_fami_psiquiatricas = checkbox_value("antecedentes_fami_psiquiatricas_activo", 2);
    $respuesta_respuesta_ant_fami_psiquiatricas = post_text("enf_psiquiatricas_respuesta");
    $ant_dm = checkbox_value("antecedentes_dm_activo", 2);
    $respuesta_ant_dm = post_text("dm_respuesta");
    $otros = post_text("otros");
    $cirugia_abdominal = post_text("cirugia_abdominal_expediente");
    $talla = post_text("talla");
    $peso_ideal = post_text("peso_ideal");
    $peso_ideal_kg = post_text("peso_ideal_kg");
    $peso = post_text("peso");
    $peso_kg = post_text("peso_kg");
    $exceso_peso = post_text("exceso_peso");
    $exceso_peso_kg = post_text("exceso_peso_kg");
    $imc = post_text("imc");
    $diagnostico = post_text("diagnostico");
    $estudios_imagenes = post_text("estudios_imagenes");
    $referencia_a = post_text("referencia_a");
    $recomendaciones = post_text("recomendaciones_quirurgicas");
    $presupuesto = post_text("presupuesto");
    $observaciones = post_text("expe_observaciones");

    $fecha_registro = date("Y-m-d H:i:s");
    $paciente = obtener_paciente($mysqli, $pacientes_id);

    if ($clinico_id <= 0) {
        $stmtBuscar = ejecutar_stmt(
            $mysqli,
            "SELECT clinico_id
             FROM clinico
             WHERE pacientes_id = ?
               AND colaborador_id = ?
               AND servicio_id = ?
             ORDER BY fecha DESC, clinico_id DESC
             LIMIT 1",
            "iii",
            array($pacientes_id, $usuario_sistema, $servicio_id)
        );

        $resultBuscar = $stmtBuscar->get_result();

        if ($resultBuscar->num_rows === 0) {
            $stmtBuscar->close();
            throw new Exception("El expediente clínico no existe");
        }

        $filaBuscar = $resultBuscar->fetch_assoc();
        $clinico_id = (int)$filaBuscar["clinico_id"];
        $stmtBuscar->close();
    }

    $stmt = ejecutar_stmt(
        $mysqli,
        "UPDATE clinico
         SET
            inicio_obesidad = ?,
            habito_alimenticio = ?,
            tipo_obesidad = ?,
            intentos_perdida_peso = ?,
            peso_maximo_alcansado = ?,
            peso_maximo_alcansado_kg = ?,
            sedentarismo = ?,
            ejercicio = ?,
            ejercicio_respuesta = ?,
            alergias = ?,
            respuesta_alergias = ?,
            erge = ?,
            respuesta_erge = ?,
            hta = ?,
            respuesta_hta = ?,
            dislipidemia = ?,
            respuesta_dislipidemia = ?,
            higado_graso = ?,
            respuesta_higado_graso = ?,
            saos = ?,
            respuesta_saos = ?,
            hipotiroidismo = ?,
            respuesta_hipotiroidismo = ?,
            articulares = ?,
            respuesta_articulares = ?,
            ovarios_poliquisticos = ?,
            respuesta_ovarios_poliquisticos = ?,
            varices = ?,
            respuesta_varices = ?,
            tabaquismo = ?,
            respuesta_tabaquismo = ?,
            alcohol = ?,
            respuesta_alcohol = ?,
            drogas = ?,
            respuesta_drogas = ?,
            ant_fami_diabetes = ?,
            respuesta_ant_fami_diabetes = ?,
            ant_fami_obesidad = ?,
            respuesta_ant_fami_obesidad = ?,
            ant_fami_cancer_gastrico = ?,
            respuesta_ant_fami_cancer_gastrico = ?,
            ant_fami_psiquiatricas = ?,
            respuesta_respuesta_ant_fami_psiquiatricas = ?,
            ant_dm = ?,
            respuesta_ant_dm = ?,
            otros = ?,
            cirugia_abdominal = ?,
            talla = ?,
            peso_ideal = ?,
            peso_ideal_kg = ?,
            peso = ?,
            peso_kg = ?,
            exceso_peso = ?,
            exceso_peso_kg = ?,
            imc = ?,
            diagnostico = ?,
            estudios_imagenes = ?,
            referencia_a = ?,
            recomendaciones = ?,
            presupuesto = ?,
            observaciones = ?
         WHERE clinico_id = ?
           AND pacientes_id = ?",
        "sssssssisisisisisisisisisisisisisisisisisisisssssssssssssssssii",
        array(
            $inicio_obesidad,
            $habito_alimenticio,
            $tipo_obesidad,
            $intentos_perdida_peso,
            $peso_maximo_alcansado,
            $peso_maximo_alcansado_kg,
            $sedentarismo,
            $ejercicio,
            $ejercicio_respuesta,
            $alergias,
            $respuesta_alergias,
            $erge,
            $respuesta_erge,
            $hta,
            $respuesta_hta,
            $dislipidemia,
            $respuesta_dislipidemia,
            $higado_graso,
            $respuesta_higado_graso,
            $saos,
            $respuesta_saos,
            $hipotiroidismo,
            $respuesta_hipotiroidismo,
            $articulares,
            $respuesta_articulares,
            $ovarios_poliquisticos,
            $respuesta_ovarios_poliquisticos,
            $varices,
            $respuesta_varices,
            $tabaquismo,
            $respuesta_tabaquismo,
            $alcohol,
            $respuesta_alcohol,
            $drogas,
            $respuesta_drogas,
            $ant_fami_diabetes,
            $respuesta_ant_fami_diabetes,
            $ant_fami_obesidad,
            $respuesta_ant_fami_obesidad,
            $ant_fami_cancer_gastrico,
            $respuesta_ant_fami_cancer_gastrico,
            $ant_fami_psiquiatricas,
            $respuesta_respuesta_ant_fami_psiquiatricas,
            $ant_dm,
            $respuesta_ant_dm,
            $otros,
            $cirugia_abdominal,
            $talla,
            $peso_ideal,
            $peso_ideal_kg,
            $peso,
            $peso_kg,
            $exceso_peso,
            $exceso_peso_kg,
            $imc,
            $diagnostico,
            $estudios_imagenes,
            $referencia_a,
            $recomendaciones,
            $presupuesto,
            $observaciones,
            $clinico_id,
            $pacientes_id
        )
    );

    $stmt->close();

    guardar_adjuntos(
        $mysqli,
        "files",
        "clinico_detalles",
        "clinico_detalles_id",
        $clinico_id,
        "ec",
        $paciente["paciente"],
        $fecha_registro
    );

    guardar_historial(
        $mysqli,
        $pacientes_id,
        $paciente["expediente"],
        "Expediente Clinico",
        $clinico_id,
        $usuario_sistema,
        $servicio_id,
        $fecha,
        "Se ha modificado el expediente clínico para el paciente: " .
            $paciente["paciente"] . " NHC: " . $clinico_id,
        $usuario_sistema,
        $fecha_registro
    );

    $mysqli->close();

    responder(
        "success",
        "Registro modificado correctamente",
        array("clinico_id" => $clinico_id)
    );

} catch (Throwable $error) {
    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }

    responder("error", $error->getMessage());
}
