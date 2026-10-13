<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Author Satu',
            'email' => 'author@mail.com',
            'password' => Hash::make('password'),
            'role' => 'author',
        ]);

        $categories = ['Teknologi', 'Pendidikan', 'Kesehatan', 'Olahraga', 'Hiburan'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }

        $author = User::where('role', 'author')->first();

        for ($i = 1; $i <= 10; $i++) {
            Post::create([
                'user_id' => $author->id,
                'category_id' => rand(1, 5),
                'title' => "Artikel Ke-$i",
                'slug' => "artikel-ke-$i-" . time() . "-$i",
                'body' => "Ini adalah isi artikel ke-$i. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                'status' => 'published',
            ]);
        }
    }
}