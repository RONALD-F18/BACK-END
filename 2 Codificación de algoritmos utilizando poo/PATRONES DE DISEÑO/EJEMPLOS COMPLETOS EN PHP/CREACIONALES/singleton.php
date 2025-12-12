<?php

class Configuracion {

    // ===========================================
    // Atributos privados según UML
    // ===========================================
    private static ?Configuracion $instancia = null;
    private string $modo;

    // ===========================================
    // Constructor privado
    // ===========================================
    private function __construct() {
        $this->modo = "por defecto";
    }

    // ===========================================
    // Método estático getInstancia()
    // ===========================================
    public static function getInstancia(): Configuracion {
        if (self::$instancia === null) {
            self::$instancia = new Configuracion();
        }
        return self::$instancia;
    }

    // ===========================================
    // Setter del modo
    // ===========================================
    public function establecerModo(string $modo): void {
        $this->modo = $modo;
    }

    // ===========================================
    // Mostrar mensaje
    // ===========================================
    public function mostrarMensaje(): void {
        echo "El modo actual es: " . $this->modo . "\n";
    }
}

# ===========================================
# EJEMPLO DE USO
# ===========================================

$config1 = Configuracion::getInstancia();
$config1->establecerModo("producción");

$config2 = Configuracion::getInstancia();

$config1->mostrarMensaje(); // El modo actual es: producción
$config2->mostrarMensaje(); // El modo actual es: producción
