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

        <form class="form-group" action="#" method="POST">
            @csrf
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($mp_question_categories as $question_category)
                @if ($question_category->survey_question)
                    @php $counter = 1; @endphp
                @endif
                    @foreach ($question_category->survey_question as $survey_question)
                        @if ($survey_question->appears_in == 3)
                        @if ($counter == 1)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse-{{ $question_category->id }}" data-bs-target="#flush-collapse-{{ $question_category->id }}" aria-expanded="false" aria-controls="flush-collapse-{{ $question_category->id }}">
                                        {{ $question_category->category_name }}
                                        {{ $question_category->id }}
                                    </button>
                                </h2>
                                @php $counter++; @endphp
                        @endif
                                <div id="flush-collapse-{{ $question_category->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $question_category->id }}" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>{{ $survey_question->sub_category_name }}</p>
                                        <p>{{ $survey_question->sub_category_description }}</p>
                                        <p>{{ $survey_question->question }}</p>
                                        <p>Ratings!</p>
                                        <div class="">
                                            <div class="mb-2">
                                                <input type="radio" name="mp_punctuality_rating" id="exceptional" value="5">
                                                <label class="btn btn-primary" for="exceptional">5 - Exceptional</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" name="mp_punctuality_rating" id="exceeds" value="4">
                                                <label class="btn btn-primary" for="exceeds">4 - Exceeds Expectations</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" name="mp_punctuality_rating" id="meets" value="3">
                                                <label class="btn btn-primary" for="meets">3 - Meets Expectations</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" name="mp_punctuality_rating" id="below" value="2">
                                                <label class="btn btn-primary" for="below">2 - Below Expectations</label>
                                            </div>
                                            <div class="">
                                                <input type="radio" name="mp_punctuality_rating" id="improve" value="1">
                                                <label class="btn btn-primary" for="improve">1 - Needs Improvement</label>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <input class="form-control btn btn-outline-success" type="submit">
        </form>
    </div>
</div>

@endsection