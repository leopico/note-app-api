<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Myo Thant Kyaw",
            'email' => "mtk@a.com",
            'password' => Hash::make('password')
        ]);
        User::create([
            'name' => "LKK",
            'email' => 'lkk@gmail.com',
            'password' => Hash::make('Maco@1992')
        ]);
        Category::create([
            'user_id' => 1,
            'name' => "course",
            'slug' =>  'course'
        ]);
        Category::create([
            'user_id' => 1,
            'name' => "marketing",
            'slug' =>  'marketing'
        ]);
        Category::create([
            'user_id' => 1,
            'name' => "articles",
            'slug' =>  'articles'
        ]);
        Note::create([
            "category_id" =>  1,
            "user_id" => 1,
            "slug" => "course",
            "title" => "Vue.js",
            "color" => "#dc3545",
            "description" => "More powerful in 2023"
        ]);
        Note::create([
            "category_id" =>  2,
            "user_id" => 1,
            "slug" => "marketing",
            "title" => "Facebook Advertising",
            "color" => "#34aadc",
            "description" => "The 5 Best Facebook Advertising Articles On The Web"
        ]);
        Note::create([
            "category_id" =>  3,
            "user_id" => 1,
            "slug" => "articles",
            "title" => "Football in 2023",
            "color" => "#34aadc",
            "description" => "Who is more attractive in 2023"
        ]);
    }
}
