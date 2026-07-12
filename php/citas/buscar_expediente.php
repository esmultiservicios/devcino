<?php
session_start();
include "../funtions.php";

header('Content-Type: application/json; charset=utf-8');

$mysqli = connect_mysqli();

/*
|--------------------------------------------------------------------------
| RESPUESTA JSON
|--------------------------------------------------------------------------
| Se conservan las respuestas originales:
| 1 = Profesional ocupado
| 2 = Paciente ocupado
| Array = Datos del paciente y horario
*/
function responder_json($respuesta) {
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

function preparar_y_ejecutar($mysqli, $sql, $tipos = "", $parametros = array()) {
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $mysqli->error);
    }

    if ($tipos !== "" && count($parametros) > 0) {
        $referencias = array($tipos);

        foreach ($parametros as $indice => $valor) {
            $referencias[] = &$parametros[$indice];
        }

        if (!call_user_func_array(array($stmt, "bind_param"), $referencias)) {
            $mensaje = $stmt->error;
            $stmt->close();
            throw new Exception("Error vinculando los parámetros: " . $mensaje);
        }
    }

    if (!$stmt->execute()) {
        $mensaje = $stmt->error;
        $stmt->close();
        throw new Exception("Error ejecutando la consulta: " . $mensaje);
    }

    return $stmt;
}

