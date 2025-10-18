<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $users = User::all();

        // get all admins
        $admins = User::where('level', '!=', 'normalUser')->get();

        return view('dashboard', compact('users', 'admins'));
    }

    function newUserPage($id) {
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the currently logged in user's ID
        $current_user = User::find($id);

        return view('admin.newuser');
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
