{{-- Animated background: liquid blobs + particle canvas + grain, with mouse/scroll
     parallax. Styles: dist/css/crystal-liquid.css. Behaviour: dist/js/crystal-motion.js.
     Include right after <body> - it's position:fixed at z-index -1, so it sits behind
     everything without needing any wrapper to be stacked above it. --}}
<div class="crystal-bg" aria-hidden="true">
    <div class="crystal-liquid">
        <span class="crystal-blob crystal-blob-1"></span>
        <span class="crystal-blob crystal-blob-2"></span>
        <span class="crystal-blob crystal-blob-3"></span>
        <span class="crystal-blob crystal-blob-4"></span>
        <span class="crystal-blob crystal-blob-5"></span>
        <span class="crystal-blob crystal-blob-6"></span>
        <span class="crystal-blob crystal-blob-7"></span>
    </div>
    <canvas id="crystalParticles"></canvas>
</div>
