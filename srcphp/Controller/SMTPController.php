<?php

namespace proyecto\Controller;

use proyecto\Response\Failure;
use proyecto\Response\Success;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SMTPController {

    public function ejemploSMTP() {
        $mail = new PHPMailer(true);

        try {
            // Obtén los datos JSON de la solicitud
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            // Configuración del servidor SMTP
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bistreacoffeecakes@gmail.com';
            $mail->Password = 'qogk ocrk rtsz knbl'; // Reemplázala con la contraseña correcta o la contraseña de aplicación generada
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Detalles del mensaje
            $mail->setFrom('bistreacoffeecakes@gmail.com');
            $mail->addAddress($dataObject->email);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Ejemplo de algo';
            $mail->Body = 'Este es un ejemplo de correo electrónico.';

            // Intenta enviar el correo
            $mail->send();

            // Éxito
            $r = new Success("Correo enviado correctamente");
            return $r->Send();
        } catch (Exception $e) {
            // Captura y maneja excepciones
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }
}

?>