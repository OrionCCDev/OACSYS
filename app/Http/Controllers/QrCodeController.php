<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;

class QrCodeController extends Controller
{
    /**
     * Display a fixed QR code that redirects to a specific route.
     */
    public function showFixedQr()
    {
        $redirectUrl = URL::to('/qr-redirect'); // The route to redirect after scanning
        $qr = QrCode::size(300)->generate($redirectUrl);
        return response()->view('qrcode.fixed', ['qr' => $qr]);
    }

    /**
     * Handle the redirect when the QR code is scanned.
     */
    public function handleRedirect()
    {
        // Change this to your desired redirect target
        return view('qrcode.qr');
    }
}
