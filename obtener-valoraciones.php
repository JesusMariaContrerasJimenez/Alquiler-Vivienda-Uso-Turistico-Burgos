<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // ✅ Para permitir acceso desde el navegador
header("Access-Control-Allow-Methods: GET, POST");

$conexion = new mysqli("sql311.infinityfree.com", "if0_38988628", "X8S06qjZrizMoMG", "if0_38988628_db_reservas");
$conexion->set_charset("latin1"); // ✅ Asegurar que los datos se envían correctamente

if ($conexion->connect_error) {
    die(json_encode(["error" => "❌ Error de conexión: " . $conexion->connect_error]));
}

// **Obtener la media y el total de valoraciones**
$limite = isset($_GET["todas"]) ? "" : "LIMIT 3";
$estadisticas = $conexion->query("SELECT AVG(general) AS media, COUNT(id) AS total FROM valoraciones")->fetch_assoc();
$resultado = $conexion->query("SELECT * FROM valoraciones ORDER BY fecha DESC $limite");
$valoraciones = [];

if ($resultado->num_rows > 0) { 
    while ($fila = $resultado->fetch_assoc()) {
        $valoraciones[] = $fila;
    }

    // ✅ Enviar la media y el total junto con las valoraciones
    echo json_encode(["media" => round($estadisticas['media'], 1), "total" => $estadisticas['total'], "valoraciones" => $valoraciones]);
} else {
    echo json_encode(["mensaje" => "⚠ No hay valoraciones disponibles"]);
}

$conexion->close();
?>