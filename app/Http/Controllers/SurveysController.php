<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SurveysController extends Controller
{
    private $rating;
    // to Managing Partner Survey Page
    function introToManagingPartnerSurvey($id){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.Managing_Partner.managingpartnersurvey');
    }

    function ratingsExplained($id){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.base.ratings_explained');
    }

    function managingPartnerSurvey($id){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.Managing_Partner.surveystage1');
    }

    function managingPartnerSurveyStep1(Request $request, $id){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        // validate the selection
        $request->validate([
            'mp_punctuality_rating' => 'required',
        ]);

        // temporarily store the selected rating in a session variable
        session(['survey' => intval($request->input('mp_punctuality_rating'))]);

        return view('surveys.Managing_Partner.surveystage2');
    }

    function managingPartnerSurveyStep2(Request $request, $id){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        // validate the selection
        $request->validate([
            'mp_committment_rating' => 'required',
        ]);

        // retrieve the previous step's selection from the session variable
        $selections_session = session('survey', []);

        // create an array to hold the previous and current data
        $selections = [];
        array_push($selections, $selections_session, intval($request->input('mp_committment_rating')));

        session(['survey' => $selections]);

        // dd(session('survey'));

        return view('surveys.Managing_Partner.surveystage3');
    }

    function managingPartnerSurveyStep3(Request $request, $id){
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        // validate the selection
        $request->validate([
            'mp_trust_rating' => 'required',
        ]);

        // retrieve the previous step's selection from the session variable
        $selections_session = session('survey', []);

        // create an array to hold the previous and current data
        array_push($selections_session, intval($request->input('mp_trust_rating')));

        session(['survey' => $selections_session]);

        $part1 = session('survey')[0];
        $part2 = session('survey')[1];
        $part3 = session('survey')[2];

        return view('surveys.base.surveyend', compact('part1', 'part2', 'part3'));
    }

    function toStaffSurveyPage($id){

        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.Staff_Survey.staffsurvey');
    }

    function beginTest($id) {
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the user's id
        $user = User::find($id);

        return view('surveys.Staff_Survey.test');
    }
}
