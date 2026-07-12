<?php
session_start();
include "../funtions.php";

header('Content-Type: application/json; charset=utf-8');

// CONEXIÓN A LA BASE DE DATOS
$mysqli = connect_mysqli();

/*
|--------------------------------------------------------------------------
| RESPUESTA PREDETERMINADA
|--------------------------------------------------------------------------
| Se conserva el mismo formato numérico que espera main.js.
*/
$datos = array(
    0 => "Error",
    1 => "No se pudo procesar la solicitud",
    2 => "error",
    3 => "btn-danger",
    4 => "",
    5 => ""
);

try {

    /*
    |--------------------------------------------------------------------------
    | VALIDAR CONEXIÓN
    |--------------------------------------------------------------------------
    */
    if (!$mysqli) {
        throw new Exception(
            "No se pudo establecer conexión con la base de datos"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR SESIÓN
    |--------------------------------------------------------------------------
    */
    if (
        !isset($_SESSION['colaborador_id']) ||
        $_SESSION['colaborador_id'] === ""
    ) {
        throw new Exception(
            "La sesión ha expirado. Inicie sesión nuevamente"
        );
    }

    $usuario = intval($_SESSION['colaborador_id']);

    if ($usuario <= 0) {
        throw new Exception(
            "El usuario de la sesión no es válido"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RECIBIR IDENTIFICADOR DEL PACIENTE
    |--------------------------------------------------------------------------
    */
    $pacientes_id = (
        isset($_POST['pacientes_id']) &&
        $_POST['pacientes_id'] !== ""
    )
        ? intval($_POST['pacientes_id'])
        : 0;

    if ($pacientes_id <= 0) {
        throw new Exception(
            "No se recibió un código de paciente válido"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RECIBIR DATOS DE TEXTO
    |--------------------------------------------------------------------------
    | No se utiliza cleanString().
    | No se convierten los datos a minúsculas.
    | La consulta preparada protege los valores contra inyección SQL.
    */
    $nombre = isset($_POST['name'])
        ? trim((string) $_POST['name'])
        : "";

    $apellido = isset($_POST['lastname'])
        ? trim((string) $_POST['lastname'])
        : "";

    $sexo = isset($_POST['sexo'])
        ? trim((string) $_POST['sexo'])
        : "";

    $telefono1 = isset($_POST['telefono1'])
        ? trim((string) $_POST['telefono1'])
        : "";

    $telefono2 = isset($_POST['telefono2'])
        ? trim((string) $_POST['telefono2'])
        : "";

    $fecha_nacimiento = isset($_POST['fecha_nac'])
        ? trim((string) $_POST['fecha_nac'])
        : "";

    $correo = isset($_POST['correo'])
        ? trim((string) $_POST['correo'])
        : "";

    $responsable = isset($_POST['responsable'])
        ? trim((string) $_POST['responsable'])
        : "";

    /*
    |--------------------------------------------------------------------------
    | El input del formulario se llama referido.
    | La columna de la tabla pacientes se llama referidopor.
    |--------------------------------------------------------------------------
    */
    $referidopor = isset($_POST['referido'])
        ? trim((string) $_POST['referido'])
        : "";

    $localidad = isset($_POST['direccion'])
        ? trim((string) $_POST['direccion'])
        : "";

    /*
    |--------------------------------------------------------------------------
    | RECIBIR CAMPOS NUMÉRICOS OPCIONALES
    |--------------------------------------------------------------------------
    */
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

    $pais_id = (
        isset($_POST['pais_id']) &&
        $_POST['pais_id'] !== ""
    )
        ? intval($_POST['pais_id'])
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

    /*
    |--------------------------------------------------------------------------
    | VALIDAR CAMPOS OBLIGATORIOS
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

    if ($sexo === "") {
        throw new Exception(
            "Debe seleccionar el sexo del paciente"
        );
    }

    if ($telefono1 === "") {
        throw new Exception(
            "Debe ingresar el teléfono principal"
        );
    }

    if ($fecha_nacimiento === "") {
        throw new Exception(
            "Debe ingresar la fecha de nacimiento"
        );
    }

    if ($localidad === "") {
        throw new Exception(
            "Debe ingresar la dirección del paciente"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR LONGITUDES SEGÚN LA TABLA pacientes
    |--------------------------------------------------------------------------
    */
    if (mb_strlen($nombre, 'UTF-8') > 30) {
        throw new Exception(
            "El nombre no puede contener más de 30 caracteres"
        );
    }

    if (mb_strlen($apellido, 'UTF-8') > 30) {
        throw new Exception(
            "El apellido no puede contener más de 30 caracteres"
        );
    }

    if (mb_strlen($sexo, 'UTF-8') > 1) {
        throw new Exception(
            "El valor seleccionado para sexo no es válido"
        );
    }

    if (mb_strlen($telefono1, 'UTF-8') > 8) {
        throw new Exception(
            "El teléfono principal no puede contener más de 8 caracteres"
        );
    }

    if (mb_strlen($telefono2, 'UTF-8') > 8) {
        throw new Exception(
            "El teléfono secundario no puede contener más de 8 caracteres"
        );
    }

    if (mb_strlen($correo, 'UTF-8') > 70) {
        throw new Exception(
            "El correo no puede contener más de 70 caracteres"
        );
    }

    if (mb_strlen($responsable, 'UTF-8') > 70) {
        throw new Exception(
            "El responsable no puede contener más de 70 caracteres"
        );
    }

    if (mb_strlen($referidopor, 'UTF-8') > 100) {
        throw new Exception(
            "El campo referido por no puede contener más de 100 caracteres"
        );
    }

    if (mb_strlen($localidad, 'UTF-8') > 250) {
        throw new Exception(
            "La dirección no puede contener más de 250 caracteres"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR CORREO SOLO CUANDO FUE INGRESADO
    |--------------------------------------------------------------------------
    */
    if (
        $correo !== "" &&
        !filter_var($correo, FILTER_VALIDATE_EMAIL)
    ) {
        throw new Exception(
            "El formato del correo electrónico no es válido"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR FORMATO DE FECHA
    |--------------------------------------------------------------------------
    */
    $fechaObjeto = DateTime::createFromFormat(
        'Y-m-d',
        $fecha_nacimiento
    );

    $fechaValida = (
        $fechaObjeto !== false &&
        $fechaObjeto->format('Y-m-d') === $fecha_nacimiento
    );

    if (!$fechaValida) {
        throw new Exception(
            "La fecha de nacimiento no tiene un formato válido"
        );
    }

    if ($fecha_nacimiento > date('Y-m-d')) {
        throw new Exception(
            "La fecha de nacimiento no puede ser mayor que la fecha actual"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COMPROBAR QUE EL PACIENTE EXISTA
    |--------------------------------------------------------------------------
    */
    $consultaPaciente = $mysqli->prepare(
        "SELECT pacientes_id
         FROM pacientes
         WHERE pacientes_id = ?
         LIMIT 1"
    );

    if (!$consultaPaciente) {
        throw new Exception(
            "No se pudo preparar la consulta del paciente: " .
            $mysqli->error
        );
    }

    $consultaPaciente->bind_param(
        "i",
        $pacientes_id
    );

    if (!$consultaPaciente->execute()) {
        throw new Exception(
            "No se pudo consultar el paciente: " .
            $consultaPaciente->error
        );
    }

    $consultaPaciente->store_result();

    if ($consultaPaciente->num_rows === 0) {
        $consultaPaciente->close();

        throw new Exception(
            "No se encontró el paciente que intenta modificar"
        );
    }

    $consultaPaciente->close();

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR PACIENTE
    |--------------------------------------------------------------------------
    | Se utilizan exactamente las columnas existentes en la tabla pacientes.
    */
    $update = $mysqli->prepare(
        "UPDATE pacientes
         SET
            nombre = ?,
            apellido = ?,
            genero = ?,
            telefono1 = ?,
            telefono2 = ?,
            email = ?,
            fecha_nacimiento = ?,
            pais_id = ?,
            departamento_id = ?,
            municipio_id = ?,
            responsable = ?,
            responsable_id = ?,
            profesion_id = ?,
            referidopor = ?,
            localidad = ?
         WHERE pacientes_id = ?"
    );

    if (!$update) {
        throw new Exception(
            "No se pudo preparar la modificación del paciente: " .
            $mysqli->error
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Tipos de parámetros
    |--------------------------------------------------------------------------
    | s = string
    | i = integer
    |
    | 7 strings:
    | nombre, apellido, género, teléfono1, teléfono2, correo, fecha
    |
    | 3 enteros:
    | país, departamento, municipio
    |
    | 1 string:
    | responsable
    |
    | 2 enteros:
    | responsable_id, profesion_id
    |
    | 2 strings:
    | referidopor, localidad
    |
    | 1 entero:
    | pacientes_id
    */
    $update->bind_param(
        "sssssssiiisiissi",
        $nombre,
        $apellido,
        $sexo,
        $telefono1,
        $telefono2,
        $correo,
        $fecha_nacimiento,
        $pais_id,
        $departamento_id,
        $municipio_id,
        $responsable,
        $responsable_id,
        $profesion_id,
        $referidopor,
        $localidad,
        $pacientes_id
    );

    if (!$update->execute()) {
        throw new Exception(
            "No se pudo modificar el paciente: " .
            $update->error
        );
    }

    $update->close();

    /*
    |--------------------------------------------------------------------------
    | RESPUESTA DE ÉXITO
    |--------------------------------------------------------------------------
    | Se conserva la respuesta original que utiliza main.js.
    */
    $datos = array(
        0 => "Editado",
        1 => "Registro editado correctamente",
        2 => "success",
        3 => "btn-primary",
        4 => "",
        5 => "Editar",
        6 => "formPacientes",
        7 => "modal_pacientes"
    );

    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE
    );

    $mysqli->close();
    exit;

} catch (Throwable $error) {

    /*
    |--------------------------------------------------------------------------
    | RESPUESTA DE ERROR
    |--------------------------------------------------------------------------
    */
    $datos = array(
        0 => "Error",
        1 => $error->getMessage(),
        2 => "error",
        3 => "btn-danger",
        4 => "",
        5 => ""
    );

    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE
    );

    if (isset($consultaPaciente) && $consultaPaciente) {
        $consultaPaciente->close();
    }

    if (isset($update) && $update) {
        $update->close();
    }

    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }

    exit;
}