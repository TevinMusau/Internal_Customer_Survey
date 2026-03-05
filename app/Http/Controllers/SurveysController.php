<?php

namespace App\Http\Controllers;

use App\Models\Completed_Managing_Partner_Survey;
use App\Models\Completed_Supervisor_Survey;
use App\Models\Managing_Partner_Survey_Result;
use App\Models\Staff_Survey_Result;
use App\Models\Supervisor_Survey_Result;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\QuestionCategory;
use App\Models\Staff_Survey_Department_Completed;

class SurveysController extends Controller
{
    // to Managing Partner Survey Page
    function introToManagingPartnerSurvey($id){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.Managing_Partner.intro');
    }

    function ratingsExplained($id){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.base.ratings_explained');
    }

    function managingPartnerSurvey($id){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        //get the Managing partner
        $managing_partner = User::where('isManagingPartner', 1)->first();

        // get all question categories common for all departments
        $common_department_question_categories = QuestionCategory::where('appears_in_all_departments', 1)->get();

        // get all question categories that appear in all departments only
        $mp_question_categories = QuestionCategory::where('appears_in_all_departments', 1)->get();

        return view('surveys.Managing_Partner.survey', compact('common_department_question_categories', 'managing_partner', 'mp_question_categories'));
    }

    function submitManagingPartnerSurvey($user_id, Request $request){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // validate the input
        $request->validate([
            'ratings' => 'required|array', // ratings field must exist
            'ratings.*' => 'required|min:1|max:5' // every user rating must exist, and must be between 1 and 5
        ]);

        // get all question categories that appear in all departments only
        $mp_question_categories = QuestionCategory::where('appears_in_all_departments', 1)->get();

        // get the managing partner
        $managing_partner = User::where('isManagingPartner', 1)->first();


// ---------------------------- MANAGING PARTNER SPECIFIC QUESTIONS VALIDATION ------------------------------------
        
        foreach ($mp_question_categories as $category) {

            foreach ($category->survey_question as $question) {

                if ($question->appears_in == 3) {

                    if (!isset($request->ratings[$question->id])) {
                        return back()->withErrors([
                            'ratings' => 'Managing Partner must be rated for every question.'
                        ]);
                    }
                }
            }
        }

        foreach ($request->ratings as $question_id => $rating) {

        // dd($request->ratings);

            // check if the MP rating for this question already exists
            $existing = Managing_Partner_Survey_Result::where('survey_question_id', $question_id)->first();
            
            if ($existing){

                // increment only the selected rating
                $existing->increment("grading_{$rating}_count");

            } else {

                // create the new record
                Managing_Partner_Survey_Result::create([
                    'survey_question_id' => $question_id,
                    'user_id' => $managing_partner->id,
                    'grading_1_count' => $rating == 1 ? 1 : 0,
                    'grading_2_count' => $rating == 2 ? 1 : 0,
                    'grading_3_count' => $rating == 3 ? 1 : 0,
                    'grading_4_count' => $rating == 4 ? 1 : 0,
                    'grading_5_count' => $rating == 5 ? 1 : 0,
                ]);
            }
        }

        // user has now completed the Managing Partner Survey
        // add their record to the Completed Managing Partner Survey Table
        Completed_Managing_Partner_Survey::create([
            'user_id' => $user_id,
            'date' => today(),
        ]);

        return redirect('/dashboard/'.auth()->user()->id)->with('success', 'You have successfully completed the Managing Partner Survey!');
    }


    function toStaffSurveyIntroPage($id){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.Staff_Survey.intro');
    }

