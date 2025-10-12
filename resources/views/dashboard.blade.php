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
            </nav>
        </div>

        {{-- Content --}}
        <div class="col-9">

            {{-- All Users --}}
            <div id="users" class="row">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>All Users</i>
                </h3>

                <p class="text-center">Display Users Here</p>

            </div>

            {{-- All Admins --}}
            <div id="admins" class="row" style="display: none">
                <h3 class="text-center fw-bold p-4" id="Title">
                    <i>All Admins</i>
                </h3>

                <p class="text-center">Display Admins Here</p>

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


        users.style.display = 'block';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction2(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");

        users.style.display = 'none';
        admins.style.display = 'block';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction3(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");


        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'block';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction4(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");


        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'block';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction5(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");


        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'block';
        notifications.style.display = 'none';
        survey_reports.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction6(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");


        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'block';
        survey_reports.style.display = 'none';
        rejected.style.display = 'none';
    }

    function myFunction7(){
        var users = document.getElementById("users");
        var admins = document.getElementById("admins");
        var surveys = document.getElementById("surveys");
        var questions = document.getElementById("questions");
        var launch_survey = document.getElementById("launch_survey");
        var notifications = document.getElementById("notifications");
        var survey_reports = document.getElementById("survey_reports");


        users.style.display = 'none';
        admins.style.display = 'none';
        surveys.style.display = 'none';
        questions.style.display = 'none';
        launch_survey.style.display = 'none';
        notifications.style.display = 'none';
        survey_reports.style.display = 'block';
        rejected.style.display = 'none';
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