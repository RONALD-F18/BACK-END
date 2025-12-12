// assets/js/validacion.js - Validación de Formularios

// Expresiones regulares para validación
const expresiones = {
    usuario: /^[a-zA-Z0-9\_\-]{4,16}$/,          // Letras, números, guión y guión bajo
    nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,             // Letras y espacios con acentos
    password: /^.{4,}$/,                          // Mínimo 4 caracteres para login
    passwordRegistro: /^.{8,}$/,                  // Mínimo 8 caracteres para registro
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    telefono: /^\d{7,14}$/,                       // 7 a 14 números
    documento: /^\d{5,20}$/,                      // 5 a 20 números
    identificador: /^.{3,}$/                      // Mínimo 3 caracteres
};

// Estado de los campos
let campos = {};

/**
 * Valida un campo específico
 */
function validarCampo(expresion, input, campo) {
    const grupo = document.getElementById(`grupo__${campo}`);
    if (!grupo) return false;
    
    const errorMsg = grupo.querySelector('.formulario__input-error');
    
    if (expresion.test(input.value)) {
        grupo.classList.remove('formulario__grupo-incorrecto');
        grupo.classList.add('formulario__grupo-correcto');
        if (errorMsg) errorMsg.classList.remove('formulario__input-error-activo');
        campos[campo] = true;
        return true;
    } else {
        grupo.classList.add('formulario__grupo-incorrecto');
        grupo.classList.remove('formulario__grupo-correcto');
        if (errorMsg) errorMsg.classList.add('formulario__input-error-activo');
        campos[campo] = false;
        return false;
    }
}

/**
 * Valida que las contraseñas coincidan
 */
function validarPasswordConfirm() {
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');
    const grupo = document.getElementById('grupo__password_confirm');
    
    if (!password || !passwordConfirm || !grupo) return true;
    
    const errorMsg = grupo.querySelector('.formulario__input-error');
    
    if (password.value === passwordConfirm.value && password.value !== '') {
        grupo.classList.remove('formulario__grupo-incorrecto');
        grupo.classList.add('formulario__grupo-correcto');
        if (errorMsg) errorMsg.classList.remove('formulario__input-error-activo');
        campos['password_confirm'] = true;
        return true;
    } else {
        grupo.classList.add('formulario__grupo-incorrecto');
        grupo.classList.remove('formulario__grupo-correcto');
        if (errorMsg) errorMsg.classList.add('formulario__input-error-activo');
        campos['password_confirm'] = false;
        return false;
    }
}

/**
 * Manejador de validación de formulario de registro
 */
function validarFormularioRegistro(e) {
    switch (e.target.name) {
        case 'nombres':
            validarCampo(expresiones.nombre, e.target, 'nombres');
            break;
        case 'apellidos':
            validarCampo(expresiones.nombre, e.target, 'apellidos');
            break;
        case 'username':
            validarCampo(expresiones.usuario, e.target, 'username');
            break;
        case 'num_documento':
            validarCampo(expresiones.documento, e.target, 'num_documento');
            break;
        case 'email':
            validarCampo(expresiones.correo, e.target, 'email');
            break;
        case 'password':
            validarCampo(expresiones.passwordRegistro, e.target, 'password');
            validarPasswordConfirm();
            break;
        case 'password_confirm':
            validarPasswordConfirm();
            break;
        case 'telefono':
            if (e.target.value === '') {
                campos['telefono'] = true;
                const grupo = document.getElementById('grupo__telefono');
                if (grupo) {
                    grupo.classList.remove('formulario__grupo-incorrecto');
                    grupo.classList.remove('formulario__grupo-correcto');
                }
            } else {
                validarCampo(expresiones.telefono, e.target, 'telefono');
            }
            break;
    }
}

/**
 * Manejador de validación de formulario de login
 */
function validarFormularioLogin(e) {
    switch (e.target.name) {
        case 'identificador':
            validarCampo(expresiones.identificador, e.target, 'identificador');
            break;
        case 'password':
            validarCampo(expresiones.password, e.target, 'password');
            break;
    }
}

