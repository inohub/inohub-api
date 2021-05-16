<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class UserTestResultAnswerRule
 * @property        $testId
 * @property string $message
 * @package App\Rules
 */
class UserTestResultAnswerRule implements Rule
{
    private $testId;
    private string $message = "The validation error message.";

    /**
     * UserTestResultAnswerRule constructor.
     *
     * @param $testId
     */
    public function __construct($testId)
    {
        $this->testId = $testId;
    }

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_int($this->testId)) {
            $this->setMessage('The test id must be an integer.');

            return false;
        }

        foreach ($value as $key => $item) {

            $questionId = Arr::get($item, 'question_id');

            if (!is_int($questionId)) {
                $this->setMessage('The ' . $key . '.question_id must be an integer.');

                return false;
            }

            if (!$this->existsQuestionId($questionId)) {
                $this->setMessage('The selected ' . $key . '.question_id is invalid.');

                return false;
            }

            if (!is_null(Arr::get($item, 'answer_text'))) {

                $answerText = Arr::get($item, 'answer_text');

                if (!is_string($answerText)) {
                    $this->setMessage('The ' . $key . '.answer_text must be an string.');

                    return false;
                }

                if (!$this->validateAnswerText($answerText)) {
                    $this->setMessage('The selected ' . $key . '.answer_text is invalid.');

                    return false;
                }

                if ($this->hasAnswer($questionId)) {
                    $this->setMessage("This question " . $questionId . " doesn't have answer");

                    return false;
                }

            } elseif (!is_null(Arr::get($item, 'variant_id'))) {

                $variantId = Arr::get($item, 'variant_id');

                if (!is_int($variantId)) {
                    $this->setMessage('The ' . $key . '.variant_id must be an integer.');

                    return false;
                }

                if (!$this->existsVariantId($variantId, $questionId)) {
                    $this->setMessage('The selected ' . $key . '.variant id is invalid.');

                    return false;
                }

                if ($this->hasVariant($questionId)) {
                    $this->setMessage("This question " . $questionId . " doesn't have variant");

                    return false;
                }

            } else {
                $this->setMessage('Select ' . $key . '.variant_id or answer text.');

                return false;
            }
        }

        return true;
    }

    /**
     * @param string $answerText
     *
     * @return bool
     */
    private function validateAnswerText(string $answerText)
    {
        return strlen($answerText) <= 500;
    }

    /**
     * @param int $questionId
     *
     * @return bool
     */
    private function existsQuestionId(int $questionId)
    {
        return DB::table('questions')
            ->where('id', $questionId)
            ->where('test_id', $this->testId)
            ->exists();
    }

    /**
     * @param int $variantId
     * @param int $questionId
     *
     * @return bool
     */
    private function existsVariantId(int $variantId, int $questionId)
    {
        return DB::table('variants')
            ->where('id', $variantId)
            ->where('question_id', $questionId)
            ->exists();
    }

    /**
     * @param int $questionId
     *
     * @return bool
     */
    private function hasAnswer(int $questionId)
    {
        return !DB::table('questions')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->where('questions.id', $questionId)
            ->exists();
    }

    /**
     * @param int $questionId
     *
     * @return bool
     */
    private function hasVariant(int $questionId)
    {
        return !DB::table('questions')
            ->join('variants', 'questions.id', '=', 'variants.question_id')
            ->where('questions.id', $questionId)
            ->exists();
    }

    /**
     * @param string $message
     */
    private function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return $this->message;
    }
}
