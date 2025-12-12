<?php

//Se pone este comando para inicializar un tipo de variable super global que guarda los datos temporalmente en el navegador
session_start();

//Se define la clase principal segun el enunciado sus atributos, metodos, etc.
class Persona
{

    //Atributos de acuerdo al enunciado
    private string $nombre;
    private string $apellido;
    private string $fechaNacimiento;
    private int $edad;
    private string $email;
    private string $telefono;
    private string $genero;


    //Constructor que inicializa los elementos
    public function __construct($nombre, $apellido, $fechaNacimiento, $edad, $email, $telefono, $genero)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->edad = $edad;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->genero = $genero;
    }

    //Getters
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getNombreCompleto()
    {
        return $this->nombre . " " . $this->apellido;
    }

    public function getFechaNacimiento(): string
    {
        return $this->fechaNacimiento;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    // Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setFechaNacimiento(string $fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setGenero($genero)
    {
        $this->genero = $genero;
    }


    //Metodos principales

    //Se declara como estatita para poder usarse sin necesidad de crear un objeto
    //Metodo para obtener la edad, primero se obtienen 3 datos como entero que son el año, mes y dia que se reciben en esta función, se asignan a unas variables, se obtiene el año, mes  y dia actuales se resra el año de nacimiento mesnos el actual y se valida si ya paso el mes y el dia
    public static function calcularEdad($anio, $mes, $dia)
    {

        $anio_nac = $anio;
        $mes_nac = $mes;
        $dia_nac = $dia;

        $anio_actual = date("Y");
        $mes_actual = date("m");
        $dia_actual = date("d");

        $edad = $anio_actual - $anio_nac;

        if ($mes_actual < $mes_nac || ($mes_actual == $mes_nac && $dia_actual < $dia_nac)) {
            $edad--;
        }

        return $edad;
    }

    //Metodos que estan en el ejercicio se cambio de array a que devuelvan string por que no entendia como hacerlo legal de esa manera

    public function comer()
    {
        return $this->getNombreCompleto() . " esta comiendo Tamal🍽️!";
    }

    public function caminar(): string
    {
        return $this->getNombreCompleto() . " está caminando 🚶";
    }

    public function hablar(): string
    {
        return $this->getNombreCompleto() . " está hablando 🗣️";
    }

    public function dormir(): string
    {
        return $this->getNombreCompleto() . " está durmiendo 🛌";
    }

    public function estudiar(): string
    {
        return $this->getNombreCompleto() . " está estudiando 📚";
    }
}


//Se valida sino exite la variable de tipo array super global con $_SESSION con el nombre de personas, si no existe se crea un arrelgo global de objetos tipo:
//$_SESSION["personas"] = [
//     0 => Persona(nombre: "Juan", apellido: "Pérez", edad: 25, email: "juan@example.com", telefono: "123456789", genero: "Masculino"),
//     1 => Persona(nombre: "María", apellido: "Gómez", edad: 30, email: "maria@example.com", telefono: "987654321", genero: "Femenino"),
//     ...
// ];

if (!isset($_SESSION["personas"])) {
    $_SESSION["personas"] = [];
}

/**Elimminar**/
//Si se envio mediante un metodo post y se le dio click al boton con id button__eliminar
//se accede al valor del input en el formulario con name indice que se le dio
//Se elimina del arreglo la persona con ese indice
//Se actaaliza el arreglo por que si no queda como con un tipo de hueco
//Lo que sigue se puso para evitar que cuando se recargue la pagina se agreguen personas con caracteres random que a la final no entendi por que pasaba, para este problema me apoye de la IA
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["button__eliminar"])) {
    $indice = $_POST["indice"];

    unset($_SESSION["personas"][$indice]);

    $_SESSION["personas"] = array_values($_SESSION["personas"]);

    header("Location: pagina.php");
    exit();
}

