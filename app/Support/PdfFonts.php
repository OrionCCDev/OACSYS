<?php

namespace App\Support;

use Dompdf\Dompdf;

/**
 * Registers the IBM Plex fonts used by the branded PDF documents (receiving,
 * clearance, employee profile). dompdf does not reliably pick up @font-face
 * rules for custom fonts - it needs each weight registered explicitly against
 * a static (non-variable) TTF file, so that's what these are.
 */
class PdfFonts
{
    public static function register(Dompdf $dompdf): void
    {
        $dir = resource_path('fonts');
        $fm = $dompdf->getFontMetrics();

        $fm->registerFont(['family' => 'Sans', 'style' => 'normal', 'weight' => 'normal'], "$dir/plexsans-400.ttf");
        $fm->registerFont(['family' => 'Sans', 'style' => 'normal', 'weight' => '500'], "$dir/plexsans-500.ttf");
        $fm->registerFont(['family' => 'Sans', 'style' => 'normal', 'weight' => '600'], "$dir/plexsans-600.ttf");
        $fm->registerFont(['family' => 'Sans', 'style' => 'normal', 'weight' => 'bold'], "$dir/plexsans-700.ttf");

        $fm->registerFont(['family' => 'Mono', 'style' => 'normal', 'weight' => 'normal'], "$dir/plexmono-400.ttf");
        $fm->registerFont(['family' => 'Mono', 'style' => 'normal', 'weight' => '500'], "$dir/plexmono-500.ttf");
        $fm->registerFont(['family' => 'Mono', 'style' => 'normal', 'weight' => '600'], "$dir/plexmono-600.ttf");
    }
}
