// 3. En un supermercado se hace una promoción, mediante la cual el cliente obtiene
// un descuento dependiendo de un número que se escoge al azar. Si el número
// escogido es menor que 74 el descuento es del 15% sobre el total de la compra,
// si es mayor o igual a 74 el descuento es del 20%. Obtener cuánto dinero se le
// descuenta.

class Compra {

    constructor(valor, numero, descuento, valorDescuento, resultado){
        this.valor = valor;
        this.numero = numero;
        this.descuento = descuento;
        this.valorDescuento = valorDescuento;
        this.resultado = resultado;
    }

    //Valor
    set_valor (valor) {
        this.valor = valor;
    }

    get_valor () {
        return `${this.valor}`;
    }

    //Número
    set_numero (numero) {
        this.numero = numero;
    }

    get_numero () {
        return `${this.numero}`;
    }

    //Descuento
    set_descuento (descuento) {
        this.descuento = descuento;
    }

    get_descuento () {
        return `${this.descuento}`;
    }

    //Valor Descuento
    set_valorDescuento (valorDescuento) {
        this.valorDescuento = valorDescuento;
    }

    get_valorDescuento () {
        return `${this.valorDescuento}`;
    }


    //Resultado
    set_resultado (resultado) {
        this.resultado = resultado;
    }

    get_resultado () {
        return `${this.resultado}`;
    }
}

//Se obtiene el formulario
    const form = document.getElementById("form");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const valor = parseFloat(document.getElementById("form__input").value);

        let numeroAzar;

        if (isNaN(valor)) {
            document.getElementById("result").innerHTML = "Por favor ingresa un número válido.";
            return;
        }

        try {

            numeroAzar = Math.floor(Math.random()*100) + 1;

            alert(`Numero Generado: ${numeroAzar}`);

            const compra1 = new Compra(valor, numeroAzar, 0, 0, 0);

            calcular(compra1);

        } catch {

            document.getElementById("result").innerHTML = "Por favor ingresa un valor valido";
            return;
        
        }

    });

    //Función clave en donde se evalua los requerimientos del enunciado
    function calcular (compra1) {

        let valor = compra1.get_valor();
        let numero = compra1.get_numero();
        let descuento = compra1.get_descuento();
        let valorDescuento = compra1.get_valorDescuento();
        let resultado = compra1.get_resultado();

        if (numero < 74) {

            descuento = 0.15;

            valorDescuento = valor * descuento;

            resultado = valor - (valor * descuento);

        } else if (numero >= 74){

            descuento = 0.20;

            valorDescuento = valor * descuento;

            resultado = valor - (valor * descuento);

        } else {

            descuento = 0;

            valorDescuento = valor * descuento;

            resultado = valor - (valor * descuento);

        }

        compra1.set_descuento(descuento);
        compra1.set_valorDescuento(valorDescuento);
        compra1.set_resultado(resultado);

        //Se asigna a la variable mensaje etiquetas html que luego se mostraran

        let mensaje = `
        <p>El descuento es: ${compra1.get_descuento() *100 }% </P>
        <p>El valor a descontar es: ${compra1.get_valorDescuento()}$ </p>
        <p>El valor a pagar es: ${compra1.get_resultado()}$`;

        document.getElementById("result").innerHTML = mensaje;

    }