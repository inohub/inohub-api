<?php

namespace App\Services\Text;

use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class TextCreateService
 * @property Model   $model
 * @property Request $request
 * @package App\Services\Text
 */
class TextCreateService
{
    private Model $model;
    private Request $request;

    /**
     * TextCreateService constructor.
     *
     * @param Model   $model
     * @param Request $request
     */
    public function __construct(Model $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $text = new Text();
        $data = $this->request->post();

        $text->title = Arr::get($data, 'title');
        $text->content = Arr::get($data, 'content');
        $text->target_class = $this->model->getMorphClass();
        $text->target_id = $this->model->id;

        return $text->save();
    }
}
