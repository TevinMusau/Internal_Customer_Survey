<?php

namespace App\Http\Controllers;

use App\Models\DepartmentQuestionCategory;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;

class QuestionCategoryController extends Controller
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
            'category_name' => 'required',
            'dept_selection' => 'required',
        ]);

        if ($request->dept_selection[0] == "all_depts") {

            //dd("Here!");
            // create the category in the Question Category Table
            $data['category_name'] = $request->category_name;
            $data['appears_in_all_departments'] = 1;

            $new_category = QuestionCategory::create($data);

            //dd($new_category->id);

            // store one by one in each department
            foreach ($departments as $department) {
                $dept_id = $department->id;

                //dd($new_category->id, $dept_id);

                $data['question_category_id'] = $new_category->id;
                $data['department_id'] = $dept_id;

                DepartmentQuestionCategory::create($data);
            }

            return redirect('/dashboard/'.auth()->user()->id)->with('success', 'Category Successfully Created');


        } else {
            // create the category in the Question Category Table
            $data['category_name'] = $request->category_name;
            $data['appears_in_all_departments'] = 0;


            // This will be an array of checked values, or null if none
            $selected_departments = $request->input('dept_selection', []);

            $new_category = QuestionCategory::create($data);

            $new_category->department()->attach($selected_departments);
            
            return redirect('/dashboard/'.auth()->user()->id)->with('success', 'Category Successfully Created');

        }

    }
}
