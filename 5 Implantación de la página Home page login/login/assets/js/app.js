// assets/js/app.js - JavaScript Principal Talent Sphere

/**
 * Toggle del Sidebar
 */
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
    if (overlay) {
        overlay.classList.toggle('active');
    }
}

/**
 * Inicialización del Sidebar
 */
function initSidebar() {
    const overlay = document.querySelector('.sidebar-overlay');
    const closeBtn = document.querySelector('.close-btn');
    
    if (overlay) {
        overlay.addEventListener('click', toggleSidebar);
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', toggleSidebar);
    }
}

/**
 * Cerrar mensajes flash automáticamente
 */
function initMensajes() {
    const alertas = document.querySelectorAll('.alert');
    
    alertas.forEach(alerta => {
        // Solo auto-cerrar si no es del formulario
        if (!alerta.id || !alerta.id.includes('formulario')) {
            setTimeout(() => {
                alerta.style.transition = 'opacity 0.3s';
                alerta.style.opacity = '0';
                setTimeout(() => alerta.remove(), 300);
            }, 5000);
        }
    });
}

/**
 * Inicialización general
 */
document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initMensajes();
});
