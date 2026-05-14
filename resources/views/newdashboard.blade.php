@extends('layouts.newapp')

@section('title') Dashboard @endsection

@section('content')

<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        min-width: 148px;
        min-height: 120px;
        background-color: rgb(0, 97, 104);
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        padding: 1rem 1.1rem;
        justify-content: space-between;
        border-bottom: 3px solid rgb(232, 104, 40);

        /* Entrance animation */
        opacity: 1;
        transform: translateY(20px);
        animation: cardEntrance 0.4s ease forwards;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 57, 61, 0.25);
    }

    /* Glow orb in top right */
    .stat-card::before {
        content: '';
        position: absolute;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        top: -20px;
        right: -20px;
        pointer-events: none;
    }

    .stat-card .card-label {
        font-size: 13px;
        color: white;
        font-weight: bold;
        margin: 0 0 6px;
    }

    .stat-card .card-number {
        font-size: 28px;
        font-weight: 500;
        color: rgb(232, 104, 40);
        font-weight: bold;
        margin: 0;
    }

    .shimmer {
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.45) 50%,
            transparent 100%
        );
        transform: skewX(-15deg);
        animation: shimmer 10s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 8%   { left: -100%; }  /* sits off-screen */
        12%, 100% { left: 160%; }  /* sweeps across and parks off the other side */
    }

    i{
        font-size: 1.2rem;
        color: rgba(255,255,255, 0.7);
    }

    /* Divider */
    .section-divider {
        height: 1px;
        background: linear-gradient(to right, rgba(0, 97, 104, 2));
        margin: 1.5rem 0;
        border: none;
    }

    #row{
        gap: 12px;
    }

    #row-staff {
        gap: 30px;
    }

    .dropdown-menu {
        z-index: 1050;
    }

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