try {
    /*
    |--------------------------------------------------------------------------
    | RECIBIR Y VALIDAR DATOS
    |--------------------------------------------------------------------------
    */
    $expediente = isset($_POST['expediente'])
        ? trim((string)$_POST['expediente'])
        : "";

    $servicio_id = isset($_POST['servicio_id']) && $_POST['servicio_id'] !== ""
        ? (int)$_POST['servicio_id']
        : 0;

    $colaborador_id = isset($_POST['colaborador_id']) && $_POST['colaborador_id'] !== ""
        ? (int)$_POST['colaborador_id']
        : 0;

    $start = isset($_POST['start'])
        ? trim((string)$_POST['start'])
        : "";

    $end = isset($_POST['end'])
        ? trim((string)$_POST['end'])
        : "";

    if ($expediente === "") {
        responder_json(array(0, "", "", "PacienteNoExiste", $colaborador_id));
    }

    if ($servicio_id <= 0) {
        responder_json(array(0, "", "", "ServicioNoValido", $colaborador_id));
    }

    if ($colaborador_id <= 0) {
        responder_json(array(0, "", "", "ProfesionalNoValido", $colaborador_id));
    }

    if ($start === "" || strtotime($start) === false) {
        responder_json(array(0, "", "", "FechaNoValida", $colaborador_id));
    }

    $fecha_cita = date("Y-m-d", strtotime($start));
    $hora_h = date("H:i", strtotime($start));

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR PUESTO DEL PROFESIONAL
    |--------------------------------------------------------------------------
    */
    $stmtPuesto = preparar_y_ejecutar(
        $mysqli,
        "SELECT puesto_id
         FROM colaboradores
         WHERE colaborador_id = ?
         LIMIT 1",
        "i",
        array($colaborador_id)
    );

    $resultPuesto = $stmtPuesto->get_result();

    if ($resultPuesto->num_rows === 0) {
        $stmtPuesto->close();
        responder_json(array(0, "", "", "ProfesionalNoValido", $colaborador_id));
    }

    $filaPuesto = $resultPuesto->fetch_assoc();
    $puesto_id = isset($filaPuesto['puesto_id'])
        ? (int)$filaPuesto['puesto_id']
        : 0;

    $stmtPuesto->close();

    if ($puesto_id <= 0) {
        responder_json(array(0, "", "", "ProfesionalNoValido", $colaborador_id));
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR PACIENTE
    |--------------------------------------------------------------------------
    */
    $stmtPaciente = preparar_y_ejecutar(
        $mysqli,
        "SELECT
            pacientes_id,
            expediente,
            CONCAT(nombre, ' ', apellido) AS nombre
         FROM pacientes
         WHERE expediente = ?
            OR identidad = ?
         LIMIT 1",
        "ss",
        array($expediente, $expediente)
    );

    $resultPaciente = $stmtPaciente->get_result();

    if ($resultPaciente->num_rows === 0) {
        $stmtPaciente->close();
        responder_json(array(0, "", "", "PacienteNoExiste", $colaborador_id));
    }

    $filaPaciente = $resultPaciente->fetch_assoc();

    $pacientes_id = isset($filaPaciente['pacientes_id'])
        ? (int)$filaPaciente['pacientes_id']
        : 0;

    $paciente_nombre = isset($filaPaciente['nombre'])
        ? $filaPaciente['nombre']
        : "";

    $stmtPaciente->close();

    if ($pacientes_id <= 0) {
        responder_json(array(0, "", "", "PacienteNoExiste", $colaborador_id));
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR JORNADA DEL PROFESIONAL
    |--------------------------------------------------------------------------
    */
    $stmtJornada = preparar_y_ejecutar(
        $mysqli,
        "SELECT
            j_colaborador_id,
            nuevos,
            subsiguientes
         FROM jornada_colaboradores
         WHERE colaborador_id = ?
         LIMIT 1",
        "i",
        array($colaborador_id)
    );

    $resultJornada = $stmtJornada->get_result();

    if ($resultJornada->num_rows === 0) {
        $stmtJornada->close();
        responder_json(array(
            $pacientes_id,
            $paciente_nombre,
            "",
            "Vacio",
            $colaborador_id
        ));
    }

    $filaJornada = $resultJornada->fetch_assoc();

    $jornada_id = isset($filaJornada['j_colaborador_id'])
        ? (int)$filaJornada['j_colaborador_id']
        : 0;

    $limite_nuevos = isset($filaJornada['nuevos'])
        ? (int)$filaJornada['nuevos']
        : 0;

    $limite_subsiguientes = isset($filaJornada['subsiguientes'])
        ? (int)$filaJornada['subsiguientes']
        : 0;

    $limite_total = $limite_nuevos + $limite_subsiguientes;

    $stmtJornada->close();

    if ($jornada_id <= 0) {
        responder_json(array(
            $pacientes_id,
            $paciente_nombre,
            "",
            "Vacio",
            $colaborador_id
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR QUE EL PROFESIONAL NO TENGA LA HORA OCUPADA
    |--------------------------------------------------------------------------
    */
    $stmtProfesional = preparar_y_ejecutar(
        $mysqli,
        "SELECT agenda_id
         FROM agenda
         WHERE colaborador_id = ?
           AND fecha_cita = ?
           AND status IN (0, 1)
         LIMIT 1",
        "is",
        array($colaborador_id, $start)
    );

    $resultProfesional = $stmtProfesional->get_result();

    if ($resultProfesional->num_rows > 0) {
        $stmtProfesional->close();
        responder_json(1);
    }

    $stmtProfesional->close();

    /*
    |--------------------------------------------------------------------------
    | VALIDAR QUE EL PACIENTE NO TENGA LA HORA OCUPADA
    |--------------------------------------------------------------------------
    */
    $stmtPacienteHora = preparar_y_ejecutar(
        $mysqli,
        "SELECT agenda_id
         FROM agenda
         WHERE pacientes_id = ?
           AND fecha_cita = ?
           AND status IN (0, 1)
         LIMIT 1",
        "is",
        array($pacientes_id, $start)
    );

    $resultPacienteHora = $stmtPacienteHora->get_result();

    if ($resultPacienteHora->num_rows > 0) {
        $stmtPacienteHora->close();
        responder_json(2);
    }

    $stmtPacienteHora->close();

    /*
    |--------------------------------------------------------------------------
    | DETERMINAR SI EL PACIENTE ES NUEVO O SUBSIGUIENTE
    |--------------------------------------------------------------------------
    */
    $stmtAgendaAnterior = preparar_y_ejecutar(
        $mysqli,
        "SELECT a.agenda_id
         FROM agenda AS a
         INNER JOIN colaboradores AS c
            ON a.colaborador_id = c.colaborador_id
         WHERE a.pacientes_id = ?
           AND c.puesto_id = ?
           AND a.status = 1
         ORDER BY a.fecha_cita DESC, a.agenda_id DESC
         LIMIT 1",
        "ii",
        array($pacientes_id, $puesto_id)
    );

    $resultAgendaAnterior = $stmtAgendaAnterior->get_result();

    $agenda_anterior_id = 0;
    $es_subsiguiente = false;

    if ($resultAgendaAnterior->num_rows > 0) {
        $filaAgendaAnterior = $resultAgendaAnterior->fetch_assoc();

        $agenda_anterior_id = isset($filaAgendaAnterior['agenda_id'])
            ? (int)$filaAgendaAnterior['agenda_id']
            : 0;

        $es_subsiguiente = $agenda_anterior_id > 0;
    }

    $stmtAgendaAnterior->close();

    /*
    |--------------------------------------------------------------------------
    | CONTAR PACIENTES NUEVOS DEL DÍA
    |--------------------------------------------------------------------------
    */
    $stmtNuevos = preparar_y_ejecutar(
        $mysqli,
        "SELECT COUNT(agenda_id) AS total_nuevos
         FROM agenda
         WHERE CAST(fecha_cita AS DATE) = ?
           AND colaborador_id = ?
           AND paciente = 'N'
           AND status = 0",
        "si",
        array($fecha_cita, $colaborador_id)
    );

    $resultNuevos = $stmtNuevos->get_result();
    $filaNuevos = $resultNuevos->fetch_assoc();

    $total_nuevos = isset($filaNuevos['total_nuevos'])
        ? (int)$filaNuevos['total_nuevos']
        : 0;

    $stmtNuevos->close();

    if (!$es_subsiguiente) {
        $total_nuevos++;
    }

    /*
    |--------------------------------------------------------------------------
    | CONTAR PACIENTES SUBSIGUIENTES DEL DÍA
    |--------------------------------------------------------------------------
    */
    $stmtSubsiguientes = preparar_y_ejecutar(
        $mysqli,
        "SELECT COUNT(agenda_id) AS total_subsiguientes
         FROM agenda
         WHERE CAST(fecha_cita AS DATE) = ?
           AND colaborador_id = ?
           AND paciente = 'S'
           AND status IN (0, 1)",
        "si",
        array($fecha_cita, $colaborador_id)
    );

    $resultSubsiguientes = $stmtSubsiguientes->get_result();
    $filaSubsiguientes = $resultSubsiguientes->fetch_assoc();

    $total_subsiguientes = isset($filaSubsiguientes['total_subsiguientes'])
        ? (int)$filaSubsiguientes['total_subsiguientes']
        : 0;

    $stmtSubsiguientes->close();

    if ($es_subsiguiente) {
        $total_subsiguientes++;
    }

    /*
    |--------------------------------------------------------------------------
    | EVALUAR HORARIO
    |--------------------------------------------------------------------------
    */
    $valores = getAgendatime(
        $jornada_id,
        $servicio_id,
        $puesto_id,
        $agenda_anterior_id,
        $hora_h,
        $total_nuevos,
        $limite_nuevos,
        $limite_total,
        $total_subsiguientes
    );

    $hora = is_array($valores) && isset($valores['hora'])
        ? $valores['hora']
        : "NulaSError";

    $color = is_array($valores) && isset($valores['colores'])
        ? $valores['colores']
        : "";

    responder_json(array(
        $pacientes_id,
        $paciente_nombre,
        $color,
        $hora,
        $colaborador_id
    ));

} catch (Throwable $error) {
    http_response_code(500);

    responder_json(array(
        0,
        "",
        "",
        "ErrorServidor",
        0,
        $error->getMessage()
    ));
} finally {
    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }
}