@extends('layouts.app')

@section('title') Supervisor Survey @endsection

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
            <h1 class="fw-bold">Supervisor ({{ $selected_supervisor->first_name }} {{ $selected_supervisor->last_name }}) Survey</h1>
        </div>

        <form class="form-group" action="{{ route('submit.supervisor.survey', ['user_id' => auth()->user()->id, 'supervisor_id' => $selected_supervisor]) }}" method="POST">
            @csrf

{{--------------------- DISPLAY ALL THE SUPERVISOR QUESTION CATEGORIES AND SURVEY QUESTIONS ---------------}}


            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($supervisor_question_categories as $question_category)
                    @php $counter = 1; @endphp
                    @foreach ($question_category->survey_question as $survey_question)
                        @if ($survey_question->appears_in == 2)
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
                                        <h4 class="btn btn-primary"> {{ $selected_supervisor->first_name }} </h4>
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" 
                                                name="ratings[{{ $survey_question->id }}]" 
                                                value="{{ $i }}">
                                                {{-- {{ old("ratings.$survey_question->id.$managing_partner->id") == $i ? 'checked' : '' }}> --}}
                                            <label>
                                                @if($i == 5) Exceptional
                                                @elseif($i == 4) Exceeds Expectations
                                                @elseif($i == 3) Meets Expectations
                                                @elseif($i == 2) Below Expectations
                                                @else Needs Improvement
                                                @endif
                                            </label>
                                        @endfor
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endforeach

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#flush-collapse" aria-expanded="false" aria-controls="flush-collapse">
                            Comments
                        </button>
                    </h2>
                    <div id="flush-collapse" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p>Write a comment for your Supervisor:</p>
                            
                            <div class="">
                                <div class="mb-2">
                                    <div class="mb-3">
                                        <label for="supervisor_comment" class="form-label">Comment Area</label>
                                        <textarea class="form-control" id="supervisor_comment" rows="3" name="supervisor_comment"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

{{--------------------- END OF SUPERVISOR QUESTION CATEGORIES AND SURVEY QUESTIONS -----------------------------------------}}

            </div>
            <input class="form-control btn btn-outline-success" type="submit">
        </form>
    </div>
</div>

@endsection