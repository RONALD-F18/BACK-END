<?php 
session_start();
if(!isset($_GET['token'])) {
    header("Location: forgot_password.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - Óptica Vision</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="logo">👓</div>
            <h2>Nueva Contraseña</h2>
            <p class="subtitle">Ingresa tu nueva contraseña</p>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="../controllers/AuthController.php?action=resetPassword" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                
                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                
                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
            </form>
            
            <div class="links">
                <a href="login.php">Volver al inicio de sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
