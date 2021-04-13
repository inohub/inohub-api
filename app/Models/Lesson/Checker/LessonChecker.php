<?php

namespace App\Models\Lesson\Checker;

use App\Models\Lesson\Lesson;

/**
 * Class LessonChecker
 * @property Lesson $lesson
 * @package App\Models\Lesson\Checker
 */
class LessonChecker
{
    private Lesson $lesson;

    /**
     * LessonChecker constructor.
     *
     * @param Lesson $lesson
     */
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * @param int $testId
     *
     * @return array
     */
    public function getFullTest(int $testId)
    {
        return $this->lesson->tests()->where('id', $testId)->with([
            'questions:id,test_id,text',
            'questions.answer:id,question_id',
            'questions.variants:id,question_id,text',
        ])->first()->toArray();
    }
}
