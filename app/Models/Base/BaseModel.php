<?php

namespace App\Models\Base;

use App\Traits\SetWithRelations\SetWithRelations;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @property $id
 * @property $created_at
 * @property $updated_at
 * @package App\Models\Base
 */
class BaseModel extends Model
{
    use SetWithRelations;
}
