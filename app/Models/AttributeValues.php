<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeTypes;

class AttributeValues extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'attribute_id', 'color_id'
    ];
    
    /**
     * Get the user that owns the Blogs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributesType()
    {
        return $this->belongsTo(AttributeTypes::class, 'attribute_id', 'id');
    }

    /**
     * The product  that belong to the AttributeValues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product()
    {
        return $this->belongsToMany(Products::class, 'product_value_pivot', 'value_id', 'product_id');
    }

    /**
     * The variants that belong to the AttributeValues
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'variant_value_pivot', 'value_id', 'variant_id');
    }

    public function scopeGetVariant($variants, $aryID = [])
    {
        return $variants->join('variant_value_pivot', 'attribute_values.id', 'variant_value_pivot.value_id')->where(function($q) use($aryID){
            $q->where('variant_value_pivot.value_id', $aryID['color'])->where('variant_value_pivot.value_id', $aryID['size']);
        });
    }

    protected $table = 'attribute_values';

}
