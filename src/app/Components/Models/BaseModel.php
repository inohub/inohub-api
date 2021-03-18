<?php

namespace App\Components\Models;

use App\Components\Interfaces\Arrayable;
use App\Helpers\DateFormatHelper;
use App\Traits\ArrayableTrait;
use App\Traits\ScopeTraits\ScopeOfId;
use App\Traits\ScopeTraits\ScopeOfNotId;
use App\Traits\ScopeTraits\ScopePaginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * Class BaseModel
 * @property $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Components\Models
 */
abstract class BaseModel extends Model implements Arrayable
{
    use ArrayableTrait, ScopePaginate, ScopeOfId, ScopeOfNotId;

    protected $casts = [
        'create_at'  => DateFormatHelper::CAST_DATE_FORMAT,
        'updated_at' => DateFormatHelper::CAST_DATE_FORMAT,
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getOriginAttribute($name)
    {
        return Arr::get($this->getAttributes(), $name);
    }
}
