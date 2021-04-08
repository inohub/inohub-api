<?php

namespace App\Models\Faq;

use App\Models\Startup\Startup;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Faq
 * @property      $startup_id
 * @property-read $startup
 * @property-read $text
 * @package App\Models\Faq
 */
class Faq extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'startup_id'
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'text'
    ];

    protected $relations = [
        'startup' => [
            'belongsTo',
            'startup_id',
        ],
        'text'    => [
            'morphOne',
            'target_class',
        ]
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function text()
    {
        return $this->morphOne(Text::class, 'textable', 'target_class', 'target_id');
    }
}
