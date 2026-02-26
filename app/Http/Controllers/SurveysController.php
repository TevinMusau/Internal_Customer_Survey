<?php

namespace App\Http\Controllers;

use App\Models\Staff_Survey_Result;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\DB;

class SurveysController extends Controller
{
    private $rating;
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

        // get all question categories that appear in all departments only
        $mp_question_categories = QuestionCategory::where('appears_in_all_departments', '1')->get();

        return view('surveys.Managing_Partner.survey', compact('mp_question_categories'));
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

        // to select a department page
        $departments = Department::all();

        return view('surveys.Staff_Survey.selectdepartment', compact('departments'));
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

    function submit($user_id, $department_id, Request $request){
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

                foreach ($department_users as $user) {

                    if (!isset($request->ratings[$question->id][$user->id])) {
                        return back()->withErrors([
                            'ratings' => 'All users must be rated for every question.'
                        ]);
                    }
                }
            }
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


            // Count new submission
            $newCounts = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
            ];

            foreach ($users as $userId => $rating) {
            $newCounts[$rating]++;
        }

        // Check if result exists for this question + department
        $existing = Staff_Survey_Result::where('survey_question_id', $question_id)
                                        ->where('department_id', $department_id)
                                        ->first();
        }

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
                'user_id' => $user_id,
                'department_id' => $department_id,
                'grading_1_count' => $newCounts[1],
                'grading_2_count' => $newCounts[2],
                'grading_3_count' => $newCounts[3],
                'grading_4_count' => $newCounts[4],
                'grading_5_count' => $newCounts[5],
            ]);
        }

        return redirect()->back()->with('success', 'Survey saved successfully.');

    }
}
