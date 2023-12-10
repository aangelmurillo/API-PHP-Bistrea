<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Models\usuario;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class VerificarController {

    function generarCodigoVerificacion() {
        return rand(100000, 999999);
    }

    function enviar() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $usuario = new usuario();

            $usuario->email_usuario = $dataObject->email_usuario;

            // Verificar si el correo electrónico del usuario se estableció correctamente
            if(!empty($usuario->email_usuario)) {
                $codigoVerificacion = $this->generarCodigoVerificacion();
                $this->enviarboton($usuario->email_usuario, $codigoVerificacion);

                // Puedes devolver una respuesta de éxito si es necesario
                $r = new Success('Correo enviado correctamente');
                return $r->Send();
            } else {
                throw new \Exception('Correo electrónico del usuario no válido');
            }

        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function enviarboton($destinatario, $codigo) {
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




}
?>