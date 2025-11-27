<?php

// ===========================================
// 1. INTERFAZ OBJETIVO
// ===========================================
interface Reproductor {
    public function reproducirArchivo(string $nombre);
}

// ===========================================
// 2. IMPLEMENTACIÓN REAL (compatible)
// ===========================================
class ReproductorMP3 implements Reproductor {
    public function reproducirArchivo(string $nombre) {
        echo "Reproduciendo archivo MP3: $nombre\n";
    }
}

// ===========================================
// 3. CLASE INCOMPATIBLE (LEGADO)
// ===========================================
class ReproductorAACAntiguo {
    public function reproducirAAC(string $archivo) {
        echo "Reproduciendo AAC (sistema antiguo): $archivo\n";
    }
}

// ===========================================
// 4. ADAPTADOR (convierte la interfaz)
// ===========================================
class AdaptadorAAC implements Reproductor {

    private ReproductorAACAntiguo $reproductorAAC;

    public function __construct(ReproductorAACAntiguo $reproductorAAC) {
        $this->reproductorAAC = $reproductorAAC;
    }

    public function reproducirArchivo(string $nombre) {
        // Adaptación: convertir llamada moderna a la antigua
        $this->reproductorAAC->reproducirAAC($nombre);
    }
}

// ===========================================
// 5. EJEMPLO DE USO
// ===========================================

// Reproductor normal
$mp3 = new ReproductorMP3();
$mp3->reproducirArchivo("cancion.mp3");

// Reproductor AAC usando adaptador
$reproductorAntiguo = new ReproductorAACAntiguo();
$adaptador = new AdaptadorAAC($reproductorAntiguo);
$adaptador->reproducirArchivo("audio.aac");

