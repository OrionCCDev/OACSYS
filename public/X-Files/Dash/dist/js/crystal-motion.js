/* OACSYS Crystal Dark - motion layer
   1. Particle field on the fixed background canvas (#crystalParticles)
   2. Parallax: background layers follow the mouse and scroll at different
      depths; tiles/stat cards tilt toward the cursor with a tracking glare
   3. Count-up for dashboard stat numbers (.crystal-stat-number)
   4. Click ripple on buttons (.btn)
   The CSS side (liquid blobs, entrance, hovers) lives in crystal-dark.css. */
(function () {
    'use strict';

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var finePointer  = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

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

    /* ---------- 2. parallax ----------
       Background depths: the liquid layer moves least (furthest away), the
       particle canvas more (closer). Both follow the cursor (opposite to it,
       like looking through a window) and drift with scroll. Targets are
       lerped each frame so the motion is smooth even when the mouse jumps.
       The liquid element's CSS transform is `scale(2)` (half-res upscale) -
       the translate is written in FRONT of it so it stays in screen pixels. */
    function startParallax() {
        if (reduceMotion) return;

        var liquid = document.querySelector('.crystal-liquid');
        var canvas = document.getElementById('crystalParticles');
        var masthead = document.querySelector('.crystal-masthead');
        if (!liquid && !canvas && !masthead) return;

        var mouseX = 0, mouseY = 0;      // -1 .. 1 from viewport centre
        var curX = 0, curY = 0;          // lerped
        var scrollY = window.scrollY || 0;
        var rafId = null;

        if (finePointer) {
            window.addEventListener('mousemove', function (e) {
                mouseX = (e.clientX / (window.innerWidth || 1)) * 2 - 1;
                mouseY = (e.clientY / (window.innerHeight || 1)) * 2 - 1;
            }, { passive: true });
            window.addEventListener('mouseleave', function () { mouseX = 0; mouseY = 0; });
        }
        window.addEventListener('scroll', function () { scrollY = window.scrollY || 0; }, { passive: true });

        function frame() {
            rafId = requestAnimationFrame(frame);
            curX += (mouseX - curX) * 0.06;
            curY += (mouseY - curY) * 0.06;

            if (liquid) {
                liquid.style.transform = 'translate3d(' + (-curX * 16).toFixed(2) + 'px,' +
                    (-curY * 16 + scrollY * 0.05).toFixed(2) + 'px,0) scale(2)';
            }
            if (canvas) {
                canvas.style.transform = 'translate3d(' + (-curX * 30).toFixed(2) + 'px,' +
                    (-curY * 30 + scrollY * 0.12).toFixed(2) + 'px,0) scale(1.06)';
            }
            if (masthead) {
                // the dashboard title drifts down slower than the page and fades as it goes
                var t = Math.min(scrollY / 320, 1);
                masthead.style.transform = 'translate3d(0,' + (scrollY * 0.22).toFixed(2) + 'px,0)';
                masthead.style.opacity = (1 - t * 0.85).toFixed(3);
            }
        }

        function start() { if (rafId === null) rafId = requestAnimationFrame(frame); }
        function stop() { if (rafId !== null) { cancelAnimationFrame(rafId); rafId = null; } }
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) stop(); else start();
        });
        start();
    }

    /* tiles / stat cards tilt toward the cursor; --mx/--my drive the CSS glare */
    function startTilt() {
        if (reduceMotion || !finePointer) return;
        var MAX_DEG = 5;

        document.addEventListener('mousemove', function (e) {
            var card = e.target.closest && e.target.closest('.crystal-tile, .crystal-stat');
            if (!card) return;
            var rect = card.getBoundingClientRect();
            var px = (e.clientX - rect.left) / rect.width;   // 0 .. 1
            var py = (e.clientY - rect.top) / rect.height;
            var rotY = (px - 0.5) * 2 * MAX_DEG;
            var rotX = (0.5 - py) * 2 * MAX_DEG;
            card.style.setProperty('--mx', (px * 100).toFixed(1) + '%');
            card.style.setProperty('--my', (py * 100).toFixed(1) + '%');
            card.style.transition = 'transform 0.08s ease, border-color 0.2s ease, box-shadow 0.25s ease, background 0.2s ease';
            card.style.transform = 'perspective(700px) rotateX(' + rotX.toFixed(2) + 'deg) rotateY(' + rotY.toFixed(2) + 'deg) translateY(-4px)';
        }, { passive: true });

        document.addEventListener('mouseout', function (e) {
            var card = e.target.closest && e.target.closest('.crystal-tile, .crystal-stat');
            if (!card || (e.relatedTarget && card.contains(e.relatedTarget))) return;
            // hand control back to the stylesheet's own hover/entrance rules
            card.style.transition = '';
            card.style.transform = '';
        }, { passive: true });
    }

    /* ---------- 3. count-up on dashboard stats ---------- */
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

    /* ---------- 4. button ripple ---------- */
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
        startParallax();
        startTilt();
        countUp();
        ripple();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
