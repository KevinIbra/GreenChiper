<?php

namespace App\Http\Controllers;

use App\Models\ImageData;
use App\Services\SteganographyService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Exception;
use Illuminate\Support\Facades\Storage;

class SteganographyController extends Controller
{
    protected SteganographyService $steganographyService;

    public function __construct(SteganographyService $steganographyService)
    {
        $this->steganographyService = $steganographyService;
    }

    public function index(): View
    {
        $images = ImageData::latest()->get();
        return view('welcome', compact('images'));
    }

    public function encode(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|max:10240',
                'message' => 'required|string|max:1000',
                'method' => 'required|in:lsb,gan,autoencoder'
            ]);

            $imageData = $this->steganographyService->encode(
                $request->file('image'),
                $validated['message'],
                $validated['method']
            );

            return response()->json([
                'success' => true,
                'message' => 'Image encoded successfully',
                'data' => $imageData,
                'download_url' => route('steganography.download', ['path' => $imageData->stego_image])
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function decode(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|max:10240',
                'method' => 'required|in:lsb,gan,autoencoder'
            ]);

            $decodedMessage = $this->steganographyService->decode(
                $request->file('image'),
                $validated['method']
            );

            return response()->json([
                'success' => true,
                'message' => $decodedMessage
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function download($path)
    {
        try {
            $fullPath = storage_path('app/public/' . $path);
            
            if (!file_exists($fullPath)) {
                abort(404, 'File not found');
            }

            // Get original filename
            $filename = basename($path);
            
            return response()->download(
                $fullPath,
                $filename,
                ['Content-Type' => 'image/png']
            );
        } catch (\Exception $e) {
            abort(404, 'File not found');
        }
    }
}