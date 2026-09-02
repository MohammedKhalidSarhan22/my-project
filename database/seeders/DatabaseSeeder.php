<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Restaurant Manager',
            'email' => 'manager@restaurant.local',
        ]);

        $categories = [
            ['name' => 'Starters', 'slug' => 'starters', 'description' => 'Light and shareable dishes.'],
            ['name' => 'Main Course', 'slug' => 'main-course', 'description' => 'Signature chef specials and mains.'],
            ['name' => 'Desserts', 'slug' => 'desserts', 'description' => 'Sweet finishes for every meal.'],
            ['name' => 'Beverages', 'slug' => 'beverages', 'description' => 'Fresh drinks and coffee.'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData + ['is_active' => true]);
        }

        $starterCategory = Category::where('slug', 'starters')->first();
        $mainCategory = Category::where('slug', 'main-course')->first();
        $dessertCategory = Category::where('slug', 'desserts')->first();
        $beverageCategory = Category::where('slug', 'beverages')->first();

        $menuItems = [
            ['category_id' => $starterCategory->id, 'name' => 'Crispy Calamari', 'slug' => 'crispy-calamari', 'description' => 'Golden fried squid with lemon aioli.', 'price' => 12.50, 'cost_price' => 5.00, 'stock_quantity' => 25, 'is_available' => true],
            ['category_id' => $starterCategory->id, 'name' => 'Garden Salad', 'slug' => 'garden-salad', 'description' => 'Mixed greens with herbs and vinaigrette.', 'price' => 9.00, 'cost_price' => 3.50, 'stock_quantity' => 30, 'is_available' => true],
            ['category_id' => $mainCategory->id, 'name' => 'Grilled Salmon', 'slug' => 'grilled-salmon', 'description' => 'Atlantic salmon served with herbs and potatoes.', 'price' => 24.00, 'cost_price' => 11.00, 'stock_quantity' => 18, 'is_available' => true],
            ['category_id' => $mainCategory->id, 'name' => 'Beef Burger', 'slug' => 'beef-burger', 'description' => 'Double patty with cheddar, tomato, and fries.', 'price' => 18.50, 'cost_price' => 8.50, 'stock_quantity' => 20, 'is_available' => true],
            ['category_id' => $mainCategory->id, 'name' => 'Chicken Alfredo Pasta', 'slug' => 'chicken-alfredo-pasta', 'description' => 'Creamy pasta topped with grilled chicken.', 'price' => 21.00, 'cost_price' => 9.50, 'stock_quantity' => 16, 'is_available' => true],
            ['category_id' => $dessertCategory->id, 'name' => 'Chocolate Lava Cake', 'slug' => 'chocolate-lava-cake', 'description' => 'Warm chocolate dessert with vanilla cream.', 'price' => 8.50, 'cost_price' => 3.00, 'stock_quantity' => 22, 'is_available' => true],
            ['category_id' => $beverageCategory->id, 'name' => 'Fresh Lemonade', 'slug' => 'fresh-lemonade', 'description' => 'Sparkling house-made lemonade.', 'price' => 4.50, 'cost_price' => 1.20, 'stock_quantity' => 40, 'is_available' => true],
            ['category_id' => $beverageCategory->id, 'name' => 'Espresso', 'slug' => 'espresso', 'description' => 'Bold double-shot coffee.', 'price' => 3.50, 'cost_price' => 1.00, 'stock_quantity' => 50, 'is_available' => true],
        ];

        foreach ($menuItems as $itemData) {
            MenuItem::create($itemData);
        }

        $tables = [
            ['name' => 'Table 1', 'capacity' => 2, 'status' => 'occupied', 'location' => 'Window', 'notes' => 'Guest with kids'],
            ['name' => 'Table 2', 'capacity' => 4, 'status' => 'available', 'location' => 'Main Hall', 'notes' => null],
            ['name' => 'Table 3', 'capacity' => 2, 'status' => 'reserved', 'location' => 'Patio', 'notes' => 'Reservation at 7:30 PM'],
            ['name' => 'Table 4', 'capacity' => 6, 'status' => 'occupied', 'location' => 'Private Room', 'notes' => 'Birthday party'],
            ['name' => 'Table 5', 'capacity' => 4, 'status' => 'available', 'location' => 'Main Hall', 'notes' => null],
        ];

        foreach ($tables as $tableData) {
            Table::create($tableData);
        }

        $table1 = Table::where('name', 'Table 1')->first();
        $table4 = Table::where('name', 'Table 4')->first();
        $table5 = Table::where('name', 'Table 5')->first();

        $orderData = [
            [
                'table_id' => $table1->id,
                'customer_name' => 'Sarah Lee',
                'status' => 'in_progress',
                'notes' => 'No onions on the burger.',
                'items' => [
                    ['menu_item_id' => MenuItem::where('slug', 'grilled-salmon')->first()->id, 'quantity' => 2],
                    ['menu_item_id' => MenuItem::where('slug', 'fresh-lemonade')->first()->id, 'quantity' => 2],
                ],
            ],
            [
                'table_id' => $table4->id,
                'customer_name' => 'Wilson Group',
                'status' => 'ready',
                'notes' => 'Extra napkins needed.',
                'items' => [
                    ['menu_item_id' => MenuItem::where('slug', 'chicken-alfredo-pasta')->first()->id, 'quantity' => 3],
                    ['menu_item_id' => MenuItem::where('slug', 'chocolate-lava-cake')->first()->id, 'quantity' => 3],
                ],
            ],
            [
                'table_id' => $table5->id,
                'customer_name' => 'Ari Johnson',
                'status' => 'served',
                'notes' => null,
                'items' => [
                    ['menu_item_id' => MenuItem::where('slug', 'beef-burger')->first()->id, 'quantity' => 1],
                    ['menu_item_id' => MenuItem::where('slug', 'espresso')->first()->id, 'quantity' => 1],
                ],
            ],
        ];

        foreach ($orderData as $data) {
            $order = Order::create([
                'table_id' => $data['table_id'],
                'customer_name' => $data['customer_name'],
                'status' => $data['status'],
                'notes' => $data['notes'],
                'total_amount' => 0,
                'paid_amount' => 0,
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $menuItem = MenuItem::findOrFail($item['menu_item_id']);
                $quantity = (int) $item['quantity'];
                $total += $quantity * (float) $menuItem->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'unit_price' => $menuItem->price,
                    'notes' => 'Prepared by kitchen',
                ]);
            }

            $order->update([
                'total_amount' => $total,
                'paid_amount' => $total,
            ]);
        }
    }
}
