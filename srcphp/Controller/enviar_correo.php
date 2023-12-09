<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function enviarCorreo($destinatario, $codigo) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bistreacoffeecakes@gmail.com';
        $mail->Password = 'qogk ocrk rtsz knbl';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('bistreacoffeecakes@gmail.com', 'Bistrea');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Código de Verificación';

        // Incluye un formulario y un botón en lugar del código de verificación
        $formulario = "
    <form action='http://localhost/PRUEBAS/phpMailer/redireccion.php' method='get'>
        <input type='hidden' name='codigo' value='$codigo'>
        <br>
        <button style='background-color: #889E89; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px; font-family: \"Roboto Mono\", monospace;'>Haz clic aquí para validar tu cuenta</button>
    </form>
    ";



        $mail->Body = "Para verificar tu registro $formulario";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>
