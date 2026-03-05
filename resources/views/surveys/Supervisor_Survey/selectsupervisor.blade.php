@extends('layouts.app')

@section('title') Supervisor Survey @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="mt-3">
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
        <div class="col-12">

            <div class="text-center mb-5">
                <h1 class="fw-bold">Supervisor Survey</h1>
            </div>
            
            <h4>Select Supervisor</h4>

            <form action="{{ route('display.supervisor.survey', ['user_id' => auth()->user()->id]) }}" method="POST">
                @csrf
                @foreach ($supervisors as $supervisor)
                    <input type="radio" name="supervisor" id="supervisor" value="{{ $supervisor->id }}">
                    <label for="supervisor">{{ $supervisor->initials }}</label> <br>
                @endforeach

                <div class="fw-bold">
                    <button class="btn btn-outline-success">Save!</button>
                </div>
            </form>
    </div>

</div>

@endsection