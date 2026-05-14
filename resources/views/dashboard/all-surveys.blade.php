@extends('layouts.newapp')

@section('title') All Surveys @endsection

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

<div class="row">
    <div class="section-pill fw-bold d-flex justify-content-start align-items-start">
        <h3 class="fw-bold p-2 m-0">
            Take Survey
        </h3>
    </div>

{{-- ------------------------------------------ TABLE -------------------------------------------------------- --}}

    <div class="container-fluid w-75">
        <div class="row justify-content-center">
            @if(!$completed_staff_survey)
                <div class="col-auto mt-4">
                    <a class="text-decoration-none" href="{{ route('staffsurveypage.intro', ['user_id' => auth()->user()->id]) }}" id="survey">
                        <div class="stat-card">
                            <i class="bi bi-bar-chart-fill" style=""></i><br>
                            <p class="card-label">Staff Survey</p>
                            <p class="card-number" data-target="20">0</p>

                            <div class="shimmer"></div>
                        </div>
                    </a>
                </div>
            @endif
            @if (!$completed_supervisor_survey)
                <div class="col-auto mt-4">
                    <a class="text-decoration-none" href="{{ route('supervisorsurveypage.intro', ['user_id' => auth()->user()->id]) }}" id="survey">
                        <div class="stat-card">
                            <i class="bi bi-bar-chart-fill" style=""></i><br>
                            <p class="card-label">Supervisor Survey</p>
                            <p class="card-number" data-target="20">0</p>

                            <div class="shimmer"></div>
                        </div>
                    </a>
                </div>
            @endif
            @if (!$completed_managing_partner_survey)
                <div class="col-auto mt-4">
                    <a class="text-decoration-none" href="{{ route('mp.survey.intro', ['user_id' => auth()->user()->id]) }}" id="survey">
                        <div class="stat-card">
                            <i class="bi bi-bar-chart-fill" style=""></i><br>
                            <p class="card-label">Managing Partner Survey</p>
                            <p class="card-number" data-target="20">0</p>

                            <div class="shimmer"></div>
                        </div>
                    </a>
                </div>
            @endif
            @if ((auth()->user()->level == 'regularAdmin') || (auth()->user()->level == 'superAdmin'))
                @if (!$completed_managing_partner_survey)
                    <div class="col-auto mt-4">
                        <a class="text-decoration-none" href="{{ route('mp.survey.intro', ['user_id' => auth()->user()->id]) }}" id="survey">
                            <div class="stat-card">
                                <i class="bi bi-bar-chart-fill" style=""></i><br>
                                <p class="card-label">Partners Survey</p>
                                <p class="card-number" data-target="20">0</p>
                                <div class="shimmer"></div>
                            </div>
                        </a>
                    </div>
                @endif
            @endif
        </div>
        
    </div>
</div>

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