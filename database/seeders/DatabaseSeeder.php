<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::create([
            'name' => 'Super Admin(Avishek Kumar Gupta)',
            'email' => 'admin@vetshop.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'address' => 'Birgunj-17 Parsa, Nepal',
            'phone' => '+977 9814295445',
            'status' => true,
        ]);
        
        User::create([
            'name' => 'Delivery Agent',
            'email' => 'delivery@vetshop.com',
            'password' => Hash::make('password'),
            'role' => 'delivery_agent',
            'address' => 'Birgunj-17 Parsa, Nepal',
            'phone' => '+977 9815230018',
            'status' => true,
        ]);
        
        User::create([
            'name' => 'Inventory Manager',
            'email' => 'inventory@vetshop.com',
            'password' => Hash::make('password'),
            'role' => 'inventory_manager',
            'address' => 'Birgunj-17 Parsa, Nepal',
            'phone' => '+977 9815230018',   
            'status' => true,
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@vetshop.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'address' => '123 Vet Street, Pet City',
            'status' => true,
        ]);

        // Team Members
        TeamMember::create([
            'name' => 'Dr. Rajesh Pandey',
            'designation' => 'Senior Veterinarian',
            'description' => 'Dr. Rajesh has over 15 years of experience in veterinary medicine, specializing in small animal care and surgery. He is passionate about animal welfare and preventative care.',
            'photo' => 'images/team/1766689460_dog.jpg',
            'facebook_url' => 'https://facebook.com',
            'twitter_url' => 'https://twitter.com',
            'display_order' => 1,
            'is_active' => true,
        ]);

        TeamMember::create([
            'name' => 'Sita Sharma',
            'designation' => 'Pet Nutritionist',
            'description' => 'Sita helps pet owners understand the dietary needs of their furry friends. With a certification in Animal Nutrition, she formulates custom diet plans.',
            'photo' => 'images/team/1766689460_dog.jpg',
            'instagram_url' => 'https://instagram.com',
            'tiktok_url' => 'https://tiktok.com',
            'display_order' => 2,
            'is_active' => true,
        ]);
        
        TeamMember::create([
            'name' => 'Amit Verma',
            'designation' => 'Grooming Expert',
            'description' => 'Amit is a certified pet groomer who makes sure your pets look their best. He handles animals with gentle care and patience.',
            'photo' => 'images/team/1766689460_dog.jpg',
            'facebook_url' => 'https://facebook.com',
            'display_order' => 3,
            'is_active' => true,
        ]);

        // Categories
        $categories = Category::factory(5)->create();

        // Products
        foreach ($categories as $category) {
            Product::factory(5)->create([
                'category_id' => $category->id
            ]);
        } 

        // Pages
        $this->call(PageSeeder::class);
    }
}
