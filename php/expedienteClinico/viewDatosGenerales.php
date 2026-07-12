<?php
session_start();
include "../funtions.php";

header('Content-Type: application/json; charset=utf-8');

$mysqli = connect_mysqli();

$pacientes_id = isset($_POST['pacientes_id']) ? (int)$_POST['pacientes_id'] : 0;

/*
|--------------------------------------------------------------------------
| VALORES PREDETERMINADOS
|--------------------------------------------------------------------------
| Se conserva exactamente el mismo orden del arreglo que espera el JS.
*/
$datos = array_fill(0, 83, "");

$datos[3] = "0 Año, 0 Mes y 0 Día";
$datos[20] = 0;
$datos[22] = 0;
$datos[24] = 0;
$datos[25] = 0;
$datos[26] = 0;
$datos[27] = 0;
$datos[28] = 0;
$datos[29] = 0;
$datos[30] = 0;
$datos[31] = 0;
$datos[32] = 0;
$datos[33] = 0;
$datos[35] = 0;
$datos[37] = 0;
$datos[39] = 0;
$datos[40] = 0;
$datos[41] = 0;
$datos[42] = 0;
$datos[43] = 0;
$datos[63] = 0;
$datos[64] = 0;
$datos[81] = 0;
$datos[82] = 0;

if ($pacientes_id <= 0) {
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    $mysqli->close();
    exit;
}

/*
|--------------------------------------------------------------------------
| CONSULTAR PACIENTE Y SU ÚLTIMO EXPEDIENTE CLÍNICO
|--------------------------------------------------------------------------
| departamentos, municipios y profesión son LEFT JOIN.
| Si el paciente tiene 0 o un catálogo faltante, el paciente igual se muestra.
*/
$sql = "SELECT
            c.*,
            p.expediente,
            p.pacientes_id,
            p.identidad,
            CONCAT(p.nombre, ' ', p.apellido) AS cliente,
            p.telefono1 AS telefono,
            CASE
                WHEN p.genero = 'H' THEN 'Hombre'
                WHEN p.genero = 'M' THEN 'Mujer'
                ELSE ''
            END AS genero,
            p.fecha_nacimiento,
            COALESCE(d.nombre, '') AS departamento,
            COALESCE(m.nombre, '') AS municipio,
            p.localidad,
            COALESCE(pr.nombre, '') AS profesion,
            p.email AS correo,
            p.referidopor AS referido
        FROM pacientes AS p
        LEFT JOIN departamentos AS d
            ON p.departamento_id = d.departamento_id
        LEFT JOIN municipios AS m
            ON p.municipio_id = m.municipio_id
        LEFT JOIN profesion AS pr
            ON p.profesion_id = pr.profesion_id
        LEFT JOIN clinico AS c
            ON c.clinico_id = (
                SELECT c2.clinico_id
                FROM clinico AS c2
                WHERE c2.pacientes_id = p.pacientes_id
                ORDER BY c2.fecha DESC, c2.clinico_id DESC
                LIMIT 1
            )
        WHERE p.pacientes_id = ?
        LIMIT 1";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    $mysqli->close();
    exit;
}

