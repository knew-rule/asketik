<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutItem extends Model
{
    protected $guarded = ['id'];

    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    public function coffee()
    {
        return $this->belongsTo(Coffee::class);
    }
}
