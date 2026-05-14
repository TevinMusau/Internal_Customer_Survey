@extends('layouts.newapp')

@section('title') Supervisor Survey Survey @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="mb-4 fst-italic">
                <h3 class="fw-bold text-center">Welcome to the Supervisor Survey</h3>
            </div>
        </div>
        <div class="col-12 ms-2">    
            <div class="mb-4">
                <h5 class="fw-bold mb-3">Purpose:</h5>
                <p class="text-break mb-3"> 
                    The purpose of this survey is to gather honest feedback about supervisor’s leadership, communication, and overall management style. It gives an opportunity for supervisees to share their experience working under their supervisor and to highlight both strengths and areas that may need improvement. Responses to this survey will help the firm understand how effectively supervisors support their teams and contribute to achieving firm goals.
                </p>
                
                <h5 class="fw-bold mb-3">Importance:</h5>
                <p class="text-break">
                    Feedback can help improve leadership quality within the firm, contributing to enhancing communication, teamwork, and overall performance. The results may also help identify areas where supervisors may need additional training or support. Ultimately, by completing this survey thoughtfully and honestly, it helps promote accountability, professional growth, and a positive work environment for everyone.
                </p>    
            </div>
            <div class="mb-4">
                <h5 class="fw-bold mb-3">How it Works:</h5>
                <ol> 
                    <li class="text-break">
                        Pick a Supervisor
                    </li>
                    <li>
                        Answer the questions based on the ratings provided
                    </li>
                    <li>
                        Submit the form
                    </li>
                </ol>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="{{ route('supervisor.survey.ratings_explained', ['user_id' => auth()->user()->id]) }}" class="text-decoration-none">
                <button class="btn btn-outline-success">Understand the Grading System</button>
            </a>
        </div>
    </div>

</div>

@endsection