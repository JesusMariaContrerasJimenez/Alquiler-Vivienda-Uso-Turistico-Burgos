<?php
header("Content-Type: application/json");
$conexion = new mysqli("sql311.infinityfree.com", "if0_38988628", "X8S06qjZrizMoMG", "if0_38988628_db_reservas");

if ($conexion->connect_error) {
    die(json_encode(["success" => false, "error" => $conexion->connect_error]));
}

$stmt = $conexion->prepare("INSERT INTO valoraciones (nombre, general, limpieza, veracidad, llegada, comunicacion, ubicacion, calidad, comentario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siiiiiiis", $_POST["nombre"], $_POST["general"], $_POST["limpieza"], $_POST["veracidad"], $_POST["llegada"], $_POST["comunicacion"], $_POST["ubicacion"], $_POST["calidad"], $_POST["comentario"]);

echo json_encode(["success" => $stmt->execute()]);
$stmt->close();
$conexion->close();
?>