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
use App\Models\SurveyQuestion;
use App\Models\SurveyReport;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;




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

// --------------------------------- CALCULATION OF FINAL RATINGS AND REPORT GENERATION -----------------------------------------

            // ---------- Managing Partner Survey ----------
            $managing_partner_final_rating = $this->calculateManagingPartnerFinalRatings($expired_survey); // returns float

            // get the Managing Partner
            $managing_partner = User::where('isManagingPartner', 1)->first();

            // generate the report for the managing partner survey
            $managing_partner_report_path = $this->generateManagingPartnerSurveyReport($managing_partner_final_rating, $managing_partner, $expired_survey);

            // save the details in a DB table
            SurveyReport::create([
                'user_id'               => $managing_partner->id,
                'survey_schedule_id'    => $expired_survey->id,
                'file_path'             => $managing_partner_report_path,
                'report_type'           => 'managing_partner',
            ]);

            // saving managing partner final rating
            Final_Rating::create([
                'managing_partner_id' => User::where('isManagingPartner', 1)->first()->id,
                'survey_schedule_id'  => $expired_survey->id,
                'final_rating'        => $managing_partner_final_rating,
                'date_calculated'     => today(),
            ]);


            // --------- Supervisor Survey ------------------
            $supervisors_final_rating = $this->calculateSupervisorFinalRatings($expired_survey); // returns associative array

            // saving each supervisor's final rating
            foreach ($supervisors_final_rating as $supervisor_id => $rating) {
            
                // generate the report for the managing partner survey
                $supervisor_report_path = $this->generateSupervisorSurveyReport($rating, $supervisor_id, $expired_survey);

                // save the details in a DB table
                SurveyReport::create([
                    'user_id'               => $supervisor_id,
                    'survey_schedule_id'    => $expired_survey->id,
                    'file_path'             => $supervisor_report_path,
                    'report_type'           => 'supervisor',
                ]);

                // saving the supervisor's final rating
                Final_Rating::create([
                    'supervisor_id'      => $supervisor_id,
                    'survey_schedule_id' => $expired_survey->id,
                    'final_rating'       => $rating,
                    'date_calculated'    => today(),
                ]);
            }
            
            
            // --------- Staff Survey -----------------------
            $staff_final_ratings = $this->calculateStaffFinalRatings($expired_survey); // returns associative array

            // save each user's final ratings
            foreach ($staff_final_ratings as $user_id => $rating) {

                // generate the report for the user in the staff survey
                $user_report_path = $this->generateStaffSurveyReport($rating, $user_id, $expired_survey);

                // save the details in a DB table
                SurveyReport::create([
                    'user_id'               => $user_id,
                    'survey_schedule_id'    => $expired_survey->id,
                    'file_path'             => $user_report_path,
                    'report_type'           => 'staff',
                ]);

                // save the user's final rating
                Final_Rating::create([
                    'user_id'            => $user_id,
                    'survey_schedule_id' => $expired_survey->id,
                    'final_rating'       => $rating,
                    'date_calculated'    => today(),
                ]);
            }
        }     
    }

    public function calculateManagingPartnerFinalRatings($expired_survey){
        
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

    public function calculateSupervisorFinalRatings($expired_survey){
        
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

    public function calculateStaffFinalRatings($expired_survey){

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

// -------------------------------------- REPORT GENERATION ---------------------------------------------
    public function generateManagingPartnerSurveyReport($managing_partner_final_rating, $managing_partner, $expired_survey){
        
        // get all survey questions and question categories for the managing partner
        $managing_partner_survey_questions = SurveyQuestion::where('appears_in', 3)
                                                            ->orWhere('appears_in', 0)
                                                            ->get();

        // path to the managing partner's folder
        $managing_partner_report_folder = storage_path('app/private/reports/'.$managing_partner->initials.'/');

        // create folder if it doesn't exist
        if (!file_exists($managing_partner_report_folder)) {
            mkdir($managing_partner_report_folder, 0777, true);
        }

        // full path to the PDF file
        $report_path = $managing_partner_report_folder.'Managing_Partner_Survey_Report_'.now()->format('Y-m-d').'.pdf';

        // create and save the PDF report for the managing partner survey
        
        Pdf::view('reports.mpsurveyreport', 
                ['managing_partner_survey_questions'    => $managing_partner_survey_questions->chunk(2), 
                'managing_partner'                      => $managing_partner,
                'managing_partner_final_rating'         => $managing_partner_final_rating,
                'expired_survey'                        => $expired_survey
            ])
            ->landscape()
            ->headerView('reports.layouts.header')
            ->footerView('reports.layouts.footer')
            ->margins(30, 0, 30, 0) // top, right, bottom, left
            ->save($report_path);
    
        return $report_path;
    }

    public function generateSupervisorSurveyReport($rating, $supervisor_id, $expired_survey){
        
        // get all survey questions and question categories for the supervisor
        $supervisor_survey_questions = SurveyQuestion::where('appears_in', 2)
                                                        ->orWhere('appears_in', 0)
                                                        ->get();

        // find the supervisor
        $supervisor = User::findOrFail($supervisor_id);

        // path to the supervisor's folder
        $supervisor_report_folder = storage_path('app/private/reports/'.$supervisor->initials.'/');

        // create folder if it doesn't exist
        if (!file_exists($supervisor_report_folder)) {
            mkdir($supervisor_report_folder, 0777, true);
        }

        // full path to the PDF file
        $report_path = $supervisor_report_folder.'Supervisor_Survey_Report_'.now()->format('Y-m-d').'.pdf';

        // create and save the PDF report for the supervisor survey
        Pdf::view('reports.supervisorsurveyreport', 
                ['supervisor_survey_questions'    => $supervisor_survey_questions->chunk(2), 
                'supervisor'                      => $supervisor,
                'supervisor_final_rating'         => $rating,
                'expired_survey'                  => $expired_survey
            ])
            ->landscape()
            ->headerView('reports.layouts.header')
            ->footerView('reports.layouts.footer')
            ->margins(30, 0, 30, 0) // top, right, bottom, left
            ->save($report_path);
    
        return $report_path;
    }

    public function generateStaffSurveyReport($rating, $user_id, $expired_survey){

        // get all survey questions and question categories for the staff survey
        $staff_survey_questions = SurveyQuestion::where('appears_in', 1)
                                                        ->orWhere('appears_in', 0)
                                                        ->get();

        // find the user
        $user = User::findOrFail($user_id);

        // path to the user's folder
        $user_report_folder = storage_path('app/private/reports/'.$user->initials.'/');

        // create folder if it doesn't exist
        if (!file_exists($user_report_folder)) {
            mkdir($user_report_folder, 0777, true);
        }

        // full path to the PDF file
        $report_path = $user_report_folder.'Staff_Survey_Report_'.now()->format('Y-m-d').'.pdf';

        // create and save the PDF report for the supervisor survey
        Pdf::view('reports.staffsurveyreport', 
                ['staff_survey_questions'    => $staff_survey_questions->chunk(2), 
                'user'                       => $user,
                'user_final_rating'          => $rating,
                'expired_survey'             => $expired_survey
            ])
            ->landscape()
            ->headerView('reports.layouts.header')
            ->footerView('reports.layouts.footer')
            ->margins(30, 0, 30, 0) // top, right, bottom, left
            ->save($report_path);
    
        return $report_path;
    }
}
