<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CourseGoalRepositoryInterface;
use App\Repositories\CourseGoalRepository;
use App\Repositories\JournalGoalRepositoryInterface;
use App\Repositories\JournalGoalRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Nếu có interface thì bind interface → implementation
        $this->app->bind(CourseGoalRepository::class, function ($app) {
            return new CourseGoalRepository($app->make(\App\Models\CourseGoal::class));
        });
    }

    public function boot(): void
    {
        // No additional boot logic needed
    }
}
