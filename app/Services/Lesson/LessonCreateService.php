<?php

namespace App\Services\Lesson;

use App\Models\Lesson\Lesson;
use App\Services\Text\TextsCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class LessonCreateService
 * @property Lesson  $lesson
 * @property Request $request
 * @package App\Services\Lesson
 */
class LessonCreateService
{
    private Lesson $lesson;
    private Request $request;

    /**
     * LessonCreateService constructor.
     *
     * @param Lesson  $lesson
     * @param Request $request
     */
    public function __construct(Lesson $lesson, Request $request)
    {
        $this->lesson = $lesson;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->lesson->course_id = Arr::get($data, 'course_id');
        $this->lesson->name = Arr::get($data, 'name');
        $this->lesson->description = Arr::get($data, 'description');

        return $this->lesson->save() && (new TextsCreateService($this->lesson, $this->request))->run();
    }
}