/**
 * Inicializa validación para formulario de registro
 */
function initValidacionRegistro() {
    const formulario = document.getElementById('formulario-registro');
    
    if (!formulario) return;
    
    // Inicializar campos
    campos = {
        nombres: false,
        apellidos: false,
        username: false,
        num_documento: false,
        email: false,
        password: false,
        password_confirm: false,
        telefono: true  // Opcional
    };
    
    const inputs = formulario.querySelectorAll('.formulario__input');
    
    // Agregar eventos a los inputs
    inputs.forEach(input => {
        input.addEventListener('keyup', validarFormularioRegistro);
        input.addEventListener('blur', validarFormularioRegistro);
    });
    
    // Validar al enviar
    formulario.addEventListener('submit', (e) => {
        const terminos = document.getElementById('acepta_terminos');
        const mensajeError = document.getElementById('formulario__mensaje');
        
        // Verificar campos obligatorios
        const camposRequeridos = ['nombres', 'apellidos', 'username', 'num_documento', 'email', 'password', 'password_confirm'];
        let todosValidos = true;
        
        camposRequeridos.forEach(campo => {
            if (!campos[campo]) {
                todosValidos = false;
                // Marcar campo como inválido si está vacío
                const input = formulario.querySelector(`[name="${campo}"]`);
                if (input && input.value === '') {
                    const grupo = document.getElementById(`grupo__${campo}`);
                    if (grupo) {
                        grupo.classList.add('formulario__grupo-incorrecto');
                        const errorMsg = grupo.querySelector('.formulario__input-error');
                        if (errorMsg) errorMsg.classList.add('formulario__input-error-activo');
                    }
                }
            }
        });
        
        if (!todosValidos || (terminos && !terminos.checked)) {
            e.preventDefault();
            if (mensajeError) {
                mensajeError.textContent = 'Por favor complete todos los campos correctamente y acepte los términos.';
                mensajeError.style.display = 'block';
            }
        } else {
            if (mensajeError) {
                mensajeError.style.display = 'none';
            }
        }
    });
}

/**
 * Inicializa validación para formulario de login
 */
function initValidacionLogin() {
    const formulario = document.getElementById('formulario-login');
    
    if (!formulario) return;
    
    // Inicializar campos
    campos = {
        identificador: false,
        password: false
    };
    
    const inputs = formulario.querySelectorAll('.formulario__input');
    
    // Agregar eventos a los inputs
    inputs.forEach(input => {
        input.addEventListener('keyup', validarFormularioLogin);
        input.addEventListener('blur', validarFormularioLogin);
    });
    
    // Validar al enviar
    formulario.addEventListener('submit', (e) => {
        const identificador = document.getElementById('identificador');
        const password = document.getElementById('password');
        const mensajeError = document.getElementById('formulario__mensaje');
        
        let valido = true;
        
        // Validar identificador
        if (!identificador || identificador.value.length < 3) {
            valido = false;
            const grupo = document.getElementById('grupo__identificador');
            if (grupo) {
                grupo.classList.add('formulario__grupo-incorrecto');
                const errorMsg = grupo.querySelector('.formulario__input-error');
                if (errorMsg) errorMsg.classList.add('formulario__input-error-activo');
            }
        }
        
        // Validar password
        if (!password || password.value.length < 4) {
            valido = false;
            const grupo = document.getElementById('grupo__password');
            if (grupo) {
                grupo.classList.add('formulario__grupo-incorrecto');
                const errorMsg = grupo.querySelector('.formulario__input-error');
                if (errorMsg) errorMsg.classList.add('formulario__input-error-activo');
            }
        }
        
        if (!valido) {
            e.preventDefault();
            if (mensajeError) {
                mensajeError.textContent = 'Por favor complete todos los campos correctamente.';
                mensajeError.style.display = 'block';
            }
        }
    });
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    initValidacionRegistro();
    initValidacionLogin();
});
