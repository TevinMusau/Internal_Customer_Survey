@extends('layouts.app')

@section('title') Dashboard @endsection

@section('content')

<div class="container-fluid w-100 p-1">
    <div class="row justify-content-center">
        <div class="mb-2 w-75">
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
    </div>
</div>

{{-- Sidebar and Content --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-3 border-end border-dark p-3">
            {{-- Sidebar Navbar --}}
            <nav class="nav sticky-top nav-pills nav-fill flex-column navbar-nav-scroll">
                <h5 class="text-center fw-bold fst-italic"> SideBar </h5>

                <a class="nav-link active" onclick="myFunction()" aria-current="page" href="#">All Users</a>
                <a class="nav-link" onclick="myFunction2()" href="#">All Admins</a>
                <a class="nav-link" onclick="myFunction3()" href="#">Surveys</a>
                <a class="nav-link" onclick="myFunction4()" href="#">Survey Questions</a>
                <a class="nav-link" onclick="myFunction5()" href="#">Launch Survey</a>
                <a class="nav-link" onclick="myFunction6()" href="#">Notifications</a>
                <a class="nav-link" onclick="myFunction7()" href="#">View Survey Reports</a>
                <a class="nav-link" onclick="myFunction8()" href="#">Comments</a>
            </nav>
        </div>

        {{-- Content --}}
        <div class="col-9">

            {{-- All Users --}}
            <div id="users" class="row">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>All Users</i>
                </h3>

                <div class="text-end">
                    <a class="" href="{{ route('new.user', ['id'=>auth()->user()->id]) }}">
                        <button class="form-control w-25 btn btn-outline-primary mb-3"> + New User </button>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless m-3">
                        <tbody>
                            <thead class="table-dark">
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Level</th>
                                @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                                    <th class="text-center" colspan="5">Action</th>
                                @endif
                            </thead>
                            @foreach ($users as $user)
                            <tr class="p-5">
                                <td class="text-center">{{ $user->first_name }}</td>
                                <td class="text-center">{{ $user->last_name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->department }}</td>
                                <td class="text-center">{{ $user->role }}</td>
                                <td class="text-center">{{ $user->level }}</td>
                                @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                                    <td class="text-center">
                                        @if ($user->level != 'superAdmin')
                                            <a class="text-decoration-none" href="{{ route('edit.user', ['admin_id' => auth()->user()->id, 'user_id' => $user->id]) }}">
                                                <button class="btn btn-outline-primary" title="Edit User">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                    @if (auth()->user()->id != $user->id)
                                        @if($user->level != 'superAdmin')
                                            <td class="text-center">
                                                <span>
                                                    <a class="text-decoration-none" 
                                                        onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" 
                                                        href="{{ route('delete.user', ['admin_id' => auth()->user()->id, 'user_id' => $user->id]) }}">
                                                        <button class="btn btn-outline-danger" title="Delete User">
                                                            <i class="bi bi-trash3"></i>
                                                        </button> 
                                                    </a>
                                                </span>
                                            </td>
                                        @endif
                                    @endif
                                @endif
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            {{-- All Admins --}}
            <div id="admins" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>All Admins</i>
                </h3>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless m-3">
                        <tbody>
                            <thead class="table-dark">
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Level</th>
                                @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                                <th class="text-center" colspan="5">Action</th>
                                @endif
                            </thead>
                            @foreach ($admins as $admin)
                            <tr>
                                <td class="text-center">{{ $admin->first_name }}</td>
                                <td class="text-center">{{ $admin->last_name }}</td>
                                <td class="text-center">{{ $admin->email }}</td>
                                <td class="text-center">{{ $admin->department }}</td>
                                <td class="text-center">{{ $admin->role }}</td>
                                <td class="text-center">{{ $admin->level }}</td>
                                @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                                    <td class="text-center">
                                        @if ($admin->level != 'superAdmin')
                                            <a class="text-decoration-none" href="{{ route('edit.user', ['admin_id' => auth()->user()->id, 'user_id' => $admin->id]) }}">
                                                <button class="btn btn-outline-primary" title="Edit User">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                    @if (auth()->user()->id != $admin->id)
                                        @if($admin->level != 'superAdmin')
                                            <td class="text-center">
                                                <a class="text-decoration-none" 
                                                    onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" 
                                                    href="{{ route('delete.user', ['admin_id' => auth()->user()->id, 'user_id' => $admin->id]) }}">
                                                    <button class="form-control btn btn-outline-danger mb-3" title="Delete User">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </a>
                                                {{-- <span>
                                                    <button class="form-control w-25 btn btn-outline-danger mb-3">Delete</button>
                                                </span> --}}
                                            </td>
                                        @endif
                                    @endif
                                @endif
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>


            {{-- Surveys --}}
            <div id="surveys" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>Surveys</i>
                </h3>

                <div class="container-fluid w-75">
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <a class="text-decoration-none" href="#" id="survey">
                                <div class="card" style="width: 11rem">
                                    <img src="{{ asset('Logo/MMAN_Temp_Logo.png') }}" class="card-img-top" alt="Card_Img">
                                    <div class="card-body text-center">
                                        <p class="card-text text-wrap fw-bold fst-italic" style="color: #BC8F8F"> Staff<br/> Survey </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4">
                            <a class="text-decoration-none" href="#" id="survey">
                                <div class="card" style="width: 10rem">
                                    <img src="{{ asset('Logo/MMAN_Temp_Logo.png') }}" class="card-img-top" alt="Card_Img">
                                    <div class="card-body text-center">
                                        <p class="card-text text-wrap fw-bold fst-italic" style="color: #BC8F8F"> Managing Partner Survey </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4">
                            <a class="text-decoration-none" href="#" id="survey">
                                <div class="card" style="width: 11rem">
                                    <img src="{{ asset('Logo/MMAN_Temp_Logo.png') }}" class="card-img-top" alt="Card_Img">
                                    <div class="card-body text-center">
                                        <p class="card-text text-wrap fw-bold fst-italic" style="color: #BC8F8F"> Supervisor<br/> Survey </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>

            {{-- Survey Questions --}}
            <div id="questions" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>Survey Questions</i>
                </h3>

                <p class="text-center">Display Survey Questions Here</p>

            </div>

            {{-- Launch Survey --}}
            <div id="launch_survey" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>Launch Survey</i>
                </h3>

                <p class="text-center">Launch Survey Here</p>

            </div>

            {{-- Notifications --}}
            <div id="notifications" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>Notifications</i>
                </h3>

                <p class="text-center">Display Notifications Here</p>

            </div>

            {{-- Survey Reports --}}
            <div id="survey_reports" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>Survey Reports</i>
                </h3>

                <p class="text-center">Display Survey Reports Here</p>

            </div>

            {{-- Comments --}}
            <div id="comments" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>Comments</i>
                </h3>

                <p class="text-center">Display Comments Here</p>

            </div>
        </div>
    </div>
</div>

<script>
    // This segment allows us to switch from one tab to another
    const navLinkEls = document.querySelectorAll('.nav-link');

    navLinkEls.forEach(navLinkEls => {
        navLinkEls.addEventListener('click', () => {
            document.querySelector('.active')?.classList.remove('active');            
            navLinkEls.classList.add('active');
        });
    });

    // this segment displays information depending on the sidebar item selected
    function myFunction(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");


        users.style.display = 'block';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        comments.style.display = 'none';

    }

    function myFunction2(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");

        users.style.display = 'none';
        admins.style.display = 'block';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        comments.style.display = 'none';
    }

    function myFunction3(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");

        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'block';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        comments.style.display = 'none';
    }

    function myFunction4(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");

        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'block';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        comments.style.display = 'none';
    }

    function myFunction5(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");

        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'block';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        comments.style.display = 'none';
    }

    function myFunction6(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");

        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'block';
        survey_reports.style.display = 'none';
        comments.style.display = 'none';
    }

    function myFunction7(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");

        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'block';
        comments.style.display = 'none';
    }

    function myFunction8(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");
        var comments = document.getElementById("comments");

        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        comments.style.display = 'block';
    }

    // function myFunction7(){
    //     var users = document.getElementById("users");
    //     var admins = document.getElementById("admins");
    //     var surveys = document.getElementById("surveys");
    //     var questions = document.getElementById("questions");
    //     var launch_survey = document.getElementById("launch_survey");
    //     var notifications = document.getElementById("notifications");
    //     var survey_reports = document.getElementById("survey_reports");


    //     users.style.display = 'none';
    //     admins.style.display = 'none';
    //     surveys.style.display = 'none';
    //     questions.style.display = 'none';
    //     launch_survey.style.display = 'none';
    //     notifications.style.display = 'none';
    //     survey_reports.style.display = 'none';
    //     rejected.style.display = 'block';
    // }
</script>


@endsection