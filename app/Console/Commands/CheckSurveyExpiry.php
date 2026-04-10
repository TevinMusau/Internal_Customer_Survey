<?php

namespace App\Console\Commands;

use App\Models\Supervisor_Survey_Result;
use Illuminate\Console\Command;
use App\Models\SurveySchedule;
use App\Models\Staff_Survey_Result;
use App\Models\Managing_Partner_Survey_Result;
use App\Models\User;
use App\Models\Department;
use App\Models\Final_Rating;



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
    public function handle() {

        $now = now();

        // check for any expired survey
        $expired_survey = SurveySchedule::where('end_date', '<=', $now->toDateString())
                            ->where('end_time', '<=', $now->toTimeString())
                            ->where('is_active', 1) // only close active surveys
                            ->first();

        if ($expired_survey) {

            // any other logic here, e.g. notify admin

            $expired_survey->update(['is_active' => 0]);

// --------------------------------- CALCULATION OF FINAL RATINGS -----------------------------------------

            $managing_partner_final_rating = $this->calculateManagingPartnerFinalRatings(); // returns float

            $supervisors_final_rating = $this->calculateSupervisorFinalRatings(); // returns associative array

            $staff_final_ratings = $this->calculateStaffFinalRatings(); // returns associative array

            $department_final_ratings = $this->calculateDepartmentFinalRatings(); // returns associative array

            // saving managing partner final rating
            Final_Rating::create([
                'managing_partner_id' => User::where('isManagingPartner', 1)->first()->id,
                'survey_schedule_id'  => $expired_survey->id,
                'final_rating'        => $managing_partner_final_rating,
                'date_calculated'     => today(),
            ]);

            // saving each supervisor's final rating
            foreach ($supervisors_final_rating as $supervisor_id => $rating) {
                Final_Rating::create([
                    'supervisor_id'      => $supervisor_id,
                    'survey_schedule_id' => $expired_survey->id,
                    'final_rating'       => $rating,
                    'date_calculated'    => today(),
                ]);
            }

            // save each user's final ratings
            foreach ($staff_final_ratings as $user_id => $rating) {
                Final_Rating::create([
                    'user_id'            => $user_id,
                    'survey_schedule_id' => $expired_survey->id,
                    'final_rating'       => $rating,
                    'date_calculated'    => today(),
                ]);
            }

            // save department ratings
            foreach ($department_final_ratings as $department_id => $rating) {
                Final_Rating::create([
                    'department_id'      => $department_id,
                    'survey_schedule_id' => $expired_survey->id,
                    'final_rating'       => $rating,
                    'date_calculated'    => today(),
                ]);
            }
        }     
    }

    public function calculateManagingPartnerFinalRatings(){
        
        // pre-set the grade counters
        $grade1 = $grade2 = $grade3 = $grade4 = $grade5 = 0;

        // get the Managing Partner
        $managing_partner = User::where('isManagingPartner', 1)->first();

        // get results of managing partner survey for the managing partner
        $managing_partner_survey_results = Managing_Partner_Survey_Result::where('user_id', $managing_partner->id)->get();

        // count the total number of ratings for each grade
        foreach ($managing_partner_survey_results as $result){
            $grade1 = $grade1 + $result->grading_1_count;
            $grade2 = $grade2 + $result->grading_2_count;
            $grade3 = $grade3 + $result->grading_3_count;
            $grade4 = $grade4 + $result->grading_4_count;
            $grade5 = $grade5 + $result->grading_5_count;
        }

        // calculating the weighted sum
        $weighted_sum = ($grade1 * 1) + ($grade2 * 2) + ($grade3 * 3) + ($grade4 * 4) + ($grade5 * 5);

        // sum up all the total gradings
        $total_ratings = $grade1 + $grade2 + $grade3 + $grade4 + $grade5;

        // calculate final rating in two decimal places
        $managing_partner_final_rating = round(($weighted_sum / $total_ratings), 2);

        return $managing_partner_final_rating;
    }

    public function calculateSupervisorFinalRatings(){
        
        // get all supervisors
        $supervisors = User::where('isSupervisor', 1)->get();

        // for storing each supervisor's final rating
        $supervisor_final_rating = [];

        // calculate the rating per supervisor
        foreach ($supervisors as $supervisor) {

            $grade1 = $grade2 = $grade3 = $grade4 = $grade5 = 0;
            
            // get results of supervisor survey for each supervisor
            $supervisor_survey_results = Supervisor_Survey_Result::where('user_id', $supervisor->id)->get();

            // count the total number of ratings for each grade
            foreach ($supervisor_survey_results as $result){
                $grade1 = $grade1 + $result->grading_1_count;
                $grade2 = $grade2 + $result->grading_2_count;
                $grade3 = $grade3 + $result->grading_3_count;
                $grade4 = $grade4 + $result->grading_4_count;
                $grade5 = $grade5 + $result->grading_5_count;
            }
            
            // calculating the weighted sum
            $weighted_sum = ($grade1 * 1) + ($grade2 * 2) + ($grade3 * 3) + ($grade4 * 4) + ($grade5 * 5);

            // sum up all the total gradings
            $total_ratings = $grade1 + $grade2 + $grade3 + $grade4 + $grade5;

            // calculate final rating and append to array
            $supervisor_final_rating[$supervisor->id] = $total_ratings > 0 ? round($weighted_sum / $total_ratings, 2) : 0;
        }

        return $supervisor_final_rating;
    }

    public function calculateStaffFinalRatings(){

        // get all users
        $users = User::all();

        // for storing each user's's final rating
        $user_final_rating = [];

        foreach ($users as $user) {

            $grade1 = $grade2 = $grade3 = $grade4 = $grade5 = 0;

            $user_result = Staff_Survey_Result::where('user_id', $user->id)->get();

            // count the total number of ratings for each grade
            foreach ($user_result as $result){
                $grade1 = $grade1 + $result->grading_1_count;
                $grade2 = $grade2 + $result->grading_2_count;
                $grade3 = $grade3 + $result->grading_3_count;
                $grade4 = $grade4 + $result->grading_4_count;
                $grade5 = $grade5 + $result->grading_5_count;
            }
            
            // calculating the weighted sum
            $weighted_sum = ($grade1 * 1) + ($grade2 * 2) + ($grade3 * 3) + ($grade4 * 4) + ($grade5 * 5);

            // sum up all the total gradings
            $total_ratings = $grade1 + $grade2 + $grade3 + $grade4 + $grade5;

            // calculate final rating and append to array
            $user_final_rating[$user->id] = $total_ratings > 0 ? round($weighted_sum / $total_ratings, 2) : 0;
        }

        return $user_final_rating;
    }

    public function calculateDepartmentFinalRatings(){ 
        
        // get all departments
        $departments = Department::all();

        // for storing each department's's final rating
        $department_final_rating = [];

        foreach ($departments as $department) {

            $grade1 = $grade2 = $grade3 = $grade4 = $grade5 = 0;

            $department_result = Staff_Survey_Result::where('department_id', $department->id)->get();

            // count the total number of ratings for each grade
            foreach ($department_result as $result){
                $grade1 = $grade1 + $result->grading_1_count;
                $grade2 = $grade2 + $result->grading_2_count;
                $grade3 = $grade3 + $result->grading_3_count;
                $grade4 = $grade4 + $result->grading_4_count;
                $grade5 = $grade5 + $result->grading_5_count;
            }
            
            // calculating the weighted sum
            $weighted_sum = ($grade1 * 1) + ($grade2 * 2) + ($grade3 * 3) + ($grade4 * 4) + ($grade5 * 5);

            // sum up all the total gradings
            $total_ratings = $grade1 + $grade2 + $grade3 + $grade4 + $grade5;

            // calculate final rating and append to array
            $department_final_rating[$department->id] = $total_ratings > 0 ? round($weighted_sum / $total_ratings, 2) : 0;
        }

        return $department_final_rating;
    }
}
