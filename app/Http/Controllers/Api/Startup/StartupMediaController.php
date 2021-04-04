<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Controller;
use App\Models\Startup\Startup;
use App\ResponseCodes\ResponseCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StartupMediaController extends Controller
{
    public function storeStartupPreviewImage(Startup $startup)
    {
        try {
            if ($startup->getFirstMediaUrl('preview-image') != null) {
                $startup->clearMediaCollection('preview-image');
            }

            $startup->addMediaFromRequest('file')
                ->toMediaCollection('preview-image');
        } catch (\Exception $exception) {
            return $this->response($exception->getMessage(), ResponseCodes::FAILED_RESULT);
        }

        return $this->response($startup->preview_image_url);
    }

    public function deleteStartupPreviewImage(Startup $startup)
    {
        $startup->clearMediaCollection('preview-image');

        $this->response(null);
    }

    public function storeStartupPreviewVideo(Startup $startup, Request $request)
    {
        $file = $request->file('file');

        $path = 'chunks/'.$file->getClientOriginalName();

        Storage::disk('public')->append($path, $file->get());

        if ($request->has('is_last') && $request->boolean('is_last')) {

            if ($startup->getFirstMediaUrl('preview-video') != null) {
                $startup->clearMediaCollection('preview-video');
            }

            $startup->addMediaFromDisk($path, 'public')
                ->toMediaCollection('preview-video');
        }

        return $this->response($startup->getFirstMediaUrl('preview-video'));
    }

    public function deleteStartupPreviewVideo(Startup $startup)
    {
        $startup->clearMediaCollection('preview-video');

        $this->response(null);
    }

}
