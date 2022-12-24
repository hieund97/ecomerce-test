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
        'name', 'attribute_id'
    ];
    

    /**
     * Get the user that owns the Blogs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributes()
    {
        return $this->belongsTo(AttributeTypes::class, 'attribute_id', 'id');
    }

    protected $table = 'attribute_values';

}
