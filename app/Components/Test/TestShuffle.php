<?php

namespace App\Components\Test;

use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;

/**
 * Class TestShuffle
 * @property Lesson  $lesson
 * @property Request $request
 * @package App\Components\Test
 */
class TestShuffle
{
    private Lesson $lesson;
    private Request $request;

    /**
     * TestShuffle constructor.
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
     * @return array
     */
    public function run()
    {
        $test = $this->lesson->getChecker()
            ->getFullTest($this->request->post('test_id'));

        shuffle($test['questions']);

        return $test;
    }
}
