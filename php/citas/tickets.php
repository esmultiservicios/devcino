<?php
session_start();
ob_start();

include "../funtions.php";

set_include_path('../../fpdf/font');
require('../../fpdf/fpdf.php');

$mysqli = connect_mysqli();

/*
|--------------------------------------------------------------------------
| CONVERTIR TEXTO PARA FPDF
|--------------------------------------------------------------------------
| FPDF con fuentes estándar no trabaja directamente con UTF-8.
| utf8_decode() está obsoleto desde PHP 8.2, por eso usamos iconv().
*/
function texto_pdf($texto) {
    $texto = (string)$texto;

    if ($texto === '') {
        return '';
    }

    if (function_exists('iconv')) {
        $convertido = @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $texto);

        if ($convertido !== false) {
            return $convertido;
        }
    }

    if (function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($texto, 'Windows-1252', 'UTF-8');
    }

    return $texto;
}

function ejecutar_consulta($mysqli, $sql, $tipos = '', $parametros = array()) {
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        throw new Exception('Error preparando la consulta: ' . $mysqli->error);
    }

    if ($tipos !== '' && count($parametros) > 0) {
        $referencias = array($tipos);

        foreach ($parametros as $indice => $valor) {
            $referencias[] = &$parametros[$indice];
        }

        if (!call_user_func_array(array($stmt, 'bind_param'), $referencias)) {
            $mensaje = $stmt->error;
            $stmt->close();
            throw new Exception('Error vinculando parámetros: ' . $mensaje);
        }
    }

    if (!$stmt->execute()) {
        $mensaje = $stmt->error;
        $stmt->close();
        throw new Exception('Error ejecutando la consulta: ' . $mensaje);
    }

    return $stmt;
}

