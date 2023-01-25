<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = ['watched','store_name','feedback'];


    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the store that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the Images that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductToImage::class);
    }

    public function scopeActive($query)
    {
        $query->where('status','Active');
    }

    public function getWatchedAttribute()
    {
        return ProductToWatch::where('product_id',$this->id)->count();
    }

    public function getStoreNameAttribute()
    {
        $store =  Store::where('id',$this->store_id)->select('name')->first();

        return $store ? $store->name : " ";
    }

    public function getFeedbackAttribute()
    {
        $feedback =  ProductToFeedback::where('product_id',$this->id)->first();

        return $feedback ? true : false;
    }

}
