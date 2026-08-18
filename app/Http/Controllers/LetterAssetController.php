<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class LetterAssetController extends Controller
{
    /**
     * Serve static letter layout assets (CSS, images, templates) securely.
     */
    public function show(string $filename): Response
    {
        $cleanFilename = basename($filename);
        $extension = strtolower(pathinfo($cleanFilename, PATHINFO_EXTENSION));

        $allowedExtensions = ['css', 'png', 'webp', 'svg', 'html'];
        if (!in_array($extension, $allowedExtensions, true)) {
            abort(404);
        }

        $allowedDirs = [
            public_path('letter'),
            resource_path('views/components/letter'),
            resource_path('views/letter'),
        ];

        $targetPath = null;
        foreach ($allowedDirs as $dir) {
            $possiblePath = $dir . DIRECTORY_SEPARATOR . $cleanFilename;
            $realPossiblePath = realpath($possiblePath);
            $realDir = realpath($dir);

            if ($realPossiblePath && $realDir && str_starts_with($realPossiblePath, $realDir)) {
                $targetPath = $realPossiblePath;
                break;
            }
        }

        if (!$targetPath || !file_exists($targetPath)) {
            abort(404);
        }

        $mimeType = match ($extension) {
            'css' => 'text/css',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'html' => 'text/html',
            default => 'text/plain',
        };

        return response(file_get_contents($targetPath))
            ->header('Content-Type', $mimeType);
    }
}
