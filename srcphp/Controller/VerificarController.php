<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Models\usuario;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require ("../../vendor/autoload.php");

class VerificarController {
    public function enviar() {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();  //Este es el protoocolo [ara enviar correo elecrinicos]
            $mail->Host = 'smtp.gmail.com';  //Esto es la conexion del servidor esmtp
            $mail->SMTPAuth = true;
            $mail->Username = 'bistreacoffeecakes@gmail.com';
            $mail->Password = 'qogkocrkrtszknbl';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;  

            $mail->setFrom('bistreacoffeecakes@gmail.com', 'Bistrea');
            $mail->addAddress('frank.athr095@gmail.com');

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Código de Verificación';
            $mail->Body = "Tu código de verificación es ";

            $mail->send();
            
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }

    }
}
?>