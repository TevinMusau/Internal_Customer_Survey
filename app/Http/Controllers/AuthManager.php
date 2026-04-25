<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;


class AuthManager extends Controller
{
    // to login page
    function login(){
        return view('auth.login');
    }

    // receives a request that contains all the data from the login form
    // all data from the login form can be accessed through the request variable created below
    function loginPost(Request $request){
        // we validate the form, checking for availability of the variables (email and password) as per the form
        // if the items are not present, it displays an error automatically
        // has key => value pairs syntax
        // the key is obtained from the form (the NAME of the input)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // gets and stores the form input in the credentials variable
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            // here, we check who is trying to log in. 
            // It could be a superAdmin (IT), a staffAdmin (HR), a regularAdmin (Partner) or a user (staff)
            // if successful, redirect to the respective page (given the route a name)
            // this redirect goes with a success message which will be printed at the home page
            if (auth()->user()->level == 'superAdmin'){
                return redirect()->intended(url('dashboard/'.auth()->user()->id))->with('success', 'Login Successful!');

            } else if (auth()->user()->level == 'staffAdmin') {
                return redirect()->intended(url('dashboard/'.auth()->user()->id))->with('success', 'Login Successful!');

            } else if (auth()->user()->level == 'regularAdmin') {
                return redirect()->intended(url('dashboard/'.auth()->user()->id))->with('success', 'Login Successful!');

            } else {
                return redirect()->intended(route('dashboard/'.auth()->user()->id))->with('success', 'Login Successful!');
            }            
        } else {

            // if not successful, redirect to the login page with an error message
            return back()->withInput()->with('error', 'Login Details Incorrect! Please Try Again');
            
            //return redirect(route('login'))->with('error', 'Login Details Incorrect! Please Try Again');
        }
    }

    // logout function
    // clean the session
    // logout the user and redirect them
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'))->with('success', 'Logout Successful!');
    }

    //send password reset link
    function sendResetLink(Request $request){
        
        // validate the input
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Password reset link sent to your email.');
        }

        return back()->with('error', 'We could not find an account with that email address.');

    }

    public function showResetForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed', // confirmed checks password_confirmation field
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => bcrypt($password)])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password reset successfully. Please log in.');
        }

        return back()->with('error', 'Invalid or expired reset link.');
    }
}
