<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductToBid extends Model
{
   protected $hidden = ['created_at', 'updated_at','deleted_at'];
   protected $guarded = [];

   protected $appends = ['user'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUserAttribute()
    {
        if(Auth::user()->type == "Seller"){

            $user =  User::where('id',$this->user_id)->select('name','username','image','url')->first();

            return $user ? $user : " ";
        }
    }
}
