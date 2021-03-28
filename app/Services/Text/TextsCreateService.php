<?php

namespace App\Services\Text;

use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class TextsCreateService
 * @property Model   $model
 * @property Request $request
 * @package App\Services\Text
 */
class TextsCreateService
{
    private Model $model;
    private Request $request;

    /**
     * TextsCreateService constructor.
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
        if (!is_null($this->model->texts)) {
            foreach ($this->model->texts as $text) {
                $text->delete();
            }
        }

        $items = $this->request->post('texts');

        $res = true;
        foreach ($items as $item) {
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
