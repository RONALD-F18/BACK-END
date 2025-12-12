-- =============================================
-- MIGRACIÓN: Agregar columnas de token de recuperación
-- Ejecutar este script si la base de datos ya existe
-- Si las columnas ya existen, puede dar error pero no afecta la BD
-- =============================================

USE talent_sphere;

-- Agregar columnas (si ya existen, dará error pero no afecta)
ALTER TABLE usuarios 
ADD COLUMN token_recuperacion VARCHAR(100) DEFAULT NULL;

ALTER TABLE usuarios 
ADD COLUMN token_expiracion DATETIME DEFAULT NULL;

-- Actualizar contraseña del administrador
-- Password: admin123
UPDATE usuarios 
SET password = '$2y$12$i1xCNqHO/GhWs7MnO/4gDeROsRilr.yCNo28d0/VqzdVw1.cYxGau'
WHERE email = 'admin@talentsphere.com' AND username = 'admin';

SELECT 'Migración completada exitosamente!' AS mensaje;
