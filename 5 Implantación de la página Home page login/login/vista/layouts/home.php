<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Sphere - Gestión de RRHH</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="home-page">
        <!-- Header -->
        <header class="main-header">
            <div class="header-content">
                <div class="brand">
                    <div class="brand-logo">
                        <svg width="32" height="32" viewBox="0 0 32 32">
                            <circle cx="16" cy="16" r="14" fill="url(#grad1)" />
                            <ellipse cx="16" cy="16" rx="10" ry="4" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1"/>
                            <ellipse cx="16" cy="16" rx="10" ry="4" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1" transform="rotate(60 16 16)"/>
                            <ellipse cx="16" cy="16" rx="10" ry="4" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1" transform="rotate(-60 16 16)"/>
                            <circle cx="16" cy="16" r="3" fill="white"/>
                            <defs>
                                <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#667eea" />
                                    <stop offset="100%" stop-color="#764ba2" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <span class="brand-name">Talent Sphere</span>
                </div>
                <nav class="main-nav">
                    <a href="#inicio">Inicio</a>
                    <a href="#servicios">Servicios</a>
                    <a href="#nosotros">Nosotros</a>
                    <a href="#contacto">Contacto</a>
                </nav>
                <div class="header-actions">
                    <?php if (estaLogueado()): ?>
                        <a href="<?= url('dashboard') ?>" class="btn-filled">Dashboard</a>
                    <?php else: ?>
                        <a href="<?= url('login') ?>" class="btn-outline">Iniciar sesión</a>
                        <a href="<?= url('registro') ?>" class="btn-filled">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="inicio" class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Bienvenido a Talent Sphere</h1>
                    <p>Simplifica la administración de tu equipo con nuestra plataforma todo en uno. Gestión integral de recursos humanos para empresas modernas.</p>
                </div>
                <div class="hero-logo-box">
                    <div class="logo-container">
                        <svg width="60" height="60" viewBox="0 0 32 32">
                            <circle cx="16" cy="16" r="14" fill="url(#grad2)" />
                            <ellipse cx="16" cy="16" rx="10" ry="4" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="1"/>
                            <ellipse cx="16" cy="16" rx="10" ry="4" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="1" transform="rotate(60 16 16)"/>
                            <ellipse cx="16" cy="16" rx="10" ry="4" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="1" transform="rotate(-60 16 16)"/>
                            <circle cx="16" cy="16" r="3" fill="white"/>
                            <defs>
                                <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#501lec" />
                                    <stop offset="100%" stop-color="#7c3aed" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="logo-text">
                            <span>Talent</span>
                            <span>Sphere</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="servicios" class="services-section">
            <h2>Nuestros Servicios</h2>
            <p class="section-subtitle">Soluciones integrales para la gestión de tu talento humano</p>
            <div class="services-container">
                <div class="service-card">
                    <h3> Empleados</h3>
                    <p>Administra perfiles completos y expedientes digitales de todo tu personal en un solo lugar.</p>
                </div>
                <div class="service-card">
                    <h3> Prestaciones Sociales</h3>
                    <p>Calcula y gestiona prestaciones sociales, cesantías, primas e intereses automáticamente.</p>
                </div>
                <div class="service-card">
                    <h3> Afiliaciones</h3>
                    <p>Controla afiliaciones a entidades de seguridad social y mantén actualizada la información.</p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="nosotros" class="features-section">
            <h2>¿Por qué elegir Talent Sphere?</h2>
            <p class="section-subtitle">Características que nos hacen diferentes</p>
            <div class="features-grid">
                <div class="feature-item">
                    <h4> Fácil de usar</h4>
                    <p>Interfaz intuitiva que no requiere capacitación extensa</p>
                </div>
                <div class="feature-item">
                    <h4> Seguro</h4>
                    <p>Protección de datos con los más altos estándares de seguridad</p>
                </div>
                <div class="feature-item">
                    <h4> En la nube</h4>
                    <p>Accede desde cualquier lugar y dispositivo</p>
                </div>
                <div class="feature-item">
                    <h4> Soporte 24/7</h4>
                    <p>Equipo de soporte siempre disponible para ayudarte</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <h2>¿Listo para transformar tu gestión de RRHH?</h2>
            <p>Únete a cientos de empresas que ya confían en Talent Sphere</p>
            <a href="<?= url('registro') ?>" class="btn-cta">Comienza Gratis</a>
        </section>

        <!-- Contact Section -->
        <section id="contacto" class="contact-section">
            <h2>Contáctanos</h2>
            <p class="section-subtitle">Estamos aquí para ayudarte</p>
            <div class="contact-wrapper">
                <form class="contact-form">
                    <div class="form-field">
                        <label>Nombre completo</label>
                        <input type="text" placeholder="Tu nombre">
                    </div>
                    <div class="form-field">
                        <label>Email</label>
                        <input type="email" placeholder="tu@email.com">
                    </div>
                    <div class="form-field">
                        <label>Empresa</label>
                        <input type="text" placeholder="Nombre de tu empresa">
                    </div>
                    <div class="form-field">
                        <label>Mensaje</label>
                        <textarea rows="4" placeholder="¿En qué podemos ayudarte?"></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Enviar Mensaje</button>
                </form>
                <div class="contact-info">
                    <div class="info-block">
                        <span class="info-title"> Email</span>
                        <span class="info-value">info@talentsphere.com</span>
                    </div>
                    <div class="info-block">
                        <span class="info-title"> Teléfono</span>
                        <span class="info-value">+57 (601) 254-4578</span>
                    </div>
                    <div class="info-block">
                        <span class="info-title"> Dirección</span>
                        <span class="info-value">Bogotá, Colombia</span>
                    </div>
                    <div class="info-block">
                        <span class="info-title"> Horario</span>
                        <span class="info-value">Lunes a Viernes: 8:00 AM - 6:00 PM</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="brand">
                        
                        <span class="brand-name">Talent Sphere</span>
                    </div>
                    <p>Soluciones inteligentes para la gestión de recursos humanos.</p>
                </div>
                <div class="footer-column">
                    <h4>Servicios</h4>
                    <a href="#">Empleados</a>
                    <a href="#">Prestaciones Sociales</a>
                    <a href="#">Afiliaciones</a>
                </div>
                <div class="footer-column">
                    <h4>Empresa</h4>
                    <a href="#">Sobre Nosotros</a>
                    <a href="#">Blog</a>
                    <a href="#">Carreras</a>
                    <a href="#">Contacto</a>
                </div>
                <div class="footer-column">
                    <h4>Legal</h4>
                    <a href="#">Términos y Condiciones</a>
                    <a href="#">Política de Privacidad</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© <?= date('Y') ?> Talent Sphere. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>
