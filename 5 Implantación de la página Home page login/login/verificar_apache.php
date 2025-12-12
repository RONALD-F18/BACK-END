<?php
// verificar_apache.php - Script para verificar el estado de Apache
// Acceder: http://localhost/talent-sphere/verificar_apache.php

echo "<h1> Diagnóstico de Apache</h1>";
echo "<hr>";

// 1. Verificar si PHP está funcionando
echo "<h2>1. Estado de PHP</h2>";
echo " PHP está funcionando correctamente<br>";
echo "Versión de PHP: " . phpversion() . "<br><br>";

// 2. Verificar configuración de Apache
echo "<h2>2. Información del Servidor</h2>";
echo "Servidor: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'No detectado') . "<br>";
echo "Puerto: " . ($_SERVER['SERVER_PORT'] ?? 'No detectado') . "<br>";
echo "Host: " . ($_SERVER['HTTP_HOST'] ?? 'No detectado') . "<br><br>";

// 3. Verificar si podemos conectarnos a localhost
echo "<h2>3. Prueba de Conexión</h2>";
$test_url = "http://localhost/talent-sphere/";
$ch = curl_init($test_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($http_code > 0) {
    echo " Conexión exitosa a localhost<br>";
    echo "Código HTTP: " . $http_code . "<br>";
} else {
    echo " No se puede conectar a localhost<br>";
    echo "Error: " . ($error ?: 'Desconocido') . "<br>";
}
echo "<br>";

// 4. Verificar archivos importantes
echo "<h2>4. Archivos del Proyecto</h2>";
$archivos = [
    'index.php' => 'Archivo principal',
    'recuperar_password.php' => 'Página de recuperación',
    'config/Configuracion.php' => 'Configuración',
    'config/BaseDatos.php' => 'Conexión BD',
    'assets/css/styles.css' => 'Estilos CSS'
];

foreach ($archivos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo " $descripcion ($archivo) existe<br>";
    } else {
        echo " $descripcion ($archivo) NO existe<br>";
    }
}
echo "<br>";

// 5. Instrucciones
echo "<h2>5. Instrucciones</h2>";
echo "<div style='background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;'>";
echo "<strong>Si ves este mensaje, PHP está funcionando pero Apache puede no estar corriendo correctamente.</strong><br><br>";
echo "<strong>Pasos a seguir:</strong><br>";
echo "1. Abre <strong>XAMPP Control Panel</strong><br>";
echo "2. Verifica que <strong>Apache</strong> esté en <strong>verde</strong> (Running)<br>";
echo "3. Si está en <strong>rojo</strong> o <strong>gris</strong>, haz clic en <strong>Start</strong><br>";
echo "4. Espera a que Apache inicie (verás mensajes en la consola)<br>";
echo "5. Intenta acceder a: <a href='http://localhost/talent-sphere/'>http://localhost/talent-sphere/</a><br>";
echo "</div>";

// 6. Verificar puerto
echo "<h2>6. Verificación de Puerto</h2>";
$puerto = $_SERVER['SERVER_PORT'] ?? 80;
if ($puerto == 80 || $puerto == 8080) {
    echo " Puerto correcto: $puerto<br>";
} else {
    echo " Puerto inusual: $puerto<br>";
    echo "Si Apache está en otro puerto, usa: http://localhost:$puerto/talent-sphere/<br>";
}
?>

