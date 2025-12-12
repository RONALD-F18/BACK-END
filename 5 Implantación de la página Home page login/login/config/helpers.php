<?php

function redirigir($ruta) {
    header("Location: index.php?ruta=" . $ruta);
    exit();
}

function limpiarDato($dato) {
    return htmlspecialchars(strip_tags(trim($dato)), ENT_QUOTES, 'UTF-8');
}

function encriptarPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verificarPassword($password, $hash) {
    return password_verify($password, $hash);
}

function generarToken($longitud = 32) {
    return bin2hex(random_bytes($longitud));
}

function iniciarSesionUsuario($usuario) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
    $_SESSION['usuario_email'] = $usuario['email'];
    $_SESSION['usuario_rol'] = $usuario['rol'];
    $_SESSION['usuario_username'] = $usuario['username'];
    $_SESSION['logueado'] = true;
}

function cerrarSesionUsuario() {
    session_unset();
    session_destroy();
}

function estaLogueado() {
    return isset($_SESSION['logueado']) && $_SESSION['logueado'] === true;
}

function esAdmin() {
    return estaLogueado() && $_SESSION['usuario_rol'] === ROL_ADMIN;
}

function esFuncionario() {
    return estaLogueado() && $_SESSION['usuario_rol'] === ROL_FUNCIONARIO;
}

function getMensaje() {
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
        return $mensaje;
    }
    return null;
}

function setMensaje($texto, $tipo = 'info') {
    $_SESSION['mensaje'] = [
        'texto' => $texto,
        'tipo' => $tipo
    ];
}

function url($ruta = '') {
    return "index.php?ruta=" . $ruta;
}

function fechaActual() {
    $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    $meses = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    
    $dia = $dias[date('w')];
    $num = date('d');
    $mes = $meses[intval(date('m'))];
    $anio = date('Y');
    
    return "$dia, $num $mes $anio";
}

function formatearUltimoAcceso($fecha) {
    if (!$fecha) {
        return 'Nunca';
    }
    
    $timestamp = strtotime($fecha);
    $hoy = strtotime('today');
    $ayer = strtotime('yesterday');
    
    if ($timestamp >= $hoy) {
        return 'Hoy ' . date('h:i A', $timestamp);
    } elseif ($timestamp >= $ayer) {
        return 'Ayer ' . date('h:i A', $timestamp);
    }
    
    return date('d/m/Y', $timestamp);
}

function mostrarError($titulo, $mensaje, $enlace = null) {
    $urlEnlace = $enlace ?: 'index.php?ruta=recuperar';
    $textoEnlace = $enlace ? 'Volver' : 'Volver a recuperar contraseña';
    
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>' . htmlspecialchars($titulo) . ' - Talent Sphere</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
            .error-box { background: white; max-width: 500px; margin: 0 auto; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            h1 { color: #dc2626; margin: 0 0 20px 0; }
            .error { color: #dc2626; font-size: 18px; margin: 20px 0; }
            a { color: #4f46e5; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1>' . htmlspecialchars($titulo) . '</h1>
            <p class="error">' . htmlspecialchars($mensaje) . '</p>
            <p><a href="' . htmlspecialchars($urlEnlace) . '">' . htmlspecialchars($textoEnlace) . '</a></p>
        </div>
    </body>
    </html>';
    exit();
}
