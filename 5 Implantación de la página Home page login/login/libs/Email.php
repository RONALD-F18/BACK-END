<?php

require_once __DIR__ . '/../libraries/PHPMailer/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../libraries/PHPMailer/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../libraries/PHPMailer/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../config/Configuracion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public static function enviarRecuperacion($emailDestino, $token)
    {
        $enlace = APP_URL . '/recuperar_password.php?token=' . urlencode($token);

        $asunto = "Recuperación de Contraseña - Talent Sphere";
        
        $mensaje = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
                .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; padding: 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 24px; }
                .body { padding: 30px; }
                .body p { color: #374151; line-height: 1.6; }
                .btn { display: inline-block; padding: 15px 30px; background: #4f46e5; color: white !important; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
                .link-text { word-break: break-all; background: #f3f4f6; padding: 10px; border-radius: 5px; font-size: 12px; color: #6b7280; }
                .footer { padding: 20px 30px; background: #f9fafb; color: #6b7280; font-size: 12px; text-align: center; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1> Talent Sphere</h1>
                </div>
                <div class="body">
                    <h2>Restablecer Contraseña</h2>
                    <p>Hemos recibido una solicitud para restablecer la contraseña de su cuenta.</p>
                    <p>Haga clic en el siguiente botón para crear una nueva contraseña:</p>
                    <p style="text-align: center;">
                        <a href="' . $enlace . '" class="btn">Restablecer Contraseña</a>
                    </p>
                    <p>O copie y pegue este enlace en su navegador:</p>
                    <p class="link-text">' . $enlace . '</p>
                    <p><strong>Nota:</strong> Este enlace expirará en 1 hora.</p>
                </div>
                <div class="footer">
                    <p>Si usted no solicitó este cambio, puede ignorar este correo.</p>
                    <p>© ' . date('Y') . ' Talent Sphere - Sistema de Gestión de RRHH</p>
                </div>
            </div>
        </body>
        </html>';

        return self::enviar($emailDestino, $asunto, $mensaje);
    }

    private static function enviar($para, $asunto, $mensajeHTML)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Remitente y destinatario
            $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
            $mail->addAddress($para);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $mensajeHTML;
            $mail->AltBody = strip_tags($mensajeHTML);

            $mail->send();
            return true;
            
        } catch (Exception $e) {
            error_log("Error PHPMailer: " . $mail->ErrorInfo);
            return false;
        }
    }
}
