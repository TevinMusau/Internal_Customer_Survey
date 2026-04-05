<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SurveySchedule;

class CheckSurveyExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-survey-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command checks if the scheduled survey has expired yet. It checks the end date and time to make sure that when the end date and time reach, the survey is marked as inactive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        // check for any expired surveys
        $expired_surveys = SurveySchedule::where('end_date', '<=', $now->toDateString())
                            ->where('end_time', '<=', $now->toTimeString())
                            ->where('is_active', 1) // only close active surveys
                            ->get();

        foreach ($expired_surveys as $survey) {
            $survey->update(['is_active' => 0]);
            
            // any other logic here, e.g. notify admin
    }
    }
}
