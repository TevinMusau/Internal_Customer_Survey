<?php

namespace App\Http\Controllers;

use App\Models\DepartmentSurveyQuestion;
use App\Models\QuestionCategory;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    function store(Request $request){
        // get all users
        $users = User::all();

        // get all departments
        $departments = Department::all();

        // get all admins
        $admins = User::where('level', '!=', 'normalUser')->get();

        // validate the input
        $request->validate([
            'question_category' => 'required',
            'question_dept_selection' => 'required',
            'sub_category_name' => 'required',
            'sub_category_description' => 'required',
            'question' => 'required',
            'scope' => 'required',
        ]);

        if ($request->question_dept_selection[0] == "all_depts") {
            // create a question in the Survey Questions Table
            $data['sub_category_name'] = $request->sub_category_name;
            $data['sub_category_description'] = $request->sub_category_description;
            $data['question_category_id'] = $request->question_category;
            $data['question'] = $request->question;
            $data['rating_id'] = 1;

            if ($request->scope == 'all_surveys'){
                $data['appears_in'] = 0;
            } else if ($request->scope == 'staff_survey') {
                $data['appears_in'] = 1;
            } else if ($request->scope == 'supervisor_survey') {
                $data['appears_in'] = 2;
            } else if ($request->scope == 'mp_survey') {
                $data['appears_in'] = 3;
            } else {
                $data['appears_in'] = 0;
            }

            $data['affects_all_department'] = 1;

            $new_question = SurveyQuestion::create($data);

            foreach ($departments as $department) {
                $dept_id = $department->id;

                $data['survey_question_id'] = $new_question->id;
                $data['department_id'] = $dept_id;

                DepartmentSurveyQuestion::create($data);
            }

            return redirect('/dashboard/'.auth()->user()->id)->with('success', 'Question Successfully Created');
        } else {

            // create a question in the Survey Questions Table
            $data['sub_category_name'] = $request->sub_category_name;
            $data['sub_category_description'] = $request->sub_category_description;
            $data['question_category_id'] = $request->question_category;
            $data['question'] = $request->question;
            $data['rating_id'] = 1;
            
            if ($request->scope == 'all_surveys'){
                $data['appears_in'] = 0;
            } else if ($request->scope == 'staff_survey') {
                $data['appears_in'] = 1;
            } else if ($request->scope == 'supervisor_survey') {
                $data['appears_in'] = 2;
            } else if ($request->scope == 'mp_survey') {
                $data['appears_in'] = 3;
            } else {
                $data['appears_in'] = 0;
            }

            $data['affects_all_department'] = 0;

            // This will be an array of checked values, or null if none
            $selected_departments = $request->input('question_dept_selection', []);

            $new_question = SurveyQuestion::create($data);

            $new_question->department()->attach($selected_departments, []);            

            return redirect('/dashboard/'.auth()->user()->id)->with('success', 'Question Successfully Created');

        }

    }

    function toEditQuestionPage($survey_question_id, $user_id){
        
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get all question categories
        $question_categories = QuestionCategory::all();

        // get all departments
        $departments = Department::all();
        
        // get details of survey question
        $survey_question = SurveyQuestion::find($survey_question_id);

        // get all departments linked to the survey question
        $linkedDepartmentIds = $survey_question->department->pluck('id')->toArray();

        // check if the list of departments selected is equal to the total number of departments
        $allSelected = count($linkedDepartmentIds) === count($departments);

        // redirect to the edit question details page
        return view('editquestion', compact('question_categories', 'survey_question', 'departments', 'allSelected', 'linkedDepartmentIds'));
    }

    function editQuestionDetails(Request $request, $survey_question_id, $user_id){

        // find the survey question
        $survey_question = SurveyQuestion::find($survey_question_id);

        // get all departments
        $departments = Department::all();

        // update the question
        $survey_question->update([
            'question_category_id'      => $request->input("question_category_id"),
            'sub_category_name'         => $request->input("sub_category_name"),
            'sub_category_description'  => $request->input("sub_category_description"),
            'question'                  => $request->input("sub_category_question"),
            'appears_in'                => $request->input("survey_question_survey_selection"),
        ]);

        // handle department sync
        if (in_array(1, $request->survey_question_department_selection)) {
            // "All Departments" selected — sync all
            $survey_question->department()->sync($departments->pluck('id')->toArray());
            $survey_question->update(['affects_all_department' => 1]);
        } else {
            // sync only selected departments
            $survey_question->department()->sync($request->survey_question_department_selection);
            $survey_question->update(['affects_all_department' => 0]);
        }

        return redirect('/dashboard/'.$user_id)->with('success', 'Question Details Successfully Updated');
    }

    function deleteQuestion($survey_question_id, $user_id){
        // get the survey question
        $survey_question = SurveyQuestion::findOrFail($survey_question_id);

        // delete it
        $survey_question->delete();

        return redirect('/dashboard/'.$user_id)->with('success', 'Question Deleted Successfully');
    }
}
