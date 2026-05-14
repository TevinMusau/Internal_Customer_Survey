@extends('layouts.newapp')

@section('title') Login @endsection

@section('content')

<div class="container w-100 p-5">
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
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <h3 class="text-center fw-bold p-4" id="Title">
                    LOGIN
                </h3>
                <form class="form-group" action="{{ route('login.post') }}" method="POST">
                    <!-- csrf is a security feature for laravel forms -->
                    @csrf
                    <div class="col-12 form-floating mb-3">
                        <input class="form-control" id="floatingEmailInput" type="text" name="email" placeholder="Enter Email Address" value="{{ old('email') }}" style="width: 500px">
                        <label for="floatingEmailInput">Email address</label>
                    </div>
                    <div class="col-12 form-floating mb-3">
                        <input class="form-control" id="floatingPasswordInput" type="password" name="password" placeholder="Enter Password" style="width: 500px">
                        <label for="floatingPasswordInput">Password</label>
                    </div>

                    <div class="row justify-content-center mt-5">
                        <div class="col-6 text-center">
                            <h5 class="mb-4"> 
                                <a class="text-decoration-none fw-bold" href="#" data-bs-toggle="modal"
                                   data-bs-target="#forgotPasswordModal" style="color: rgb(0, 97, 104)"> 
                                   Forgot Password? 
                                </a> 
                            </h5>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <button class="form-control w-25 btn btn-outline-success mb-3">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Forgot Password Modal --}}
            <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="forgotPasswordModalLabel">Forgot Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{ route('reset.link') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p class="text-muted">
                                    Enter your email address and we'll send you a link to reset your password.
                                </p>
                                <div class="form-floating mb-3">
                                    <input
                                        class="form-control"
                                        id="forgotEmailInput"
                                        type="email"
                                        name="email"
                                        placeholder="Enter your email"
                                        required
                                    >
                                    <label for="forgotEmailInput">Email address</label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" style="background-color: rgb(0, 97, 104); border-color: rgb(0, 97, 104)">
                                    Send Reset Link
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    </div>
    
</div>

@endsection