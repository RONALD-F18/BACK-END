<?php

class Usuario
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Obtiene todos los usuarios
     */
    public function obtenerTodos()
    {
        $sql = "SELECT * FROM usuarios ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene un usuario por ID
     */
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Obtiene un usuario por email
     */
    public function obtenerPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Obtiene un usuario por username
     */
    public function obtenerPorUsername($username)
    {
        $sql = "SELECT * FROM usuarios WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    /**
     * Busca usuario por email o username (para login)
     */
    public function buscarParaLogin($identificador)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email OR username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $identificador,
            'username' => $identificador
        ]);
        return $stmt->fetch();
    }

    /**
     * Crea un nuevo usuario
     */
    public function crear($datos)
    {
        $sql = "INSERT INTO usuarios (nombres, apellidos, username, tipo_documento, num_documento, 
                email, password, telefono, fecha_nacimiento, rol, estado, fecha_registro) 
                VALUES (:nombres, :apellidos, :username, :tipo_documento, :num_documento, 
                :email, :password, :telefono, :fecha_nacimiento, :rol, :estado, NOW())";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'] ?? '',
            'username' => $datos['username'] ?? null,
            'tipo_documento' => $datos['tipo_documento'] ?? 'CC',
            'num_documento' => $datos['num_documento'],
            'email' => $datos['email'],
            'password' => encriptarPassword($datos['password']),
            'telefono' => $datos['telefono'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'rol' => $datos['rol'] ?? ROL_FUNCIONARIO,
            'estado' => $datos['estado'] ?? ESTADO_ACTIVO
        ]);
    }

    /**
     * Actualiza un usuario existente
     */
    public function actualizar($id, $datos)
    {
        $campos = [];
        $valores = ['id' => $id];

        // Campos que se pueden actualizar
        $camposPermitidos = [
            'nombres',
            'apellidos',
            'username',
            'tipo_documento',
            'num_documento',
            'email',
            'telefono',
            'fecha_nacimiento',
            'rol',
            'estado'
        ];

        foreach ($camposPermitidos as $campo) {
            if (isset($datos[$campo]) && $datos[$campo] !== '') {
                $campos[] = "$campo = :$campo";
                $valores[$campo] = $datos[$campo];
            }
        }

        // Actualizar contraseña si se proporciona
        if (!empty($datos['password'])) {
            $campos[] = "password = :password";
            $valores['password'] = encriptarPassword($datos['password']);
        }

        if (empty($campos)) {
            return false;
        }

        $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($valores);
    }

    /**
     * Elimina un usuario
     */
    public function eliminar($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Actualiza el último acceso del usuario
     */
    public function actualizarUltimoAcceso($id)
    {
        $sql = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Guarda token de recuperación de contraseña
     */
    public function guardarTokenRecuperacion($email, $token)
    {
        try {
            $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $sql = "UPDATE usuarios SET token_recuperacion = :token, token_expiracion = :expiracion WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute([
                'token' => $token,
                'expiracion' => $expiracion,
                'email' => $email
            ]);
            
            // Verificar que se actualizó al menos una fila
            return $resultado && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al guardar token de recuperación: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca usuario por token de recuperación válido
     */
    public function buscarPorToken($token)
    {
        try {
            if (empty($token)) {
                return false;
            }
            
            $sql = "SELECT * FROM usuarios WHERE token_recuperacion = :token AND token_expiracion > NOW()";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['token' => $token]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error al buscar token de recuperación: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza contraseña y limpia token
     */
    public function actualizarPassword($id, $password)
    {
        $sql = "UPDATE usuarios SET password = :password, token_recuperacion = NULL, token_expiracion = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'password' => encriptarPassword($password),
            'id' => $id
        ]);
    }

    /**
     * Cuenta usuarios por estado
     */
    public function contarPorEstado($estado)
    {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE estado = :estado";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['estado' => $estado]);
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }

    /**
     * Cuenta usuarios por rol
     */
    public function contarPorRol($rol)
    {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE rol = :rol";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['rol' => $rol]);
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }

    /**
     * Cuenta total de usuarios
     */
    public function contarTotal()
    {
        $sql = "SELECT COUNT(*) as total FROM usuarios";
        $stmt = $this->db->query($sql);
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }

    /**
     * Busca usuarios por término
     */
    public function buscar($termino)
    {
        $terminoBusqueda = "%$termino%";
        $sql = "SELECT * FROM usuarios WHERE 
                nombres LIKE :t1 OR 
                apellidos LIKE :t2 OR 
                email LIKE :t3 OR 
                num_documento LIKE :t4
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            't1' => $terminoBusqueda,
            't2' => $terminoBusqueda,
            't3' => $terminoBusqueda,
            't4' => $terminoBusqueda
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Verifica si existe un email
     */
    public function existeEmail($email, $excluirId = null)
    {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE email = :email";
        $params = ['email' => $email];

        if ($excluirId) {
            $sql .= " AND id != :id";
            $params['id'] = $excluirId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $resultado = $stmt->fetch();
        return $resultado['total'] > 0;
    }

    /**
     * Verifica si existe un username
     */
    public function existeUsername($username, $excluirId = null)
    {
        if (empty($username)) return false;

        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE username = :username";
        $params = ['username' => $username];

        if ($excluirId) {
            $sql .= " AND id != :id";
            $params['id'] = $excluirId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $resultado = $stmt->fetch();
        return $resultado['total'] > 0;
    }
}
