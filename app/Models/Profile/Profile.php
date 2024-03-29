<?php

namespace App\Models\Profile;

use App\Models\BaseModel\BaseModel;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Profile
 * @property string    $first_name
 * @property string    $las_name
 * @property string    username
 * @property string    iin
 * @property-read User $user
 * @package App\Models\Profile
 */
class Profile extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'iin'
    ];

    protected $hidden = [
        'iin'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
