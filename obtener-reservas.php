<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
$conexion = new mysqli("sql311.infinityfree.com", "if0_38988628", "X8S06qjZrizMoMG", "if0_38988628_db_reservas");

if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión a la base de datos"]));
}

$sql = "SELECT FechaEntrada, FechaSalida FROM reservas";
$resultado = $conexion->query($sql);

$reservas = [];

while ($fila = $resultado->fetch_assoc()) {
    $reservas[] = $fila;
}

echo json_encode($reservas);

$conexion->close();
?>