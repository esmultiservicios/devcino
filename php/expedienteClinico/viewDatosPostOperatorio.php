<?php
session_start();
include "../funtions.php";

header('Content-Type: application/json; charset=utf-8');

$mysqli = connect_mysqli();

$pacientes_id = isset($_POST['pacientes_id']) ? (int)$_POST['pacientes_id'] : 0;
$arreglo = array();

if ($pacientes_id <= 0) {
    echo json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    $mysqli->close();
    exit;
}

$sql = "SELECT post.*
        FROM postoperacion AS post
        WHERE post.pacientes_id = ?
        ORDER BY post.fecha DESC";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    $mysqli->close();
    exit;
}

$stmt->bind_param("i", $pacientes_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $arreglo[] = $row;
}

echo json_encode($arreglo, JSON_UNESCAPED_UNICODE);

$stmt->close();
$mysqli->close();
?>