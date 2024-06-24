<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $correo = $data['correo'];
    $imagenData = $data['imagen'];

    // Decodifica la imagen de base64
    $imagenData = str_replace('data:image/png;base64,', '', $imagenData);
    $imagenData = str_replace(' ', '+', $imagenData);
    $imagenBinaria = base64_decode($imagenData);

    // Guarda la imagen en el servidor temporalmente
    $rutaImagenTemporal = 'temp/carnet_' . uniqid() . '.png';
    file_put_contents($rutaImagenTemporal, $imagenBinaria);

    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Reemplaza con tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'jhonnygonsalez7@gmail.com';  // Reemplaza con tu dirección de correo
        $mail->Password = 'fhcs orfw xcoh glck';  // Reemplaza con tu contraseña
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('jhonnygonsalez7@gmail.com', 'Aprendiz');
        $mail->addAddress($correo);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Carnet Generado';
        $mail->Body = 'Adjunto encontrarás tu carnet generado.';
        $mail->addAttachment($rutaImagenTemporal, 'carnet.png');

        $mail->send();
        echo json_encode(['message' => 'Correo enviado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['message' => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
    } finally {
        // Elimina la imagen temporal
        unlink($rutaImagenTemporal);
    }
} else {
    echo json_encode(['message' => 'Método no permitido.']);
}
?>
