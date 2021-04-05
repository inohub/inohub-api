<?php

namespace App\Models\Text;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Text
 * @property $title
 * @property $content
 * @property $target_class
 * @property $target_id
 * @package App\Models\Text
 */
class Text extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content',
        'target_class',
        'target_id',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'target_class',
        'target_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function textable()
    {
        return $this->morphTo(
            null,
            'target_class',
            'target_id',
            'id',
        );
    }
}
