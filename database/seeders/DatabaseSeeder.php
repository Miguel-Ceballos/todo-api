<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();

        $categories = Category::factory(5)
            ->recycle($users)
            ->create();

        Task::factory(100)
            ->recycle($users)
            ->recycle($categories)
            ->create();
    }
}
