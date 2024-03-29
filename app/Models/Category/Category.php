<?php

namespace App\Models\Category;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Category
 * @property string          $title
 * @property string          $description
 * @property int             $parent_id
 * @property-read Category   $parent
 * @property-read Collection $children
 * @package App\Models\Category
 */
class Category extends BaseModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'parent_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
