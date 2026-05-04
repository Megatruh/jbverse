import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (!toggleBtn || !passwordInput) return;

        // Saat tombol ditekan (hold)
        const showPassword = () => {
            passwordInput.setAttribute('type', 'text');
        };

        // Saat tombol dilepas (mouse up)
        const hidePassword = () => {
            passwordInput.setAttribute('type', 'password');
        };

        // Event untuk mouse / touch
        toggleBtn.addEventListener('mousedown', showPassword);
        toggleBtn.addEventListener('mouseup', hidePassword);
        toggleBtn.addEventListener('mouseleave', hidePassword);

        // Untuk perangkat touch (smartphone)
        toggleBtn.addEventListener('touchstart', showPassword);
        toggleBtn.addEventListener('touchend', hidePassword);
        toggleBtn.addEventListener('touchcancel', hidePassword);

        // Mencegah default action agar tidak memicu hilang fokus pada input (opsional)
        toggleBtn.addEventListener('click', (e) => e.preventDefault());
    });
