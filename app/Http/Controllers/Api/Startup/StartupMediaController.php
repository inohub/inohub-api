<?php

namespace App\Http\Controllers\Api\Startup;

use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Models\Startup\Startup;
use App\Services\Media\MediaChunkUploadService;
use Illuminate\Http\Request;

class StartupMediaController extends Controller
{
    public function storeStartupPreviewImage(Startup $startup, Request $request, $collectionName = 'preview-image')
    {
        try {
            if ((new MediaChunkUploadService($startup, $request, $collectionName))->run()) {
                return $this->response($startup->getFirstMediaUrl($collectionName));
            }

            throw new FailedResultException('Не удалось сохранить');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function deleteStartupPreviewImage(Startup $startup)
    {
        $startup->clearMediaCollection('preview-image');

        $this->response([]);
    }

    public function storeStartupPreviewVideo(Startup $startup, Request $request, $collectionName = 'preview-video')
    {
        try {
            if ((new MediaChunkUploadService($startup, $request, $collectionName))->run()) {
                return $this->response($startup->getFirstMediaUrl($collectionName));
            }

            throw new FailedResultException('Не удалось сохранить');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function deleteStartupPreviewVideo(Startup $startup)
    {
        $startup->clearMediaCollection('preview-video');

        $this->response([]);
    }

}
