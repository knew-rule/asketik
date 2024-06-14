<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cart::create([
            'user_id' => 2,
            'coffee_id' => 1,
            'quantity' => 2
        ]);

        
        Cart::create([
            'user_id' => 2,
            'coffee_id' => 2,
            'quantity' => 2
        ]);

        Cart::create([
            'user_id' => 2,
            'coffee_id' => 3,
            'quantity' => 4
        ]);

        Cart::create([
            'user_id' => 2,
            'coffee_id' => 4,
            'quantity' => 4
        ]);
        
        Cart::create([
            'user_id' => 2,
            'coffee_id' => 5,
            'quantity' => 2
        ]);
        
        Cart::create([
            'user_id' => 2,
            'coffee_id' => 6,
            'quantity' => 2
        ]);

        Cart::create([
            'user_id' => 2,
            'coffee_id' => 7,
            'quantity' => 4
        ]);
    }
}