$stmt->bind_param("i", $pacientes_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();

    $fecha_nacimiento = isset($fila['fecha_nacimiento']) ? $fila['fecha_nacimiento'] : "";

    $anos = 0;
    $meses = 0;
    $dias = 0;

    if ($fecha_nacimiento !== "" && $fecha_nacimiento !== "0000-00-00") {
        $edad_calculada = getEdad($fecha_nacimiento);
        $anos = isset($edad_calculada['anos']) ? (int)$edad_calculada['anos'] : 0;
        $meses = isset($edad_calculada['meses']) ? (int)$edad_calculada['meses'] : 0;
        $dias = isset($edad_calculada['dias']) ? (int)$edad_calculada['dias'] : 0;
    }

    $palabra_anos = $anos === 1 ? "Año" : "Años";
    $palabra_meses = $meses === 1 ? "Mes" : "Meses";
    $palabra_dias = $dias === 1 ? "Día" : "Días";

    $datos[0] = $fila['identidad'] ?? "";
    $datos[1] = $fila['cliente'] ?? "";
    $datos[2] = $fecha_nacimiento;
    $datos[3] = $anos." ".$palabra_anos.", ".$meses." ".$palabra_meses." y ".$dias." ".$palabra_dias;
    $datos[4] = $fila['telefono'] ?? "";
    $datos[5] = $fila['departamento'] ?? "";
    $datos[6] = $fila['municipio'] ?? "";
    $datos[7] = $fila['localidad'] ?? "";
    $datos[8] = $fila['profesion'] ?? "";
    $datos[9] = $fila['clinico_id'] ?? "";
    $datos[10] = $fila['correo'] ?? "";
    $datos[11] = $fila['genero'] ?? "";
    $datos[12] = $fila['referido'] ?? "";

    /*
    |--------------------------------------------------------------------------
    | DATOS CLÍNICOS
    |--------------------------------------------------------------------------
    | Solo se asignan si sí existe clinico_id.
    */
    if (!empty($fila['clinico_id'])) {
        $datos[13] = $fila['fecha'] ?? "";
        $datos[14] = $fila['inicio_obesidad'] ?? "";
        $datos[15] = $fila['habito_alimenticio'] ?? "";
        $datos[16] = $fila['tipo_obesidad'] ?? "";
        $datos[17] = $fila['intentos_perdida_peso'] ?? "";
        $datos[18] = $fila['peso_maximo_alcansado'] ?? "";
        $datos[19] = $fila['sedentarismo'] ?? "";
        $datos[20] = isset($fila['ejercicio']) ? (int)$fila['ejercicio'] : 0;
        $datos[21] = $fila['ejercicio_respuesta'] ?? "";
        $datos[22] = isset($fila['alergias']) ? (int)$fila['alergias'] : 0;
        $datos[23] = $fila['respuesta_alergias'] ?? "";
        $datos[24] = isset($fila['erge']) ? (int)$fila['erge'] : 0;
        $datos[25] = isset($fila['hta']) ? (int)$fila['hta'] : 0;
        $datos[26] = isset($fila['dislipidemia']) ? (int)$fila['dislipidemia'] : 0;
        $datos[27] = isset($fila['higado_graso']) ? (int)$fila['higado_graso'] : 0;
        $datos[28] = isset($fila['saos']) ? (int)$fila['saos'] : 0;
        $datos[29] = isset($fila['hipotiroidismo']) ? (int)$fila['hipotiroidismo'] : 0;
        $datos[30] = isset($fila['articulares']) ? (int)$fila['articulares'] : 0;
        $datos[31] = isset($fila['ovarios_poliquisticos']) ? (int)$fila['ovarios_poliquisticos'] : 0;
        $datos[32] = isset($fila['varices']) ? (int)$fila['varices'] : 0;
        $datos[33] = isset($fila['tabaquismo']) ? (int)$fila['tabaquismo'] : 0;
        $datos[34] = $fila['respuesta_tabaquismo'] ?? "";
        $datos[35] = isset($fila['alcohol']) ? (int)$fila['alcohol'] : 0;
        $datos[36] = $fila['respuesta_alcohol'] ?? "";
        $datos[37] = isset($fila['drogas']) ? (int)$fila['drogas'] : 0;
        $datos[38] = $fila['respuesta_drogas'] ?? "";
        $datos[39] = isset($fila['ant_fami_diabetes']) ? (int)$fila['ant_fami_diabetes'] : 0;
        $datos[40] = isset($fila['ant_fami_obesidad']) ? (int)$fila['ant_fami_obesidad'] : 0;
        $datos[41] = isset($fila['ant_fami_cancer_gastrico']) ? (int)$fila['ant_fami_cancer_gastrico'] : 0;
        $datos[42] = isset($fila['ant_fami_psiquiatricas']) ? (int)$fila['ant_fami_psiquiatricas'] : 0;
        $datos[43] = isset($fila['ant_dm']) ? (int)$fila['ant_dm'] : 0;
        $datos[44] = $fila['otros'] ?? "";
        $datos[45] = $fila['cirugia_abdominal'] ?? "";
        $datos[46] = $fila['talla'] ?? "";
        $datos[47] = $fila['peso_ideal'] ?? "";
        $datos[48] = $fila['peso'] ?? "";
        $datos[49] = $fila['exceso_peso'] ?? "";
        $datos[50] = $fila['imc'] ?? "";
        $datos[51] = $fila['diagnostico'] ?? "";
        $datos[52] = $fila['estudios_imagenes'] ?? "";
        $datos[53] = $fila['referencia_a'] ?? "";
        $datos[54] = $fila['recomendaciones'] ?? "";
        $datos[55] = $fila['presupuesto'] ?? "";
        $datos[56] = $fila['paciente'] ?? "";
        $datos[57] = $fila['estado'] ?? "";
        $datos[58] = $fila['fecha_registro'] ?? "";
        $datos[59] = $fila['peso_maximo_alcansado_kg'] ?? "";
        $datos[60] = $fila['peso_ideal_kg'] ?? "";
        $datos[61] = $fila['peso_kg'] ?? "";
        $datos[62] = $fila['exceso_peso_kg'] ?? "";
        $datos[63] = isset($fila['edad']) ? (int)$fila['edad'] : 0;
        $datos[64] = isset($fila['servicio_id']) ? (int)$fila['servicio_id'] : 0;
        $datos[65] = $fila['clinico_id'] ?? "";
        $datos[66] = $fila['observaciones'] ?? "";
        $datos[67] = $fila['respuesta_erge'] ?? "";
        $datos[68] = $fila['respuesta_hta'] ?? "";
        $datos[69] = $fila['respuesta_dislipidemia'] ?? "";
        $datos[70] = $fila['respuesta_higado_graso'] ?? "";
        $datos[71] = $fila['respuesta_hipotiroidismo'] ?? "";
        $datos[72] = $fila['respuesta_articulares'] ?? "";
        $datos[73] = $fila['respuesta_ovarios_poliquisticos'] ?? "";
        $datos[74] = $fila['respuesta_varices'] ?? "";
        $datos[75] = $fila['respuesta_ant_fami_diabetes'] ?? "";
        $datos[76] = $fila['respuesta_ant_fami_obesidad'] ?? "";
        $datos[77] = $fila['respuesta_ant_fami_cancer_gastrico'] ?? "";
        $datos[78] = $fila['respuesta_respuesta_ant_fami_psiquiatricas'] ?? "";
        $datos[79] = $fila['respuesta_ant_dm'] ?? "";
        $datos[80] = $fila['respuesta_saos'] ?? "";
        $datos[81] = isset($fila['colaborador_id']) ? (int)$fila['colaborador_id'] : 0;
        $datos[82] = isset($fila['agenda_id']) ? (int)$fila['agenda_id'] : 0;
    }
}

echo json_encode($datos, JSON_UNESCAPED_UNICODE);

$stmt->close();
$mysqli->close();
?>