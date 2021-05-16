<?php

namespace App\Services\Text;

use App\Components\Request\DataTransfer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class TextsCreateService
 * @property Model        $model
 * @property DataTransfer $request
 * @package App\Services\Text
 */
class TextsCreateService
{
    private Model $model;
    private DataTransfer $request;

    /**
     * TextsCreateService constructor.
     *
     * @param Model        $model
     * @param DataTransfer $request
     */
    public function __construct(Model $model, DataTransfer $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        if (!is_null($this->model->texts)) {
            foreach ($this->model->texts as $text) {
                $text->delete();
            }
        }

        $res = true;
        foreach ($this->request->post('texts', []) as $value) {

            $res = $res && (new TextCreateService($this->model, new DataTransfer([
                    'title'   => Arr::get($value, 'title'),
                    'content' => Arr::get($value, 'content'),
                ])))->run();
        }

        return $res;
    }
}
