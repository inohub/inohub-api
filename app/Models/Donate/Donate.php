<?php

namespace App\Models\Donate;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\Donate\Checker\DonateChecker;
use App\Models\Startup\Startup;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donate
 * @property      $id
 * @property      $owner_id
 * @property      $startup_id
 * @property      $amount
 * @property-read $owner
 * @property-read $startup
 * @package App\Models\Donate
 */
class Donate extends Model implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'startup_id',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class, 'startup_id');
    }

    /**
     * @return DonateChecker
     */
    public function getChecker()
    {
        return new DonateChecker($this);
    }
}
