<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    //

    use HasFactory;
    protected $fillable = [
        'dish_id',
        'user_id',
        'status',
        'total_amount',
        'applied_coupon_id',
        'discount_amount',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function user_address()
    {
        return $this->belongsTo(UserAddress::class, 'user_id');
    }
}
