<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Response\Failure;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class SMTPController {

    public function ejemploSMTP() {
        $mail = new PHPMailer(true);

        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
        
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bistreacoffeecakes@gmail.com';
            $mail->Password = 'qogk ocrk rtsz knbl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('bistreacoffeecakes@gmail.com');
            $mail->addAddress($dataObject->email);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'EJemplo de algo ';
            $mail->Body = 'Ejemplo de algo';

            $mail->send();
            echo "auisa";
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }

    }

}

?>