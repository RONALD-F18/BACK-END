//1. Leer un número y escribir el valor absoluto del mismo.

class numero {

    constructor(valor, resultado){
        this.valor = valor;
        this.resultado = resultado;
    }

    set_valor(valor){
        this.valor = valor;
    }

    get_valor (){
        return `${this.valor}`;
    }

    set_resultado(resultado){
        this.resultado = resultado;
    }

    get_resultado (){
        return `${this.resultado}`;
    }
}

function operacion (numero1){

    let valor = numero1.get_valor();

    let resultado = numero1.get_resultado();

    if(valor < 0) {

        resultado = valor * -1;

    } else {

        resultado = valor;

    }

    numero1.set_resultado(resultado);

    let mensaje = `Resultado: ${numero1.get_resultado() }` ;

    document.getElementById("resultado").innerHTML += mensaje + "<br>";
    
}

function repetir () {

    let conteo = 1;

    while(conteo !== 0){

        let pregunta = parseFloat(prompt("Deseas validar otro número? 1. Si 2. No presiona otro número"));

        if (pregunta === 1){

            let valor = parseFloat(prompt("Ingrese un número para encontrar su valor absoluto"));

            let numero1 = new numero(valor, 0);

            numero1.set_valor(valor);

            operacion(numero1);

        } else {

            conteo = 0;

        }
    }
}

let valor = parseFloat(prompt("Ingrese un número para encontrar su valor absoluto"));

let numero1 = new numero(valor, 0);

operacion(numero1);

repetir();