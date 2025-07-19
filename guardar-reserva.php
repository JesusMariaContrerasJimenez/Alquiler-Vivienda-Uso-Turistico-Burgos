<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/PHPMailer.php';
require 'vendor/phpmailer/SMTP.php';
require 'vendor/phpmailer/Exception.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conexion = new mysqli("sql311.infinityfree.com", "if0_38988628", "X8S06qjZrizMoMG", "if0_38988628_db_reservas");

if ($conexion->connect_error) {
    die(json_encode(["success" => false, "error" => "Error de conexión: " . $conexion->connect_error]));
}

// **Recibir datos del formulario**
$dni = $_POST['dni'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$numPersonas = $_POST['numPersonas'] ?? 1;
$necesitaCuna = isset($_POST['necesitaCuna']) ? ($_POST['necesitaCuna'] == 1 ? 'Sí' : 'No') : 'No';
$opcionSeleccionada = $_POST['opcionSeleccionada'] ?? '';
$fechaEntrada = $_POST['fechaEntrada'] ?? '';
$fechaSalida = $_POST['fechaSalida'] ?? '';
$total = $_POST['precioTotal'] ?? 0;

// **Insertar reserva en la base de datos**
$sql = "INSERT INTO reservas (DNI, Nombre, Apellidos, Email, Telefono, NumPersonas, NecesitaCuna, Opcion, FechaEntrada, FechaSalida, Total)
        VALUES ('$dni', '$nombre', '$apellidos', '$email', '$telefono', $numPersonas, '$necesitaCuna', '$opcionSeleccionada', '$fechaEntrada', '$fechaSalida', $total)";

if ($conexion->query($sql) === TRUE) {
    $idReserva = $conexion->insert_id; // ID de la reserva recién creada
    enviarCorreoConfirmacion($idReserva, $dni, $nombre, $apellidos, $email, $telefono, $numPersonas, $necesitaCuna, $opcionSeleccionada, $fechaEntrada, $fechaSalida, $total);
    echo json_encode(["success" => true, "mensaje" => "✅ Reserva en php registrada correctamente"]);
} else {
    echo json_encode(["success" => false, "error" => "❌ Error al guardar la reserva: " . $conexion->error]);
}

$conexion->close();

// **Función para enviar correos de confirmación**
function enviarCorreoConfirmacion($idReserva, $dni, $nombre, $apellidos, $email, $telefono, $numPersonas, $necesitaCuna, $opcionSeleccionada, $fechaEntrada, $fechaSalida, $total) {
    $mail = new PHPMailer(true);

    try {
        // ✅ Configuración SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'contacto4bs@gmail.com'; // Cuenta Gmail
        $mail->Password = 'yzbf rqup gpry rdtn'; // App Password de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('contacto4bs@gmail.com', 'Reservas 4BS');
        $mail->addAddress($email); // Usuario de la reserva
        $mail->addCC('contacto4bs@gmail.com'); // Copia al administrador

        // ✅ Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Reserva confirmada en 4BS';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: auto; border: 1px solid #ddd;'>
                <div style='text-align: center;'>
                    <img src='https://4bspisoturisticoburgos.free.nf/img/logo%20blanco.jpg' alt='4BS Logo' width='150' style='margin-bottom: 20px;'>
                </div>
                <h2 style='color: #333; text-align: center;'>Reserva confirmada</h2>
                <p>Hola <strong>$nombre</strong>,</p>
                <p>Tu reserva ha sido confirmada en <strong>4BS</strong> con los siguientes datos:</p>
                
                <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>ID de reserva:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$idReserva</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Nombre:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$nombre $apellidos</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>DNI:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$dni</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Email:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$email</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Tlfno:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$telefono</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Total de personas:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$numPersonas</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Necesita cuna:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$necesitaCuna</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Habitaciones:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$opcionSeleccionada</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Fecha de entrada:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$fechaEntrada</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Fecha de salida:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$fechaSalida</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>Total:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$total euros</td>
                    </tr>
                </table>
                
                <p>Recuerda que dispones de <strong>24 horas</strong> para realizar el <strong>pago de la estancia</strong>. Dicho pago se puede realizar por transferencia bancaria o bizum: </p>
                <p>Número de cuenta: <strong>ES29 2100 0414 6102 0026 5167</strong></p>
                <p>Bizum: <strong>653116504</strong></p>

                <p>También debes rellenar el siguiente formulario antes del día de llegada, con los datos de los huéspedes:</p>
                <p><a href='https://docs.google.com/forms/d/e/1FAIpQLSeR5ZQQLaAixKIZ8I2AYoRc1ZQ8oSfcYypcGAfVRfYRKvuKgA/viewform?usp=header' style='color: #007BFF; font-weight: bold;'>👉 Datos de los huéspedes</a></p>
                
                <p>Si tienes alguna duda, no dudes en contactarnos.</p>

                <div style='background: #f4f4f4; padding: 15px; text-align: center; margin-top: 20px;'>
                    <p><strong>Contacto:</strong></p>
                    <p>4BS: Calle Rivalamora 12, Burgos</p>
                    <p>Tlfno: +34 653 11 65 04</p>
                    <p>Email: contacto4bs@gmail.com</p>
                    <p>Web: <a href='https://4bspisoturisticoburgos.free.nf' style='color: #007BFF;'>https://4bspisoturisticoburgos.free.nf/</a></p>
                </div>
            </div>
        ";

        // ✅ Enviar correo
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

?>