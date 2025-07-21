<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QrCodeController extends Controller
{
    public function generateFixedQr()
    {
        try {
            // Your redirect URL
            $redirectUrl = 'https://orionacsys.com/qr-redirect';

            Log::info('Starting QR code generation for URL: ' . $redirectUrl);

            // Generate QR code using QR Server API
            $apiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($redirectUrl);

            Log::info('API URL: ' . $apiUrl);

            // Get QR code image content with timeout
            $response = Http::timeout(30)->get($apiUrl);

            Log::info('API Response Status: ' . $response->status());

            if ($response->successful()) {
                // Check if images directory exists
                $imagesDir = public_path('images');
                if (!file_exists($imagesDir)) {
                    Log::info('Creating images directory');
                    if (!mkdir($imagesDir, 0755, true)) {
                        throw new \Exception('Failed to create images directory');
                    }
                }

                // Save the QR code image
                $path = public_path('images/fixed-qr.png');

                Log::info('Saving to path: ' . $path);
                Log::info('Response body size: ' . strlen($response->body()) . ' bytes');

                // Save the image
                $bytesWritten = file_put_contents($path, $response->body());

                if ($bytesWritten === false) {
                    throw new \Exception('file_put_contents returned false');
                }

                Log::info('QR code saved successfully. Bytes written: ' . $bytesWritten);

                return response()->json([
                    'success' => true,
                    'message' => 'QR code generated and saved successfully',
                    'path' => $path,
                    'bytes' => $bytesWritten
                ]);

            } else {
                $errorMsg = 'QR Server API request failed with status: ' . $response->status();
                Log::error($errorMsg);
                Log::error('Response body: ' . $response->body());

                return response()->json([
                    'success' => false,
                    'message' => $errorMsg,
                    'details' => $response->body()
                ]);
            }

        } catch (\Exception $e) {
            $errorMsg = 'QR Code generation failed: ' . $e->getMessage();
            Log::error($errorMsg);
            Log::error('Exception trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $errorMsg,
                'details' => $e->getTraceAsString()
            ]);
        }
    }

    public function showFixedQr()
    {
        $qrPath = '/images/fixed-qr.png';
        $redirectUrl = 'https://orionacsys.com/qr-redirect';

        return view('qrcode.fixed', [
            'qrPath' => $qrPath,
            'redirectUrl' => $redirectUrl
        ]);
    }

    public function handleRedirect()
    {
        return view('qrcode.qr');
    }
}
