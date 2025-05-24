<?php
$conexion = new mysqli("sql311.infinityfree.com", "if0_38988628", "X8S06qjZrizMoMG", "if0_38988628_db_reservas");

$fechaInicio = $_POST['fechaInicio'];
$fechaSalida = $_POST['fechaSalida'];

// **1️⃣ Verificar que la fecha de entrada sea anterior a la de salida**
if ($fechaInicio >= $fechaSalida) {
    echo json_encode(["disponible" => false, "mensaje" => "La fecha de entrada debe ser anterior a la fecha de salida."]);
    exit; // Detener la ejecución
}

// **2️⃣ Consultar disponibilidad en la base de datos**
$sql = "SELECT * FROM reservas WHERE FechaEntrada <= '$fechaSalida' AND FechaSalida >= '$fechaInicio'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo json_encode(["disponible" => false, "mensaje" => "Las fechas seleccionadas están ocupadas."]);
} else {
    echo json_encode(["disponible" => true]);
}

$conexion->close();
?>