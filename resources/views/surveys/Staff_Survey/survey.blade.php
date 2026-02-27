@extends('layouts.app')

@section('title') Staff Survey @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="col-12 text-center mb-4">
                <h1 class="fw-bold">Staff Survey</h1>
            </div>
            
            <form class="form-group" action="{{ route('submit.staff.survey', ['department_id' => (int)$selected_department_id, 'user_id' => auth()->user()->id]) }}" method="POST">
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
                                                @foreach ($department_users as $user)
                                                    <div class="mb-2">
                                                        <h4 class="btn btn-primary"> {{ $user->first_name }} </h4>

                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <input type="radio" 
                                                                name="ratings[{{ $survey_question->id }}][{{ $user->id }}]" 
                                                                value="{{ $i }}"
                                                                {{ old("ratings.$survey_question->id.$user->id") == $i ? 'checked' : '' }}>
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
                                                @endforeach
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
                    {{-- {{ dd((int)$question_category->department->pluck('id')[0]) }} --}}

                    @if ((int)$question_category->department->pluck('id')[0] == (int)$selected_department_id)
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
                                                @foreach ($department_users as $user)
                                                    <div class="mb-2">
                                                        <h4 class="btn btn-primary"> {{ $user->first_name }} </h4>

                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <input type="radio" 
                                                                name="ratings[{{ $survey_question->id }}][{{ $user->id }}]" 
                                                                value="{{ $i }}"
                                                                {{ old("ratings.$survey_question->id.$user->id") == $i ? 'checked' : '' }}>
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
                                                @endforeach
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
                                                @foreach ($department_users as $user)
                                                    <div class="mb-2">
                                                        <h4 class="btn btn-primary"> {{ $user->first_name }} </h4>

                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <input type="radio" 
                                                                name="ratings[{{ $survey_question->id }}][{{ $user->id }}]" 
                                                                value="{{ $i }}"
                                                                {{ old("ratings.$survey_question->id.$user->id") == $i ? 'checked' : '' }}>
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
                                                @endforeach
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