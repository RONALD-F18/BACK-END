// 4. La Cía. MAZDA premia anualmente a sus mejores vendedores de acuerdo a la
// siguiente tabla:
// Si vendió Le corresponde de Comisión sobre ventas totales
// 1000000 <= venta < 3000000 3%
// 3000000 <= venta < 5000000 4%
// 5000000 <= venta < 7000000 5%
// 7000000 <= venta < 10000000 6%
// Diseñar un programa que lea las ventas de 100 vendedores y que escriba la
// comisión anual que le corresponda a cada vendedor. Nota ningún vendedor vende
// más de 10000000 al año.

class Venta {

    //Se espera el valor de la longitud de los datos a operar  con los arreglos que almacenaran los valores el % de descuento y el total a pagar
    constructor(longitud){

        this.longitud = longitud;

        this.valores = [];
        this.comisiones = [];
        this.ganancias = [];
        this.contador = 1;  
    }

    //Función clave en donde se evaluan las condiciones dadas en el enunciado 
    agregar(venta){

        let comision;
        let ganancia;

        this.valores.push(venta);

        if(venta >= 0 && venta < 1000000) {

            comision = 0;

            ganancia = venta * comision;

            this.comisiones.push(comision);
            this.ganancias.push(ganancia);

        } else if (venta >= 1000000 && venta < 3000000){

            comision = 0.03;

            ganancia = venta * comision;

            this.comisiones.push(comision);
            this.ganancias.push(ganancia);

        } else if (venta >= 3000000 && venta < 5000000){

            comision = 0.04;

            ganancia = venta * comision;

            this.comisiones.push(comision);
            this.ganancias.push(ganancia);

        } else if (venta >= 5000000 && venta < 7000000){

            comision = 0.05;

            ganancia = venta * comision;

            this.comisiones.push(comision);
            this.ganancias.push(ganancia);

        } else if (venta >= 7000000 && venta < 10000000){

            comision = 0.06;

            ganancia = venta * comision;

            this.comisiones.push(comision);
            this.ganancias.push(ganancia);

        } 

    }

    //Se muestran los resultados mediante un for simple
    mostrar(){
        let texto = "<h2>Reporte de Ventas:</h2>";

        for (let incremento = 0; incremento < this.valores.length; incremento++){

             texto += `<p>Vendedor: ${incremento + 1} | Valor Venta: ${this.valores[incremento]}$ | Comisión: ${this.comisiones[incremento]*100}% | Total de Ganancia en Comisiones: ${this.ganancias[incremento]}$</p>`;

        }

        return texto;
       
    }

    
    

}

//Se pasa la longitud de valores a operar
const venta = new Venta(5);


//Localización de etiquetas html

const contador = document.getElementById("contador");
const input = document.getElementById("form__input");
const boton = document.getElementById("form__button");
const resultado = document.getElementById("result");


//Pimer indicación para el usuario de orientación
contador.textContent = `Ingrese la venta del Vendedor número 1`;

//Evento clave al hacer click, evitando que se recargue la página
boton.addEventListener("click", (event) => {
    event.preventDefault();
    registrarVenta();       
});


function registrarVenta () {

    //condición clave para evaluar si ya se registraron las ventas necesarias
    if (venta.contador > venta.longitud) {
        contador.textContent = "Ingreso completado!";
        resultado.innerHTML = venta.mostrar(); 
    }

    let  valor = input.value.trim();

    //Condición para evaluar si el input esta vacio
    if (valor === "") {

        document.getElementById("result").innerHTML = "Por favor Ingrese un número";        
        return;

    }

    valor = parseFloat(valor);


    //Condiciones implicitas en el ejercicio a tener en cuenta.
    if (valor < 0) {

        document.getElementById("result").innerHTML = "Ingrese un valor igual o mayor a 0 para continuar";
        return;

    } else if (valor >= 10000000){

        document.getElementById("result").innerHTML = "El valor de la venta no puede ser igual o superior a 10.000.000";
        return;

    } else {


        //Si se ingreso un valor valido se ejecuta su metodo correspondiente.
        venta.agregar(valor);


        input.value = "";

        venta.contador++;


        if (venta.contador > venta.longitud) {

            contador.textContent = "Ingreso completado!";
            resultado.innerHTML = venta.mostrar();
            
        } else {

            contador.textContent = `Ingrese la venta del Vendedor número: ${venta.contador}`;
            document.getElementById("result").innerHTML = "Venta agregada";
        }

    }

}
