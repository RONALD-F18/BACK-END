<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Talent Sphere</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="app-layout">
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <aside class="sidebar">
            <div class="sidebar-top">
                <div class="sidebar-brand">
                    <div class="brand-icon">

                    </div>
                    <div class="brand-text">
                        <span class="brand-title">Talent Sphere</span>
                        <span class="brand-sub">Gestión de RRHH</span>
                    </div>
                </div>
                <button class="close-btn" onclick="toggleSidebar()">✕</button>
            </div>

            <nav class="sidebar-menu">
                <a href="<?= url('dashboard') ?>" class="menu-item active">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Dashboard</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Afiliaciones</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Empleados</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Certificación</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Contratos</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Memorandos</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Prestaciones Sociales</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Inasistencias</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Incapacidades</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Actividades</span>
                </a>
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Reportes</span>
                </a>

                <?php if (esAdmin()): ?>
                    <a href="<?= url('usuarios') ?>" class="menu-item">
                        <span class="menu-icon"></span>
                        <span class="menu-label">Gestión Usuarios</span>
                    </a>
                <?php endif; ?>
            </nav>

            <div class="sidebar-bottom">
                <a href="#" class="menu-item">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Ayuda</span>
                </a>

                <div class="user-card">
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['usuario_nombre'] ?? 'U', 0, 1)) ?></div>
                    <div class="user-details">
                        <span class="user-name"><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?></span>
                        <span class="user-email"><?= htmlspecialchars($_SESSION['usuario_email'] ?? '') ?></span>
                    </div>
                </div>

                <a href="<?= url('logout') ?>" class="menu-item logout-btn">
                    <span class="menu-icon"></span>
                    <span class="menu-label">Cerrar Sesión</span>
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <button class="hamburger" onclick="toggleSidebar()">
                    <span></span><span></span><span></span>
                </button>
                <div class="header-info">
                    <h1>Dashboard</h1>
                    <p>Panel de Control</p>
                </div>
                <span class="header-date"><?= fechaActual() ?></span>
            </header>

            <div class="dashboard-body">
                <?php $mensaje = getMensaje(); ?>
                <?php if ($mensaje): ?>
                    <div class="alert alert-<?= $mensaje['tipo'] ?>">
                        <?= $mensaje['texto'] ?>
                    </div>
                <?php endif; ?>

                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-icon yellow"><span></span></div>
                        <div class="stat-data">
                            <span class="stat-number"><?= $stats['total'] ?? 0 ?></span>
                            <span class="stat-text">Total Usuarios</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green"><span>✓</span></div>
                        <div class="stat-data">
                            <span class="stat-number"><?= $stats['activos'] ?? 0 ?></span>
                            <span class="stat-text">Activos</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange"><span>⏸</span></div>
                        <div class="stat-data">
                            <span class="stat-number"><?= $stats['inactivos'] ?? 0 ?></span>
                            <span class="stat-text">Inactivos</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon pink"><span></span></div>
                        <div class="stat-data">
                            <span class="stat-number"><?= $stats['admins'] ?? 0 ?></span>
                            <span class="stat-text">Administradores</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="card">
                        <div class="card-top">
                            <h3>Tu Perfil</h3>
                        </div>
                        <div style="padding: 15px 0;">
                            <p style="margin-bottom: 12px;"><strong>Nombre:</strong> <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'N/A') ?></p>
                            <p style="margin-bottom: 12px;"><strong>Email:</strong> <?= htmlspecialchars($_SESSION['usuario_email'] ?? 'N/A') ?></p>
                            <p style="margin-bottom: 12px;"><strong>Rol:</strong>
                                <span class="role-tag <?= strtolower($_SESSION['usuario_rol'] ?? 'funcionario') ?>">
                                    <?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'Funcionario') ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="card quick-actions">
                        <h3>Acciones Rápidas</h3>
                        <div class="actions-grid">
                            <a href="#" class="action-btn btn-yellow"> Nuevo Empleado</a>
                            <a href="#" class="action-btn btn-pink"> Crear Contrato</a>
                            <?php if (esAdmin()): ?>
                                <a href="<?= url('usuarios') ?>" class="action-btn btn-green"> Gestionar Usuarios</a>
                            <?php endif; ?>
                            <a href="#" class="action-btn btn-orange"> Ver Reportes</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
        }

        // Auto-cerrar alertas
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(a => {
                a.style.opacity = '0';
                setTimeout(() => a.remove(), 300);
            });
        }, 4000);
    </script>
</body>

</html>