<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Coffee;
use App\Models\User;
use App\Models\Coupon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => 'user12345',
            'usertype' => 'customer',
        ]);


        User::factory()->create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => 'customer12345',
            'usertype' => 'customer',
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin12345',
            'usertype' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => 'superadmin12345',
            'usertype' => 'superadmin',
        ]);

        $coffees = [
            // Milk Coffee
            ['name' => 'Signature', 'price' => 14000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/signature_baru.jpg'],
            ['name' => 'Latte', 'price' => 15000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/latte_baru.jpg'],
            ['name' => 'Tiramisu', 'price' => 15000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/tiramisu_baru.jpg'],
            ['name' => 'Caramel', 'price' => 15000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/caramel_baru.jpg'],
            ['name' => 'Vanilla', 'price' => 15000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/vanila_baru.jpg'],
            ['name' => 'Mocha', 'price' => 17000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/mocha_baru.jpg'],
            ['name' => 'Regal', 'price' => 17000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/Cookies_N_Cream_baru.jpg'],
            ['name' => 'Cookie', 'price' => 17000, 'category' => 'Milk Coffee', 'image' => 'menu/milk_coffee/cookie_milk_coffee.jpg'],
        
            // Manual Brew
            ['name' => 'Espresso', 'price' => 10000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/expresso_baru.jpg'],
            ['name' => 'Americano', 'price' => 10000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/americano_baru.jpg'],
            ['name' => 'Longblack', 'price' => 10000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/longblack_baru.jpg'],
            ['name' => 'Tubruk', 'price' => 10000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/kopi_tubruk_baru.jpg'],
            ['name' => 'Vietnam Drip', 'price' => 12000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/vietnam_drip_baru.jpg'],
            ['name' => 'Sanger', 'price' => 13000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/sanger_baru.jpg'],
            ['name' => 'V60/Filter', 'price' => 15000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/v60_baru.jpg'],
            ['name' => 'Japanesse Filter', 'price' => 15000, 'category' => 'Manual Brew', 'image' => 'menu/manual_brew/japanese_filter_baru.jpg'],

            // Non Coffee
            ['name' => 'Chocolate', 'price' => 13000, 'category' => 'Non Coffee', 'image' => 'menu/non_coffee/chocolate.jpg'],
            ['name' => 'Matcha', 'price' => 13000, 'category' => 'Non Coffee', 'image' => 'menu/non_coffee/matcha_baru.jpg'],
            ['name' => 'Redvelvet', 'price' => 13000, 'category' => 'Non Coffee', 'image' => 'menu/non_coffee/red_velvet_baru.jpg'],
            ['name' => 'Taro', 'price' => 13000, 'category' => 'Non Coffee', 'image' => 'menu/non_coffee/taro_coffe.jpg'],
            ['name' => 'Regal', 'price' => 15000, 'category' => 'Non Coffee', 'image' => 'menu/non_coffee/regal_baru.jpg'],
            ['name' => 'Cookie', 'price' => 15000, 'category' => 'Non Coffee', 'image' => 'menu/non_coffee/cookie_milk_non_coffie.jpg'],

            // Sparkling
            ['name' => 'Espresso Tonic', 'price' => 10000, 'category' => 'Sparkling', 'image' => 'menu/sparkling/espresso_tonic_baru.jpg'],
            ['name' => 'Blue Ocean', 'price' => 13000, 'category' => 'Sparkling', 'image' => 'menu/sparkling/ocean_blue_baru.jpg'],
            ['name' => 'Gummie Mint', 'price' => 15000, 'category' => 'Sparkling', 'image' => 'menu/sparkling/gummie_mint_baru.jpg'],

            // Foods
            ['name' => 'Mie Goreng', 'price' => 8000, 'category' => 'Foods', 'image' => 'menu/foods/mie_goreng_baru.jpg'],
            ['name' => 'Mie Rebus', 'price' => 8000, 'category' => 'Foods', 'image' => 'menu/foods/mie_rebus_baru.jpg'],
            ['name' => 'Nasgor Ori', 'price' => 12000, 'category' => 'Foods', 'image' => 'menu/foods/nasi_goreng_baru.jpg'],
            ['name' => 'Nasgor Ebi', 'price' => 12000, 'category' => 'Foods', 'image' => 'menu/foods/nasi_goreng_ebi_baru.jpg'],
            ['name' => 'Mie Jebew', 'price' => 15000, 'category' => 'Foods', 'image' => 'menu/foods/mie_jebew_baru.jpg'],
            ['name' => 'Seblak', 'price' => 15000, 'category' => 'Foods', 'image' => 'menu/foods/seblak_baru.jpg'],
            ['name' => 'MieNas', 'price' => 16000, 'category' => 'Foods', 'image' => 'menu/foods/mie_nas.jpg'],
        
             // Snacks
            ['name' => 'Sosis Solo', 'price' => 10000, 'category' => 'Snacks', 'image' => 'menu/snacks/sosis_solo_baru.jpg'],
            ['name' => 'Lumpia', 'price' => 10000, 'category' => 'Snacks', 'image' => 'menu/snacks/lumpia_baru.jpg'],
            ['name' => 'Kentang', 'price' => 10000, 'category' => 'Snacks', 'image' => 'menu/snacks/kentang_baru.jpg'],
            ['name' => 'Nugget', 'price' => 12000, 'category' => 'Snacks', 'image' => 'menu/snacks/nugget_baru.jpg'],

        ];

        foreach ($coffees as $coffeeData) {
            Coffee::factory()->create([
                'name' => $coffeeData['name'],
                'price' => $coffeeData['price'],
                'category' => $coffeeData['category'],
                'image' => $coffeeData['image'],
            ]);
        }

        Coupon::create([
            'code' => 'SAVE10',
            'type' => 'percentage',
            'value' => 10,
            'max_uses' => 100,
            'expiry_date' => Carbon::now()->addMonths(6), // Expires in 6 months
        ]);

        Coupon::create([
            'code' => 'GET20OFF',
            'type' => 'fixed_amount',
            'value' => 20,
            'max_uses' => 50,
            'expiry_date' => Carbon::now()->addYear(), // Expires in 1 year
        ]);

        //Coffee::factory()->count(10)->create();
    }
}
