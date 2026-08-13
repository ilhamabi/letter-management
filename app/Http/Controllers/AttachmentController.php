<?php

namespace App\Http\Controllers;

use App\Models\SubmissionAttachment;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AttachmentController extends Controller
{
    /**
     * Display or stream the submission attachment file directly in browser tab.
     */
    public function show(SubmissionAttachment $attachment): Response
    {
        $path = $attachment->file_path;

        if (Storage::disk('public')->exists($path)) {
            $fullPath = Storage::disk('public')->path($path);
            $mimeType = $attachment->mime_type ?: mime_content_type($fullPath) ?: 'application/pdf';

            return response()->file($fullPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $attachment->original_filename . '"',
            ]);
        }

        // Fallback: check directly in public/storage
        $publicPath = public_path('storage/' . $path);
        if (file_exists($publicPath)) {
            $mimeType = $attachment->mime_type ?: mime_content_type($publicPath) ?: 'application/pdf';

            return response()->file($publicPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $attachment->original_filename . '"',
            ]);
        }

        abort(404, 'File lampiran tidak ditemukan.');
    }
}
