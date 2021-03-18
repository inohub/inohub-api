<?php

namespace App\Models\Startup;

use App\Components\Interfaces\OwnerInterface;
use App\Components\Models\BaseModel;
use App\Models\User\User;
use App\Traits\ScopeTraits\ScopeOfOwner;
use App\Traits\User\OwnerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Startup
 * @property string $name
 * @property string $description
 * @property User   $owner
 * @package App\Models\Startup
 */
class Startup extends BaseModel implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'name',
        'description',
    ];
}
