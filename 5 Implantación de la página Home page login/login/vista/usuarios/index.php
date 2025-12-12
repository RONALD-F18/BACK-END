<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Talent Sphere</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }

        .page-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f3f4f6;
        }


        .brand-icon::after {
            content: '';
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
        }

        .brand-text .title {
            font-weight: 700;
            color: #ffffffff;
            font-size: 24px;
            display: block;
        }

        .brand-text .sub {
            font-size: 11px;
            color: #ffffffff;
            font-size: 14px;
            font-weight: bold;
            ;
        }

        .sidebar-menu {
            flex: 1;
            padding: 15px 10px;
            overflow-y: auto;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 4px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .menu-item:hover {
            background: #f3f4f6;
            color: #3284f7ff;
        }

        .menu-item.active {
            background: #398dfaff;
            color: #ffffffff;
            font-weight: 600;

        }

        .menu-icon {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid #f3f4f6;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-details .name {
            font-weight: 600;
            font-size: 13px;
            color: #1f2937;
            display: block;
        }

        .user-details .email {
            font-size: 11px;
            color: #6b7280;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
        }

        /* Header */
        .page-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            font-size: 22px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-left p {
            font-size: 13px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .btn-new {
            background: white;
            color: #4f46e5;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-new:hover {
            background: #f0f0ff;
            transform: translateY(-1px);
        }

        /* Content Area */
        .content-area {
            padding: 25px 30px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }

        .stat-card .label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
        }

        /* Filters */
        .filters-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
        }

        .search-box {
            position: relative;
            margin-bottom: 15px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .search-box::before {
            content: '🔍';
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 6px;
            font-size: 13px;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        /* Table */
        .table-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #4f46e5;
            color: white;
            padding: 15px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            color: #374151;
        }

        .data-table tr:hover {
            background: #f9fafb;
        }

        .user-cell .name {
            font-weight: 600;
            color: #1f2937;
        }

        .user-cell .doc {
            font-size: 12px;
            color: #6b7280;
        }

        .tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .tag.admin {
            background: #fee2e2;
            color: #dc2626;
        }

        .tag.funcionario {
            background: #dbeafe;
            color: #2563eb;
        }

        .tag.activo {
            background: #dcfce7;
            color: #16a34a;
        }

        .tag.inactivo {
            background: #fef3c7;
            color: #d97706;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #dbeafe;
            color: #2563eb;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: white;
            border-radius: 12px;
            width: 450px;
            max-width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalIn 0.2s ease;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 12px 12px 0 0;
        }

        .modal-header h2 {
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            opacity: 0.8;
        }

        .modal-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #374151;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .roles-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
        }

        .role-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .role-option {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .role-option:hover {
            border-color: #c7d2fe;
        }

        .role-option.selected {
            border-color: #4f46e5;
            background: #eef2ff;
        }

        .role-option input {
            display: none;
        }

        .role-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
        }

        .role-desc {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .modal-footer {
            padding: 0 25px 25px;
            display: flex;
            gap: 12px;
        }

        .btn-save {
            flex: 1;
            background: #4f46e5;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-save:hover {
            background: #4338ca;
        }

        .btn-cancel {
            padding: 14px 24px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            color: #4b5563;
        }

        .btn-cancel:hover {
            background: #f9fafb;
        }

        /* Alert */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="page-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon"></div>
                <div class="brand-text">
                    <span class="title">Talent Sphere</span>
                    <span class="sub">Gestión de RRHH</span>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="<?= url('dashboard') ?>" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Afiliaciones</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Empleados</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Certificación</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Contratos</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Memorandos</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Prestaciones Sociales</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Inasistencias</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Incapacidades</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Actividades</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span>Reportes</span>
                </a>
                <a href="<?= url('usuarios') ?>" class="menu-item active">
                    <span class="menu-icon"></span>
                    <span>Usuarios</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['usuario_nombre'] ?? 'U', 0, 1)) ?></div>
                    <div class="user-details">
                        <span class="name"><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?></span>
                        <span class="email"><?= htmlspecialchars($_SESSION['usuario_email'] ?? '') ?></span>
                    </div>
                </div>
                <a href="<?= url('logout') ?>" class="menu-item" style="color: #dc2626;">
                    <span class="menu-icon">

                    </span>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <div class="header-left">
                    <h1> Gestión de Usuarios</h1>
                    <p>Administración de Acceso y Permisos del sistema</p>
                </div>
                <button class="btn-new" onclick="abrirModalNuevo()">
                    Nuevo Usuario
                </button>
            </header>

            <div class="content-area">
                <?php $mensaje = getMensaje(); ?>
                <?php if ($mensaje): ?>
                    <div class="alert alert-<?= $mensaje['tipo'] ?>">
                        <?= $mensaje['texto'] ?>
                    </div>
                <?php endif; ?>

                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="label">Total Usuarios</div>
                        <div class="value"><?= $stats['total'] ?? 0 ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="label">Usuarios Activos</div>
                        <div class="value"><?= $stats['activos'] ?? 0 ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="label">Usuarios Inactivos</div>
                        <div class="value"><?= $stats['inactivos'] ?? 0 ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="label">Administradores</div>
                        <div class="value"><?= $stats['admins'] ?? 0 ?></div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters-card">
                    <div class="search-box">
                        <input type="text" id="buscar" placeholder="Buscar por nombre, email o documento...">
                    </div>
                    <div class="filter-buttons">
                        <button class="filter-btn active">Todos los estados</button>
                        <button class="filter-btn">Todos los roles</button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Contacto</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Último Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-body">
                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">
                                        No hay usuarios registrados
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $u): ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="name"><?= htmlspecialchars($u['nombres'] . ' ' . $u['apellidos']) ?></div>
                                                <div class="doc">C.C <?= htmlspecialchars($u['num_documento']) ?></div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($u['telefono'] ?: 'N/A') ?></td>
                                        <td>
                                            <span class="tag <?= strtolower($u['rol']) ?>"><?= $u['rol'] ?></span>
                                        </td>
                                        <td>
                                            <span class="tag <?= strtolower($u['estado']) ?>"><?= $u['estado'] ?></span>
                                        </td>
                                        <td><?= formatearUltimoAcceso($u['ultimo_acceso']) ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="btn-action btn-edit" onclick="abrirModalEditar(<?= $u['id'] ?>)" title="Editar">✏️</button>
                                                <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                                                    <button class="btn-action btn-delete" onclick="eliminarUsuario(<?= $u['id'] ?>)" title="Eliminar">🗑️</button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="modal">
        <div class="modal-box">
            <div class="modal-header">
                <h2> <span id="modal-titulo">Editar Usuarios</span></h2>
                <button class="modal-close" onclick="cerrarModal()">×</button>
            </div>

            <form id="form-usuario" onsubmit="guardarUsuario(event)">
                <input type="hidden" id="usuario_id" name="id">

                <div class="modal-body">
                    <div class="section-title"> Información Personal</div>

                    <div class="form-group">
                        <label>Nombre Completo *</label>
                        <input type="text" id="nombre_completo" placeholder="Ej: Carlos Andrés Gómez" required>
                    </div>

                    <div class="form-group">
                        <label>Documento *</label>
                        <input type="text" id="documento" placeholder="Ej: 1015432198" required>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" id="email" placeholder="Ej: correo@empresa.com" required>
                    </div>

                    <div class="form-group">
                        <label>Teléfono *</label>
                        <input type="text" id="telefono" placeholder="Ej: +57 3105551234">
                    </div>

                    <div class="roles-section">
                        <div class="section-title">Permisos y Acceso</div>

                        <div class="role-list">
                            <label class="role-option" onclick="seleccionarRol(this)">
                                <input type="radio" name="rol" value="Administrador">
                                <div class="role-name">Administrador</div>
                                <div class="role-desc">Acceso total al sistema</div>
                            </label>
                            <label class="role-option selected" onclick="seleccionarRol(this)">
                                <input type="radio" name="rol" value="Funcionario" checked>
                                <div class="role-name">Funcionario</div>
                                <div class="role-desc">Puede crear y modificar</div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-save">Guardar Cambios</button>
                    <button type="button" class="btn-cancel" onclick="cerrarModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Abrir modal para nuevo usuario
        function abrirModalNuevo() {
            document.getElementById('modal-titulo').textContent = 'Nuevo Usuario';
            document.getElementById('usuario_id').value = '';
            document.getElementById('nombre_completo').value = '';
            document.getElementById('documento').value = '';
            document.getElementById('email').value = '';
            document.getElementById('telefono').value = '';
            document.querySelector('input[name="rol"][value="Funcionario"]').checked = true;
            actualizarRolVisual();
            document.getElementById('modal').classList.add('active');
        }

        // Abrir modal para editar usuario
        function abrirModalEditar(id) {
            document.getElementById('modal-titulo').textContent = 'Editar Usuarios';

            fetch('<?= url('usuarios/obtener/') ?>' + id)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const u = data.usuario;
                        document.getElementById('usuario_id').value = u.id;
                        document.getElementById('nombre_completo').value = (u.nombres + ' ' + u.apellidos).trim();
                        document.getElementById('documento').value = u.num_documento || '';
                        document.getElementById('email').value = u.email || '';
                        document.getElementById('telefono').value = u.telefono || '';

                        const rolInput = document.querySelector('input[name="rol"][value="' + u.rol + '"]');
                        if (rolInput) rolInput.checked = true;
                        actualizarRolVisual();

                        document.getElementById('modal').classList.add('active');
                    } else {
                        alert('Error al cargar los datos del usuario');
                    }
                })
                .catch(e => {
                    console.error(e);
                    alert('Error de conexión');
                });
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal').classList.remove('active');
        }

        // Seleccionar rol
        function seleccionarRol(elemento) {
            const radio = elemento.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
            actualizarRolVisual();
        }

        // Actualizar visual de roles
        function actualizarRolVisual() {
            document.querySelectorAll('.role-option').forEach(opt => {
                const radio = opt.querySelector('input[type="radio"]');
                opt.classList.toggle('selected', radio && radio.checked);
            });
        }

        // Guardar usuario
        function guardarUsuario(e) {
            e.preventDefault();

            const nombre = document.getElementById('nombre_completo').value.trim();
            const partes = nombre.split(' ');
            const mitad = Math.ceil(partes.length / 2);

            const formData = new FormData();
            formData.append('id', document.getElementById('usuario_id').value);
            formData.append('nombres', partes.slice(0, mitad).join(' '));
            formData.append('apellidos', partes.slice(mitad).join(' ') || partes[0]);
            formData.append('num_documento', document.getElementById('documento').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('telefono', document.getElementById('telefono').value);
            formData.append('rol', document.querySelector('input[name="rol"]:checked').value);
            formData.append('estado', 'Activo');

            fetch('<?= url('usuarios/actualizar-ajax') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.mensaje || 'Error al guardar');
                    }
                })
                .catch(e => {
                    console.error(e);
                    alert('Error de conexión');
                });
        }

        // Eliminar usuario
        function eliminarUsuario(id) {
            if (!confirm('¿Está seguro de eliminar este usuario?')) return;

            const formData = new FormData();
            formData.append('id', id);

            fetch('<?= url('usuarios/eliminar-ajax') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.mensaje || 'Error al eliminar');
                    }
                })
                .catch(e => {
                    console.error(e);
                    alert('Error de conexión');
                });
        }

        // Búsqueda en tabla
        document.getElementById('buscar').addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#tabla-body tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
            });
        });

        // Cerrar modal al hacer clic fuera
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') cerrarModal();
        });
    </script>
</body>

</html>