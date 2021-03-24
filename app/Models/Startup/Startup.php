<?php

namespace App\Models\Startup;

use App\Interfaces\Base\OwnerInterface;
use App\Models\User\User;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use App\Traits\SetWithRelations\SetWithRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Startup
 * @property           $id
 * @property           $owner_id
 * @property string    $name
 * @property           $description
 * @property-read User $owner
 * @package App\Models\Startup
 */
class Startup extends Model implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner, SetWithRelations;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'name',
        'description'
    ];
}
