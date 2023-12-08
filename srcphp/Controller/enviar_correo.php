<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function enviarCorreo($destinatario, $codigo) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();  //Este es el protoocolo [ara enviar correo elecrinicos]
        $mail->Host = 'smtp.gmail.com';  //Esto es la conexion del servidor esmtp
        $mail->SMTPAuth = true;
        $mail->Username = 'bistreacoffeecakes@gmail.com';
        $mail->Password = 'qogk ocrk rtsz knbl';
        $mail->SMTPSecure = 'tls';   //esto es ocmo seguridad
        $mail->Port = 587;  //este es el puerto comun de tls

        $mail->setFrom('bistreacoffeecakes@gmail.com', 'Bistrea');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Código de Verificación';
        $mail->Body = "Tu código de verificación es: $codigo";

        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>
