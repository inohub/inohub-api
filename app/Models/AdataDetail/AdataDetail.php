<?php

namespace App\Models\AdataDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdataDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'token',
        'checked_at'
    ];
}
