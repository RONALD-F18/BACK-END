<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Óptica Vision</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="logo">👓</div>
            <h2>Crear Cuenta</h2>
            <p class="subtitle">Únete a nuestra óptica</p>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="../controllers/AuthController.php?action=register" method="POST">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="name" required placeholder="Tu nombre">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="tu@email.com">
                </div>
                
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                
                <button type="submit" class="btn btn-primary">Registrarse</button>
            </form>
            
            <div class="links">
                <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
