<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Models\Category
 * @property $title
 * @property $description
 * @property $parent_id
 * @property-read $parent
 */
class Category extends Model
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

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
