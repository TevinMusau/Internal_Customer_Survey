@extends('layouts.newapp')

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

            <div class="accordion accordion-flush" id="categoryAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Common Questions Category
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
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
                                                <div class="accordion-item">
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
                        </div>
                    </div>
                </div>
            </div>

{{------------------------------------ END OF COMMON DEPARTMENT QUESTIONS -----------------------------------------}}

{{------------------- DISPLAY DEPARTMENT SPECIFIC QUESTION CATEGORIES AND QUESTIONS --------------------------------}}

            <div class="accordion accordion-flush mt-3" id="roleSpecificAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Role-Specific Questions
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
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
                        </div>
                    </div>
                </div>
            </div>

{{-------------------------------------- END OF DEPARTMENT SPECIFIC QUESTIONS -----------------------------}}

{{----------------------------------------- START OF COMMENTS SECTION -----------------------------------------}}

            <div class="accordion accordion-flush mt-3" id="roleSpecificAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Comments Section
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#flush-collapse" aria-expanded="false" aria-controls="flush-collapse">
                                            Write a comment for each user
                                        </button>
                                    </h2>
                                    <div id="flush-collapse" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">                                            
                                            <div class="">
                                                @foreach ($department_users as $user)
                                                    <div class="mb-2">
                                                        <h4 class="btn btn-primary"> {{ $user->first_name }} </h4>

                                                        <div class="mb-3">
                                                            <textarea class="form-control" id="staff_comment" rows="3" name="staff_comment[{{ $user->id }}]" placeholder="Write comment here..."></textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{----------------------------------------- END OF COMMENTS SECTION -----------------------------------------}}

                <input class="form-control btn btn-outline-success mt-3" type="submit">
            </form>
        </div>
    </div>
</div>

@endsection