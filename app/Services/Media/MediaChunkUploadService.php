<?php


namespace App\Services\Media;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaChunkUploadService
{
    private Model $model;
    private Request $request;
    private string $collectionName;

    /**
     * LikeService constructor.
     *
     * @param  Model  $model
     * @param  Request  $request
     * @param  string  $collectionName
     */
    public function __construct(Model $model, Request $request, string $collectionName)
    {
        $this->model = $model;
        $this->request = $request;
        $this->collectionName = $collectionName;
    }

    public function run()
    {
        $file = $this->request->file('file');

        $path = 'chunks/user_'.'1'.'/'.$file->getClientOriginalName();

        Storage::disk('public')->append($path, $file->get());

        if ($this->request->has('is_last') && $this->request->boolean('is_last')) {
            $name = basename($path, '.part');

            if ($this->model->getFirstMediaUrl($this->collectionName) != null) {
                $this->model->clearMediaCollection($this->collectionName);
            }

            $this->model->addMediaFromDisk($path, 'public')
                ->usingFileName($name)
                ->toMediaCollection($this->collectionName);
        }

        return $this->model;
    }
}
