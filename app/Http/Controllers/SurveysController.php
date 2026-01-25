<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\QuestionCategory;

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

        // get question categories and survey questions that are related to the department selected
        $department_survey_questions = $department_selected->question_category()->where('appears_in_all_departments', 0)->get();

        return view('surveys.Staff_Survey.survey', compact('selected_department_id', 'department_selected', 'department_survey_questions', 'common_department_question_categories'));
    }
}
