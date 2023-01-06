<?php

namespace Database\Seeders;

use App\Models\Admin\Cart\Order\Contact;
use App\Models\Admin\Cart\Order\Order;
use App\Models\Admin\Item\Item;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{

    /**
     * @return void
     * @throws Exception
     */
    public function run()
    {
        if (Order::count() != 0) {
            throw new Exception(Order::getTableName() . ' table is not empty. Stop all seeds!!!');
        }

        foreach (Contact::all() as $contact) {
            for ($i = 0; $i <= rand(3, 10); $i++) {
                Order::create([
                    'item_id' => Item::inRandomOrder()->first()->id,
                    'cnt' => rand(1, 5),
                    'contact_id' => $contact->id
                ]);
            }
        }
    }
}