try {
    /*
    |--------------------------------------------------------------------------
    | VALIDAR DATOS DE ENTRADA
    |--------------------------------------------------------------------------
    */
    $agenda_id = isset($_GET['agenda_id']) ? (int)$_GET['agenda_id'] : 0;

    if ($agenda_id <= 0) {
        throw new Exception('No se recibió una cita válida');
    }

    if (
        !isset($_SESSION['colaborador_id']) ||
        (int)$_SESSION['colaborador_id'] <= 0
    ) {
        throw new Exception('La sesión ha expirado');
    }

    $usuario_sesion = (int)$_SESSION['colaborador_id'];

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR AGENDA
    |--------------------------------------------------------------------------
    */
    $stmtAgenda = ejecutar_consulta(
        $mysqli,
        "SELECT
            usuario,
            DATE_FORMAT(CAST(fecha_cita AS DATE), '%d/%m/%Y') AS fecha_cita,
            CAST(fecha_cita AS DATE) AS fecha1,
            hora,
            DATE_FORMAT(fecha_registro, '%d/%m/%Y %h:%i:%s %p') AS fecha_registro,
            pacientes_id,
            colaborador_id,
            expediente,
            servicio_id,
            reprogramo
         FROM agenda
         WHERE agenda_id = ?
         LIMIT 1",
        "i",
        array($agenda_id)
    );

    $resultAgenda = $stmtAgenda->get_result();

    if ($resultAgenda->num_rows === 0) {
        $stmtAgenda->close();
        throw new Exception('No se encontró la cita indicada');
    }

    $agenda = $resultAgenda->fetch_assoc();
    $stmtAgenda->close();

    $pacientes_id = isset($agenda['pacientes_id']) ? (int)$agenda['pacientes_id'] : 0;
    $colaborador_id = isset($agenda['colaborador_id']) ? (int)$agenda['colaborador_id'] : 0;
    $expediente = isset($agenda['expediente']) ? (int)$agenda['expediente'] : 0;
    $servicio_id = isset($agenda['servicio_id']) ? (int)$agenda['servicio_id'] : 0;
    $usuario_sistema = isset($agenda['usuario']) ? (int)$agenda['usuario'] : 0;
    $fecha_registro = isset($agenda['fecha_registro']) ? $agenda['fecha_registro'] : '';
    $reprogramo = isset($agenda['reprogramo']) ? (int)$agenda['reprogramo'] : 0;
    $fecha_cita = isset($agenda['fecha_cita']) ? $agenda['fecha_cita'] : '';
    $hora_cita = isset($agenda['hora']) ? $agenda['hora'] : '';

    $reprogramo_cita = $reprogramo === 1 ? '(Reprogramación)' : '';
    $exp = $expediente === 0 ? 'TEMP' : $expediente;

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR EMPRESA
    |--------------------------------------------------------------------------
    */
    $stmtEmpresa = ejecutar_consulta(
        $mysqli,
        "SELECT
            e.telefono,
            e.celular,
            e.correo,
            e.eslogan,
            e.horario
         FROM users AS u
         INNER JOIN empresa AS e
            ON u.empresa_id = e.empresa_id
         WHERE u.colaborador_id = ?
         LIMIT 1",
        "i",
        array($usuario_sesion)
    );

    $resultEmpresa = $stmtEmpresa->get_result();
    $empresa = $resultEmpresa->num_rows > 0
        ? $resultEmpresa->fetch_assoc()
        : array();

    $stmtEmpresa->close();

    $telefono = isset($empresa['telefono']) ? $empresa['telefono'] : '';
    $celular = isset($empresa['celular']) ? $empresa['celular'] : '';
    $correo = isset($empresa['correo']) ? $empresa['correo'] : '';
    $horario = isset($empresa['horario']) ? $empresa['horario'] : '';
    $eslogan = isset($empresa['eslogan']) ? $empresa['eslogan'] : '';

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR PACIENTE
    |--------------------------------------------------------------------------
    */
    $stmtPaciente = ejecutar_consulta(
        $mysqli,
        "SELECT
            CONCAT(nombre, ' ', apellido) AS nombre,
            identidad
         FROM pacientes
         WHERE pacientes_id = ?
         LIMIT 1",
        "i",
        array($pacientes_id)
    );

    $resultPaciente = $stmtPaciente->get_result();
    $paciente = $resultPaciente->num_rows > 0
        ? $resultPaciente->fetch_assoc()
        : array();

    $stmtPaciente->close();

    $nombre_usuario = isset($paciente['nombre']) ? $paciente['nombre'] : '';
    $identidad_usuario = isset($paciente['identidad']) ? $paciente['identidad'] : '';

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR PROFESIONAL
    |--------------------------------------------------------------------------
    */
    $stmtMedico = ejecutar_consulta(
        $mysqli,
        "SELECT
            CONCAT(nombre, ' ', apellido) AS nombre,
            puesto_id
         FROM colaboradores
         WHERE colaborador_id = ?
         LIMIT 1",
        "i",
        array($colaborador_id)
    );

    $resultMedico = $stmtMedico->get_result();
    $medico = $resultMedico->num_rows > 0
        ? $resultMedico->fetch_assoc()
        : array();

    $stmtMedico->close();

    $puesto_id = isset($medico['puesto_id']) ? (int)$medico['puesto_id'] : 0;
    $nombre_medico = isset($medico['nombre']) ? $medico['nombre'] : '';

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR PUESTO
    |--------------------------------------------------------------------------
    */
    $puesto = '';
    $consultar_colaborador = 0;

    if ($puesto_id > 0) {
        $stmtPuesto = ejecutar_consulta(
            $mysqli,
            "SELECT nombre, puesto_id
             FROM puesto_colaboradores
             WHERE puesto_id = ?
             LIMIT 1",
            "i",
            array($puesto_id)
        );

        $resultPuesto = $stmtPuesto->get_result();

        if ($resultPuesto->num_rows > 0) {
            $filaPuesto = $resultPuesto->fetch_assoc();
            $puesto = isset($filaPuesto['nombre']) ? $filaPuesto['nombre'] : '';
            $consultar_colaborador = isset($filaPuesto['puesto_id'])
                ? (int)$filaPuesto['puesto_id']
                : 0;
        }

        $stmtPuesto->close();
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR SERVICIO
    |--------------------------------------------------------------------------
    */
    $servicio = '';

    if ($servicio_id > 0) {
        $stmtServicio = ejecutar_consulta(
            $mysqli,
            "SELECT nombre
             FROM servicios
             WHERE servicio_id = ?
             LIMIT 1",
            "i",
            array($servicio_id)
        );

        $resultServicio = $stmtServicio->get_result();

        if ($resultServicio->num_rows > 0) {
            $filaServicio = $resultServicio->fetch_assoc();
            $servicio = isset($filaServicio['nombre']) ? $filaServicio['nombre'] : '';
        }

        $stmtServicio->close();
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR USUARIO DEL SISTEMA
    |--------------------------------------------------------------------------
    */
    $usuario_sistema_nombre = '';

    if ($usuario_sistema > 0) {
        $stmtUsuario = ejecutar_consulta(
            $mysqli,
            "SELECT CONCAT(nombre, ' ', apellido) AS nombre
             FROM colaboradores
             WHERE colaborador_id = ?
             LIMIT 1",
            "i",
            array($usuario_sistema)
        );

        $resultUsuario = $stmtUsuario->get_result();

        if ($resultUsuario->num_rows > 0) {
            $filaUsuario = $resultUsuario->fetch_assoc();
            $usuario_sistema_nombre = isset($filaUsuario['nombre'])
                ? $filaUsuario['nombre']
                : '';
        }

        $stmtUsuario->close();
    }

    /*
    |--------------------------------------------------------------------------
    | DETERMINAR TIPO DE CITA
    |--------------------------------------------------------------------------
    */
    $tipo_cita = 'Nuevo';

    if (
        $pacientes_id > 0 &&
        $servicio_id > 0 &&
        $consultar_colaborador > 0
    ) {
        $stmtTipo = ejecutar_consulta(
            $mysqli,
            "SELECT a.agenda_id
             FROM agenda AS a
             INNER JOIN colaboradores AS c
                ON a.colaborador_id = c.colaborador_id
             WHERE a.pacientes_id = ?
               AND a.servicio_id = ?
               AND c.puesto_id = ?
               AND a.status = 1
             LIMIT 1",
            "iii",
            array(
                $pacientes_id,
                $servicio_id,
                $consultar_colaborador
            )
        );

        $resultTipo = $stmtTipo->get_result();

        if ($resultTipo->num_rows > 0) {
            $tipo_cita = 'Subsiguiente';
        }

        $stmtTipo->close();
    }

    $hora = $hora_cita !== ''
        ? date('g:i a', strtotime($hora_cita))
        : '';

    /*
    |--------------------------------------------------------------------------
    | GENERAR PDF
    |--------------------------------------------------------------------------
    */
    $pdf = new FPDF('P', 'mm', array(80, 170));
    $pdf->SetMargins(6, 0.3, 65);
    $pdf->SetAutoPageBreak(true, 0.5);
    $pdf->AddPage();

    $logo = '../../img/logo.png';

    if (file_exists($logo)) {
        $pdf->Image($logo, 11, 2, 45, 10, 'PNG');
    }

    $pdf->Ln(12);

    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(8, 3, texto_pdf('Cita N°:') . ' ' . $agenda_id, 0);
    $pdf->Ln(1);

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Cell(8, 8, texto_pdf('Fecha Cita: ' . $fecha_cita . ' Hora: ' . $hora), 0);
    $pdf->Ln(1);

    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(8, 14, texto_pdf('Tipo de Cita: ' . $tipo_cita . ' ' . $reprogramo_cita), 0);
    $pdf->Ln(1);

    $pdf->Cell(8, 20, texto_pdf('Nombre: ' . $nombre_usuario), 0);
    $pdf->Ln(1);

    $pdf->Cell(8, 26, texto_pdf('Identidad: ' . $identidad_usuario . '  Exp: ' . $exp), 0);
    $pdf->Ln(1);

    $pdf->Cell(8, 32, texto_pdf('Profesional: ' . $nombre_medico), 0);
    $pdf->Ln(1);

    $pdf->Cell(8, 37, texto_pdf('Servicio: ' . $servicio), 0);
    $pdf->Ln(1);

    $pdf->Cell(8, 43, texto_pdf('Especialidad: ' . $puesto), 0);
    $pdf->Ln(1);

    $pdf->Cell(8, 49, texto_pdf('Usuario: ' . $usuario_sistema_nombre), 0);

    $pdf->Ln(7);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Cell(8, 45, texto_pdf('Nota:'), 0);
    $pdf->Ln(3);

    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(8, 47, texto_pdf('Por favor estar 15 minutos antes de su cita'), 0);
    $pdf->Ln(3);

    $pdf->Cell(8, 49, texto_pdf('Tomando las medidas de bioseguridad'), 0);
    $pdf->Ln(3);

    $pdf->Cell(8, 52, texto_pdf($eslogan), 0);
    $pdf->Ln(3);

    $pdf->SetFont('helvetica', '', 8);
    $pdf->Ln(3);
    $pdf->Cell(8, 97, texto_pdf('__________________________'), 0);
    $pdf->Ln(2);

    $pdf->Cell(8, 99, texto_pdf('Firma y Sello'), 0);
    $pdf->Ln(2);

    $pdf->Cell(8, 101, texto_pdf('Nos puede llamar al siguiente número'), 0);
    $pdf->Ln(2);

    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Cell(8, 104, texto_pdf('PBX: ' . $telefono), 0);

    $pdf->Ln(3);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Cell(8, 106, texto_pdf('Fecha Registro: ' . $fecha_registro), 0);

    /*
    |--------------------------------------------------------------------------
    | EVITAR "SOME DATA HAS ALREADY BEEN OUTPUT"
    |--------------------------------------------------------------------------
    | Se limpia cualquier contenido accidental antes de enviar el PDF.
    */
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    $pdf->Output('I', 'Citas.pdf');
    exit;

} catch (Throwable $error) {
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');

    echo 'No se pudo generar el ticket: ' . $error->getMessage();

    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }

    exit;
}