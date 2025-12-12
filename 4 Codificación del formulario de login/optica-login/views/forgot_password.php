<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Óptica Vision</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="logo">👓</div>
            <h2>Recuperar Contraseña</h2>
            <p class="subtitle">Te enviaremos instrucciones por email</p>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form action="../controllers/AuthController.php?action=forgotPassword" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="tu@email.com">
                </div>
                
                <button type="submit" class="btn btn-primary">Enviar Instrucciones</button>
            </form>
            
            <div class="links">
                <a href="login.php">Volver al inicio de sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
