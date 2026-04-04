@extends('layouts.app')

@section('title') Edit Question Details @endsection

@section('content')

<div class="container-fluid border border-3 w-50 p-2">
    <div class="col-12">
        <h3 class="text-center fw-bold fst-italic m-5 mb-2" id="Title">
            Edit Question
        </h3>

        <div class="row">
            <div class="mt-1">
                @if($errors->any())
                    <div class="col-12">
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                        @endforeach
                    </div>
                @endif
    
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
    
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <form class="form-group" action="{{ route('edit.question.post', ['survey_question_id' => $survey_question->id, 'user_id' => auth()->user()->id]) }}" method="POST">
                <!-- csrf is a security feature for laravel forms -->
                @csrf
                <div class="col-12 text-center p-3">
                    <div class="col-12 text-center p-3"></div>
                        <label for="category-select" class="form-label fw-500">Question Category</label>
                        <select name="question_category_id" id="category-select" class="form-select">
                            <option value="" disabled>Select a question category</option>
                            @foreach ($question_categories as $category)
                                @if ($survey_question->question_category_id == $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->category_name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="sub_category_name" class="form-label fw-500">Question Category Name</label>
                        <input class="form-control" type="text" name='sub_category_name' value="{{ $survey_question->sub_category_name }}" placeholder="Enter Sub Category Name">
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="sub_category_description" class="form-label fw-500">Question Category Description</label>
                        <input class="form-control" type="text" name='sub_category_description' value="{{ $survey_question->sub_category_description }}" placeholder="Enter Sub Category Name">
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="sub_category_question" class="form-label fw-500">Question</label>
                        <input class="form-control" type="text" name='sub_category_question' value="{{ $survey_question->question }}" placeholder="Enter Sub Category Question">
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="survey-select" class="form-label fw-500">Survey Selection</label>
                        <select name="survey_question_survey_selection" id="survey-select" class="form-select">
                            <option value="" disabled>Select a survey the question will appear in</option>
                            <option value="0" {{ $survey_question->appears_in == 0 ? 'selected' : '' }}>All Surveys</option>
                            <option value="1" {{ $survey_question->appears_in == 1 ? 'selected' : '' }}>Staff Survey</option>
                            <option value="2" {{ $survey_question->appears_in == 2 ? 'selected' : '' }}>Supervisor Survey</option>
                            <option value="3" {{ $survey_question->appears_in == 3 ? 'selected' : '' }}>Managing Partner Survey</option>
                        </select>
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="department-select" class="form-label fw-500">Department Selection</label>
                        <select name="survey_question_department_selection[]" id="department-select" class="form-select" multiple>
                            <option value="1" @selected($allSelected)>All Departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(!$allSelected && in_array($department->id, $linkedDepartmentIds))>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row justify-content-center">
                        <div class="text-center m-3">
                            <button class="form-control w-50 btn btn-outline-success">Edit Question</button>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div>

@endsection