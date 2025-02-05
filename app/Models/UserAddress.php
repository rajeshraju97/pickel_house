<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //

    protected $fillable = [
        "user_id",
        "label",
        "address_line_1",
        "address_line_2",
        "city",
        "pincode",

    ];
}
