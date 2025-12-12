<?php

class UsuarioControlador
{
    private $usuarioModelo;

    public function __construct()
    {
        $this->usuarioModelo = new Usuario(BaseDatos::conectar());
    }

    /**
     * Verifica que el usuario esté autenticado
     */
    private function verificarAuth()
    {
        if (!estaLogueado()) {
            setMensaje('Debe iniciar sesión para acceder', 'warning');
            redirigir('login');
        }
    }

    /**
     * Verifica que el usuario sea administrador
     */
    private function verificarAdmin()
    {
        $this->verificarAuth();
        if (!esAdmin()) {
            setMensaje('No tiene permisos para acceder a esta sección', 'error');
            redirigir('dashboard');
        }
    }

    /**
     * Muestra el dashboard
     */
    public function dashboard()
    {
        $this->verificarAuth();

        // Obtener estadísticas
        $stats = [
            'total' => $this->usuarioModelo->contarTotal(),
            'activos' => $this->usuarioModelo->contarPorEstado(ESTADO_ACTIVO),
            'inactivos' => $this->usuarioModelo->contarPorEstado(ESTADO_INACTIVO),
            'admins' => $this->usuarioModelo->contarPorRol(ROL_ADMIN)
        ];

        require_once 'vista/layouts/dashboard.php';
    }

    /**
     * Lista todos los usuarios (CRUD - Read)
     */
    public function index()
    {
        $this->verificarAdmin();

        $usuarios = $this->usuarioModelo->obtenerTodos();

        // Estadísticas
        $stats = [
            'total' => $this->usuarioModelo->contarTotal(),
            'activos' => $this->usuarioModelo->contarPorEstado(ESTADO_ACTIVO),
            'inactivos' => $this->usuarioModelo->contarPorEstado(ESTADO_INACTIVO),
            'admins' => $this->usuarioModelo->contarPorRol(ROL_ADMIN)
        ];

        require_once 'vista/usuarios/index.php';
    }

    /**
     * Muestra formulario para crear usuario (CRUD - Create)
     */
    public function crear()
    {
        $this->verificarAdmin();
        require_once 'vista/usuarios/crear.php';
    }

    /**
     * Procesa la creación de usuario
     */
    public function guardar()
    {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('usuarios');
        }

        $datos = [
            'nombres' => limpiarDato($_POST['nombres'] ?? ''),
            'apellidos' => limpiarDato($_POST['apellidos'] ?? ''),
            'username' => limpiarDato($_POST['username'] ?? ''),
            'tipo_documento' => limpiarDato($_POST['tipo_documento'] ?? 'CC'),
            'num_documento' => limpiarDato($_POST['num_documento'] ?? ''),
            'email' => limpiarDato($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? 'password123',
            'telefono' => limpiarDato($_POST['telefono'] ?? ''),
            'fecha_nacimiento' => limpiarDato($_POST['fecha_nacimiento'] ?? date('Y-m-d')),
            'rol' => limpiarDato($_POST['rol'] ?? ROL_FUNCIONARIO),
            'estado' => limpiarDato($_POST['estado'] ?? ESTADO_ACTIVO)
        ];

        // Validaciones
        if (empty($datos['nombres']) || empty($datos['email'])) {
            setMensaje('Por favor complete los campos obligatorios', 'error');
            redirigir('usuarios');
            return;
        }

        if ($this->usuarioModelo->existeEmail($datos['email'])) {
            setMensaje('El correo electrónico ya está registrado', 'error');
            redirigir('usuarios');
            return;
        }

        try {
            $this->usuarioModelo->crear($datos);
            setMensaje('Usuario creado exitosamente', 'success');
        } catch (Exception $e) {
            setMensaje('Error al crear usuario: ' . $e->getMessage(), 'error');
        }

        redirigir('usuarios');
    }

    /**
     * Muestra formulario para editar usuario (CRUD - Update)
     */
    public function editar($id)
    {
        $this->verificarAdmin();

        $usuario = $this->usuarioModelo->obtenerPorId($id);

        if (!$usuario) {
            setMensaje('Usuario no encontrado', 'error');
            redirigir('usuarios');
        }

        require_once 'vista/usuarios/editar.php';
    }

    /**
     * Procesa la actualización de usuario
     */
    public function actualizar($id)
    {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('usuarios');
        }

        $datos = [
            'nombres' => limpiarDato($_POST['nombres'] ?? ''),
            'apellidos' => limpiarDato($_POST['apellidos'] ?? ''),
            'username' => limpiarDato($_POST['username'] ?? ''),
            'tipo_documento' => limpiarDato($_POST['tipo_documento'] ?? ''),
            'num_documento' => limpiarDato($_POST['num_documento'] ?? ''),
            'email' => limpiarDato($_POST['email'] ?? ''),
            'telefono' => limpiarDato($_POST['telefono'] ?? ''),
            'rol' => limpiarDato($_POST['rol'] ?? ''),
            'estado' => limpiarDato($_POST['estado'] ?? '')
        ];

