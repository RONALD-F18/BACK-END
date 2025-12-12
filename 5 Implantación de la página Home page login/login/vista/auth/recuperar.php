<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Talent Sphere</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="avatar-placeholder" style="background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);"></div>
                <h2>Recuperar Contraseña</h2>
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
                        <strong>Demo:</strong> Link de recuperación: 
                        <a href="<?= url('nueva-password/' . $_SESSION['token_demo']) ?>">Restablecer contraseña</a>
                    </div>
                    <?php unset($_SESSION['token_demo']); ?>
                <?php endif; ?>
                
                <div id="formulario__mensaje" class="alert alert-error" style="display: none;"></div>
                
                <p style="text-align: center; color: #666; margin-bottom: 25px; font-size: 14px;">
                    Ingresa tu correo electrónico y te enviaremos instrucciones para restablecer tu contraseña.
                </p>
                
                <form id="formulario-recuperar" action="<?= url('recuperar/procesar') ?>" method="POST" novalidate>
                    <div class="field-group" id="grupo__email">
                        <label>Correo Electrónico</label>
                        <input 
                            type="email" 
                            name="email"
                            id="email"
                            class="input-form formulario__input"
                            placeholder="tu@email.com"
                        >
                        <p class="formulario__input-error">Ingrese un correo electrónico válido</p>
                    </div>
                    
                    <button type="submit" class="btn-login" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        Enviar Instrucciones
                    </button>
                    
                    <p class="signup-text" style="margin-top: 20px;">
                        <a href="<?= url('login') ?>">← Volver a Iniciar Sesión</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    document.getElementById('formulario-recuperar').addEventListener('submit', function(e) {
        const email = document.getElementById('email');
        const grupo = document.getElementById('grupo__email');
        const errorMsg = grupo.querySelector('.formulario__input-error');
        const regex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
        
        if (!regex.test(email.value)) {
            e.preventDefault();
            grupo.classList.add('formulario__grupo-incorrecto');
            errorMsg.classList.add('formulario__input-error-activo');
        } else {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.add('formulario__grupo-correcto');
            errorMsg.classList.remove('formulario__input-error-activo');
        }
    });
    
    document.getElementById('email').addEventListener('input', function() {
        const grupo = document.getElementById('grupo__email');
        const errorMsg = grupo.querySelector('.formulario__input-error');
        const regex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
        
        if (regex.test(this.value)) {
            grupo.classList.remove('formulario__grupo-incorrecto');
            grupo.classList.add('formulario__grupo-correcto');
            errorMsg.classList.remove('formulario__input-error-activo');
        } else if (this.value !== '') {
            grupo.classList.add('formulario__grupo-incorrecto');
            grupo.classList.remove('formulario__grupo-correcto');
            errorMsg.classList.add('formulario__input-error-activo');
        }
    });
    </script>
</body>
</html>