    function staffSurveySelectDepartments($id) {
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        // get all departments
        $departments = Department::all();

        // check if the user has completed survey for some departments
        $department_surveys_completed_by_user = Staff_Survey_Department_Completed::where('user_id', $id)->get();

        // check if the user has completed survey for different department
        if ($department_surveys_completed_by_user->count() > 0) {

            $departments_complete = [];

            // get ID's of departments the user has done the survey for
            foreach ($department_surveys_completed_by_user as $completed_department){
                array_push($departments_complete, $completed_department->department_id);
            }

            // display the departments, except those that the user has completed
            $departments = $departments->except($departments_complete);

            return view('surveys.Staff_Survey.selectdepartment', compact('departments'));

        } else if ($departments->count() == $department_surveys_completed_by_user->count()) {
            $departments = "Complete!";

        } else {

            return view('surveys.Staff_Survey.selectdepartment', compact('departments'));
        }

    }

    function displaySurveyPerDepartment($id, Request $request){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // validate the departments form
        $request->validate([
            'department' => 'required',
        ]);

        // get all question categories common for all departments
        $common_department_question_categories = QuestionCategory::where('appears_in_all_departments', 1)->get();

        // get the department selected by the user
        $selected_department_id = $request->input('department');
        $department_selected = Department::find($selected_department_id);

        // get all users in that department
        $department_users = $department_selected->users()->get();

        // get question categories and survey questions that are related to the department selected
        $department_survey_questions = $department_selected->question_category()->where('appears_in_all_departments', 0)->get();

        return view('surveys.Staff_Survey.survey', compact('selected_department_id', 'department_selected', 'department_users', 'department_survey_questions', 'common_department_question_categories'));
    }

    function submitStaffSurvey($user_id, $department_id, Request $request){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // validate the input
        $request->validate([
            'ratings' => 'required|array', // ratings field must exist
            'ratings.*' => 'required|array', // each question must have an array of users
            'ratings.*.*' => 'required|min:1|max:5' // every user rating must exist, and must be between 1 and 5
        ]);

        // get all question categories common for all departments
        $common_department_question_categories = QuestionCategory::where('appears_in_all_departments', 1)->get();

        // get the selected department that the user is reviewing at the moment
        $department_selected = Department::find($department_id);

        // get all users in that department
        $department_users = $department_selected->users()->get();

        // get question categories and survey questions that are related to the department selected
        $department_survey_questions = $department_selected->question_category()->where('appears_in_all_departments', 0)->get();

        /**
         * Question Categories and Survey questions can either be common or specific to a department
         * So when doing validation, we must account for this
         */

// ----------------------------------- COMMON QUESTIONS VALIDATION ----------------------------------------
        
        foreach ($common_department_question_categories as $category) {

            foreach ($category->survey_question as $question) {

                if ($question->appears_in == 0){

                    foreach ($department_users as $user) {

                        if (!isset($request->ratings[$question->id][$user->id])) {
                            return back()->withErrors([
                                'ratings' => 'All users must be rated for every question!!'
                            ]);
                        }
                    }
                }
            }
        }

// ---------------------------- DEPARTMENT SPECIFIC QUESTIONS VALIDATION ------------------------------------

        foreach ($department_survey_questions as $category) {

            foreach ($category->survey_question as $question) {

                foreach ($department_users as $user) {

                    if (!isset($request->ratings[$question->id][$user->id])) {
                        return back()->withErrors([
                            'ratings' => 'All users must be rated for every question.'
                        ]);
                    }
                }
            }
        }

        foreach ($request->ratings as $question_id => $users) {

            // Prepare counters to count new submissions
            $newCounts = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
            ];

            // count ratings for question
            foreach ($users as $userId => $rating) {

                // count the ratings
                $newCounts[$rating]++;

                // Check if result exists for this question + department
                $existing = Staff_Survey_Result::where('survey_question_id', $question_id)
                                                ->where('user_id', $userId)
                                                ->first();

                if ($existing) {
                    // Add new counts to existing counts
                    $existing->grading_1_count += $newCounts[1];
                    $existing->grading_2_count += $newCounts[2];
                    $existing->grading_3_count += $newCounts[3];
                    $existing->grading_4_count += $newCounts[4];
                    $existing->grading_5_count += $newCounts[5];

                    $existing->save();

                } else {
                    // No previous result, create new
                    Staff_Survey_Result::create([
                        'survey_question_id' => $question_id,
                        // save the rated user's ID
                        'user_id' => $userId,
                        'department_id' => $department_id,
                        'grading_1_count' => $newCounts[1],
                        'grading_2_count' => $newCounts[2],
                        'grading_3_count' => $newCounts[3],
                        'grading_4_count' => $newCounts[4],
                        'grading_5_count' => $newCounts[5],
                    ]);
                }
            }
        }
        
