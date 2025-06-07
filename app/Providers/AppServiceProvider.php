<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema; 
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
    public function boot(): void{
        if (!Schema::hasTable('courses') || !Schema::hasTable('journal_times')) {
        Log::warning('Một hoặc nhiều bảng cần thiết không tồn tại. Dừng thực thi logic trong boot().');
        return;
    }
        $today = Carbon::now()->toDateString();
        $records = DB::table('courses')->where('next_date', '<=', $today)->where('status',1)->get();
        foreach ($records as $record) {
            $currentDate = Carbon::parse($record->next_date);
            $loopCounter = 0;
            $maxLoops = 1000;
            while ($currentDate->lte($today)&& $loopCounter < $maxLoops) {
                $numberOfProcess = $record->type_process == "1week" ? 1 : ($record->type_process == "2week" ? 2 : ($record->type_process == "3week" ? 3 : ($record->type_process == "4week" ? 4 : 1)) );
                $start_date = $currentDate->copy();
                $end_date = $start_date->copy()->startOfWeek(Carbon::SUNDAY)->addWeeks($numberOfProcess);
                $next_date = $end_date->copy()->addDay();
                $status = Carbon::parse($today)->between($start_date, $end_date) ? 1 : 0;
                Log::info('Process Information', [
                'start_date' => $start_date->toDateString(),
                'end_date' => $end_date->toDateString(),
                'next_date' => $next_date->toDateString(),
                'number_of_process' => $numberOfProcess,
                'status' => $status,
            ]);
                $exists = DB::table('journal_times')
                ->where('course_id', $record->id)
                ->where('start_date', $start_date->toDateString())
                ->where('end_date', $end_date->toDateString())
                ->exists();
                if (!$exists) {
                    DB::table('journal_times')->insert([
                    'course_id' => $record->id,
                    'start_date' => $start_date->toDateString(),
                    'end_date' => $end_date->toDateString(),
                    'deadline'=> $record->next_deadline,
                    'accept_deadline'=> $record->accept_deadline,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                }

                
                DB::table('courses')
                    ->where('id', $record->id)
                    ->update(['next_date' => $next_date->toDateString()]);
                $currentDate = $next_date->copy();
                $loopCounter++;
            }
        }
        $journalTimes = DB::table('journal_times')->where('status', 1)->get();
        DB::table('journal_times')
        ->where('status', 1)
        ->where(function($query) use ($today) {
            $query->whereDate('start_date', '>', $today)
                ->orWhereDate('end_date', '<', $today);
        })
        ->update(['status' => 0]);
    }
}
