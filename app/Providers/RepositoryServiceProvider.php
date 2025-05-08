<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CourseGoalRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Nếu có interface thì bind interface → implementation
        $this->app->bind(CourseGoalRepository::class, function () {
            return new CourseGoalRepository();
        });
    }

    public function boot(): void
    {
        // Không cần gì thêm ở đây
    }
}
