@extends('layouts.app')

@section('title') Managing Partner Survey @endsection

@section('content')

<div class="container-fluid w-100 p-1">
    <div class="row justify-content-center">
        <div class="mb-2 w-75">
            <!-- Here, we print out the errors 
            -- this first section prints out errors due to form validation (the validate function in Auth Manager)
            -- they are many, so we use a foreach loop to print each one of them out
            -->
            @if($errors->any())
                <div class="col-12">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                    @endforeach
                </div>
            @endif

            <!-- Here, we print out the errors due to the users attempt to login (to create a session)
            -- this section connects with the ->with method in Auth Manager
            -- they are many, so we use a foreach loop to print each one of them out
            -->
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session()->has('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session()->has('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-4">
            <h1 class="fw-bold">Managing Parter Survey</h1>
        </div>

        <div class="col-7 border border-black">
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                    <span class="fs-6">Punctuality</span>
                </div>
                <div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                    <span class="fs-6">Committment</span>
                </div>
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div class="col-7 border border-dark">
            <div class="h6">
                <p>
                    <ol>
                        <li>
                            How would you rate the current Managing Partner in terms of committment to their role?
                        </li>
                    </ol>
                </p>

                <div class="text-end">                
                    <!-- Ratings Reminder Modal -->
                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Ratings Explained
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ratings Explained</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>                
                                <ul>
                                    <li>
                                        <strong>EXCEPTIONAL (5): </strong><br>
                                        Consistently exceeds all relevant performance standards. Provides leadership, fosters teamwork, is highly productive, innovative, and responsive and generates top quality work.
                                    </li> <br>
                                    <li>
                                        <strong>EXCEEDS EXPECTATIONS (4): </strong><br>
                                        Consistently meets and often exceeds all relevant performance standards. Shows initiative and versatility, works collaboratively, has strong technical & interpersonal skills or has achieved significant improvement in these areas.
                                    </li> <br>
                                    <li>
                                        <strong>MEETS EXPECTATIONS (3): </strong><br>
                                        Meets all relevant performance standards. Seldom exceeds or falls short of desired results or objectives.
                                    </li> <br>
                                    <li>
                                        <strong>BELOW EXPECTATIONS (2): </strong><br>
                                        Sometimes meets the performance standards. Seldom exceeds and often falls short of desired results. Performance has declined significantly, or employee has not sustained adequate improvement, as required since the last performance review or performance.
                                    </li> <br>
                                    <li>
                                        <strong>NEEDS IMPROVEMENT (1): </strong><br>Consistently falls short of performance standards.
                                    </li> <br>
                                </ul>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>

                <form class="form-group" action="{{ route('mp.survey.p2.post', ['user_id' => auth()->user()->id]) }}" method="POST">
                    @csrf
                    <div class="">
                        <div class="mb-2">
                            <input type="radio" name="mp_committment_rating" id="exceptional" value="5">
                            <label class="btn btn-primary" for="exceptional">5 - Exceptional</label>
                        </div>
                        <div class="mb-2">
                            <input type="radio" name="mp_committment_rating" id="exceeds" value="4">
                            <label class="btn btn-primary" for="exceeds">4 - Exceeds Expectations</label>
                        </div>
                        <div class="mb-2">
                            <input type="radio" name="mp_committment_rating" id="meets" value="3">
                            <label class="btn btn-primary" for="meets">3 - Meets Expectations</label>
                        </div>
                        <div class="mb-2">
                            <input type="radio" name="mp_committment_rating" id="below" value="2">
                            <label class="btn btn-primary" for="below">2 - Below Expectations</label>
                        </div>
                        <div class="">
                            <input type="radio" name="mp_committment_rating" id="improve" value="1">
                            <label class="btn btn-primary" for="improve">1 - Needs Improvement</label>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-outline-success">
                        Next
                    </button>
                </div>
            </form>
            {{-- <div class="text-start mt-4">
                <button class="btn btn-outline-success">
                    Previous
                </button>
            </div> --}}
        </div>
    </div>
</div>

@endsection