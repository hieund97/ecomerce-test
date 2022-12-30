<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValues;

class AttributeTypes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
    ];

    /**
     * Get all of the attributesType for the AttributeTypes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributesValue()
    {
        return $this->hasMany(AttributeValues::class, 'attribute_id', 'id');
    }

    protected $table = 'attributes';

};