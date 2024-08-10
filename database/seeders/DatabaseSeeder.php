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
        $users = User::factory(5)->create();

        $categories = Category::factory(20)
            ->recycle($users)
            ->create();

//        Task::factory(200)
//            ->recycle($users)
//            ->recycle($categories)
//            ->create();

        for ( $i = 0; $i < 30; $i++ ) {
            for ($j = 0; $j < 20; $j++ ) {
                for ($k = 0; $k < 5; $k++ ) {
                    if ( $categories[$j]['user_id'] === $users[$k]['id'] ) {
                        Task::factory()
                            ->recycle($users[$k])
                            ->recycle($categories[$j])
                            ->create();
                    }
                }
            }
        }
    }
}
