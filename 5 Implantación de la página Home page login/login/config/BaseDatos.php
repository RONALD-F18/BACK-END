<?php
// config/BaseDatos.php - Patrón Singleton para conexión a BD

class BaseDatos {
    private static $instancia = null;
    private $conexion = null;

    // Constructor privado para prevenir instanciación directa
    private function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $opciones = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $this->conexion = new PDO($dsn, DB_USER, DB_PASS, $opciones);
        } catch (PDOException $e) {
            throw new Exception("Error de conexión a la Base de Datos: " . $e->getMessage());
        }
    }

    // Prevenir clonación
    private function __clone() {}

    // Prevenir deserialización
    public function __wakeup() {
        throw new Exception("No se puede deserializar un singleton.");
    }

    /**
     * Obtiene la instancia única de la clase (Singleton)
     * @return BaseDatos
     */
    public static function getInstancia(): BaseDatos {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    /**
     * Obtiene la conexión PDO
     * @return PDO
     */
    public function getConexion(): PDO {
        return $this->conexion;
    }

    /**
     * Método estático de conveniencia para obtener la conexión directamente
     * @return PDO
     */
    public static function conectar(): PDO {
        return self::getInstancia()->getConexion();
    }
}
