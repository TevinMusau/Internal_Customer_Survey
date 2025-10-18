@extends('layouts.app')

@section('title') Create New User @endsection

@section('content')

<div class="container-fluid border border-3 w-50 p-2">
    <div class="col-12">
        <h3 class="text-center fw-bold fst-italic m-5 mb-2" id="Title">
            Create New User 
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

            <form class="form-group" action="{{ route('createNewUser', ['id' => auth()->user()->id]) }}" method="POST">
                <!-- csrf is a security feature for laravel forms -->
                @csrf
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='fname' placeholder="Enter First Name">
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='lname' placeholder="Enter Last Name">
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="email" name='email' placeholder="Enter Email Address">
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='department' placeholder="Enter Department">
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='role' placeholder="Enter Role">
                </div>
                
                <h5 class="text-center fw-bolder mt-2"> Select the User's level 
                    <i class="bi bi-info-circle cursor-pointer text-primary h6" 
                        title=" 
* Super Admin - Reserved for IT 
* Staff Admin - Reserved for HR
* Regular Admin - Reserved for Partners
* Normal User - Reserved for any other user
                        ">
                    </i>                       
                </h5>
                <div class="d-flex flex-row mb-5 text-center">
                    @if (auth()->user()->level == 'superAdmin')
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <input type="radio" name="super_admin" id="super_admin" value="super_admin">
                            <label class="btn btn-info" for="super_admin">Super Admin</label>
                        </div>
                    @else
                        <div class="">
                            <input type="radio" name="user_level" id="super_admin" value="super_admin" disabled>
                            <label class="btn btn-info disabled" for="super_admin" aria-disabled="true">Super Admin</label>
                        </div>
                    @endif
                    
                    <div class="">
                        <input type="radio" name="user_level" id="staff_admin" value="staff_admin">
                        <label class="btn btn-warning" for="staff_admin">Staff Admin</label>
                    </div>
                    <div class="">
                        <input type="radio" name="user_level" id="regular_admin" value="regular_admin">
                        <label class="btn btn-secondary" for="regular_admin">Regular Admin</label>
                    </div>
                    <div class="">
                        <input type="radio" name="user_level" id="normal_user" value="normal_user" checked>
                        <label class="btn btn-success" for="normal_user">Normal User</label>
                    </div>
                </div>

                <div class="col-12 p-3 border border-bottom border-top" style="background-color: #DCDCDC">
                    <h6> <strong> The Password Must: </strong> </h6>
                    <ul> 
                        <li> Contain at least 8 characters </li> 
                        <li> Contain at least 1 lowercase character </li>
                        <li> Contain at least 1 uppercase character </li>
                        <li> Contain at least 1 special character </li>
                    </ul>
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="password" name='password' placeholder="Enter Password">
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="password" name='password_confirmation' placeholder="Confirm Password">
                </div>

                <div class="row justify-content-center">
                    <div class="text-center m-3">
                        <button class="form-control w-50 btn btn-outline-success">Create New User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection