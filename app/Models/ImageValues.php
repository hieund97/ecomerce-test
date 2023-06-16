<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageValues extends Model
{
    use HasFactory;

    /**
     * The image that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'related_id', 'is_primary', 'image_type'
    ];

    protected $table = 'image_value';

    /**
     * Get the product that owns the ImageValues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'related_id', 'id');
    }

    /**
     * Get the slider that owns the ImageValues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function slider()
    {
        return $this->belongsTo(Slider::class, 'related_id', 'id');
    }

    /**
     * Get the category that owns the ImageValues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'related_id', 'id');
    }
}
