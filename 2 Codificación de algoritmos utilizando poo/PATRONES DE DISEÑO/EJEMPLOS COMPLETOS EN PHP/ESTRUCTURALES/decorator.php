<?php

// ===========================================
// 1. INTERFAZ COMPONENTE
// ===========================================
interface Bebida {
    public function obtenerDescripcion(): string;
    public function obtenerCosto(): float;
}

// ===========================================
// 2. COMPONENTE CONCRETO
// ===========================================
class CafeSimple implements Bebida {
    public function obtenerDescripcion(): string {
        return "Café simple";
    }

    public function obtenerCosto(): float {
        return 5.0;
    }
}

// ===========================================
// 3. DECORADOR ABSTRACTO
// ===========================================
abstract class BebidaDecorador implements Bebida {
    
    protected Bebida $bebida;

    public function __construct(Bebida $bebida) {
        $this->bebida = $bebida;
    }

    public function obtenerDescripcion(): string {
        return $this->bebida->obtenerDescripcion();
    }

    public function obtenerCosto(): float {
        return $this->bebida->obtenerCosto();
    }
}

// ===========================================
// 4. DECORADOR CONCRETO: LECHE
// ===========================================
class DecoradorLeche extends BebidaDecorador {

    public function obtenerDescripcion(): string {
        return $this->bebida->obtenerDescripcion() . " + leche";
    }

    public function obtenerCosto(): float {
        return $this->bebida->obtenerCosto() + 1.0;
    }
}

// ===========================================
// 5. DECORADOR CONCRETO: CHOCOLATE
// ===========================================
class DecoradorChocolate extends BebidaDecorador {

    public function obtenerDescripcion(): string {
        return $this->bebida->obtenerDescripcion() . " + chocolate";
    }

    public function obtenerCosto(): float {
        return $this->bebida->obtenerCosto() + 2.0;
    }
}

// ===========================================
// 6. EJEMPLO DE USO
// ===========================================

// Café simple
$bebida = new CafeSimple();
echo $bebida->obtenerDescripcion() . " = $" . $bebida->obtenerCosto() . "\n";

// Café con leche
$bebida = new DecoradorLeche($bebida);
echo $bebida->obtenerDescripcion() . " = $" . $bebida->obtenerCosto() . "\n";

// Café con leche y chocolate
$bebida = new DecoradorChocolate($bebida);
echo $bebida->obtenerDescripcion() . " = $" . $bebida->obtenerCosto() . "\n";

