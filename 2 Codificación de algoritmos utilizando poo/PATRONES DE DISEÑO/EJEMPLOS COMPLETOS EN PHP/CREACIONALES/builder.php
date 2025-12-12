<?php

// ===========================================
// 1. PRODUCTO: CASA
// ===========================================
class Casa {
    private $paredes = 0;
    private $puertas = 0;
    private $ventanas = 0;

    public function setParedes($cantidad) {
        $this->paredes = $cantidad;
    }

    public function setPuertas($cantidad) {
        $this->puertas = $cantidad;
    }

    public function setVentanas($cantidad) {
        $this->ventanas = $cantidad;
    }

    public function __toString() {
        return "Casa con $this->paredes paredes, $this->puertas puertas y $this->ventanas ventanas.";
    }
}

// ===========================================
// 2. BUILDER: INTERFAZ
// ===========================================
interface ConstructorCasa {
    public function construirParedes();
    public function construirPuertas();
    public function construirVentanas();
    public function obtenerCasa(): Casa;
}

// ===========================================
// 3. BUILDER CONCRETO
// ===========================================
class ConstructorCasaSimple implements ConstructorCasa {

    private $casa;

    public function __construct() {
        $this->casa = new Casa();
    }

    public function construirParedes() {
        $this->casa->setParedes(4);
    }

    public function construirPuertas() {
        $this->casa->setPuertas(1);
    }

    public function construirVentanas() {
        $this->casa->setVentanas(2);
    }

    public function obtenerCasa(): Casa {
        return $this->casa;
    }
}

// ===========================================
// 4. DIRECTOR
// ===========================================
class Ingeniero {
    public function construir(ConstructorCasa $builder): Casa {
        $builder->construirParedes();
        $builder->construirPuertas();
        $builder->construirVentanas();
        return $builder->obtenerCasa();
    }
}

// ===========================================
// 5. EJEMPLO DE USO
// ===========================================
$builder = new ConstructorCasaSimple();
$ingeniero = new Ingeniero();

$casa = $ingeniero->construir($builder);

echo $casa;  // Casa con 4 paredes, 1 puertas y 2 ventanas.

