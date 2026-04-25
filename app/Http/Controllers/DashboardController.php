<?php

namespace App\Http\Controllers;

use App\Models\Completed_Managing_Partner_Survey;
use App\Models\Completed_Supervisor_Survey;
use App\Models\Staff_Survey_Department_Completed;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

use App\Models\SurveySchedule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\QuestionCategory;
use App\Models\Comment;
use App\Models\SurveyQuestion;


class DashboardController extends Controller
{
    // to dashboard page
    function dashboard($id){
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the currently logged in user's ID
        $current_user = User::find($id);

        // get all users
        $users = User::with('departments')->get();

        // get all departments
        $departments = Department::with('users')->get();

        // get all question categories
        $question_categories = QuestionCategory::with('department')->get();

        // get all admins
        $admins = User::with('departments')->where('level', '!=', 'normalUser')->get();

        $completed_managing_partner_survey = Completed_Managing_Partner_Survey::where('user_id', $id)->first();

        $completed_supervisor_survey = Completed_Supervisor_Survey::where('user_id', $id)->first();

        // check if the user has completed the staff survey
        // check if the user has completed survey for some departments
        $department_surveys_completed_by_user = Staff_Survey_Department_Completed::where('user_id', $id)->get();

        // check if the user has done surveys for all departments
        if ($departments->count() != $department_surveys_completed_by_user->count()){
            $completed_staff_survey = false;
        } else {
            $completed_staff_survey = true;
        }

        // check if there is an already active survey
        $active_survey = SurveySchedule::where('is_active', 1)->first();

        $scheduled_survey = $active_survey ?? null;        

        // get the all questions
        $all_questions = QuestionCategory::with('survey_question.department')
                                    ->join('survey_questions', 'question_categories.id', '=', 'survey_questions.question_category_id')
                                    ->select(
                                        'question_categories.id',
                                        'survey_questions.id as survey_question_id',
                                        'question_categories.category_name as question_category',
                                        'survey_questions.sub_category_name',
                                        'survey_questions.sub_category_description as description',
                                        'survey_questions.question',
                                        'survey_questions.appears_in as appears_in',
                                        'survey_questions.affects_all_department as departments_affected',
                                        'question_categories.appears_in_all_departments',
                                    )
                                    ->get()
                                    ->groupBy('question_category');

        // get all comments
        $comments = Comment::with(['commentor', 'commentee'])->get();
        

        return view('dashboard', compact('users', 'admins', 'departments', 'question_categories', 'completed_managing_partner_survey', 'completed_supervisor_survey', 'completed_staff_survey', 'all_questions', 'comments', 'scheduled_survey'));
    }

    function newUserPage($id) {
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the currently logged in user's ID
        $current_user = User::find($id);

        // get all departments names (a collection of just the names)
        $departments = Department::all();

        return view('admin.newuser', compact('departments'));
    }

    function toNewDepartmentPage($admin_id){
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        return view('admin.createdepartment');
    }

    function deleteUser($admin_id, $user_id)
    {
        // get all users
        $users = User::all();

        // get all admins
        $admins = User::where('level', '!=', 'normalUser')->get();

        // find the user
        $user = User::find($user_id);

        // delete the user
        $user->delete();

        return redirect()->route('dashboard', ['id' => $admin_id, 'users' => $users, 'admins' => $admins])->with('success', "User Successfully Deleted");
    }
}
