<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValues;

class Products extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'sku', 'status', 'is_new', 'price', 'is_sale', 'highlight', 'quantity', 'additional_information', 'description', 'related_product_id', 'image'
    ];

    /**
     * Get all of the comments for the Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'product_category_pivot', 'product_id', 'category_id');
    }

    /**
     * Get all of the attribute_value for the Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attribute_value()
    {
        return $this->belongsToMany(AttributeValues::class, 'product_value_pivot', 'product_id', 'value_id');
    }

    /**
     * Get all of the variants for the Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }

    /**
     * Get all of the image_value for the Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function image()
    {
        return $this->hasMany(ImageValues::class, 'related_id', 'id');
    }

    /**
     * The tag that belong to the Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'tag_pivot', 'related_id', 'tag_id');
    }
}
