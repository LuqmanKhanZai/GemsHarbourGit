<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'p_text',
    //     'contact',
    //     'cnic',
    //     'address',
    //     'salary',
    //     'image',
    //     'url',
    //     'designation',
    //     'education',
    //     'dob',
    //     'experience',
    //     'start_date',
    //     'end_date',
    //     'type',
    //     'status',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the Attendance for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */


    public function scopeAdmin($query)
    {
        $balance = $query->where('type','Admin');
    }

    public function scopeBuyer($query)
    {
        $balance = $query->where('type','Buyer');
    }

    public function scopeSeller($query)
    {
        $balance = $query->where('type','Seller');
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function card()
    {
        return $this->hasOne(UserToCard::class);
    }

    public function saleproduct()
    {
        return $this->hasMany(OrderSub::class);
    }
    
    // public function feedback()
    // {
    //      return $this->hasMany(ProductToFeedback::class);
    // }



}
