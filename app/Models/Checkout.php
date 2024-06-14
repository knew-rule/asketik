<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(CheckoutItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
