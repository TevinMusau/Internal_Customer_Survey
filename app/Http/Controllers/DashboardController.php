<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    // to dashboard page
    function dashboard($id){
        // if user is not logged in, redirect to the login page with a warning message
        // if(!auth()->user()){
        //     return redirect('login')->with('warning', 'You Must First Login!');
        // }

        // get thw user's ID
        $user = User::find($id);

        return view('dashboard', compact('user'));
    }
}
