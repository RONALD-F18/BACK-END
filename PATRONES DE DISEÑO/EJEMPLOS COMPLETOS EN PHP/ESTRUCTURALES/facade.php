<?php

// ===========================================
// 1. SUBSISTEMA: SISTEMA DE SONIDO
// ===========================================
class SistemaSonido {

    public function encender() {
        echo "Sonido encendido\n";
    }

    public function subirVolumen() {
        echo "Volumen subiendo...\n";
    }

    public function apagar() {
        echo "Sonido apagado\n";
    }
}

// ===========================================
// 2. SUBSISTEMA: PANTALLA
// ===========================================
class SistemaPantalla {

    public function bajarPantalla() {
        echo "Pantalla bajando...\n";
    }

    public function subirPantalla() {
        echo "Pantalla subiendo...\n";
    }
}

// ===========================================
// 3. SUBSISTEMA: PROYECTOR
// ===========================================
class SistemaProyector {

    public function encender() {
        echo "Proyector encendido\n";
    }

    public function apagar() {
        echo "Proyector apagado\n";
    }
}

// ===========================================
// 4. FACHADA: FACHADA CINE
// ===========================================
class FachadaCine {

    private SistemaSonido $sonido;
    private SistemaPantalla $pantalla;
    private SistemaProyector $proyector;

    public function __construct(
        SistemaSonido $sonido,
        SistemaPantalla $pantalla,
        SistemaProyector $proyector
    ) {
        $this->sonido = $sonido;
        $this->pantalla = $pantalla;
        $this->proyector = $proyector;
    }

    public function iniciarPelicula() {
        echo "Preparando para iniciar la película...\n";
        $this->pantalla->bajarPantalla();
        $this->proyector->encender();
        $this->sonido->encender();
        $this->sonido->subirVolumen();
        echo "¡Película iniciada!\n";
    }

    public function terminarPelicula() {
        echo "Finalizando la película...\n";
        $this->sonido->apagar();
        $this->proyector->apagar();
        $this->pantalla->subirPantalla();
        echo "Cine apagado.\n";
    }
}

// ===========================================
// 5. EJEMPLO DE USO
// ===========================================

$sonido = new SistemaSonido();
$pantalla = new SistemaPantalla();
$proyector = new SistemaProyector();

$fachada = new FachadaCine($sonido, $pantalla, $proyector);

$fachada->iniciarPelicula();
echo "\n";
$fachada->terminarPelicula();
