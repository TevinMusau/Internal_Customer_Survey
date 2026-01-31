<?php

namespace App\Http\Controllers;

use App\Models\DepartmentSurveyQuestion;
use App\Models\QuestionCategory;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;

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
        ]);

        if ($request->question_dept_selection[0] == "all_depts") {
            // create a question in the Survey Questions Table
            $data['sub_category_name'] = $request->sub_category_name;
            $data['sub_category_description'] = $request->sub_category_description;
            $data['question_category_id'] = $request->question_category;
            $data['question'] = $request->question;
            $data['rating_id'] = 1;
            $data['appears_in'] = 0;
            $data['affects_all_departments'] = 1;

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
            $data['appears_in'] = 0;
            $data['affects_all_departments'] = 1;

            // This will be an array of checked values, or null if none
            $selected_departments = $request->input('question_dept_selection', []);

            $new_question = SurveyQuestion::create($data);

            $new_question->department()->attach($selected_departments, []);            

            return redirect('/dashboard/'.auth()->user()->id)->with('success', 'Question Successfully Created');

        }

    }
}
