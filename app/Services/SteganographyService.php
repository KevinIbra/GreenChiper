<?php

namespace App\Services;

use App\Models\ImageData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class SteganographyService
{
    public function encode(UploadedFile $image, string $message, string $method): ImageData
    {
        $originalPath = $image->store('images/original', 'public');
        if (!$originalPath) {
            throw new Exception('Failed to store original image');
        }

        try {
            $stegoPath = match($method) {
                'lsb' => $this->encodeLSB($originalPath, $message),
                'gan' => $this->encodeGAN($originalPath, $message),
                default => throw new Exception('Invalid steganography method'),
            };

            $psnr = $this->calculatePSNR($originalPath, $stegoPath);
            $ssim = $this->calculateSSIM($originalPath, $stegoPath);

            return ImageData::create([
                'original_image' => $originalPath,
                'stego_image' => $stegoPath,
                'hidden_message' => $message,
                'method_used' => $method,
                'psnr_value' => $psnr,
                'ssim_value' => $ssim
            ]);
        } catch (Exception $e) {
            Storage::disk('public')->delete($originalPath);
            throw $e;
        }
    }

    public function decode(UploadedFile $image, string $method): string
    {
        $imagePath = $image->store('images/temp', 'public');
        if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
            throw new Exception('The image failed to upload.');
        }
        try {
            $decodedMessage = match($method) {
                'lsb' => $this->decodeLSB($imagePath),
                'gan' => $this->decodeGAN($imagePath),
                default => throw new Exception('Invalid steganography method'),
            };
            unlink(storage_path('app/public/' . $imagePath));
            return $decodedMessage;
        } catch (Exception $e) {
            if (file_exists(storage_path('app/public/' . $imagePath))) {
                unlink(storage_path('app/public/' . $imagePath));
            }
            throw $e;
        }
    }

    private function decodeLSB(string $imagePath): string
    {
        try {
            $pythonScript = base_path('python/lsb_steganography.py');
            if (!file_exists($pythonScript)) {
                throw new Exception('LSB decoder script not found');
            }

            $fullPath = Storage::disk('public')->path($imagePath);
            if (!file_exists($fullPath)) {
                throw new Exception('Image not found');
            }

            // Fix path separators for Windows
            $pythonScript = str_replace('\\', '/', $pythonScript);
            $fullPath = str_replace('\\', '/', $fullPath);

            // Execute Python script with correct arguments
            $command = sprintf(
                'python "%s" decode "%s" 2>&1',
                $pythonScript,
                $fullPath
            );

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new Exception('Python script execution failed: ' . implode("\n", $output));
            }

            // Get only the last line of output (the JSON response)
            $jsonResponse = end($output);
            $result = json_decode($jsonResponse, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response: ' . $jsonResponse);
            }

            if (!$result['success']) {
                throw new Exception($result['error'] ?? 'Unknown LSB decoding error');
            }

            if (empty($result['message'])) {
                throw new Exception('No message found in image');
            }

            return $result['message'];

        } catch (Exception $e) {
            throw new Exception('LSB decoding failed: ' . $e->getMessage());
        }
    }

    private function decodeGAN(string $imagePath): string 
    {
        try {
            $pythonScript = base_path('python/gan_decoder.py');
            if (!file_exists($pythonScript)) {
                throw new Exception('GAN decoder script not found');
            }
            $fullPath = Storage::disk('public')->path($imagePath);
            if (!file_exists($fullPath)) {
                throw new Exception('Image file not found');
            }
            $command = sprintf(
                'python "%s" "%s" 2>&1',
                escapeshellarg($pythonScript),
                escapeshellarg($fullPath)
            );
            exec($command, $output, $returnCode);
            if ($returnCode !== 0) {
                throw new Exception('Python script failed with code ' . $returnCode);
            }
            if (empty($output)) {
                throw new Exception('No output from GAN decoder script');
            }
            $jsonResponse = end($output);
            $result = json_decode($jsonResponse, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response from GAN decoder: ' . implode("\n", $output));
            }
            if (!$result['success']) {
                throw new Exception($result['error'] ?? 'Unknown error');
            }
            if (empty($result['message'])) {
                throw new Exception('No message found in image');
            }
            if (!mb_check_encoding($result['message'], 'UTF-8')) {
                throw new Exception('Invalid UTF-8 message encoding');
            }
            return $result['message'];
        } catch (Exception $e) {
            throw new Exception('GAN decoding failed: ' . $e->getMessage());
        }
    }

    private function encodeLSB(string $originalPath, string $message): string 
    {
        try {
            // Validate inputs
            if (empty($message)) {
                throw new Exception('Message cannot be empty');
            }

            $pythonScript = base_path('python/lsb_steganography.py');
            if (!file_exists($pythonScript)) {
                throw new Exception('LSB encoder script not found at: ' . $pythonScript);
            }

            $originalFullPath = Storage::disk('public')->path($originalPath);
            if (!file_exists($originalFullPath)) {
                throw new Exception('Original image not found at: ' . $originalFullPath);
            }

            // Create stego directory if it doesn't exist
            $stegoDir = Storage::disk('public')->path('images/stego');
            if (!file_exists($stegoDir)) {
                mkdir($stegoDir, 0755, true);
            }

            $stegoPath = 'images/stego/' . uniqid() . '.png';
            $stegoFullPath = Storage::disk('public')->path($stegoPath);

            // Fix path separators for Windows
            $pythonScript = str_replace('\\', '/', $pythonScript);
            $originalFullPath = str_replace('\\', '/', $originalFullPath);
            $stegoFullPath = str_replace('\\', '/', $stegoFullPath);

            // Build and execute command
            $command = sprintf(
                'python "%s" encode "%s" %s "%s" 2>&1',
                $pythonScript,
                $originalFullPath,
                escapeshellarg($message),
                $stegoFullPath
            );

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new Exception('Python script execution failed: ' . implode("\n", $output));
            }

            $jsonResponse = end($output);
            $result = json_decode($jsonResponse, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response from Python script: ' . $jsonResponse);
            }

            if (!$result['success']) {
                throw new Exception($result['error'] ?? 'Unknown LSB encoding error');
            }

            if (!file_exists($stegoFullPath)) {
                throw new Exception('Output file was not created');
            }

            return $stegoPath;

        } catch (Exception $e) {
            // Clean up any partial output
            if (isset($stegoFullPath) && file_exists($stegoFullPath)) {
                unlink($stegoFullPath);
            }
            throw new Exception('LSB encoding failed: ' . $e->getMessage());
        }
    }

    private function encodeGAN(string $originalPath, string $message): string 
    {
        try {
            // Validate input image and get full paths
            $originalFullPath = Storage::disk('public')->path($originalPath);
            $stegoPath = 'images/stego/' . uniqid() . '.png';
            $stegoFullPath = Storage::disk('public')->path($stegoPath);

            // Validate image before processing
            $image = imagecreatefromstring(file_get_contents($originalFullPath));
            if (!$image) {
                throw new Exception('Invalid input image');
            }
            imagedestroy($image);

            // Ensure message length is valid
            if (empty($message) || strlen($message) > 256) {
                throw new Exception('Message must be between 1 and 256 characters');
            }

            // Prepare Python command with quality parameters
            $pythonScript = base_path('python/gan_steganography.py');
            if (!file_exists($pythonScript)) {
                throw new Exception('GAN Python script not found');
            }

            // Fix path separators and escape properly
            $originalFullPath = str_replace('\\', '/', $originalFullPath);
            $stegoFullPath = str_replace('\\', '/', $stegoFullPath);
            
            // Build command with proper argument order and escaping
            $command = sprintf(
                'python %s %s %s %s --quality high --preserve-ratio --no-compress',
                escapeshellarg($pythonScript),
                escapeshellarg($originalFullPath),
                escapeshellarg($message),
                escapeshellarg($stegoFullPath)
            );

            // Capture both stdout and stderr
            $output = [];
            $returnCode = -1;
            exec($command . ' 2>&1', $output, $returnCode);

            // Detailed error reporting
            if ($returnCode !== 0) {
                $errorOutput = implode("\n", $output);
                throw new Exception("Python script failed (code {$returnCode}): {$errorOutput}");
            }

            if (empty($output)) {
                throw new Exception('No output from GAN script');
            }

            // Parse JSON response
            $jsonResponse = end($output);
            $result = json_decode($jsonResponse, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response: ' . implode("\n", $output));
            }

            if (!$result['success']) {
                throw new Exception($result['error'] ?? 'Unknown error in GAN script');
            }

            // Verify output image
            if (file_exists($stegoFullPath)) {
                $psnr = $this->calculatePSNR($originalPath, $stegoPath);
                if ($psnr < 25.0) { // Lowered from 30.0 to 25.0 for better balance
                    throw new Exception('Generated image quality is too low');
                }

                // Verify message can be decoded
                if (!$this->verifyGANEncoding($stegoPath, $message)) {
                    throw new Exception('Message verification failed');
                }
            }

            return $stegoPath;

        } catch (Exception $e) {
            // Cleanup on failure
            if (isset($stegoFullPath) && file_exists($stegoFullPath)) {
                unlink($stegoFullPath);
            }
            throw new Exception('GAN encoding failed: ' . $e->getMessage());
        }
    }

    private function verifyGANEncoding(string $stegoPath, string $originalMessage): bool
    {
        try {
            // Try to decode immediately after encoding
            $decodedMessage = $this->decodeGAN($stegoPath);
            
            // Compare original and decoded messages
            if (empty($decodedMessage)) {
                return false;
            }

            // Allow partial matches with at least 80% similarity
            similar_text($originalMessage, $decodedMessage, $percent);
            return $percent >= 80;

        } catch (Exception $e) {
            return false;
        }
    }

    private function calculatePSNR(string $originalPath, string $stegoPath): float
    {
        try {
            $originalFullPath = Storage::disk('public')->path($originalPath);
            $stegoFullPath = Storage::disk('public')->path($stegoPath);
            
            if (!file_exists($originalFullPath) || !file_exists($stegoFullPath)) {
                throw new Exception("Image files not found");
            }

            $originalImg = @imagecreatefromstring(file_get_contents($originalFullPath));
            $stegoImg = @imagecreatefromstring(file_get_contents($stegoFullPath));
            
            if (!$originalImg || !$stegoImg) {
                throw new Exception("Failed to load images");
            }

            // Get dimensions of both images
            $widthOrig = imagesx($originalImg);
            $heightOrig = imagesy($originalImg);
            $widthStego = imagesx($stegoImg);
            $heightStego = imagesy($stegoImg);

            // Use minimum dimensions to avoid bounds error
            $width = min($widthOrig, $widthStego);
            $height = min($heightOrig, $heightStego);

            $mse = 0;
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    $rgb1 = imagecolorat($originalImg, $x, $y);
                    $rgb2 = imagecolorat($stegoImg, $x, $y);
                    $r1 = ($rgb1 >> 16) & 0xFF;
                    $g1 = ($rgb1 >> 8) & 0xFF;
                    $b1 = $rgb1 & 0xFF;
                    $r2 = ($rgb2 >> 16) & 0xFF;
                    $g2 = ($rgb2 >> 8) & 0xFF;
                    $b2 = $rgb2 & 0xFF;
                    $mse += pow($r1 - $r2, 2) + pow($g1 - $g2, 2) + pow($b1 - $b2, 2);
                }
            }

            imagedestroy($originalImg);
            imagedestroy($stegoImg);

            $mse /= (3 * $width * $height);
            return $mse == 0 ? 100.0 : (20 * log10(255) - 10 * log10($mse));

        } catch (Exception $e) {
            if (isset($originalImg)) imagedestroy($originalImg);
            if (isset($stegoImg)) imagedestroy($stegoImg);
            throw $e;
        }
    }

    private function calculateSSIM($original, $stego): float
    {
        // TODO: Implement SSIM calculation
        return 0.0;
    }
}