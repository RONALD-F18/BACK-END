// 5. Almacenar 500 números en un vector, elevar al cuadrado cada valor
// almacenado en el vector, y almacenar el resultado en otro vector. Imprimir
// el vector original y el vector resultante.

//Clase principal
class Numero {
    
    //Se ingresa la longitud de valores y los dos arreglos que almacenaran los números con una variable que llevara el conteo
    constructor(longitud) {
        this.longitud = longitud;

        this.valores = [];
        this.potencias = [];
        this.contador = 1;
    }

    //Se llama a esta función para agregar los valores a los arreglos.
    set_calcular(valor){

        this.valores.push(valor);

        let resultado = valor * valor;

        this.potencias.push(resultado);
        
    }


    set_mostrar () {

        //Se limpia el la etiqueta
        document.getElementById("result__originales").innerHTML = "";

        //Texto para indicarle los valores a mostrar al usuario
        document.getElementById("result__container__origins").innerHTML = "Números Ingresados:";

        //Se imprimen los valores del primer arreglo.
        for(let elemento of this.valores){
            
            document.getElementById("result__originales").innerHTML += "| " + elemento + " | ";

        }

        //Se limpia el la etiqueta
        document.getElementById("result__potencias").innerHTML = "";

        //Texto para indicarle los valores a mostrar al usuario
        document.getElementById("result__container__potencias").innerHTML = "Números Potenciados:";

        //Se imprimen los valores del segundo arreglo.
        for(let elemento of this.potencias){
            
            document.getElementById("result__potencias").innerHTML += "| " + elemento + " | ";

        }

    }
}

//Se pasa la longitud de valores a operar
const numero1 = new Numero(5);

//Se idenfican las etiquetas principales del html
const contador = document.getElementById("contador");
const input = document.getElementById("form__input");
const boton = document.getElementById("form__button");
const resultado = document.getElementById("result");

//Primera indicación al usuario
contador.textContent = `Ingrese el número 1 de ${numero1.longitud}:`;


//Evento clave al hacer click, evitando que se recargue la página
boton.addEventListener("click", (event) => {
    event.preventDefault();
    registrarNumero();
});



function registrarNumero() {
    

    let valor = input.value.trim();

    //Si esta vacio el input
    if (valor === "") {
        resultado.innerHTML = "Por favor Ingrese un número!"
        return;
    }

    valor = parseFloat(valor);

    numero1.set_calcular(valor);

    input.value = "";

    numero1.contador++;

    //Condiciones claves:
    if (numero1.contador > numero1.longitud) {
            contador.textContent = "Ingreso completado!";
            numero1.set_mostrar();
            return;
    } else {
        contador.textContent = `Ingrese el número ${numero1.contador} de ${numero1.longitud}:`;
        resultado.innerHTML = "Valor Agregado!"
    }


}