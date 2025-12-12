<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - Talent Sphere</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="avatar-placeholder" style="background: linear-gradient(180deg, #10b981 0%, #059669 100%);"></div>
                <h2>Crear Nueva Contraseña</h2>
            </div>
            
            <div class="login-body">
                <?php $mensaje = getMensaje(); ?>
                <?php if ($mensaje): ?>
                    <div class="alert alert-<?= $mensaje['tipo'] ?>">
                        <?= $mensaje['texto'] ?>
                    </div>
                <?php endif; ?>
                
                <div id="formulario__mensaje" class="alert alert-error" style="display: none;"></div>
                
                <form id="formulario-nueva-password" action="recuperar_password.php" method="POST" novalidate>
                    <input type="hidden" name="token" value="<?= htmlspecialchars(isset($token) ? $token : '') ?>">
                    
                    <div class="field-group" id="grupo__password">
                        <label>Nueva Contraseña</label>
                        <input 
                            type="password" 
                            name="password"
                            id="password"
                            class="input-form formulario__input"
                            placeholder="••••••••••••••••"
                        >
                        <p class="formulario__input-error">Mínimo 8 caracteres</p>
                    </div>
                    
                    <div class="field-group" id="grupo__password_confirm">
                        <label>Confirmar Contraseña</label>
                        <input 
                            type="password" 
                            name="password_confirm"
                            id="password_confirm"
                            class="input-form formulario__input"
                            placeholder="••••••••••••••••"
                        >
                        <p class="formulario__input-error">Las contraseñas no coinciden</p>
                    </div>

                    <div class="requirements-box">
                        <p><strong>Requisitos de la Contraseña:</strong></p>
                        <ul>
                            <li>Mínimo 8 caracteres</li>
                            <li>Al menos una letra mayúscula</li>
                            <li>Al menos un número</li>
                        </ul>
                    </div>
                    
                    <button type="submit" class="btn-login" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        Actualizar Contraseña
                    </button>
                    
                    <p class="signup-text" style="margin-top: 20px;">
                        <a href="<?= url('login') ?>">← Volver a Iniciar Sesión</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');
    
    function validarPassword() {
        const grupo = document.getElementById('grupo__password');
        const errorMsg = grupo.querySelector('.formulario__input-error');
        
        if (password.value.length >= 8) {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.add('formulario__grupo-correcto');
            errorMsg.classList.remove('formulario__input-error-activo');
            return true;
        } else if (password.value !== '') {
            grupo.classList.add('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto');
            errorMsg.classList.add('formulario__input-error-activo');
        }
        return false;
    }
    
    function validarConfirm() {
        const grupo = document.getElementById('grupo__password_confirm');
        const errorMsg = grupo.querySelector('.formulario__input-error');
        
        if (password.value === passwordConfirm.value && passwordConfirm.value !== '') {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.add('formulario__grupo-correcto');
            errorMsg.classList.remove('formulario__input-error-activo');
            return true;
        } else if (passwordConfirm.value !== '') {
            grupo.classList.add('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto');
            errorMsg.classList.add('formulario__input-error-activo');
        }
        return false;
    }
    
    password.addEventListener('input', function() {
        validarPassword();
        if (passwordConfirm.value !== '') validarConfirm();
    });
    
    passwordConfirm.addEventListener('input', validarConfirm);
    
    document.getElementById('formulario-nueva-password').addEventListener('submit', function(e) {
        const mensaje = document.getElementById('formulario__mensaje');
        
        if (!validarPassword() || !validarConfirm()) {
            e.preventDefault();
            mensaje.textContent = 'Por favor corrija los errores en el formulario';
            mensaje.style.display = 'block';
        }
    });
    </script>
</body>
</html>
