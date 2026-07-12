<?php
session_start();
include "../funtions.php";

header('Content-Type: application/json; charset=utf-8');

$mysqli = connect_mysqli();

$datos = array(
    0 => "Error",
    1 => "No se pudo procesar la solicitud",
    2 => "error",
    3 => "btn-danger",
    4 => "",
    5 => ""
);

try {

    // VALIDAR SESIÓN
    if (
        !isset($_SESSION['colaborador_id']) ||
        $_SESSION['colaborador_id'] === ""
    ) {
        throw new Exception(
            "La sesión ha expirado. Inicie sesión nuevamente"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RECIBIR DATOS
    |--------------------------------------------------------------------------
    | pacientes_id y expediente no vienen del formulario.
    | Se generan más abajo utilizando correlativo().
    */

    $nombre = isset($_POST['name'])
        ? trim($_POST['name'])
        : "";

    $apellido = isset($_POST['lastname'])
        ? trim($_POST['lastname'])
        : "";

    $sexo = isset($_POST['sexo'])
        ? trim($_POST['sexo'])
        : "";

    $telefono1 = isset($_POST['telefono1'])
        ? trim($_POST['telefono1'])
        : "";

    $telefono2 = isset($_POST['telefono2'])
        ? trim($_POST['telefono2'])
        : "";

    $fecha_nacimiento = isset($_POST['fecha_nac'])
        ? trim($_POST['fecha_nac'])
        : "";

    $correo = isset($_POST['correo'])
        ? trim($_POST['correo'])
        : "";

    $identidad = isset($_POST['identidad'])
        ? trim($_POST['identidad'])
        : "";

    $pais_id = (
        isset($_POST['pais_id']) &&
        $_POST['pais_id'] !== ""
    )
        ? intval($_POST['pais_id'])
        : 0;

    $departamento_id = (
        isset($_POST['departamento_id']) &&
        $_POST['departamento_id'] !== ""
    )
        ? intval($_POST['departamento_id'])
        : 0;

    $municipio_id = (
        isset($_POST['municipio_id']) &&
        $_POST['municipio_id'] !== ""
    )
        ? intval($_POST['municipio_id'])
        : 0;

    $profesion_id = (
        isset($_POST['profesion_pacientes']) &&
        $_POST['profesion_pacientes'] !== ""
    )
        ? intval($_POST['profesion_pacientes'])
        : 0;

    $responsable_id = (
        isset($_POST['responsable_id']) &&
        $_POST['responsable_id'] !== ""
    )
        ? intval($_POST['responsable_id'])
        : 0;

    $responsable = isset($_POST['responsable'])
        ? trim($_POST['responsable'])
        : "";

    /*
    |--------------------------------------------------------------------------
    | El input del formulario se llama "referido".
    | En la tabla pacientes la columna se llama "referidopor".
    |--------------------------------------------------------------------------
    */
    $referidopor = isset($_POST['referido'])
        ? trim($_POST['referido'])
        : "";

    $localidad = isset($_POST['direccion'])
        ? trim($_POST['direccion'])
        : "";

    /*
    |--------------------------------------------------------------------------
    | VALIDACIONES
    |--------------------------------------------------------------------------
    */

    if ($nombre === "") {
        throw new Exception(
            "Debe ingresar el nombre del paciente"
        );
    }

    if ($apellido === "") {
        throw new Exception(
            "Debe ingresar el apellido del paciente"
        );
    }

    if ($identidad === "") {
        throw new Exception(
            "Debe ingresar el RTN o identidad del paciente"
        );
    }

    if ($fecha_nacimiento === "") {
        throw new Exception(
            "Debe ingresar la fecha de nacimiento"
        );
    }

    if ($telefono1 === "") {
        throw new Exception(
            "Debe ingresar el teléfono principal"
        );
    }

    if ($sexo === "") {
        throw new Exception(
            "Debe seleccionar el sexo del paciente"
        );
    }

    if ($localidad === "") {
        throw new Exception(
            "Debe ingresar la dirección del paciente"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR LONGITUD SEGÚN LA TABLA
    |--------------------------------------------------------------------------
    */

    if (strlen($identidad) > 15) {
        throw new Exception(
            "La identidad no puede contener más de 15 caracteres"
        );
    }

    if (strlen($nombre) > 30) {
        throw new Exception(
            "El nombre no puede contener más de 30 caracteres"
        );
    }

    if (strlen($apellido) > 30) {
        throw new Exception(
            "El apellido no puede contener más de 30 caracteres"
        );
    }

    if (strlen($telefono1) > 8) {
        throw new Exception(
            "El teléfono principal no puede contener más de 8 caracteres"
        );
    }

    if (strlen($telefono2) > 8) {
        throw new Exception(
            "El teléfono secundario no puede contener más de 8 caracteres"
        );
    }

    if (strlen($correo) > 70) {
        throw new Exception(
            "El correo no puede contener más de 70 caracteres"
        );
    }

    if (strlen($localidad) > 250) {
        throw new Exception(
            "La dirección no puede contener más de 250 caracteres"
        );
    }

    if (strlen($responsable) > 70) {
        throw new Exception(
            "El responsable no puede contener más de 70 caracteres"
        );
    }

    if (strlen($referidopor) > 100) {
        throw new Exception(
            "El campo referido por no puede contener más de 100 caracteres"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALORES DEL SISTEMA
    |--------------------------------------------------------------------------
    */

    $fecha = date("Y-m-d");
    $religion_id = 0;
    $estado_civil = 0;
    $usuario = intval($_SESSION['colaborador_id']);
    $estado = 1;
    $fecha_registro = date("Y-m-d H:i:s");

    /*
    |--------------------------------------------------------------------------
    | VERIFICAR SI EL PACIENTE YA EXISTE
    |--------------------------------------------------------------------------
    */

    $select = $mysqli->prepare(
        "SELECT pacientes_id
         FROM pacientes
         WHERE identidad = ?
           AND nombre = ?
           AND apellido = ?
           AND telefono1 = ?
         LIMIT 1"
    );

    if (!$select) {
        throw new Exception(
            "No se pudo preparar la consulta del paciente: " .
            $mysqli->error
        );
    }

    $select->bind_param(
        "ssss",
        $identidad,
        $nombre,
        $apellido,
        $telefono1
    );

    if (!$select->execute()) {
        throw new Exception(
            "No se pudo consultar el paciente: " .
            $select->error
        );
    }

    $select->store_result();

    if ($select->num_rows > 0) {

        $select->close();

        $datos = array(
            0 => "Error",
            1 => "Lo sentimos, este registro ya existe y no se puede almacenar",
            2 => "error",
            3 => "btn-danger",
            4 => "",
            5 => ""
        );

        echo json_encode(
            $datos,
            JSON_UNESCAPED_UNICODE
        );

        $mysqli->close();
        exit;
    }

    $select->close();

    /*
    |--------------------------------------------------------------------------
    | GENERAR pacientes_id Y expediente
    |--------------------------------------------------------------------------
    */

    $pacientes_id = intval(
        correlativo(
            'pacientes_id',
            'pacientes'
        )
    );

    $expediente = intval(
        correlativo(
            'expediente',
            'pacientes'
        )
    );

    if ($pacientes_id <= 0) {
        throw new Exception(
            "No se pudo generar el código del paciente"
        );
    }

    if ($expediente <= 0) {
        throw new Exception(
            "No se pudo generar el número de expediente"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INSERTAR PACIENTE
    |--------------------------------------------------------------------------
    | Se utilizan exactamente las columnas de la tabla pacientes.
    */

    $insert = $mysqli->prepare(
        "INSERT INTO pacientes
        (
            pacientes_id,
            expediente,
            identidad,
            nombre,
            apellido,
            genero,
            telefono1,
            telefono2,
            fecha_nacimiento,
            email,
            fecha,
            pais_id,
            departamento_id,
            municipio_id,
            localidad,
            religion_id,
            profesion_id,
            estado_civil,
            responsable,
            responsable_id,
            referidopor,
            usuario,
            estado,
            fecha_registro
        )
        VALUES
        (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )"
    );

    if (!$insert) {
        throw new Exception(
            "No se pudo preparar el registro del paciente: " .
            $mysqli->error
        );
    }

    $insert->bind_param(
        "iisssssssssiiisiiisisiis",
        $pacientes_id,
        $expediente,
        $identidad,
        $nombre,
        $apellido,
        $sexo,
        $telefono1,
        $telefono2,
        $fecha_nacimiento,
        $correo,
        $fecha,
        $pais_id,
        $departamento_id,
        $municipio_id,
        $localidad,
        $religion_id,
        $profesion_id,
        $estado_civil,
        $responsable,
        $responsable_id,
        $referidopor,
        $usuario,
        $estado,
        $fecha_registro
    );

    if (!$insert->execute()) {
        throw new Exception(
            "No se pudo almacenar el paciente: " .
            $insert->error
        );
    }

    $insert->close();

    /*
    |--------------------------------------------------------------------------
    | RESPUESTA DE ÉXITO
    |--------------------------------------------------------------------------
    */

    $datos = array(
        0 => "Almacenado",
        1 => "Registro almacenado correctamente",
        2 => "success",
        3 => "btn-primary",
        4 => "formulario_pacientes",
        5 => "Registro",
        6 => "formPacientes",
        7 => "modal_pacientes"
    );

    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE
    );

    $mysqli->close();
    exit;

} catch (Throwable $e) {

    $datos = array(
        0 => "Error",
        1 => $e->getMessage(),
        2 => "error",
        3 => "btn-danger",
        4 => "",
        5 => ""
    );

    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE
    );

    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }

    exit;
}