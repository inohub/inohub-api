<?php

namespace App\Models\Test;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Answer
 * @property int           $question_id
 * @property string        $correct_text
 * @property-read Question $question
 * @package App\Models\Test
 */
class Answer extends BaseModel
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
