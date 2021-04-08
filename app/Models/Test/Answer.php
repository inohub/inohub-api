<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * @property      $question_id
 * @property      $correct_text
 * @property-read $question
 * @package App\Models\Test
 */
class Answer extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'question_id',
        'correct_text',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
