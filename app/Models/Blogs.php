<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Blogs extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'detail', 'status', 'category_id', 'description'
    ];

    /**
     * Get the user that owns the Blogs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    /**
     * The tag that belong to the Blogs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'tag_pivot ', 'related_id', 'tag_id');
    }

    /**
     * Get all of the image for the Blogs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function image()
    {
        return $this->hasMany(ImageValues::class, 'related_id', 'id');
    }
}
