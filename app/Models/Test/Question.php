<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * @property      $test_id
 * @property      $text
 * @property-read $test
 * @property-read $answer
 * @property-read $variants
 * @package App\Models\Test
 */
class Question extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'test_id',
        'text',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function answer()
    {
        return $this->hasOne(Answer::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class, 'question_id');
    }
}
