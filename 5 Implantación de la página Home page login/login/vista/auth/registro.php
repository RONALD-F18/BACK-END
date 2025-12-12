<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Talent Sphere</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <div class="register-header">
                <div class="header-circle"></div>
                <h2>Registro de Usuario</h2>
                <p>Sistema de Recursos Humanos</p>
            </div>

            <div class="register-body">
                <?php $mensaje = getMensaje(); ?>
                <?php if ($mensaje): ?>
                    <div class="alert alert-<?= $mensaje['tipo'] ?>">
                        <?= $mensaje['texto'] ?>
                    </div>
                <?php endif; ?>
                
                <div id="formulario__mensaje" class="alert alert-error" style="display: none;"></div>
                
                <form id="formulario-registro" action="<?= url('registro/procesar') ?>" method="POST">
                    <div class="form-grid">
                        <div class="field-group" id="grupo__nombres">
                            <label>Nombre(s) *</label>
                            <input 
                                type="text" 
                                name="nombres"
                                class="formulario__input input-form"
                                placeholder="Juan Carlos"
                                required
                            >
                            <p class="formulario__input-error">El nombre solo puede contener letras y espacios</p>
                        </div>
                        <div class="field-group" id="grupo__apellidos">
                            <label>Apellido(s) *</label>
                            <input 
                                type="text" 
                                name="apellidos"
                                class="formulario__input input-form"
                                placeholder="Pérez García"
                                required
                            >
                            <p class="formulario__input-error">Los apellidos solo pueden contener letras y espacios</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="field-group" id="grupo__username">
                            <label>Nombre de Usuario *</label>
                            <input 
                                type="text" 
                                name="username"
                                class="formulario__input input-form"
                                placeholder="juanperez"
                                required
                            >
                            <p class="formulario__input-error">4-16 caracteres: letras, números, guión, guión bajo</p>
                        </div>
                        <div class="field-group">
                            <label>Tipo de Documento *</label>
                            <select name="tipo_documento" class="input-form" required>
                                <option value="">Seleccionar...</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="PA">Pasaporte</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="field-group" id="grupo__num_documento">
                            <label>Número de Documento *</label>
                            <input 
                                type="text" 
                                name="num_documento"
                                class="formulario__input input-form"
                                placeholder="1234567890"
                                required
                            >
                            <p class="formulario__input-error">El documento debe tener entre 5 y 20 números</p>
                        </div>
                        <div class="field-group" id="grupo__email">
                            <label>Correo Electrónico *</label>
                            <input 
                                type="email" 
                                name="email"
                                class="formulario__input input-form"
                                placeholder="correo@ejemplo.com"
                                required
                            >
                            <p class="formulario__input-error">Ingrese un correo válido</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="field-group" id="grupo__password">
                            <label>Contraseña *</label>
                            <input 
                                type="password" 
                                name="password"
                                id="password"
                                class="formulario__input input-form"
                                placeholder="••••••••••••"
                                required
                            >
                            <p class="formulario__input-error">La contraseña debe tener mínimo 8 caracteres</p>
                        </div>
                        <div class="field-group" id="grupo__password_confirm">
                            <label>Confirmar Contraseña *</label>
                            <input 
                                type="password" 
                                name="password_confirm"
                                id="password_confirm"
                                class="formulario__input input-form"
                                placeholder="••••••••••••"
                                required
                            >
                            <p class="formulario__input-error">Las contraseñas no coinciden</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="field-group" id="grupo__telefono">
                            <label>Número de Teléfono (Opcional)</label>
                            <input 
                                type="tel" 
                                name="telefono"
                                class="formulario__input input-form"
                                placeholder="3001234567"
                            >
                            <p class="formulario__input-error">El teléfono debe tener entre 7 y 14 dígitos</p>
                        </div>
                        <div class="field-group">
                            <label>Fecha de Nacimiento *</label>
                            <input 
                                type="date" 
                                name="fecha_nacimiento"
                                class="input-form"
                                required
                            >
                        </div>
                    </div>

                    <div class="requirements-box">
                        <p>Requisitos de la Contraseña:</p>
                        <ul>
                            <li>Mínimo 8 caracteres</li>
                            <li>Al menos una letra mayúscula</li>
                            <li>Al menos un número</li>
                        </ul>
                    </div>

                    <label class="terms-check">
                        <input type="checkbox" name="acepta_terminos" id="acepta_terminos" required>
                        <span>Acepto los <a href="#">Términos y Condiciones</a> y la <a href="#">Política de Privacidad</a></span>
                    </label>

                    <div class="buttons-row">
                        <a href="<?= url('home') ?>" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-create">Crear Cuenta</button>
                    </div>

                    <p class="login-text">
                        ¿Ya tienes cuenta? <a href="<?= url('login') ?>">Inicia Sesión Aquí</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    <script src="assets/js/validacion.js"></script>
</body>
</html>