/**Agregar Datos */
//Si se envio mediante un metodo post y se le dio click al boton con id button__agregar
//Se obtienen los valores enviados desde el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["button__agregar"])) {
    $nombre = $_POST["name"];
    $apellido = $_POST["last__name"];
    $fechaNacimiento = $_POST["birthdate"];
    $email = $_POST["email"];
    $telefono = $_POST["phone"];
    $genero = $_POST["gender"];

    //2005-09-03
    //Se obtiene la fecha enviada como string y con substr se accede a ciertos caracteres, ya que en una fecha normal no varian y se pasan a entero para la función requerida
    $anio = intval(substr($fechaNacimiento, 0, 4));
    $mes = intval(substr($fechaNacimiento, 5, 2));
    $dia = intval(substr($fechaNacimiento, 8, 2));

    //Se le pasan los datos a la función estatica.
    $edad = Persona::calcularEdad($anio, $mes, $dia);

    //Se crea el obgeto normal
    $persona = new Persona($nombre, $apellido, $fechaNacimiento, $edad, $email, $telefono, $genero);

    //Se agrega a este tipo de array con objetos como se ilustro un poco en la parte de arriba
    $_SESSION["personas"][] = $persona;


    //Lo mismo que en la parte de arriba se menciono en eliminar
    header("Location: pagina.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persona</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header class="header">

        <h1>Persona</h1>

    </header>


    <div class="section">

        <form class="form" action="pagina.php" method="POST" id="form" autocomplete="off">

            <div class="form__input__container">
                <label for="name">Nombre:</label>
                <input type="text" name="name" class="form__input" id="name" required>
            </div>

            <div class="form__input__container">
                <label for="last__name">Apellido:</label>
                <input type="text" name="last__name" class="form__input" id="last__name" required>
            </div>

            <div class="form__input__container">
                <label for="birthdate">Fecha de Nacimiento:</label>
                <input type="date" name="birthdate" class="form__input" id="birthdate" required>
            </div>

            <div class="form__input__container">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form__input" id="email" required>
            </div>

            <div class="form__input__container">
                <label for="phone">Telefono:</label>
                <input type="text" name="phone" class="form__input" id="phone" required>
            </div>

            <div class="form__input__container">
                <label for="gender">Genero:</label>
                <select name="gender" id="gender" class="form__input" required>
                    <option value="">Selecionar...</option>
                    <option value="Másculino">Másculino</option>
                    <option value="Fémenino">Fémenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <br>

            <div class="form__input__container">
                <button type="submit" id="button__agregar" name="button__agregar">Agregar Persona</button>
            </div>

        </form>

    </div>

    <!--Para imprimir se uso la etiqueta table-->
    <div class="content">

        <table>

            <thead>
                <th>Nombre Completo</th>
                <th>Edad</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Genero</th>
            </thead>

            <tbody>
                <?php
                //Se valida si exite el arreglo global y si tiene mas de una persona
                if (isset($_SESSION["personas"]) && count($_SESSION["personas"]) > 0) {

                    //Se usa este for each para recorrer cada posición del array eso de as $indice =>P lo que hace es acceder al obgeto persona determinado por un indice es de cir tipo:
                    //$_SESSION["personas"] = [
                    //     0 => Persona(nombre: "Juan", apellido: "Pérez", edad: 25, email: "juan@example.com", telefono: "123456789", genero: "Masculino"),
                    //     1 => Persona(nombre: "María", apellido: "Gómez", edad: 30, email: "maria@example.com", telefono: "987654321", genero: "Femenino"),
                    //     ...
                    // ];  
                    //Los indices son los numeros y la $p es todo ese obgeto persona.
                    foreach ($_SESSION["personas"] as $indice => $p) {

                        echo "
                            <!--Se imprimen las columnas correspondientes con forme a los atributos de la clase usando el for each que recorre el arreclo con la variable p-->
                            <tr>
                                <td>{$p->getNombreCompleto()}</td>
                                <td>{$p->getEdad()}</td>
                                <td>{$p->getEmail()}</td>
                                <td>{$p->getTelefono()}</td>
                                <td>{$p->getGenero()}</td>
                                <td>

                                <!--Se ponen los botones correspondientes a lo solicitado por el enunciado que muestran un alerta y se accede a los metodos de ese objeto-->
                                    <button type='button' class='btn-comer' onclick=\"alert('{$p->comer()}');\">🍽️</button>
                                    <button type='button' class='btn-caminar' onclick=\"alert('{$p->caminar()}');\">🚶</button>
                                    <button type='button' class='btn-hablar' onclick=\"alert('{$p->hablar()}');\">🗣️</button>
                                    <button type='button' class='btn-dormir' onclick=\"alert('{$p->dormir()}');\">🛌</button>
                                    <button type='button' class='btn-estudiar' onclick=\"alert('{$p->estudiar()}');\">📚</button>


                                    <!--Se llama al isset eliminar en PHP y se envia como formulario con el valor del input-->
                                    <form method='POST' action='pagina.php' style='display:inline;'>
                                        <input type='hidden' name='indice' value='{$indice}'>
                                        <button type='submit' name='button__eliminar' class='btn-eliminar' onclick='return confirm(\"¿Estás seguro de eliminar esta persona?\")'>Eliminar</button>
                                    </form>


                                </td>
                            </tr>
                        ";
                    }
                    //Si no entra al if ejecuta esto y lo imprime se uso estilos sencillos en linea
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No hay personas registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>