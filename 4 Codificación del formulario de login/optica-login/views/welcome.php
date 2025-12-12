<?php 
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Óptica Vision</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="welcome-box">
            <div class="success-icon">✓</div>
            <h2>¡Bienvenido!</h2>
            <p class="welcome-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
            <p class="welcome-message">Has iniciado sesión correctamente</p>
            
            <div class="welcome-actions">
                <a href="../controllers/AuthController.php?action=logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
