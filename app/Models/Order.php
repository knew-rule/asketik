<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items() // Changed method name from orderItems to items
    {
        return $this->hasMany(OrderItem::class); // Corrected relationship method name
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

