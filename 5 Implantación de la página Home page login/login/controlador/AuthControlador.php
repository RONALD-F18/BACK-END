<?php

require_once __DIR__ . '/../libs/Email.php';

class AuthControlador
{
    private $usuarioModelo;

    public function __construct()
    {
        $this->usuarioModelo = new Usuario(BaseDatos::conectar());
    }

    public function home()
    {
        require_once 'vista/layouts/home.php';
    }

    public function login()
    {
        if (estaLogueado()) {
            redirigir('dashboard');
        }
        require_once 'vista/auth/login.php';
    }

    public function procesarLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('login');
        }

        $identificador = limpiarDato($_POST['identificador'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($identificador) || empty($password)) {
            setMensaje('Por favor complete todos los campos', 'error');
            redirigir('login');
        }

        $usuario = $this->usuarioModelo->buscarParaLogin($identificador);

        if (!$usuario) {
            setMensaje('Usuario o contraseña incorrectos', 'error');
            redirigir('login');
        }

        if ($usuario['estado'] !== ESTADO_ACTIVO) {
            setMensaje('Su cuenta está inactiva. Contacte al administrador.', 'error');
            redirigir('login');
        }

        if (!verificarPassword($password, $usuario['password'])) {
            setMensaje('Usuario o contraseña incorrectos', 'error');
            redirigir('login');
        }

        $this->usuarioModelo->actualizarUltimoAcceso($usuario['id']);
        iniciarSesionUsuario($usuario);

        setMensaje('¡Bienvenido ' . $usuario['nombres'] . '!', 'success');
        redirigir('dashboard');
    }

    public function registro()
    {
        if (estaLogueado()) {
            redirigir('dashboard');
        }
        require_once 'vista/auth/registro.php';
    }

    public function procesarRegistro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('registro');
        }

        $datos = [
            'nombres' => limpiarDato($_POST['nombres'] ?? ''),
            'apellidos' => limpiarDato($_POST['apellidos'] ?? ''),
            'username' => limpiarDato($_POST['username'] ?? ''),
            'tipo_documento' => limpiarDato($_POST['tipo_documento'] ?? ''),
            'num_documento' => limpiarDato($_POST['num_documento'] ?? ''),
            'email' => limpiarDato($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'telefono' => limpiarDato($_POST['telefono'] ?? ''),
            'fecha_nacimiento' => limpiarDato($_POST['fecha_nacimiento'] ?? ''),
            'acepta_terminos' => isset($_POST['acepta_terminos']),
            'rol' => ROL_FUNCIONARIO
        ];

        $errores = $this->validarRegistro($datos);

        if (!empty($errores)) {
            setMensaje(implode('<br>', $errores), 'error');
            redirigir('registro');
        }

        if ($this->usuarioModelo->existeEmail($datos['email'])) {
            setMensaje('El correo electrónico ya está registrado', 'error');
            redirigir('registro');
        }

        if (!empty($datos['username']) && $this->usuarioModelo->existeUsername($datos['username'])) {
            setMensaje('El nombre de usuario ya está en uso', 'error');
            redirigir('registro');
        }

        try {
            $this->usuarioModelo->crear($datos);
            setMensaje('¡Registro exitoso! Ya puede iniciar sesión', 'success');
            redirigir('login');
        } catch (Exception $e) {
            setMensaje('Error al crear el usuario: ' . $e->getMessage(), 'error');
            redirigir('registro');
        }
    }

    public function recuperar()
    {
        if (estaLogueado()) {
            redirigir('dashboard');
        }
        require_once 'vista/auth/recuperar.php';
    }

    public function procesarRecuperar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('recuperar');
        }

        $email = limpiarDato($_POST['email'] ?? '');

        if (empty($email)) {
            setMensaje('Por favor ingrese su correo electrónico', 'error');
            redirigir('recuperar');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setMensaje('Ingrese un correo electrónico válido', 'error');
            redirigir('recuperar');
        }

        $usuario = $this->usuarioModelo->obtenerPorEmail($email);

        if ($usuario) {
            $token = generarToken();
            if ($this->usuarioModelo->guardarTokenRecuperacion($email, $token)) {
                $enviado = Email::enviarRecuperacion($email, $token);
                if (!$enviado) {
                    $_SESSION['token_demo'] = $token;
                    $_SESSION['token_email'] = $email;
                }
            }
        }

        setMensaje('Si el correo existe en nuestro sistema, recibirá instrucciones para restablecer su contraseña.', 'info');
        redirigir('recuperar');
    }

    public function nuevaPassword($token)
    {
        if (estaLogueado()) {
            redirigir('dashboard');
        }

        $token = trim($token);
        
        if (empty($token) || $token === 'index' || $token === 'procesar') {
            setMensaje('Enlace de recuperación inválido. Por favor, solicite un nuevo enlace.', 'error');
            redirigir('recuperar');
        }

        $usuario = $this->usuarioModelo->buscarPorToken($token);
        if (!$usuario) {
            setMensaje('El enlace de recuperación es inválido o ha expirado. Por favor, solicite un nuevo enlace.', 'error');
            redirigir('recuperar');
        }

        require_once __DIR__ . '/../vista/auth/nueva_password.php';
    }

    public function procesarNuevaPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('login');
        }

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        $usuario = $this->usuarioModelo->buscarPorToken($token);

        if (!$usuario) {
            setMensaje('El enlace de recuperación es inválido o ha expirado', 'error');
            redirigir('login');
        }

        if (empty($password) || strlen($password) < 8) {
            setMensaje('La contraseña debe tener al menos 8 caracteres', 'error');
            redirigir('nueva-password/' . $token);
        }

        if ($password !== $password_confirm) {
            setMensaje('Las contraseñas no coinciden', 'error');
            redirigir('nueva-password/' . $token);
        }

        try {
            $this->usuarioModelo->actualizarPassword($usuario['id'], $password);
            setMensaje('¡Contraseña actualizada! Ya puede iniciar sesión', 'success');
            redirigir('login');
        } catch (Exception $e) {
            setMensaje('Error al actualizar la contraseña', 'error');
            redirigir('nueva-password/' . $token);
        }
    }

    public function logout()
    {
        cerrarSesionUsuario();
        setMensaje('Sesión cerrada correctamente', 'info');
        redirigir('home');
    }

    private function validarRegistro($datos)
    {
        $errores = [];

        if (empty($datos['nombres'])) {
            $errores[] = 'El nombre es requerido';
        }
        if (empty($datos['apellidos'])) {
            $errores[] = 'Los apellidos son requeridos';
        }
        if (empty($datos['username'])) {
            $errores[] = 'El nombre de usuario es requerido';
        } elseif (!preg_match('/^[a-zA-Z0-9_-]{4,16}$/', $datos['username'])) {
            $errores[] = 'El usuario debe tener entre 4 y 16 caracteres (letras, números, guión, guión bajo)';
        }
        if (empty($datos['tipo_documento'])) {
            $errores[] = 'El tipo de documento es requerido';
        }
        if (empty($datos['num_documento'])) {
            $errores[] = 'El número de documento es requerido';
        }
        if (empty($datos['email'])) {
            $errores[] = 'El correo electrónico es requerido';
        } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no es válido';
        }
        if (empty($datos['password'])) {
            $errores[] = 'La contraseña es requerida';
        } elseif (strlen($datos['password']) < 8) {
            $errores[] = 'La contraseña debe tener al menos 8 caracteres';
        }
        if ($datos['password'] !== $datos['password_confirm']) {
            $errores[] = 'Las contraseñas no coinciden';
        }
        if (empty($datos['fecha_nacimiento'])) {
            $errores[] = 'La fecha de nacimiento es requerida';
        }
        if (!$datos['acepta_terminos']) {
            $errores[] = 'Debe aceptar los términos y condiciones';
        }

        return $errores;
    }
}