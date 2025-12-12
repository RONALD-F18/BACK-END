<?php
// config/Configuracion.php - Configuración del Sistema Talent Sphere

// --- URL / RUTAS ---
// NOTA: Si Apache está en puerto 8080, cambia localhost por localhost:8080
// Por defecto XAMPP usa puerto 80 (no es necesario especificarlo)
// Si necesitas usar puerto 8080, cambia las URLs a: http://localhost:8080/login
define('BASE_PATH', '/login');
define('BASE_URL', 'http://localhost/login/index.php');
define('APP_URL', 'http://localhost/login'); // URL base para enlaces en emails

// --- CONFIGURACIÓN DE BASE DE DATOS ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'talent_sphere');
define('DB_USER', 'root');
define('DB_PASS', '');

// --- CONFIGURACIÓN DE SESIÓN ---
define('SESSION_NAME', 'talent_sphere_session');
define('SESSION_LIFETIME', 3600); // 1 hora

// --- ROLES DEL SISTEMA ---
define('ROL_ADMIN', 'Administrador');
define('ROL_FUNCIONARIO', 'Funcionario');

// --- ESTADOS ---
define('ESTADO_ACTIVO', 'Activo');
define('ESTADO_INACTIVO', 'Inactivo');

// --- CONFIGURACIÓN SMTP (Gmail) ---
// Rellena aquí con tu correo y la clave de aplicación de Gmail
// ¡IMPORTANTE! Reemplaza los valores de ejemplo:
define('SMTP_USER', 'ronaldacademy223@gmail.com');          // <- TU CORREO DE GMAIL REAL
define('SMTP_PASS', 'overqmotyvbxzoaf');  // <- TU CLAVE DE APLICACIÓN DE 16 CARACTERES
define('SMTP_FROM_NAME', 'TRonald');                // nombre del remitente