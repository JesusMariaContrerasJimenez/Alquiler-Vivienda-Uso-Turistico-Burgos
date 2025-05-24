<?php
header('Content-Type: application/json');
$conexion = new mysqli("sql311.infinityfree.com", "if0_38988628", "X8S06qjZrizMoMG", "if0_38988628_db_reservas");

if ($conexion->connect_error) {
    die(json_encode(["success" => false, "error" => "Error de conexión: " . $conexion->connect_error]));
}

// **1️⃣ Recibir datos del formulario**
$dni = $_POST['dni'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$numPersonas = $_POST['numPersonas'] ?? 1;
$fechaEntrada = $_POST['fechaEntrada'] ?? '';
$fechaSalida = $_POST['fechaSalida'] ?? '';
$opcionSeleccionada = $_POST['opcionSeleccionada'] ?? '';
$total = $_POST['precioTotal'] ?? 0;

// **2️⃣ Validar que los datos estén completos**
if (empty($dni) || empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($fechaEntrada) || empty($fechaSalida) || empty($opcionSeleccionada)) {
    die(json_encode(["success" => false, "error" => "⚠️ Todos los campos son obligatorios"]));
}

// **3️⃣ Insertar reserva en la base de datos**
$sql = "INSERT INTO reservas (DNI, Nombre, Apellidos, Email, Teléfono, NumPersonas, FechaEntrada, FechaSalida, Opcion, Total)
        VALUES ('$dni', '$nombre', '$apellidos', '$email', '$telefono', $numPersonas, '$fechaEntrada', '$fechaSalida', '$opcionSeleccionada', $total)";

if ($conexion->query($sql) === TRUE) {
    // **4️⃣ Marcar fechas como ocupadas en el calendario**
    $sql_calendario = "UPDATE calendario SET Estado = 'ocupado' WHERE Fecha >= '$fechaEntrada' AND Fecha <= '$fechaSalida'";
    $conexion->query($sql_calendario);

    echo json_encode(["success" => true, "mensaje" => "✅ Reserva registrada correctamente"]);
} else {
    echo json_encode(["success" => false, "error" => "❌ Error al guardar la reserva: " . $conexion->error]);
}

$conexion->close();
?>