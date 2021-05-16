<?php

namespace App\Services\Text;

use App\Components\Request\DataTransfer;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TextCreateService
 * @property Model        $model
 * @property DataTransfer $request
 * @package App\Services\Text
 */
class TextCreateService
{
    private Model $model;
    private DataTransfer $request;

    /**
     * TextCreateService constructor.
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
        $text = new Text();

        $text->title = $this->request->post('title');
        $text->content = $this->request->post('content');
        $text->target_class = $this->model->getMorphClass();
        $text->target_id = $this->model->id;

        return $text->save();
    }
}
