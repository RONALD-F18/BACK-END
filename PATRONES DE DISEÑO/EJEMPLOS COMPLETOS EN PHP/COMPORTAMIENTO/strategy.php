<?php

// ===========================================
// 1. INTERFAZ ESTRATEGIA
// ===========================================
interface EstrategiaEnvio {
    public function calcularCosto(int $distancia): float;
}

// ===========================================
// 2. ESTRATEGIA: ENVÍO NORMAL
// ===========================================
class EnvioNormal implements EstrategiaEnvio {
    public function calcularCosto(int $distancia): float {
        return $distancia * 1.0; // costo base
    }
}

// ===========================================
// 3. ESTRATEGIA: ENVÍO RÁPIDO
// ===========================================
class EnvioRapido implements EstrategiaEnvio {
    public function calcularCosto(int $distancia): float {
        return $distancia * 2.5; // más caro por mayor velocidad
    }
}

// ===========================================
// 4. ESTRATEGIA: ENVÍO ECONÓMICO
// ===========================================
class EnvioEconomico implements EstrategiaEnvio {
    public function calcularCosto(int $distancia): float {
        return $distancia * 0.7; // más barato
    }
}

// ===========================================
// 5. CONTEXTO: CARRITO DE COMPRAS
// ===========================================
class CarritoCompras {

    private EstrategiaEnvio $estrategia;

    public function __construct(EstrategiaEnvio $estrategia) {
        $this->estrategia = $estrategia;
    }

    public function cambiarEstrategia(EstrategiaEnvio $estrategia) {
        $this->estrategia = $estrategia;
    }

    public function procesarEnvio(int $distancia) {
        $costo = $this->estrategia->calcularCosto($distancia);
        echo "Costo del envío: $" . $costo . "\n";
    }
}

// ===========================================
// 6. EJEMPLO DE USO
// ===========================================

$carrito = new CarritoCompras(new EnvioNormal());
$carrito->procesarEnvio(10);  // Envío normal

$carrito->cambiarEstrategia(new EnvioRapido());
$carrito->procesarEnvio(10);  // Envío rápido

$carrito->cambiarEstrategia(new EnvioEconomico());
$carrito->procesarEnvio(10);  // Envío económico

