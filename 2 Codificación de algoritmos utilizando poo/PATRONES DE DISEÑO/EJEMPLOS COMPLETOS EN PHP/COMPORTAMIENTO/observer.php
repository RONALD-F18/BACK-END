<?php

// ===========================================
// 1. INTERFAZ SUJETO
// ===========================================
interface Sujeto {
    public function adjuntar(Observador $obs);
    public function desadjuntar(Observador $obs);
    public function notificar();
}

// ===========================================
// 2. INTERFAZ OBSERVADOR
// ===========================================
interface Observador {
    public function actualizar(string $mensaje);
}

// ===========================================
// 3. SUJETO CONCRETO: CANAL DE YOUTUBE
// ===========================================
class CanalYouTube implements Sujeto {

    /** @var Observador[] */
    private array $suscriptores = [];

    private string $ultimoVideo = "";

    public function adjuntar(Observador $obs) {
        $this->suscriptores[] = $obs;
    }

    public function desadjuntar(Observador $obs) {
        $this->suscriptores = array_filter(
            $this->suscriptores,
            fn($s) => $s !== $obs
        );
    }

    public function subirVideo(string $titulo) {
        $this->ultimoVideo = $titulo;
        echo "📹 Canal subió un nuevo video: $titulo\n";
        $this->notificar();
    }

    public function notificar() {
        foreach ($this->suscriptores as $s) {
            $s->actualizar("Nuevo video publicado: " . $this->ultimoVideo);
        }
    }
}

// ===========================================
// 4. OBSERVADOR CONCRETO: MÓVIL
// ===========================================
class SuscriptorMovil implements Observador {

    private string $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    public function actualizar(string $mensaje) {
        echo "📱 {$this->nombre} recibió notificación en MÓVIL: $mensaje\n";
    }
}

// ===========================================
// 5. OBSERVADOR CONCRETO: PC
// ===========================================
class SuscriptorPC implements Observador {

    private string $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    public function actualizar(string $mensaje) {
        echo "💻 {$this->nombre} recibió notificación en PC: $mensaje\n";
    }
}

// ===========================================
// 6. EJEMPLO DE USO
// ===========================================

$canal = new CanalYouTube();

// Crear suscriptores
$s1 = new SuscriptorMovil("Carlos");
$s2 = new SuscriptorPC("Ana");
$s3 = new SuscriptorMovil("Luis");

// Adjuntar suscriptores
$canal->adjuntar($s1);
$canal->adjuntar($s2);
$canal->adjuntar($s3);

// Subir video
$canal->subirVideo("Patrón Observer explicado paso a paso");
