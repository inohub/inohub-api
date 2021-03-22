<?php

namespace App\Models\Startup;

use App\Interfaces\Base\OwnerInterface;
use App\Models\User\User;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Startup
 * @property           $id
 * @property           $owner_id
 * @property string    $name
 * @property           $text
 * @property-read User $owner
 * @package App\Models\Startup
 */
class Startup extends Model implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'text'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
