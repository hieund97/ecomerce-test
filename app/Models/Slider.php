<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'description', 'status', 'image', 'type_slider', 'related_id'
    ];

    /**
     * Get all of the image for the Slider
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function image()
    {
        return $this->hasMany(ImageValues::class, 'related_id', 'id');
    }

    protected $table = 'slider';
}
