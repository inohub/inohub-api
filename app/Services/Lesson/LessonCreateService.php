<?php

namespace App\Services\Lesson;

use App\Components\Request\DataTransfer;
use App\Models\Lesson\Lesson;
use App\Services\Text\TextsCreateService;

/**
 * Class LessonCreateService
 * @property Lesson       $lesson
 * @property DataTransfer $request
 * @package App\Services\Lesson
 */
class LessonCreateService
{
    private Lesson $lesson;
    private DataTransfer $request;

    /**
     * LessonCreateService constructor.
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
        $this->lesson->course_id = $this->request->post('course_id');
        $this->lesson->name = $this->request->post('name');
        $this->lesson->description = $this->request->post('description');

        return $this->lesson->save() && (new TextsCreateService($this->lesson, new DataTransfer([
                'texts' => $this->request->post('texts'),
            ])))->run();
    }
}
