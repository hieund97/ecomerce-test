<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'status', 'type'
    ];

   /**
    * The product that belong to the Tag
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function product()
   {
       return $this->belongsToMany(Products::class, 'tag_pivot', 'tag_id', 'related_id');
   }

    protected $table = 'tags';

    /**
     * The blog that belong to the Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blog()
    {
        return $this->belongsToMany(Blogs::class, 'tag_pivot', 'tag_id', 'related_id');
    }
}
