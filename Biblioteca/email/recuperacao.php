<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2019-04-15
 * Time: 11:50
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "configEMail.php";
require "vendor/autoload.php";

class recuperacao
{
    public function recuperarSenha($email, $nomeUsuario)
    {
        $mail = new PHPMailer(true);
        try {
            //Configurações de servidor
            $mail->SMTPDebug = SMTPDEBUG;   
            $mail->isSMTP();                
            $mail->Host       = HOST;        
            $mail->SMTPAuth   = SMTPAUTH;    
            $mail->Username   = USERNAME;     
            $mail->Password   = PASSWORD;     
            $mail->SMTPSecure = SMTPSECURE;   
            $mail->Port       = PORT;         
        
            //Configurações de destinatário
            $mail->setFrom(USERNAME, ALIAS);
            $mail->addAddress($email, $nomeUsuario);
    
            //Configurações de Conteúdo da Mensagem
            $mail->Subject = 'Teste de Envio de E-mail pelo GMAIl';
            $mail->msgHTML("Teste de envio OK!");
        
            //Configurações de Anexos
            $mail->addAttachment(LOGO);                           
        
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo "A mensagem não pode ser Enviada. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>