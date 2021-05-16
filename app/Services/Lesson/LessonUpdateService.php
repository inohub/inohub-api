<?php

namespace App\Services\Lesson;

use App\Components\Request\DataTransfer;
use App\Models\Lesson\Lesson;
use App\Services\Text\TextsCreateService;

/**
 * Class LessonUpdateService
 * @property Lesson       $lesson
 * @property DataTransfer $request
 * @package App\Services\Lesson
 */
class LessonUpdateService
{
    private Lesson $lesson;
    private DataTransfer $request;

    /**
     * LessonUpdateService constructor.
     *
     * @param Lesson       $lesson
     * @param DataTransfer $request
     */
    public function __construct(Lesson $lesson, DataTransfer $request)
    {
        $this->lesson = $lesson;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->lesson->description = $this->request->post('description');

        return $this->lesson->save() && (new TextsCreateService($this->lesson, new DataTransfer([
                'texts' => $this->request->post('texts'),
            ])))->run();
    }
}