<body>
    <div class="container-fluid w-100 p-1">
        <div class="row justify-content-center">
            <div class="mb-2 w-75 text-center">
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
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible fade show">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    </div>
                @endif

                @if(session()->has('danger'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('danger') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {!!  session('success') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav> --}}

    <div class="row mt-5" id="row">
        <div class="section-pill fw-bold">
            <i class="bi bi-person-lines-fill" style="color: rgb(232, 104, 40);"></i>
            <span>User Management</span>
        </div>
        <div class="col-auto">
            <a href="{{ route('view.allusers', ['id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                    <i class="bi bi-people-fill" style=""></i><br>
                    <p class="card-label">Total Users</p>
                    <p class="card-number" data-target="{{ $user_count }}">0</p>
                    <div class="shimmer"></div>
                </div>
            </a>
        </div>
        <div class="col-auto">
            <a href="{{ route('view.alladmins', ['id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                        <i class="bi bi-shield-fill" style=""></i><br>
                        <p class="card-label">Total Admins</p>
                        <p class="card-number" data-target="{{ $admin_count }}">0</p>
                        <div class="shimmer"></div>
                </div>
            </a>
        </div>
        <div class="col-auto">
            <a href="{{ route('view.alldepartments', ['id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                    <i class="bi bi-diagram-3-fill" style=""></i><br>
                    <p class="card-label">Total Departments</p>
                    <p class="card-number" data-target="{{ $department_count }}">0</p>
                    <div class="shimmer"></div>
                </div>
            </a>
        </div>
        <div class="col-auto">
            <div class="stat-card">
                <i class="bi bi-ban" style=""></i><br>
                <p class="card-label">Deactivated User Accounts</p>
                <p class="card-number" data-target="20">0</p>
                <div class="shimmer"></div>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    <div class="row mt-4" id="row-staff">
        <div class="section-pill fw-bold">
            <i class="bi bi-kanban-fill" style="color: rgb(232, 104, 40);"></i>
            Survey Management
        </div>
        {{-- <div class="col-auto mt-4">
            <div class="stat-card">
                <i class="bi bi-bar-chart-fill" style=""></i><br>
                <p class="card-label">Staff Survey Results</p>
                <p class="card-number" data-target="20">0</p>

                <div class="shimmer"></div>
            </div>
        </div>
        <div class="col-auto mt-4">
            <div class="stat-card">
                <i class="bi bi-bar-chart-steps" style=""></i><br>
                <p class="card-label">Managing Partner Survey Results</p>
                <p class="card-number" data-target="20">0</p>

                <div class="shimmer"></div>
            </div>
        </div>
        <div class="col-auto mt-4">
            <div class="stat-card">
                <i class="bi bi-clipboard-data-fill" style=""></i><br>
                <p class="card-label">Supervisor Survey Results</p>
                <p class="card-number" data-target="20">0</p>

                <div class="shimmer"></div>
            </div>
        </div> --}}
        <div class="col-auto mt-4">
            <div class="stat-card">
                <i class="bi bi-file-earmark-bar-graph-fill" style=""></i><br>
                <p class="card-label">Survey Reports</p>
                <p class="card-number" data-target="20">0</p>

                <div class="shimmer"></div>
            </div>
        </div>
        
        <div class="col-auto mt-4">
            <a href="{{ route('schedule.survey.page', ['user_id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                    <i class="bi bi-send-fill" style=""></i><br>
                    <p class="card-label">Launch Survey</p>
                    <p class="card-number" data-target="20">0</p>

                    <div class="shimmer"></div>
                </div>
            </a>
        </div>

        <div class="col-auto mt-4">
            <a href="{{ route('survey.respondents', ['user_id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                    <i class="bi bi-person-lines-fill" style=""></i><br>
                    <p class="card-label">Survey Respondents</p>
                    <p class="card-number" data-target="20">0</p>

                    <div class="shimmer"></div>
                </div>
            </a>
        </div>

        <div class="col-auto mt-4">
            <a href="{{ route('survey.questions', ['user_id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                    <i class="bi bi-question-circle-fill" style=""></i><br>
                    <p class="card-label">Survey Questions</p>
                    <p class="card-number" data-target="20">0</p>

                    <div class="shimmer"></div>
                </div>
            </a>
        </div>

        <div class="col-auto mt-4">
            <a href="{{ route('view.surveys', ['user_id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                    <i class="bi bi-pencil-fill" style=""></i><br>
                    <p class="card-label">Take Survey</p>
                    <p class="card-number" data-target="20">0</p>

                    <div class="shimmer"></div>
                </div>
            </a>
        </div>
    </div>

    <hr class="section-divider">

    <div class="row mt-4" id="row">
        <div class="section-pill fw-bold">
            <i class="bi bi-briefcase-fill" style="color: rgb(232, 104, 40);"></i>
            Staff Management
        </div>
        <div class="col-auto mt-4">
            <a href="{{ route('view.allcomments', ['user_id' => auth()->user()->id]) }}" style="text-decoration: none">
                <div class="stat-card">
                    <i class="bi bi-chat-dots-fill" style=""></i><br>
                    <p class="card-label">All Comments</p>
                    <p class="card-number" data-target="{{ $comments_count }}">0</p>

                    <div class="shimmer"></div>
                </div>
            </a>
        </div>
    </div>

    <hr class="section-divider">

    <div class="row mt-4" id="row">
        <div class="section-pill fw-bold">
            <i class="bi bi-gear-fill" style="color: rgb(232, 104, 40);"></i>
            Settings
        </div>
        {{-- <div class="col-auto mt-4">
            <div class="stat-card">
                <i class="bi bi-star-fill" style=""></i><br>
                <p class="card-label">New Rating Scheme</p>
                <p class="card-number" data-target="20">0</p>

                <div class="shimmer"></div>
            </div>
        </div> --}}
        <div class="col-auto mt-4">
            <div class="stat-card">
                <i class="bi bi-sliders" style=""></i><br>
                <p class="card-label">User Preferences</p>
                <p class="card-number" data-target="20">0</p>

                <div class="shimmer"></div>
            </div>
        </div>
        <div class="col-auto mt-4">
            <div class="stat-card">
                <i class="bi bi-envelope-at-fill" style=""></i><br>
                <p class="card-label">Reminder Email</p>
                <p class="card-number" data-target="20">0</p>

                <div class="shimmer"></div>
            </div>
        </div>
    </div>
</body>

<script>
    function animateCounter(el, target, duration = 1500) {
        const start = performance.now();
        const update = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target).toLocaleString();
            if (progress < 1) requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    }

    document.querySelectorAll('.card-number[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target, 10);
        if (!isNaN(target)) animateCounter(el, target);
    });

</script>

@endsection