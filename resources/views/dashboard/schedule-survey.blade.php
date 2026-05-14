@extends('layouts.newapp')

@section('title') Schedule A Survey @endsection

@section('content')

<style>
    /* Section pills */
    .section-pill {
        background: rgba(232, 104, 40, 0.12);
        color: rgb(180, 70, 15);
        font-size: 19px;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 1rem;
    }
</style>

<div id="users" class="row">
    <div class="section-pill fw-bold d-flex justify-content-center align-items-center">
        <h3 class="fw-bold p-2 m-0">
            Schedule Survey
        </h3>
    </div>


{{-- ------------------------------------------ FORM -------------------------------------------------------- --}}

    @if (auth()->user()->level != 'superAdmin' && auth()->user()->level != 'staffAdmin')
        <h3 class="text-center fw-bold p-4" id="Title">
            <i>You don't have permissions to perform this action!!!!</i>
        </h3>
    @else
        @if ($scheduled_survey)
            <h3 class="text-center fw-bold p-4" id="Title">
                <i>There is an already active survey. You cannot create another!</i>
            </h3>

            <form action="{{ route('edit.scheduled.survey', ['user_id' => auth()->user()->id, 'scheduled_survey_id' => $scheduled_survey->id]) }}" method="POST">
                @csrf
                <div class="text-center">
                    <label class="form-label fw-bold" for="survey_name">Survey Name</label>
                    <input class="form-control mx-auto w-25" type="text" name="survey_name" value="{{ $scheduled_survey->survey_name }}" placeholder="e.g. ICS - H1 202x" title="Enter End Time">
                </div>

                <div class="col-12 d-flex gap-3">
                    <div class="col-6">
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="date" name="start_date" value="{{ $scheduled_survey->start_date }}" placeholder="Start Date" title="Start Date">
                        </div>
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="time" name="time_start" disabled value="{{ $scheduled_survey->start_time }}" placeholder="Start Time" title="Start Time">
                            <input class="form-control" type="hidden" name="start_time" value="{{ $scheduled_survey->start_time }}" placeholder="Start Time" title="Start Time">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="date" name="end_date" value="{{ $scheduled_survey->end_date }}" placeholder="End Date" title="End Date">
                        </div>
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="time" name="end_time" value="{{ $scheduled_survey->end_time }}" placeholder="End Time" title="End Time">
                        </div>
                    </div>
                </div>

                <div class="fw-bold mt-4">
                    <button class="btn btn-outline-success">Schedule a Survey!</button>
                </div>
            </form>

        @else
            <form action="{{ route('schedule.survey', ['user_id' => auth()->user()->id]) }}" method="POST">
                @csrf
                <div class="text-center">
                    <label class="form-label fw-bold" for="survey_name">Survey Name</label>
                    <input class="form-control mx-auto w-25" type="text" name="survey_name" placeholder="e.g. ICS - H1 202x" title="Enter End Time">
                </div>

                <div class="col-12 d-flex gap-3">
                    <div class="col-6">
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="date" name="start_date" placeholder="Enter Start Date" title="Enter Start Date">
                        </div>
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="time" name="start_time" placeholder="Enter Start Time" title="Enter Start Time">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="date" name="end_date" placeholder="Enter End Date" title="Enter End Date">
                        </div>
                        <div class="ms-5 mt-3">
                            <input class="form-control" type="time" name="end_time" placeholder="Enter End Time" title="Enter End Time">
                        </div>
                    </div>
                </div>

                <div class="fw-bold mt-4">
                    <button class="btn btn-outline-success">Schedule a Survey!</button>
                </div>
            </form>
        @endif
        
    @endif
@endsection