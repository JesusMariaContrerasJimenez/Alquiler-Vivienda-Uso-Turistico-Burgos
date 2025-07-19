<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/PHPMailer.php';
require 'vendor/phpmailer/SMTP.php';
require 'vendor/phpmailer/Exception.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Usa el servidor SMTP de Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'contacto4bs@gmail.com'; // 
    $mail->Password = 'yzbf rqup gpry rdtn'; // "App Password" en Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configurar correo
    $mail->setFrom($_POST["email"], $_POST["nombre"]);
    $mail->addAddress("contacto4bs@gmail.com");
    $mail->Subject = "Mensaje de contacto";
    $mail->Body = "Nombre: " . $_POST["nombre"] . "\nEmail: " . $_POST["email"] . "\nMensaje:\n" . $_POST["mensaje"];

    $mail->send();
    echo json_encode(["success" => true]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $mail->ErrorInfo]);
}
?>