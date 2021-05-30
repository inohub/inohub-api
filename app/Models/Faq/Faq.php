<?php

namespace App\Models\Faq;

use App\Models\Startup\Startup;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Faq
 * @property int          $startup_id
 * @property-read Startup $startup
 * @property-read Text    $text
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
