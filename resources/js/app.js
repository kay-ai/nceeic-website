// resources/js/app.js

import './bootstrap';
import 'flowbite';

// ── Scroll-triggered reveal animations ──────────────────────────
// Any element with class="reveal" fades up when it enters the viewport.
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, i * 60);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
