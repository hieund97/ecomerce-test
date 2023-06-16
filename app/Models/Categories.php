<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Blogs;

class Categories extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'parent_id', 'status', 'type'
    ];

    /**
     * Get all of the comments for the Categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs()
    {
        return $this->hasMany(Blogs::class, 'category_id', 'id');
    }

    /**
     * The products that belong to the Categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_category_pivot', 'category_id', 'product_id');
    }
    
    /**
     * Get the image associated with the Categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne(ImageValues::class, 'related_id', 'id');
    }
}