        // the user has now completed the survey for this department
        // add this to the department table
        Staff_Survey_Department_Completed::create([
                        'user_id' => $user_id,
                        'department_id' => $department_id,
                        'date' => today()
        ]);

        return redirect()->back()->with('success', 'You have successfully completed Staff Survey for the '.$department_selected->name. ' department!');
    }

    function toSupervisorSurveyIntroPage($user_id){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($user_id);

        return view('surveys.Supervisor_Survey.intro');
    }

    function supervisorSurveySelectSupervisor($user_id){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get all supervisors
        $supervisors = User::where('isSupervisor', 1)->get();

        return view('surveys.Supervisor_Survey.selectsupervisor', compact('supervisors'));

    }

    function displaySupervisorSurvey($user_id, Request $request){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // validate the supervisors form
        $request->validate([
            'supervisor' => 'required',
        ]);

        // get the selected supervisor
        $selected_supervisor = User::find($request->supervisor);

        // get supervisor survey questions
        $supervisor_question_categories = QuestionCategory::where('appears_in_all_departments', 1)->get();

        return view('surveys.Supervisor_Survey.survey', compact('supervisor_question_categories', 'selected_supervisor'));
    }

    function submitSupervisorSurvey($user_id, $supervisor_id, Request $request){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // validate the input
        $request->validate([
            'ratings' => 'required|array', // ratings field must exist
            'ratings.*' => 'required|min:1|max:5' // every user rating must exist, and must be between 1 and 5
        ]);

        // get all question categories common for all departments
        $supervisor_question_categories = QuestionCategory::where('appears_in_all_departments', 1)->get();

        // get the supervisor
        $supervisor = User::find($supervisor_id);

        foreach ($supervisor_question_categories as $category) {

            foreach ($category->survey_question as $question) {

                if ($question->appears_in == 2) {

                    if (!isset($request->ratings[$question->id])) {
                        return back()->withErrors([
                            'ratings' => 'Supervisor must be rated for every question.'
                        ]);
                    }
                }
            }
        }

        foreach ($request->ratings as $question_id => $rating) {

        // dd($request->ratings);

            // check if the supervisor's rating for each question already exists
            $existing = Supervisor_Survey_Result::where('survey_question_id', $question_id)
                                                    ->where('user_id', $supervisor_id)
                                                    ->first();
            
            if ($existing){

                // increment only the selected rating
                $existing->increment("grading_{$rating}_count");

            } else {

                // create the new record
                Supervisor_Survey_Result::create([
                    'survey_question_id' => $question_id,
                    'user_id' => $supervisor->id,
                    'grading_1_count' => $rating == 1 ? 1 : 0,
                    'grading_2_count' => $rating == 2 ? 1 : 0,
                    'grading_3_count' => $rating == 3 ? 1 : 0,
                    'grading_4_count' => $rating == 4 ? 1 : 0,
                    'grading_5_count' => $rating == 5 ? 1 : 0,
                ]);
            }
        }

        // user has now completed the Supervisor Survey
        // add their record to the Completed Supervisor Survey Table
        Completed_Supervisor_Survey::create([
            'user_id' => $user_id,
            'date' => today(),
        ]);

        return redirect('/dashboard/'.auth()->user()->id)->with('success', 'You have successfully completed the Supervisor Survey!');
    }
}
