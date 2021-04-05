<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Controller;
use App\Models\Startup\Startup;
use App\ResponseCodes\ResponseCodes;
use App\Services\Media\MediaChunkUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StartupMediaController extends Controller
{
    public function storeStartupPreviewImage(Startup $startup, Request $request, $collectionName = 'preview-image')
    {
        try {
            if ((new MediaChunkUploadService($startup, $request, $collectionName))->run()) {

                return $this->response($startup->getFirstMediaUrl($collectionName));
            }
        } catch (\Throwable $exception) {
            return $this->response($exception->getMessage(), ResponseCodes::FAILED_RESULT);
        }
    }

    public function deleteStartupPreviewImage(Startup $startup)
    {
        $startup->clearMediaCollection('preview-image');

        $this->response(null);
    }

    public function storeStartupPreviewVideo(Startup $startup, Request $request, $collectionName = 'preview-video')
    {
        try {
            if ((new MediaChunkUploadService($startup, $request, $collectionName))->run()) {

                return $this->response($startup->getFirstMediaUrl($collectionName));
            }
        } catch (\Throwable $exception) {
            return $this->response($exception->getMessage(), ResponseCodes::FAILED_RESULT);
        }
    }

    public function deleteStartupPreviewVideo(Startup $startup)
    {
        $startup->clearMediaCollection('preview-video');

        $this->response(null);
    }

}
