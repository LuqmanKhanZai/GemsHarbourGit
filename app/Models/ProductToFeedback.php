<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductToFeedback extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['user'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function getUserAttribute()
    {
        $user =  User::where('id',$this->user_id)->select('name','username','image','url')->first();

        return $user ? $user : " ";
    }
}
