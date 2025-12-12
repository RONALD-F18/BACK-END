<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'talent_sphere';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Instalador Talent Sphere</title></head><body>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    h1 { color: #4f46e5; }
    .ok { color: #16a34a; font-weight: bold; }
    .error { color: #dc2626; font-weight: bold; }
    .warning { color: #d97706; }
    table { border-collapse: collapse; width: 100%; margin: 20px 0; }
    th, td { border: 1px solid #e5e7eb; padding: 12px; text-align: left; }
    th { background: #4f46e5; color: white; }
    tr:nth-child(even) { background: #f9fafb; }
    code { background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
    .btn { display: inline-block; padding: 15px 30px; background: #4f46e5; color: white; text-decoration: none; border-radius: 8px; font-size: 16px; margin-top: 20px; }
    .btn:hover { background: #4338ca; }
</style>";
echo "<div class='container'>";
echo "<h1>🚀 Instalador Talent Sphere</h1>";

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
    echo "<p class='ok'>✅ Conexión a MySQL exitosa</p>";

    $pdo->exec("DROP DATABASE IF EXISTS `$dbname`");
    $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");
    echo "<p class='ok'>✅ Base de datos '$dbname' creada</p>";

    $pdo->exec("
        CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombres VARCHAR(100) NOT NULL,
            apellidos VARCHAR(100) NOT NULL,
            username VARCHAR(50) UNIQUE,
            tipo_documento ENUM('CC', 'CE', 'TI', 'PA') DEFAULT 'CC',
            num_documento VARCHAR(20) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            telefono VARCHAR(20),
            fecha_nacimiento DATE,
            rol ENUM('Administrador', 'Funcionario') DEFAULT 'Funcionario',
            estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
            fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
            ultimo_acceso DATETIME,
            token_recuperacion VARCHAR(100) DEFAULT NULL,
            token_expiracion DATETIME DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    echo "<p class='ok'>✅ Tabla 'usuarios' creada</p>";

    $hashAdmin = password_hash('admin123', PASSWORD_BCRYPT);
    $hashUser = password_hash('password123', PASSWORD_BCRYPT);

    // 5. Insertar usuarios
    $stmt = $pdo->prepare("
        INSERT INTO usuarios (nombres, apellidos, username, tipo_documento, num_documento, email, password, telefono, rol, estado, fecha_nacimiento, ultimo_acceso) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    // Admin
    $stmt->execute(['Admin', 'Sistema', 'admin', 'CC', '1234567890', 'admin@talentsphere.com', $hashAdmin, '3001234567', 'Administrador', 'Activo', '1990-01-01']);
    
    // Usuarios de prueba
    $stmt->execute(['Carlos Andrés', 'Gómez', 'carlosgomez', 'CC', '1015432198', 'carlos@empresa.com', $hashUser, '+57 3105551234', 'Funcionario', 'Activo', '1985-03-15']);
    $stmt->execute(['María Fernanda', 'López', 'marialopez', 'CC', '1020567834', 'maria@empresa.com', $hashUser, '+57 3205557890', 'Funcionario', 'Activo', '1990-07-22']);
    $stmt->execute(['Juan Pablo', 'Martínez', 'juanmartinez', 'CC', '1025678901', 'juan@empresa.com', $hashUser, '+57 3155559876', 'Funcionario', 'Activo', '1988-11-08']);
    $stmt->execute(['Andrea Carolina', 'Silva', 'andreasilva', 'CC', '1033705584', 'andrea@empresa.com', $hashUser, '+57 3185554321', 'Funcionario', 'Inactivo', '1992-05-30']);

    echo "<p class='ok'> 5 usuarios insertados</p>";

    // 6. Mostrar tabla de usuarios
    echo "<h2> Usuarios creados:</h2>";
    echo "<table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Contraseña</th>
        </tr>";

    $result = $pdo->query("SELECT id, username, email, rol, estado FROM usuarios ORDER BY id");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $pwd = ($row['username'] === 'admin') ? 'admin123' : 'password123';
        $estadoClass = ($row['estado'] === 'Activo') ? 'ok' : 'warning';
        echo "<tr>
            <td>{$row['id']}</td>
            <td><strong>{$row['username']}</strong></td>
            <td>{$row['email']}</td>
            <td>{$row['rol']}</td>
            <td class='$estadoClass'>{$row['estado']}</td>
            <td><code>$pwd</code></td>
        </tr>";
    }
    echo "</table>";

    // 7. Verificar que el login funciona
    echo "<h2> Verificación de contraseñas:</h2>";
    
    $stmt = $pdo->prepare("SELECT username, password FROM usuarios WHERE username = ?");
    $stmt->execute(['admin']);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin && password_verify('admin123', $admin['password'])) {
        echo "<p class='ok'> TEST EXITOSO: admin / admin123 funciona correctamente</p>";
    } else {
        echo "<p class='error'> ERROR: La verificación de contraseña falló</p>";
    }

    $stmt->execute(['carlosgomez']);
    $carlos = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($carlos && password_verify('password123', $carlos['password'])) {
        echo "<p class='ok'> TEST EXITOSO: carlosgomez / password123 funciona correctamente</p>";
    } else {
        echo "<p class='error'> ERROR: La verificación de contraseña falló</p>";
    }

    // 8. Éxito
    echo "<hr>";
    echo "<h2 style='color: #16a34a;'> ¡Instalación completada con éxito!</h2>";
    echo "<p>Ahora puede acceder al sistema con las credenciales mostradas arriba.</p>";
    echo "<a href='index.php' class='btn'> Ir al Sistema</a>";
    echo "<p class='warning' style='margin-top: 20px;'> <strong>IMPORTANTE:</strong> Elimine este archivo (instalar.php) después de usarlo por seguridad.</p>";

} catch (PDOException $e) {
    echo "<p class='error'> Error de base de datos: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Verifique que MySQL esté corriendo y que las credenciales sean correctas.</p>";
} catch (Exception $e) {
    echo "<p class='error'> Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "</div></body></html>";
