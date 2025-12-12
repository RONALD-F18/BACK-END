<?php
// index.php - Router Principal

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

// Cargar configuración
require_once 'config/Configuracion.php';
require_once 'config/BaseDatos.php';
require_once 'config/helpers.php';

// Cargar modelos
require_once 'modelo/Usuario.php';

// Cargar controladores
require_once 'controlador/AuthControlador.php';
require_once 'controlador/UsuarioControlador.php';

$ruta = rtrim($_GET['ruta'] ?? 'home', '/');
$partes = explode('/', $ruta);
$controlador = $partes[0] ?? 'home';
$accion = $partes[1] ?? 'index';
$parametro = $partes[2] ?? null;

switch ($controlador) {
    case 'home':
    case '':
        $auth = new AuthControlador();
        $auth->home();
        break;

    case 'login':
        $auth = new AuthControlador();
        $auth->{$accion === 'procesar' ? 'procesarLogin' : 'login'}();
        break;

    case 'registro':
        $auth = new AuthControlador();
        $auth->{$accion === 'procesar' ? 'procesarRegistro' : 'registro'}();
        break;

    case 'recuperar':
        $auth = new AuthControlador();
        $auth->{$accion === 'procesar' ? 'procesarRecuperar' : 'recuperar'}();
        break;

    case 'nueva-password':
        $auth = new AuthControlador();
        if ($accion === 'procesar') {
            $auth->procesarNuevaPassword();
        } else {
            $token = $_GET['token'] ?? '';
            if (empty($token) && !empty($accion) && $accion !== 'index' && $accion !== 'procesar') {
                $token = urldecode($accion);
            }
            $auth->nuevaPassword(trim($token));
        }
        break;

    case 'logout':
        (new AuthControlador())->logout();
        break;

    case 'dashboard':
        $usuario = new UsuarioControlador();
        $usuario->dashboard();
        break;

    case 'usuarios':
        $usuario = new UsuarioControlador();
        switch ($accion) {
            case 'index':
            case '':
                $usuario->index();
                break;
            case 'crear':
                $usuario->crear();
                break;
            case 'guardar':
                $usuario->guardar();
                break;
            case 'editar':
                $usuario->editar($parametro);
                break;
            case 'actualizar':
                $usuario->actualizar($parametro);
                break;
            case 'eliminar':
                $usuario->eliminar($parametro);
                break;
            case 'estado':
                $usuario->cambiarEstado($parametro);
                break;
            case 'obtener':
                $usuario->obtener($parametro);
                break;
            case 'actualizar-ajax':
                $usuario->actualizarAjax();
                break;
            case 'eliminar-ajax':
                $usuario->eliminarAjax();
                break;
            default:
                $usuario->index();
        }
        break;

    default:
        http_response_code(404);
        require_once 'vista/layouts/404.php';
        break;
}
