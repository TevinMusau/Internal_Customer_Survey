@extends('layouts.newapp')

@section('title') All Users @endsection

@section('content')

<style>
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

<div id="users" class="row">
    <div class="section-pill fw-bold d-flex justify-content-center align-items-center">
        <h3 class="fw-bold p-2 m-0">
            Survey Respondents
        </h3>
    </div>

    @for ($i = 0; $i < 3; $i++)
        <div class="mt-4">
            @if ($i==0) <p class="h5 text-center fw-bold mb-5">Completed Managing Partner Survey</p> @endif
            @if ($i==1) <p class="h5 text-center fw-bold mt-4 mb-5">Completed Staff Survey</p> @endif
            @if ($i==2) <p class="h5 text-center fw-bold mt-4 mb-5">Completed Supervisor Survey</p> @endif
{{-- ----------------------------------------- FILTERS -------------------------------------------------------- --}}

            <form method="GET" action="#" class="d-flex flex-wrap gap-2 align-items-center m-3">
                <input type="text" name="name" value="{{ request('name') }}"
                        class="form-control form-control-sm" style="width:160px" placeholder="Search name...">

                <a href="#"
                    class="btn btn-sm btn-outline-secondary">
                    {{ request('sort', 'asc') == 'asc' ? 'A → Z' : 'Z → A' }}
                </a>

                <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>

                <a href="#" class="btn btn-sm btn-outline-secondary">Clear</a>

            </form>

        {{-- ------------------------------------------ TABLE -------------------------------------------------------- --}}

            <div class="table-responsive">
                <table class="table table-hover table-striped table-borderless m-3">
                    <thead>
                        <tr>
                            <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">First Name</th>
                            <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Last Name</th>
                            <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Initials</th>
                            <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($i==0)
                            @foreach ($completed_mp_survey as $user) 
                                <tr class="p-5">
                                    <td class="text-center">{{ $user->user->first_name }}</td>
                                    <td class="text-center">{{ $user->user->last_name }}</td>
                                    <td class="text-center">{{ $user->user->initials }}</td>
                                    <td class="text-center">{{ $user->user->email }}</td>
                                </tr>
                            @endforeach
                        @endif
                        @if ($i==1)
                            @foreach ($completed_staff_survey as $user) 
                                <tr class="p-5">
                                    <td class="text-center">{{ $user->user->first_name }}</td>
                                    <td class="text-center">{{ $user->user->last_name }}</td>
                                    <td class="text-center">{{ $user->user->initials }}</td>
                                    <td class="text-center">{{ $user->user->email }}</td>
                                </tr>
                            @endforeach
                        @endif
                        @if ($i==2)
                            @foreach ($completed_supervisor_survey as $user) 
                                <tr class="p-5">
                                    <td class="text-center">{{ $user->user->first_name }}</td>
                                    <td class="text-center">{{ $user->user->last_name }}</td>
                                    <td class="text-center">{{ $user->user->initials }}</td>
                                    <td class="text-center">{{ $user->user->email }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endfor
</div>

@endsection