        // Si se proporciona nueva contraseña
        if (!empty($_POST['password'])) {
            $datos['password'] = $_POST['password'];
        }

        // Verificar email único
        if ($this->usuarioModelo->existeEmail($datos['email'], $id)) {
            setMensaje('El correo electrónico ya está en uso por otro usuario', 'error');
            redirigir('usuarios/editar/' . $id);
        }

        try {
            $this->usuarioModelo->actualizar($id, $datos);
            setMensaje('Usuario actualizado exitosamente', 'success');
            redirigir('usuarios');
        } catch (Exception $e) {
            setMensaje('Error al actualizar usuario: ' . $e->getMessage(), 'error');
            redirigir('usuarios/editar/' . $id);
        }
    }

    /**
     * Elimina un usuario (CRUD - Delete)
     */
    public function eliminar($id)
    {
        $this->verificarAdmin();

        // No permitir eliminar el propio usuario
        if ($id == $_SESSION['usuario_id']) {
            setMensaje('No puede eliminar su propio usuario', 'error');
            redirigir('usuarios');
        }

        try {
            $this->usuarioModelo->eliminar($id);
            setMensaje('Usuario eliminado exitosamente', 'success');
        } catch (Exception $e) {
            setMensaje('Error al eliminar usuario: ' . $e->getMessage(), 'error');
        }

        redirigir('usuarios');
    }

    /**
     * Cambia el estado de un usuario
     */
    public function cambiarEstado($id)
    {
        $this->verificarAdmin();

        $usuario = $this->usuarioModelo->obtenerPorId($id);

        if (!$usuario) {
            setMensaje('Usuario no encontrado', 'error');
            redirigir('usuarios');
        }

        $nuevoEstado = $usuario['estado'] === ESTADO_ACTIVO ? ESTADO_INACTIVO : ESTADO_ACTIVO;

        try {
            $this->usuarioModelo->actualizar($id, ['estado' => $nuevoEstado]);
            setMensaje('Estado del usuario actualizado', 'success');
        } catch (Exception $e) {
            setMensaje('Error al cambiar estado: ' . $e->getMessage(), 'error');
        }

        redirigir('usuarios');
    }

    /**
     * Obtiene datos de usuario para AJAX
     */
    public function obtener($id)
    {
        $this->verificarAdmin();

        header('Content-Type: application/json');

        $usuario = $this->usuarioModelo->obtenerPorId($id);

        if ($usuario) {
            unset($usuario['password']); // No enviar password
            echo json_encode(['success' => true, 'usuario' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Usuario no encontrado']);
        }
        exit();
    }

    /**
     * Actualiza o crea usuario via AJAX
     */
    public function actualizarAjax()
    {
        $this->verificarAdmin();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
            exit();
        }

        $id = intval($_POST['id'] ?? 0);

        $datos = [
            'nombres' => limpiarDato($_POST['nombres'] ?? ''),
            'apellidos' => limpiarDato($_POST['apellidos'] ?? ''),
            'num_documento' => limpiarDato($_POST['num_documento'] ?? ''),
            'email' => limpiarDato($_POST['email'] ?? ''),
            'telefono' => limpiarDato($_POST['telefono'] ?? ''),
            'rol' => limpiarDato($_POST['rol'] ?? ROL_FUNCIONARIO),
            'estado' => limpiarDato($_POST['estado'] ?? ESTADO_ACTIVO)
        ];

        if (empty($datos['nombres']) || empty($datos['email'])) {
            echo json_encode(['success' => false, 'mensaje' => 'Nombre y email son requeridos']);
            exit();
        }

        if ($id > 0) {
            if ($this->usuarioModelo->existeEmail($datos['email'], $id)) {
                echo json_encode(['success' => false, 'mensaje' => 'El email ya está en uso']);
                exit();
            }

            $this->usuarioModelo->actualizar($id, $datos);
            echo json_encode(['success' => true, 'mensaje' => 'Usuario actualizado']);
            exit();
        }

        if ($this->usuarioModelo->existeEmail($datos['email'])) {
            echo json_encode(['success' => false, 'mensaje' => 'El email ya está registrado']);
            exit();
        }

        $datos['password'] = $this->generarPasswordSegura();

        $this->usuarioModelo->crear($datos);

        echo json_encode(['success' => true, 'mensaje' => 'Usuario creado']);
        exit();
    }


    private function generarPasswordSegura()
    {
        return bin2hex(random_bytes(4));
    }



    /**
     * Elimina usuario via AJAX
     */
    public function eliminarAjax()
    {
        $this->verificarAdmin();

        header('Content-Type: application/json');

        $id = intval($_POST['id'] ?? 0);

        if ($id == $_SESSION['usuario_id']) {
            echo json_encode(['success' => false, 'mensaje' => 'No puede eliminar su propio usuario']);
            exit();
        }

        try {
            $this->usuarioModelo->eliminar($id);
            echo json_encode(['success' => true, 'mensaje' => 'Usuario eliminado']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
        }
        exit();
    }
}
