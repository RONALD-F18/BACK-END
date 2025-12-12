<?php
// recuperar_password.php - Página directa para recuperación de contraseña

session_start();
require_once 'config/Configuracion.php';
require_once 'config/BaseDatos.php';
require_once 'config/helpers.php';
require_once 'modelo/Usuario.php';

if (estaLogueado()) {
    redirigir('dashboard');
}

// Manejar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    if (empty($token)) {
        setMensaje('Token inválido', 'error');
        redirigir('recuperar');
    }
    
    try {
        $usuarioModelo = new Usuario(BaseDatos::conectar());
        $usuario = $usuarioModelo->buscarPorToken($token);
        
        if (!$usuario) {
            setMensaje('El enlace de recuperación es inválido o ha expirado', 'error');
            redirigir('recuperar');
        }
        
        $urlRetorno = "recuperar_password.php?token=" . urlencode($token);
        
        if (empty($password) || strlen($password) < 8) {
            setMensaje('La contraseña debe tener al menos 8 caracteres', 'error');
            header("Location: " . $urlRetorno);
            exit();
        }
        
        if ($password !== $password_confirm) {
            setMensaje('Las contraseñas no coinciden', 'error');
            header("Location: " . $urlRetorno);
            exit();
        }
        
        $usuarioModelo->actualizarPassword($usuario['id'], $password);
        setMensaje('¡Contraseña actualizada! Ya puede iniciar sesión', 'success');
        redirigir('login');
        
    } catch (Exception $e) {
        setMensaje('Error al actualizar la contraseña. Por favor, intente nuevamente.', 'error');
        header("Location: recuperar_password.php?token=" . urlencode($token));
        exit();
    }
}

// Obtener y validar token
$token = trim($_GET['token'] ?? '');

if (empty($token)) {
    mostrarError('Error', 'Enlace de recuperación inválido. Por favor, solicite un nuevo enlace.');
}

try {
    $usuarioModelo = new Usuario(BaseDatos::conectar());
    $usuario = $usuarioModelo->buscarPorToken($token);
    
    if (!$usuario) {
        mostrarError('Error', 'El enlace de recuperación es inválido o ha expirado. Por favor, solicite un nuevo enlace.');
    }
    
    require_once 'vista/auth/nueva_password.php';
    
} catch (Exception $e) {
    mostrarError('Error', 'Error al procesar el enlace de recuperación: ' . $e->getMessage());
}

