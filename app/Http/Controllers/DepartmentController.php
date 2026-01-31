<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Department;

class DepartmentController extends Controller
{
    function createNewDepartment(Request $request){

        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }
        
        // validate the input
        $request->validate([
            'department_name' => 'required',
        ]);

        // create the department in the database
        $data['name'] = Str::ucfirst($request->department_name);
        Department::create($data);

        return redirect('/dashboard/'.auth()->user()->id)->with('success', 'Department Successfully Created');
    }

    function toEditDepartmentPage($admin_id, $department_id){

        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the selected department
        $department_selected = Department::find($department_id);

        return view('admin.editdepartment', compact('department_selected'));
    }

    function editDepartment(Request $request, $admin_id, $department_id){

        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the department
        $department = Department::find($department_id);

        // set the new credentials that the admin has entered
        $department->name = $request->input('department_name');

        // save
        $department->save();

        return redirect(to: '/dashboard/'.$admin_id)->with('success', 'Department Details Successfully Updated');
    }

    function deleteDepartment($admin_id, $department_id){
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the department
        $department = Department::find($department_id);

        // delete the department
        $department->delete();

        return redirect(to: '/dashboard/'.$admin_id)->with('success', 'Department Successfully Deleted');

    }
}
