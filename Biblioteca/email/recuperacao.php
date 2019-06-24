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
            $mail->Subject = ASSUNTOREC;
            $mail->msgHTML("
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                <html lang=\"br\" xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>A Simple Responsive HTML Email</title>
                    <style type='text/css'>
                        body {margin: 0; padding: 0; min-width: 100%!important;}
                        img {height: auto;}
                        .content {width: 100%; max-width: 600px;}
                        .header {padding: 40px 30px 20px 30px;}
                        .innerpadding {padding: 30px 30px 30px 30px;}
                        .borderbottom {border-bottom: 1px solid #f2eeed;}
                        .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
                        .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
                        .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
                        .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
                        .bodycopy {font-size: 16px; line-height: 22px;}
                        .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
                        .button a {color: #ffffff; text-decoration: none;}
                        .footer {padding: 20px 30px 15px 30px;}
                        .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
                        .footercopy a {color: #ffffff; text-decoration: underline;}
                    </style>
                </head>
                
                <body bgcolor='#f6f8f1'>
                <table width='100%' bgcolor='#f6f8f1' border='0' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td>
                            <table bgcolor='#ffffff' class='content' align='center' cellpadding='0' cellspacing='0' border='0'>
                                <tr>
                                    <td bgcolor='#c7d8a7' class='header'>
                                        <table width='70' align='left' border='0' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td height='70' style='padding: 0 20px 20px 0;'>
                                                    <img class='fix' src='cid:logo' width='85' height='60' border='0' alt=''' />
                                                </td>
                                            </tr>
                                        </table>
                                        <table class='col425' align='left' border='0' cellpadding='0' cellspacing='0' style='width: 100%; max-width: 425px;'>
                                            <tr>
                                                <td height='70'>
                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                        <tr>
                                                            <td class='subhead' style='padding: 0 0 0 3px;'>
                                                                BIBLIOTECA DIGITAL
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class='h2' style='padding: 5px 0 0 0;'>
                                                                \"<b>Ler</b>, passaporte para o Mundo!\"
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='innerpadding borderbottom'>
                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td class='h2'>
                                                    Olá, ".$nomeUsuario."
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='bodycopy'>
                                                    Este e-mail foi encaminhado conforme solicitação de recuperação de acesso realizada em nosso Sistema, se não foi você favor não prossiga com os passos indicados abaixo e desconside-o!
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='innerpadding borderbottom'>
                                        <table width='115' align='left' border='0' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td height='115' style='padding: 0 20px 20px 0;'>
                                                    <img class='fix' src=\"cid:livro\" width='115' height='115' border='0' alt=''' />
                                                </td>
                                            </tr>
                                        </table>
                                        <table class='col380' align='left' border='0' cellpadding='0' cellspacing='0' style='width: 100%; max-width: 380px;'>
                                            <tr>
                                                <td>
                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                        <tr>
                                                            <td class='bodycopy'>
                                                                Para recuperar seu acesso ao Sistema favor clicar no botão abaixo e seguir os passos para o cadastro de uma nova Senha!
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style='padding: 20px 0 0 0;'>
                                                                <table class='buttonwrapper' bgcolor='#e05443' border='0' cellspacing='0' cellpadding='0'>
                                                        <tr>
                                                            <td class='button' height='45'>
                                                                <a href='#'>Recuperar!</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class='innerpadding bodycopy'>
                            Favor, não responder a este e-mail, ele somente é utilizado para envio de mensagens Informativas.
                            Equipe Biblioteca Digital.
                        </td>
                    </tr>
                    <tr>
                        <td class='footer' bgcolor='#44525f'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                            <tr>
                                <td align='center' class='footercopy'>
                                    &reg; Biblioteca Digital, Juiz de Fora - MG, Brasil 2019<br/>
                                </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                </table>
                </body>
                </html>"
            );

            //Configurações de Anexos
            $mail->addEmbeddedImage(LOGO,'logo');
            $mail->addEmbeddedImage(LIVRO,'livro');
        
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