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


}


    public function boot(): void
    {
        // No additional boot logic needed
    }
}
