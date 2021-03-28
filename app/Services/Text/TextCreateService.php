<?php

namespace App\Services\Text;

use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
        $res = true;
        $data = $this->request->post('texts');

        foreach ($data as $item) {
            $text = new Text();

            $text->title = $item['title'];
            $text->content = $item['content'];
            $text->target_class = $this->model->getMorphClass();
            $text->target_id = $this->model->id;

            $res = $res && $text->save();
        }

        return $res;
    }
}
