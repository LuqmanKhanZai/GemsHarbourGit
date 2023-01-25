<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];

    /**
     * Get all of the product for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasMany(Product::class)->where('status','Active');
    }

    public function random_product()
    {
        return $this->hasMany(Product::class)->where('status','Active');
        // return $this->hasMany(Product::class)->where('status','Active')->inRandomOrder()->limit(4);
    }

    public function scopeActive($query)
    {
        $query->where('status','Active');
    }
}
