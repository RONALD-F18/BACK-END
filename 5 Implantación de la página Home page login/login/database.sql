-- =============================================
-- BASE DE DATOS: TALENT SPHERE
-- Sistema de Gestión de Recursos Humanos
-- =============================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS talent_sphere
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE talent_sphere;

-- =============================================
-- TABLA: usuarios
-- =============================================
CREATE TABLE IF NOT EXISTS usuarios (
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
    token_expiracion DATETIME DEFAULT NULL,
    
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_estado (estado),
    INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- USUARIO ADMINISTRADOR POR DEFECTO
-- Password: admin123
-- =============================================
INSERT INTO usuarios (
    nombres, 
    apellidos, 
    username, 
    tipo_documento,
    num_documento, 
    email, 
    password, 
    rol, 
    estado,
    fecha_nacimiento
) VALUES (
    'Administrador',
    'Sistema',
    'admin',
    'CC',
    '1234567890',
    'admin@talentsphere.com',
    '$2y$12$i1xCNqHO/GhWs7MnO/4gDeROsRilr.yCNo28d0/VqzdVw1.cYxGau',
    'Administrador',
    'Activo',
    '1990-01-01'
);

-- =============================================
-- USUARIOS DE EJEMPLO
-- Password para todos: password123
-- =============================================
INSERT INTO usuarios (nombres, apellidos, username, tipo_documento, num_documento, email, password, telefono, fecha_nacimiento, rol, estado) VALUES
('Carlos Andrés', 'Gómez López', 'carlosgomez', 'CC', '1015432198', 'carlos.gomez@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3105551234', '1985-03-15', 'Funcionario', 'Activo'),
('María Fernanda', 'López Rodríguez', 'marialopez', 'CC', '1020567834', 'maria.lopez@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3205557890', '1990-07-22', 'Funcionario', 'Activo'),
('Juan Pablo', 'Martínez Silva', 'juanmartinez', 'CC', '1025678901', 'juan.martinez@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3155559876', '1988-11-08', 'Funcionario', 'Activo'),
('Andrea Carolina', 'Silva Pérez', 'andreasilva', 'CC', '1033705584', 'andrea.silva@empresa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3185554321', '1992-05-30', 'Funcionario', 'Inactivo');

-- =============================================
-- VERIFICAR INSTALACIÓN
-- =============================================
SELECT 'Base de datos creada exitosamente!' AS mensaje;
SELECT COUNT(*) AS total_usuarios FROM usuarios;
