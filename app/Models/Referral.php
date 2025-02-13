<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    //
    protected $fillable = [
        'referrer_id ',
        'referred_id',
        'referral_code',
    ];


    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

}
