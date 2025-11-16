<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class EditUserController extends Controller
{
    function toEditPage($admin_id, $user_id){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // find the user's details based on the user's ID
        $user = User::find($user_id);

        // redirect to the edit details page
        return view('admin.edituser', compact('user'));
    }

    function editDetails(Request $request, $admin_id, $user_id){

        // find the user's details based on the user's ID
        $user = User::find($user_id);
        // dd($user);

        // set the new credentials that the user has entered
        $user->first_name = $request->input('fname');
        $user->last_name = $request->input('lname');
        $user->email = $request->input('email');
        $user->department = $request->input('department');
        $user->role = $request->input('role');
        $user->level = $request->input('user_level');

        // check if the password fields are empty
        if ($request->input('password') == null && $request ->input('password_confirmation') == null) {
            
            // update new user credentials on the DB
            $user->update();

            return redirect('/dashboard/'.$admin_id)->with('success', 'User Details Successfully Updated');

        } else {

            // make sure the confirmation password and the password field match
            $request->validate([
                'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/','regex:/[@$!%*#?&]/', 'confirmed']
            ]);

            // hash the password
            $user->password = Hash::make($request->input('password'));
            
            // update the details in the DB
            $user->update();

            return redirect('/dashboard/'.$admin_id)->with('success', 'User Details Successfully Updated');
        }
    }
}
