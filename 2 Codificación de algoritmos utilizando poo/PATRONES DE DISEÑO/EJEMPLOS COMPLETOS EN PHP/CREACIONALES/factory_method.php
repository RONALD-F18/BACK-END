<?php

// ===========================================
// 1. INTERFAZ ANIMAL
// ===========================================
interface Animal {
    public function hacerSonido(): string;
}

// ===========================================
// 2. CLASE PERRO QUE IMPLEMENTA ANIMAL
// ===========================================
class Perro implements Animal {
    public function hacerSonido(): string {
        return "Guau guau";
    }
}

// ===========================================
// 3. CLASE ABSTRACTA CREADOR (FACTORY METHOD)
// ===========================================
abstract class CreadorAnimal {
    // Método Factory
    public abstract function crear(): Animal;

    // Método opcional para demostrar el uso del objeto creado
    public function mostrarSonido(): string {
        $animal = $this->crear();
        return $animal->hacerSonido();
    }
}

// ===========================================
// 4. CREADOR CONCRETO QUE CREA PERROS
// ===========================================
class CreadorPerro extends CreadorAnimal {
    public function crear(): Animal {
        return new Perro();  // crea el producto concreto
    }
}

// ===========================================
// 5. EJEMPLO DE USO
// ===========================================
$creador = new CreadorPerro();
$perro = $creador->crear();

echo $perro->hacerSonido();       // Guau guau
echo "\n";
echo $creador->mostrarSonido();   // Guau guau

