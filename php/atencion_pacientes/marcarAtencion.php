<?php
session_start();
include "../funtions.php";

header('Content-Type: application/json; charset=utf-8');

$mysqli = connect_mysqli();

$datos = array(
    0 => 2,
    1 => "",
    2 => "",
    3 => "Error al marcar la atención"
);

try {
    if (!isset($_SESSION['colaborador_id']) || $_SESSION['colaborador_id'] == "") {
        throw new Exception("Sesión expirada o usuario no válido");
    }

    if (!isset($_POST['agenda_id']) || $_POST['agenda_id'] == "") {
        throw new Exception("No se recibió el código de agenda");
    }

    $agenda_id = intval($_POST['agenda_id']);
    $comentario = "";

    if (isset($_POST['comentario'])) {
        $comentario = cleanStringStrtolower($_POST['comentario']);
    }

    $usuario_sistema = intval($_SESSION['colaborador_id']);
    $fecha_registro = date("Y-m-d H:i:s");

    // CONSULTAR DATOS DE LA AGENDA
    $consultar = "SELECT 
            CAST(fecha_cita AS DATE) AS fecha,
            expediente,
            pacientes_id,
            colaborador_id,
            servicio_id,
            status
        FROM agenda 
        WHERE agenda_id = '$agenda_id'
        LIMIT 1";

    $result_agenda = $mysqli->query($consultar);

    if (!$result_agenda) {
        throw new Exception("Error consultando agenda: " . $mysqli->error);
    }

    if ($result_agenda->num_rows == 0) {
        throw new Exception("No se encontró la agenda indicada");
    }

    $consulta_agenda = $result_agenda->fetch_assoc();

    $pacientes_id = intval($consulta_agenda['pacientes_id']);
    $colaborador_id = intval($consulta_agenda['colaborador_id']);
    $servicio_id = intval($consulta_agenda['servicio_id']);
    $expediente = intval($consulta_agenda['expediente']);
    $fecha = $consulta_agenda['fecha'];
    $status_actual = intval($consulta_agenda['status']);

    // Si ya estaba atendida, no lo tratamos como error.
    // Esto evita el mensaje "Esta atención ya no está pendiente" cuando se trabaja desde Pacientes.
    if ($status_actual == 1) {
        $datos = array(
            0 => 1,
            1 => "AtencionMedica",
            2 => $agenda_id,
            3 => "La atención ya estaba marcada correctamente"
        );

        echo json_encode($datos);
        $mysqli->close();
        exit;
    }

    // Si está como ausencia o eliminada, sí se detiene para no cambiar estados delicados.
    if ($status_actual == 2) {
        $datos = array(
            0 => 3,
            1 => "",
            2 => "",
            3 => "Esta cita está marcada como ausencia, no se puede marcar como atención culminada"
        );

        echo json_encode($datos);
        $mysqli->close();
        exit;
    }

    if ($status_actual == 4) {
        $datos = array(
            0 => 3,
            1 => "",
            2 => "",
            3 => "Esta cita está eliminada, no se puede marcar como atención culminada"
        );

        echo json_encode($datos);
        $mysqli->close();
        exit;
    }

    // CONSULTAR DATOS DEL PACIENTE
    $consulta_paciente = "SELECT 
            expediente,
            identidad,
            usuario,
            nombre,
            apellido,
            fecha_nacimiento,
            telefono1,
            telefono2,
            genero,
            localidad,
            departamento_id,
            municipio_id,
            email,
            estado
        FROM pacientes 
        WHERE pacientes_id = '$pacientes_id'
        LIMIT 1";

    $result_paciente = $mysqli->query($consulta_paciente);

    if (!$result_paciente) {
        throw new Exception("Error consultando paciente: " . $mysqli->error);
    }

    if ($result_paciente->num_rows == 0) {
        throw new Exception("No se encontró el paciente de esta agenda");
    }

    $consulta_paciente2 = $result_paciente->fetch_assoc();

    $expediente = intval($consulta_paciente2['expediente']);
    $nombre = $consulta_paciente2['nombre'];
    $apellido = $consulta_paciente2['apellido'];

    // MARCAR LA ATENCION
    $update = "UPDATE agenda
        SET status = '1'
        WHERE agenda_id = '$agenda_id'";

    $query_update = $mysqli->query($update);

    if (!$query_update) {
        throw new Exception("Error actualizando agenda: " . $mysqli->error);
    }

    // INGRESAR REGISTRO EN HISTORIAL
    $historial_numero = historial();
    $estado = "Agregar";
    $modulo = "Agenda";

    $observacion = "Se ha marcado la atención para el paciente: $nombre $apellido con el número de agenda $agenda_id. Comentario: $comentario";

    if (strlen($observacion) > 200) {
        $observacion = substr($observacion, 0, 200);
    }

    $insert = "INSERT INTO historial 
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
        VALUES
        (
            '$historial_numero',
            '$pacientes_id',
            '$expediente',
            '$modulo',
            '$agenda_id',
            '$usuario_sistema',
            '$servicio_id',
            '$fecha',
            '$estado',
            '$observacion',
            '$usuario_sistema',
            '$fecha_registro'
        )";

    $query_insert = $mysqli->query($insert);

    if (!$query_insert) {
        throw new Exception("Error insertando historial: " . $mysqli->error);
    }

    $datos = array(
        0 => 1,
        1 => "AtencionMedica",
        2 => $agenda_id,
        3 => "Atención marcada correctamente"
    );

    echo json_encode($datos);

    if (isset($result_agenda)) {
        $result_agenda->free();
    }

    if (isset($result_paciente)) {
        $result_paciente->free();
    }

    $mysqli->close();
    exit;

} catch (Exception $e) {
    $datos = array(
        0 => 2,
        1 => "",
        2 => "",
        3 => $e->getMessage()
    );

    echo json_encode($datos);

    if (isset($result_agenda) && $result_agenda) {
        $result_agenda->free();
    }

    if (isset($result_paciente) && $result_paciente) {
        $result_paciente->free();
    }

    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }

    exit;
}