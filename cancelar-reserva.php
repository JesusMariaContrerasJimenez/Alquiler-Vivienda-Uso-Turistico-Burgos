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
$id = $_POST['id'] ?? '';
$dni = $_POST['dni'] ?? '';

if (!$id || !$dni) {
    echo json_encode(["exito" => false, "mensaje" => "⚠️ Falta el ID o el DNI."]);
    exit;
}

// 🔍 Obtener datos de la reserva antes de borrarla
$sqlSelect = "SELECT * FROM reservas WHERE id = '$id' AND DNI = '$dni'";
$result = $conexion->query($sqlSelect);

if ($result->num_rows === 0) {
    echo json_encode(["exito" => false, "mensaje" => "❌ No se encontró ninguna reserva con ese ID y DNI."]);
    exit;
}

$reserva = $result->fetch_assoc();

//Calcular devolución
$fechaHoy = new DateTime();
$fechaEntradaObj = new DateTime($reserva['FechaEntrada']);
$diasAntes = $fechaHoy->diff($fechaEntradaObj)->days;
$porcentajeReembolso = ($fechaHoy < $fechaEntradaObj && $diasAntes >= 7) ? 100 : 40;

// 🗑️ Eliminar la reserva
$sqlDelete = "DELETE FROM reservas WHERE id = '$id' AND DNI = '$dni'";
if ($conexion->query($sqlDelete) === TRUE) {
    enviarCorreoCancelacion(
        $id,
        $reserva['DNI'],
        $reserva['Nombre'],
        $reserva['Apellidos'],
        $reserva['Email'],
        $reserva['Telefono'],
        $reserva['NumPersonas'],
        $reserva['NecesitaCuna'],
        $reserva['Opcion'],
        $reserva['FechaEntrada'],
        $reserva['FechaSalida'],
        $reserva['Total'],
        $porcentajeReembolso
    );
    echo json_encode(["exito" => true, "mensaje" => "✅ Reserva cancelada correctamente"]);
} else {
    echo json_encode(["exito" => false, "mensaje" => "❌ Error al cancelar la reserva: " . $conexion->error]);
}

$conexion->close();

// **Función para enviar correos de confirmación**
function enviarCorreoCancelacion($idReserva, $dni, $nombre, $apellidos, $email, $telefono, $numPersonas, $necesitaCuna, $opcionSeleccionada, $fechaEntrada, $fechaSalida, $total, $porcentajeReembolso) {
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
        $mail->Subject = 'Reserva cancelada en 4BS';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: auto; border: 1px solid #ddd;'>
                <div style='text-align: center;'>
                    <img src='https://4bspisoturisticoburgos.free.nf/img/logo%20blanco.jpg' alt='4BS Logo' width='150' style='margin-bottom: 20px;'>
                </div>
                <h2 style='color: #333; text-align: center;'>Reserva confirmada</h2>
                <p>Hola <strong>$nombre</strong>,</p>
                <p>Tu reserva ha sido <strong>cancelada</strong> en <strong>4BS</strong> con los siguientes datos:</p>
                
                <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>ID de reserva:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$idReserva</td>
                    </tr>
                    <tr>
                        <td style='border: 1px solid #ddd; padding: 8px;'><strong>DNI:</strong></td>
                        <td style='border: 1px solid #ddd; padding: 8px;'>$dni</td>
                    </tr>
                </table>
                
                <p>Según nuestra política, se abonará el <strong>$porcentajeReembolso%</strong> del importe total de la reserva.</p>

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