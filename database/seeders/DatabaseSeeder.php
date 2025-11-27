<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@nexstack.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample categories
        $category1 = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories',
        ]);

        $category2 = Category::create([
            'name' => 'Office Supplies',
            'description' => 'Office equipment and supplies',
        ]);

        // Create sample suppliers
        Supplier::create([
            'company_name' => 'Tech Supplies Inc.',
            'contact_person' => 'John Smith',
            'email' => 'contact@techsupplies.com',
            'phone' => '123-456-7890',
            'address' => '123 Tech Street, City, Country',
        ]);

        // Create sample products
        Product::create([
            'name' => 'Laptop',
            'category_id' => $category1->id,
            'description' => 'High-performance laptop',
            'price' => 999.99,
            'quantity' => 10,
            'status' => 'active',
        ]);

        Product::create([
            'name' => 'Office Chair',
            'category_id' => $category2->id,
            'description' => 'Comfortable office chair',
            'price' => 199.99,
            'quantity' => 25,
            'status' => 'active',
        ]);
    }
}

