@extends('layouts.app')

@section('title') Staff Survey @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="col-12 text-center mb-4">
                <h1 class="fw-bold">Managing Parter Survey</h1>
            </div>
            
            <form class="form-group" action="#" method="POST">
                @csrf

{{--------------------- DISPLAY ALL THE COMMON SURVEY QUESTION CATEGORIES AND SURVEY QUESTIONS ---------------}}

                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($common_department_question_categories as $question_category)
                        @php $counter = 1; @endphp
                        @foreach ($question_category->survey_question as $survey_question)
                            @if ($survey_question->appears_in == 0)
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
                    
{{------------------------------------ END OF COMMON DEPARTMENT QUESTIONS -----------------------------------------}}

{{------------------- DISPLAY DEPARTMENT SPECIFIC QUESTION CATEGORIES AND QUESTIONS --------------------------------}}

                    @foreach ($department_survey_questions as $question_category)
                        
                    @if ($question_category->pivot->department_id == (int)$selected_department_id)
                        {{-- {{ dd($question_category->pivot->department_id == (int)$selected_department_id) }} --}}
                        @php $counter = 1; @endphp
                        
                        @foreach ($question_category->survey_question as $survey_question)
                            @if ($survey_question->appears_in == 1)
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

{{-------------------------------------- END OF DEPARTMENT SPECIFIC QUESTIONS -----------------------------}}

                <input class="form-control btn btn-outline-success" type="submit">
            </form>
        </div>
    </div>
</div>

@endsection