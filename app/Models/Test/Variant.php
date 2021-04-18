<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Variant
 * @property      $question_id
 * @property      $text
 * @property      $is_correct
 * @property-read $question
 * @package App\Models\Test
 */
class Variant extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
