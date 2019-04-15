<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2019-04-15
 * Time: 11:50
 */

use PHPMailer\PHPMailer\PHPMailer;
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
require "PHPMailer/src/Exception.php";
require "configEMail.php";

class recuperacao
{
    public function recuperarSenha($email, $nomeUsuario)
    {
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->SMTPDebug = SMTPDEBUG;
        $mail->Host = HOST;
        $mail->Port = PORT;
        $mail->SMTPSecure = SMTPSECURE;
        $mail->SMTPAuth = SMTPAUTH;

        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;

        $mail->setFrom(USERNAME, ALIAS);
        $mail->addAddress($email, $nomeUsuario);
        $mail->Subject = 'Teste de Envio de E-mail pelo GMAIl';
        $mail->msgHTML("Teste de envio OK!");
        $mail->addAttachment(LOGO);

        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
}

?>