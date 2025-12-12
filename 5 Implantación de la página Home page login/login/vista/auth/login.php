<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Talent Sphere</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="avatar-placeholder"></div>
                <h2>Inicia Sesión para Continuar</h2>
            </div>
            
            <div class="login-body">
                <?php $mensaje = getMensaje(); ?>
                <?php if ($mensaje): ?>
                    <div class="alert alert-<?= $mensaje['tipo'] ?>">
                        <?= $mensaje['texto'] ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['token_demo'])): ?>
                    <div class="alert alert-info">
                        <strong>🔗 Enlace de recuperación (si el correo no llegó):</strong><br>
                        <a href="recuperar_password.php?token=<?= urlencode($_SESSION['token_demo']) ?>" style="word-break: break-all; color: #4f46e5; text-decoration: underline; display: block; margin: 10px 0; font-weight: bold;">
                            👆 Haz clic aquí para restablecer tu contraseña
                        </a>
                        <small style="display: block; margin-top: 5px; color: #666;">
                            Email: <?= htmlspecialchars($_SESSION['token_email'] ?? 'N/A') ?><br>
                            Token: <?= htmlspecialchars(substr($_SESSION['token_demo'], 0, 30)) ?>...
                        </small>
                    </div>
                <?php endif; ?>
                
                <div id="formulario__mensaje" class="alert alert-error" style="display: none;"></div>
                
                <form id="formulario-login" action="<?= url('login/procesar') ?>" method="POST" novalidate>
                    <div class="field-group" id="grupo__identificador">
                        <label>Usuario o Correo</label>
                        <input 
                            type="text" 
                            name="identificador"
                            id="identificador"
                            class="input-form formulario__input"
                            placeholder="usuario@email.com"
                        >
                        <p class="formulario__input-error">Ingrese su usuario o correo electrónico</p>
                    </div>
                    
                    <div class="field-group" id="grupo__password">
                        <label>Contraseña</label>
                        <input 
                            type="password" 
                            name="password"
                            id="password"
                            class="input-form formulario__input"
                            placeholder="••••••••••••••••"
                        >
                        <p class="formulario__input-error">La contraseña debe tener al menos 4 caracteres</p>
                    </div>
                    
                    <div class="form-row">
                        <label class="remember-check">
                            <input type="checkbox" name="recordar">
                            <span>Recuérdame</span>
                        </label>
                        <a href="<?= url('recuperar') ?>" class="forgot-pass">¿Olvidaste tu Contraseña?</a>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Iniciar Sesión
                    </button>
                    
                    <div class="separator">
                        <span>O Continúa Con</span>
                    </div>
                    
                    <div class="social-row">
                        <button type="button" class="btn-social">Google</button>
                        <button type="button" class="btn-social">Facebook</button>
                    </div>
                    
                    <p class="signup-text">
                        ¿No tienes cuenta? <a href="<?= url('registro') ?>">Crear una cuenta</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    <script src="assets/js/validacion.js"></script>
</body>
</html>
