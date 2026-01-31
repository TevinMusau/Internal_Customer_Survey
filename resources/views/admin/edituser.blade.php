@extends('layouts.app')

@section('title') Edit User Details @endsection

@section('content')

<div class="container-fluid border border-3 w-50 p-2">
    <div class="col-12">
        <h3 class="text-center fw-bold fst-italic m-5 mb-2" id="Title">
            Edit User Info
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

            <form class="form-group" action="{{ route('edit.user.post', ['admin_id' => auth()->user()->id, 'user_id' => $user->id]) }}" method="POST">
                <!-- csrf is a security feature for laravel forms -->
                @csrf
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='fname' value="{{ $user->first_name }}" placeholder="Enter First Name">
                </div>
                @if ($user->middle_name)
                    <div class="col-12 text-center p-3">
                        <input class="form-control" type="text" name='mname' value="{{ $user->middle_name }}" placeholder="Enter Middle Name">
                    </div>
                @else
                    <div class="col-12 text-center p-3">
                        <input class="form-control" type="text" name='mname' value="N/A" placeholder="Enter Middle Name">
                    </div>
                @endif
                
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='lname' value="{{ $user->last_name }}" placeholder="Enter Last Name">
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='initials' value="{{ $user->initials }}" placeholder="Enter Initials">
                </div>
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="email" name='email' value="{{ $user->email }}" placeholder="Enter Email Address">
                </div>

                <div class="col-12 p-3 border border-bottom border-top" style="background-color: #F0FFFF">
                    <h6> <strong> Edit the User's Department: </strong> </h6>

                    @foreach ($departments as $department)
                    <div class="form-check">
                        <div class="d-flex justify-content-evenly">
                            <input class="btn-check" type="checkbox" name="department_selection[]" value="{{ $department->id }}" id="department_selection_{{ $department->id }}" autocomplete="off" {{ $department->id == $user->departments->contains($department->id) ? 'checked' : ''}} >
                            <label class="btn btn-outline-info" for="department_selection_{{ $department->id }}"> {{ $department->name }} </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='department' value="{{ $user->departments->pluck('name')->join(', ') }}" placeholder="Enter Department">
                </div> --}}
                <div class="col-12 text-center p-3">
                    <input class="form-control" type="text" name='role' value="{{ $user->role }}" placeholder="Enter Role">
                </div>
                <div class="form-check form-switch ms-3 mt-3 mb-4">
                    @if ($user->isSupervisor)
                        <input class="form-check-input" type="checkbox" name="supervisor" role="switch" id="supervisor" checked>
                    @else
                        <input class="form-check-input" type="checkbox" name="supervisor" role="switch" id="supervisor">

                    @endif
                    <label class="form-check-label" for="supervisor">Is this user a supervisor?</label>
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
                            <input type="radio" name="user_level" id="super_admin" value="superAdmin" {{ $user->level == 'superAdmin' ? 'checked' : '' }}>
                            <label class="btn btn-info" for="super_admin">Super Admin</label>
                        </div>
                    @else
                        <div class="">
                            <input type="radio" name="user_level" id="super_admin" value="superAdmin" disabled {{ $user->level == 'superAdmin' ? 'checked' : '' }}>
                            <label class="btn btn-info disabled" for="super_admin" aria-disabled="true">Super Admin</label>
                        </div>
                    @endif
                    
                    <div class="">
                        <input type="radio" name="user_level" id="staff_admin" value="staffAdmin" {{ $user->level == 'staffAdmin' ? 'checked' : '' }}>
                        <label class="btn btn-warning" for="staff_admin">Staff Admin</label>
                    </div>
                    <div class="">
                        <input type="radio" name="user_level" id="regular_admin" value="regularAdmin" {{ $user->level == 'regularAdmin' ? 'checked' : '' }}>
                        <label class="btn btn-secondary" for="regular_admin">Regular Admin</label>
                    </div>
                    <div class="">
                        <input type="radio" name="user_level" id="normal_user" value="normalUser" {{ $user->level == 'normalUser' ? 'checked' : '' }}>
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
                        <button class="form-control w-50 btn btn-outline-success">Edit User Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection