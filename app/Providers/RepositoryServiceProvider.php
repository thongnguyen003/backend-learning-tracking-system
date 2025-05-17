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
        // Bind CourseGoalRepositoryInterface to CourseGoalRepository
        $this->app->bind(CourseGoalRepositoryInterface::class, CourseGoalRepository::class);

        // Bind JournalGoalRepositoryInterface to JournalGoalRepository
        $this->app->bind(JournalGoalRepositoryInterface::class, JournalGoalRepository::class);
    }

    public function boot(): void
    {
        // No additional boot logic needed
    }
}
