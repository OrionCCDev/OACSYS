/* OACSYS Crystal Dark - motion layer
   1. Particle field on the fixed background canvas (#crystalParticles)
   2. Count-up for dashboard stat numbers (.crystal-stat-number)
   3. Click ripple on buttons (.btn)
   The CSS side (orbs, entrance, hovers) lives in crystal-dark.css. */
(function () {
    'use strict';

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------- 1. particles ---------- */
    function startParticles() {
        var canvas = document.getElementById('crystalParticles');
        if (!canvas || reduceMotion) return;

        var ctx = canvas.getContext('2d');
        var dpr = Math.min(window.devicePixelRatio || 1, 1.5);
        var width = 0, height = 0, particles = [], rafId = null, lastTime = 0;
        var LINK_DIST = 130;

        function resize() {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width * dpr;
            canvas.height = height * dpr;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

            // density scales with viewport area, clamped so phones stay light
            var target = Math.max(28, Math.min(80, Math.round((width * height) / 22000)));
            while (particles.length < target) particles.push(spawn());
            particles.length = target;
        }

        function spawn() {
            return {
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.22,
                vy: (Math.random() - 0.5) * 0.22,
                r: 0.8 + Math.random() * 1.6,
                a: 0.35 + Math.random() * 0.5
            };
        }

        function frame(now) {
            rafId = requestAnimationFrame(frame);
            var dt = lastTime ? Math.min((now - lastTime) / 16.67, 3) : 1; // normalise to ~60fps steps
            lastTime = now;

            ctx.clearRect(0, 0, width, height);

            var i, j, p, q;
            for (i = 0; i < particles.length; i++) {
                p = particles[i];
                p.x += p.vx * dt;
                p.y += p.vy * dt;
                if (p.x < -10) p.x = width + 10; else if (p.x > width + 10) p.x = -10;
                if (p.y < -10) p.y = height + 10; else if (p.y > height + 10) p.y = -10;
            }

            // faint links between close neighbours
            ctx.lineWidth = 1;
            for (i = 0; i < particles.length; i++) {
                p = particles[i];
                for (j = i + 1; j < particles.length; j++) {
                    q = particles[j];
                    var dx = p.x - q.x, dy = p.y - q.y;
                    var d2 = dx * dx + dy * dy;
                    if (d2 < LINK_DIST * LINK_DIST) {
                        var t = 1 - Math.sqrt(d2) / LINK_DIST;
                        ctx.strokeStyle = 'rgba(125, 196, 255, ' + (t * 0.18).toFixed(3) + ')';
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(q.x, q.y);
                        ctx.stroke();
                    }
                }
            }

            for (i = 0; i < particles.length; i++) {
                p = particles[i];
                ctx.fillStyle = 'rgba(125, 196, 255, ' + p.a.toFixed(2) + ')';
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function start() { if (rafId === null) { lastTime = 0; rafId = requestAnimationFrame(frame); } }
        function stop() { if (rafId !== null) { cancelAnimationFrame(rafId); rafId = null; } }

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(resize, 120);
        });
        // don't burn the battery while the tab is in the background
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) stop(); else start();
        });

        resize();
        start();
    }

    /* ---------- 2. count-up on dashboard stats ---------- */
    function countUp() {
        var nodes = document.querySelectorAll('.crystal-stat-number');
        if (!nodes.length || reduceMotion) return;

        Array.prototype.forEach.call(nodes, function (el) {
            var raw = el.textContent.trim();
            var target = parseInt(raw.replace(/[^\d-]/g, ''), 10);
            if (isNaN(target) || String(target) !== raw) return; // only plain integers
            var duration = 900, startTime = null;
            el.textContent = '0';
            function step(now) {
                if (!startTime) startTime = now;
                var t = Math.min((now - startTime) / duration, 1);
                var eased = 1 - Math.pow(1 - t, 3);
                el.textContent = Math.round(target * eased);
                if (t < 1) requestAnimationFrame(step); else el.textContent = target;
            }
            requestAnimationFrame(step);
        });
    }

    /* ---------- 3. button ripple ---------- */
    function ripple() {
        if (reduceMotion) return;
        document.addEventListener('mousedown', function (e) {
            var btn = e.target.closest && e.target.closest('.btn');
            if (!btn || btn.classList.contains('btn-file') || btn.classList.contains('close')) return;
            var rect = btn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);
            var span = document.createElement('span');
            span.className = 'crystal-ripple';
            span.style.width = span.style.height = size + 'px';
            span.style.left = (e.clientX - rect.left - size / 2) + 'px';
            span.style.top = (e.clientY - rect.top - size / 2) + 'px';
            btn.appendChild(span);
            span.addEventListener('animationend', function () { span.remove(); });
        });
    }

    function init() {
        startParticles();
        countUp();
        ripple();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
