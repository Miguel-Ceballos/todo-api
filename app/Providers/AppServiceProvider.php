<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Task;
use App\Policies\CategoryPolicy;
use App\Policies\CategoryTaskPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Category::class, CategoryTaskPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
    }
}
