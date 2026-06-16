<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function download(ApplicationDocument $document)
    {
        if (!Storage::disk('private')->exists($document->stored_path)) {
            abort(404, 'File not found');
        }

        $type = request()->query('type', 'download');

        if ($type === 'view') {
            return Storage::disk('private')->response(
                $document->stored_path,
                $document->original_filename,
                ['Content-Type' => $document->mime_type]
            );
        }

        return Storage::disk('private')->download(
            $document->stored_path,
            $document->original_filename,
            ['Content-Type' => $document->mime_type]
        );
    }
}
