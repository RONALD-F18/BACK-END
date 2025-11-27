<?php

// =======================
//     INTERFACE COMMAND
// =======================
interface Comando
{
    public function ejecutar();
}

// =======================
//        RECEPTOR
// =======================
class Luz
{
    public function encender()
    {
        echo "La luz está encendida.<br>";
    }

    public function apagar()
    {
        echo "La luz está apagada.<br>";
    }
}

// =======================
//    COMANDOS CONCRETOS
// =======================
class ComandoEncenderLuz implements Comando
{
    private Luz $luz;

    public function __construct(Luz $luz)
    {
        $this->luz = $luz;
    }

    public function ejecutar()
    {
        $this->luz->encender();
    }
}

class ComandoApagarLuz implements Comando
{
    private Luz $luz;

    public function __construct(Luz $luz)
    {
        $this->luz = $luz;
    }

    public function ejecutar()
    {
        $this->luz->apagar();
    }
}

// =======================
//        INVOCADOR
// =======================
class ControlRemoto
{
    private Comando $boton;

    public function setComando(Comando $c)
    {
        $this->boton = $c;
    }

    public function presionarBoton()
    {
        $this->boton->ejecutar();
    }
}

// =======================
//       PRUEBA DEL PATRÓN
// =======================

$luz = new Luz();

$encender = new ComandoEncenderLuz($luz);
$apagar   = new ComandoApagarLuz($luz);

$control = new ControlRemoto();

$control->setComando($encender);
$control->presionarBoton();   // Enciende

$control->setComando($apagar);
$control->presionarBoton();   // Apaga
