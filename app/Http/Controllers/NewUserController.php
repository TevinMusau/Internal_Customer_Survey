<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NewUserController extends Controller
{
    // function to create new user
    function createUser(Request $request){
        // validate the form data
        $request->validate([
            'fname' => 'required|min:3|max:50',
            'lname' => 'required|min:3|max:50',
            'email' => 'required|email',
            'department_selection' => 'required',
            'role' => 'required',
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/','regex:/[@$!%*#?&]/', 'confirmed']
        ]);

        // get data from the request variable and store it in an array 
        // e.g. gets the fname from the request variable and stores in the data array
        $data['first_name'] = $request->fname;

        // check if middle name has been input
        if ($request->mname != null){

            // save the middle name
            $data['middle_name'] = $request->mname;

            // if the middle name is used in the initials
            if ($request->boolean('mname_initial')){
                // extract the first letter of the fname, mname and lname
                $initials_with_middle_name = strtoupper(substr($request->fname, 0, 1) . substr($request->mname, 0, 1) . substr($request->lname, 0, 1));

                // save the initials
                $data['initials'] = $initials_with_middle_name;

            } else {
                // extract the first letter of the fname and lname
                $initials = strtoupper(substr($request->fname, 0, 1) . substr($request->lname, 0, 1));

                // save the initials
                $data['initials'] = $initials;
            }
        } else {
            // extract the first letter of the fname and lname
            $initials = strtoupper(substr($request->fname, 0, 1) . substr($request->lname, 0, 1));

            // save the initials
            $data['initials'] = $initials;
        }
        $data['last_name'] = $request->lname;
        $data['email'] = $request->email;
        $data['password'] = $request->password;

        $data['department_id'] = $request->department_selection;

        $data['role'] = $request->role;

        if ($request->boolean('supervisor')) {
            $data['isSupervisor'] = 1;
        }

        // check the role assigned by the admin when creating the user
        $selectedLevel = $request->user_level;

        // set the user's level accordingly
        switch ($selectedLevel){
            case "super_admin":
                $data['level'] = 'superAdmin';
                break;
            case "staff_admin":
                $data['level'] = 'staffAdmin';
                break;
            case "regular_admin":
                $data['level'] = 'regularAdmin';
                break;
            case "normal_user":
                $data['level'] = 'normalUser';
                break;
            default:
                $data['level'] = 'normalUser';
                break;
        }

        // insert the user in the database
        // we use a model
        // a model does all the queries to the database
        // the below creates a user by passing in to the model all the items which the user has inputted
        $user = User::create($data);

        // check if user creation is successful
        // if there is no user
        if (!$user){
            // create a log of the action done
            Log::error('Unable to create new user. Attempt done by '.auth()->user()->level.' '. auth()->user()->first_name.' of user ID'.auth()->user()->id);

            return back()->withInput()->with('error', 'Registration failed, try again!');

        }

        // create a log of the action done
        Log::info('User creation successful. Created by '.auth()->user()->level.' '. auth()->user()->first_name.' of user ID'.auth()->user()->id);

        // back to home page with success message
        return redirect(route('dashboard', ['id'=>auth()->user()->id]))->with('success', 'Registration Successful!');
    }
}
