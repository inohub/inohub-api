<?php

namespace App\Models\Faq;

use App\Models\Startup\Startup;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
      'startup_id'
    ];

    protected $with = [
      'text'
    ];

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }

    public function text()
    {
        return $this->morphOne(Text::class,'textable','target_class', 'target_id');
    }
}
