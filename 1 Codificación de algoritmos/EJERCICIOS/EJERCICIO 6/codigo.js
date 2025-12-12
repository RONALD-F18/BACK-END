// 6.Se tiene almacenada la matriz M (50,5) la cual contiene la información sobre las
// calificaciones de la materia de LENGUAJES ALGORITMICOS. Esta información,
// es el código estudiantil del alumno, Calificación 1, Calificación 2, Calificación 3,
// Calificación final.
// Escriba un programa que imprima:
// A).-Cantidad de alumnos que aprobaron la materia(Para aprobar, entre 3.0 y
// 5.0) .
// B).-Cantidad de alumnos que tienen derecho a recuperar(para recuperación,
// promedio Calificación final entre 2.0 y 2.9).
// C).-El número de alumnos que hayan, obtenido la máxima Calificación
// final(Calificación final igual a 5.0).

// Notas:
// • Las notas deben estar entre 1.0 y 5.0, se debe controlar, que esté la
// calificación en este
// rango.
// • La Calificación final, debe ser obtenida, del promedio de las tres
// calificaciones
// anteriores ingresadas, no es un dato de entrada.


//Clase principal
class Alumno {

    //Logitud de alumnos
    constructor(longitud){
        this.longitud = longitud;
        this.contador = 1;
        this.registros = [];
    }

    set_longitud (longitud){
        this.longitud = longitud;
    }

    get_longitud () {
        return this.longitud;
    }

    //Metodo que agrega los datos a la matrix principal ([])
    set_calcular (codigo, valor1, valor2, valor3){

        let promedio = ((valor1 + valor2 + valor3)/3);

        this.registros.push([codigo, valor1, valor2, valor3, promedio]);

    }

    //Visualización de resultados
    set_mostrar () {

        //Variables de control para los apartados A, B, C
        let aprobados = 0;
        let recuperacion = 0;
        let maxima = 0;

        //Recorrela por decirlo asi las filas de la matriz para validar los aprtados A, B, C
        for(let i = 0; i < this.longitud; i++){
   
            if (this.registros[i][4] >= 3.0 && this.registros[i][4] <= 5.0) {

                //Aprobados
                aprobados += 1;
            } else if (this.registros[i][4] >= 2.0 && this.registros[i][4] < 3.0) {
  
                //Recuperación
                recuperacion += 1;
            }   

            if (this.registros[i][4] === 5.0) {
                
                // Máxima calificación
                maxima += 1;
            }

        }

        //Se imprimen los apartados A, B, C
        document.getElementById("result__aprobados").innerHTML = `Cantidad de alumnos que aprobaron la materia: ${aprobados}`;

        document.getElementById("result__recuperaciones").innerHTML = `Cantidad de alumnos que tienen derecho a recuperar: ${recuperacion}`;

        document.getElementById("result__maxima").innerHTML = `Cantidad de alumnos que tienen la máxima calificación: ${maxima}`;

        
        //Informe final
        let mensaje = "Informe:<br><br>";

        for(let i = 0; i < this.longitud; i++){
            mensaje += `<p>Código Alumno: ${this.registros[i][0]}</p>`;

            mensaje += `<p>Código Calificación 1: ${this.registros[i][1]}</p>`;

            mensaje += `<p>Código Calificación 2: ${this.registros[i][2]}</p>`;

            mensaje += `<p>Código Calificación 3: ${this.registros[i][3]}</p>`;

            mensaje += `<p>Código Calificación Final: ${this.registros[i][4]}</p>`;

            mensaje += `<br>`;

            mensaje += `<br>`;
        }

        document.getElementById("result").innerHTML = mensaje;
    }

    

}

//Se pasa la longitud de alumanos a registrar sus notas
const alumno1 = new Alumno(5);

//Se obtienen id de algunos apartados del html
const contador = document.getElementById("contador");
const boton = document.getElementById("form__button");
const resultado = document.getElementById("result");

//Primera indicación al usuario
contador.textContent = `Ingrese los datos del alumno número 1 de ${alumno1.longitud}:`;


boton.addEventListener("click", (event) => {
    event.preventDefault();
    registrarDatos();
});

function registrarDatos () {

    //Se obtienen mas id, no se obtiene el valor directamente para despues al registrar los datos de un alumno que aparezcan vacios
    let inputCodigo = document.getElementById("form__codigo");
    let input1 = document.getElementById("form__cal1");
    let input2 = document.getElementById("form__cal2");
    let input3 = document.getElementById("form__cal3");

    //Se obtienen como tal los valores ingresados por el usuario
    let codigo = parseFloat(inputCodigo.value);
    let valor1 = parseFloat(input1.value);
    let valor2 = parseFloat(input2.value);
    let valor3 = parseFloat(input3.value);

    //Si esta vacio el input
    if (isNaN(codigo) || isNaN(valor1) || isNaN(valor2) || isNaN(valor3)) {
        resultado.innerHTML = "Por favor Ingrese un valor en todos los campos!"
        return;
    }

    //Validación que pide el ejercicio
    if (valor1 < 1.0 || valor1 > 5.0 || valor2 < 1.0 || valor2 > 5.0 || valor3 < 1.0 || valor3 > 5.0) {
        resultado.innerHTML = ("Las calificaciones deben estar entre 1.0 y 5.0");
        return;
    }

    //Se le pasan valores al metodo principal de la clase
    alumno1.set_calcular(codigo, valor1, valor2, valor3);

    inputCodigo.value = "";
    input1.value = "";
    input2.value = "";
    input3.value = "";

    alumno1.contador++;

    //Condiciones claves:
    if (alumno1.contador > alumno1.longitud) {
            contador.textContent = "Ingreso completado!";
            alumno1.set_mostrar();
            return;
    } else {
        contador.textContent = `Ingrese el número ${alumno1.contador} de ${alumno1.longitud}:`;
        resultado.innerHTML = "Valor Agregado!"
    }

}
