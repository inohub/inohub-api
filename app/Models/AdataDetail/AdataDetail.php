<?php

namespace App\Models\AdataDetail;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdataDetail extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'token',
        'checked_at'
    ];
}
