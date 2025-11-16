@extends('layouts.app')

@section('title') Staff Survey @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="mb-4 fst-italic">
                <h3 class="fw-bold text-center">Welcome to the Staff Survey</h3>
            </div>
        </div>
        <div class="col-12 ms-2">    
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Purpose:</h5>
                <p class="text-break mb-3"> 
                    The purpose of this internal staff survey is to provide an opportunity for team members to offer constructive feedback about one another in a structured and confidential manner. The survey seeks to promote self-awareness, accountability, and continuous personal and professional growth among staff.                
                </p>
                
                <h5 class="fw-bold mb-3">Importance:</h5>
                <p class="text-break">
                    Peer feedback is an important part of building a transparent, collaborative, and high-performing workplace. The insights gathered will help individuals understand how they are perceived by colleagues, identify strengths, and recognize areas for improvement — ultimately enhancing teamwork, communication, and the overall work environment.                </p>
                    
            </div>
            <div class="mb-4">
                <h5 class="fw-bold mb-3">How it Works:</h5>
                <ol> 
                    <li class="text-break">
                        Pick a Department
                    </li>
                    <li>
                        Answer the questions based on the ratings provided for each person in the department
                    </li>
                    <li>
                        Choose another department and rinse and repeat
                    </li>
                </ol>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="{{ route('staff.survey.intro', ['user_id' => auth()->user()->id]) }}" class="text-decoration-none">
                <button class="btn btn-outline-success">Start the Survey</button>
            </a>
        </div>
    </div>

</div>

@endsection