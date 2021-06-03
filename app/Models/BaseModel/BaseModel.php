<?php

namespace App\Models\BaseModel;

use App\Traits\ScopePaginate\ScopePaginate;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @property int $id
 * @property     $created_at
 * @property     $updated_at
 * @package App\Models\BaseModel
 */
class BaseModel extends Model
{
    use ScopePaginate;
}
