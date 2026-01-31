@extends('layouts.app')

@section('title') Create New Department @endsection

@section('content')

<div class="container-fluid border border-3 w-50 p-2">
    <div class="col-12">
        <h3 class="text-center fw-bold fst-italic m-5 mb-2" id="Title">
            Create New Department 
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

            <form class="form-group" action="#" method="POST">
                <!-- csrf is a security feature for laravel forms -->
                @csrf
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='department_name' placeholder="Enter Department Name">
                </div>

                <div class="row justify-content-center">
                    <div class="text-center m-3">
                        <button class="form-control w-50 btn btn-outline-success">Create New Department</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection