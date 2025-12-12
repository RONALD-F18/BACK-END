<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Óptica Vision</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="logo">👓</div>
            <h2>Iniciar Sesión</h2>
            <p class="subtitle">Bienvenido a tu óptica</p>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form action="../controllers/AuthController.php?action=login" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="tu@email.com">
                </div>
                
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>
            
            <div class="links">
                <a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
                <a href="register.php">Crear cuenta nueva</a>
            </div>
        </div>
    </div>
</body>
</html>
