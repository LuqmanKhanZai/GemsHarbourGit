<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockBider extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['user'];

    public function getUserAttribute()
    {
        $user =  User::where('id',$this->buyer_id)->select('name','username','image','url')->first();

        return $user ? $user : " ";
    }
}
