<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->name = $_POST['name'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];

            if($this->user->emailExists()) {
                $_SESSION['error'] = "El email ya está registrado";
                header("Location: ../views/register.php");
                exit();
            }

            if($this->user->register()) {
                $_SESSION['success'] = "Registro exitoso. Por favor inicia sesión.";
                header("Location: ../views/login.php");
                exit();
            } else {
                $_SESSION['error'] = "Error al registrar usuario";
                header("Location: ../views/register.php");
                exit();
            }
        }
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];

            if($this->user->login()) {
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['user_name'] = $this->user->name;
                $_SESSION['user_email'] = $this->user->email;
                header("Location: ../views/welcome.php");
                exit();
            } else {
                $_SESSION['error'] = "Email o contraseña incorrectos";
                header("Location: ../views/login.php");
                exit();
            }
        }
    }

    public function forgotPassword() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->email = $_POST['email'];

            if(!$this->user->emailExists()) {
                $_SESSION['error'] = "Email no encontrado";
                header("Location: ../views/forgot_password.php");
                exit();
            }

            if($this->user->generateResetToken()) {
                $_SESSION['reset_token'] = $this->user->reset_token;
                $_SESSION['reset_email'] = $this->user->email;
                
                $emailSent = $this->sendResetEmail($this->user->email, $this->user->reset_token);
                
                if($emailSent) {
                    $_SESSION['success'] = "Se ha enviado un email con instrucciones. Revisa tu bandeja de entrada.";
                } else {
                    $_SESSION['success'] = "Token generado. Copia este enlace en tu navegador: <br><strong>http://localhost/optica-login/views/reset_password.php?token=" . $this->user->reset_token . "</strong>";
                }
                
                header("Location: ../views/forgot_password.php");
                exit();
            }
        }
    }

    public function resetPassword() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $_POST['token'];
            $newPassword = $_POST['password'];

            if($this->user->resetPassword($token, $newPassword)) {
                $_SESSION['success'] = "¡Contraseña actualizada exitosamente! Ya puedes iniciar sesión.";
                header("Location: ../views/login.php");
                exit();
            } else {
                $_SESSION['error'] = "Token inválido o expirado. Solicita uno nuevo.";
                header("Location: ../views/forgot_password.php");
                exit();
            }
        }
    }

    private function sendResetEmail($email, $token) {
        $resetLink = "http://localhost/optica-login/views/reset_password.php?token=" . $token;
        
        $subject = "Recuperar Contraseña - Óptica Vision";
        $message = "Hola,\n\n";
        $message .= "Hemos recibido una solicitud para restablecer tu contraseña.\n\n";
        $message .= "Haz clic en el siguiente enlace para crear una nueva contraseña:\n";
        $message .= $resetLink . "\n\n";
        $message .= "Este enlace expirará en 1 hora.\n\n";
        $message .= "Si no solicitaste este cambio, puedes ignorar este correo.\n\n";
        $message .= "Saludos,\nEquipo Óptica Vision";
        
        $headers = "From: noreply@opticavision.com\r\n";
        $headers .= "Reply-To: noreply@opticavision.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        return @mail($email, $subject, $message, $headers);
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../views/login.php");
        exit();
    }
}

if(isset($_GET['action'])) {
    $controller = new AuthController();
    $action = $_GET['action'];
    
    if(method_exists($controller, $action)) {
        $controller->$action();
    }
}
?>
