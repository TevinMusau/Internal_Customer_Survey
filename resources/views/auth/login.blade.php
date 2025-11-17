@extends('layouts.app')

@section('title') Login @endsection

@section('content')

<h3 class="text-center fw-bold p-4" id="Title">
    <i>LOGIN</i>
</h3>

<div class="container-fluid w-50 border p-3">
    <div class="row justify-content-center">
        <div class="mt-5">
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
        <form class="form-group" action="{{ route('login.post') }}" method="POST">
            <!-- csrf is a security feature for laravel forms -->
            @csrf
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="text" name="email" placeholder="Enter Email Address" value="{{ old('email') }}" style="width: 500px">
            </div>
            <div class="col-12 text-center m-2 p-3">
                <input class="form-control" type="password" name="password" placeholder="Enter Password" style="width: 500px">
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-6 text-center">
                    <h5 class="mb-4"> <a class="text-decoration-none" href="/forgotpassword" style="color: #FF1493"> Forgot Password </a> </h5>
                </div>
                <div class="col-6 text-center">
                    <h5 class="mb-4"> <a class="text-decoration-none" href="/register" style="color: #FF1493"> Create an Account </a> </h5>
                </div>
            </div>

            <div class="row justify-content-center">
                <button class="form-control w-25 btn btn-outline-success mb-3">Sign In</button>
            </div>

        </form>

    </div>
    
</div>

@endsection