// 2. Hacer un programa que imprima el nombre de un artículo, clave, precio original y
// su precio con descuento. El descuento lo hace en base a la clave, si la clave es
// 01 el descuento es del 10% y si la clave es 02 el descuento en del 20% (solo
// existen dos claves).

class articulo {

    constructor(nombre, clave, precio, descuento, resultado){
        this.nombre = nombre;
        this.clave = clave;
        this.precio = precio;
        this.descuento = descuento;
        this.resultado = resultado;
    }

    //Nombre
    set_nombre (nombre){
        this.nombre = nombre;
    }

    get_nombre (){
        return `${this.nombre}`;
    }

    //Clave
    set_clave (clave){
        this.clave = clave;
    }

    get_clave (){
        return `${this.clave}`;
    }

    //Precio
    set_precio (precio){
        this.precio = precio;
    }

    get_precio (){
        return `${this.precio}`;
    }

    //Descuento
    set_descuento (descuento){
        this.descuento = descuento;
    }

    get_descuento (){
        return `${this.descuento}`;
    }

    //Resultado
    set_resultado (resultado){
        this.resultado = resultado;
    }

    get_resultado (){
        return `${this.resultado}`;
    }

}

function calcular (articulo1) {

    let clave = articulo1.get_clave();
    let precio = articulo1.get_precio();
    let descuento = articulo1.get_descuento();
    let resultado = articulo1.get_resultado();
    let mensaje;

    clave = clave.toLowerCase();

    if (clave === "01") {
        
        descuento = 0.10;

    } else if (clave === "02") {

        descuento = 0.20;

    } else {

        descuento = 0 ;

    }

    resultado = precio - (precio * descuento);

    articulo1.set_resultado(resultado);

    if(descuento === 0.10 || descuento === 0.20) {

        mensaje = `
        <strong>Artículo:</strong> ${articulo1.get_nombre()} <br>
        <strong>Clave:</strong> ${articulo1.get_clave()} <br>
        <strong>Precio original:</strong> $${articulo1.get_precio()} <br>
        <strong>Precio con descuento:</strong> $${articulo1.get_resultado()}
    `;

    } else {

        mensaje = `
        <strong>Artículo:</strong> ${articulo1.get_nombre()} <br>
        <strong>Clave:</strong> ${articulo1.get_clave()} <br>
        <strong>Precio:</strong> ${articulo1.get_resultado()}
    `;

    }

    document.getElementById("resultado").innerHTML = mensaje;

}


let nombreArticulo = prompt("Ingrese el nombre del articulo comprado: ");
let precioArticulo = parseFloat(prompt("Ingrese el precio del articulo comprado: "));
let claveArticulo = prompt("Ingrese la clave para validar el descuento: ");

let articulo1 = new articulo(nombreArticulo, claveArticulo, precioArticulo, 0, 0);

calcular(articulo1);

