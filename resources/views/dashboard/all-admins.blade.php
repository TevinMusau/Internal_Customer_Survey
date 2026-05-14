@extends('layouts.newapp')

@section('title') All Admins @endsection

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

<div id="admins" class="row">
    <div class="section-pill fw-bold d-flex justify-content-center align-items-center">
        <h3 class="fw-bold p-2 m-0">
            All Admins
        </h3>
    </div>

{{-- ----------------------------------------- FILTERS -------------------------------------------------------- --}}
    <form method="GET" action="#" class="d-flex flex-wrap gap-2 align-items-center m-3">
        <input type="text" name="name" value="{{ request('name') }}"
                class="form-control form-control-sm" style="width:160px" placeholder="Search first name...">

        <select name="dept" class="form-select form-select-sm" style="width:150px">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->name }}" {{ request('dept') == $dept->name ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>

        <select name="level" class="form-select form-select-sm" style="width:140px">
            <option value="">All Levels</option>
            <option value="superAdmin"  {{ request('level') == 'superAdmin'  ? 'selected' : '' }}>superAdmin</option>
            <option value="staffAdmin"  {{ request('level') == 'staffAdmin'  ? 'selected' : '' }}>staffAdmin</option>
        </select>

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
            <thead class="table-dark">
                <tr>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">First Name</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Last Name</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Email</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Department</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Role</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Level</th>
                    @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);" colspan="5">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td class="text-center">{{ $admin->first_name }}</td>
                    <td class="text-center">{{ $admin->last_name }}</td>
                    <td class="text-center">{{ $admin->email }}</td>
                    <td class="text-center">{{ $admin->departments->pluck('name')->join(', ') ?: 'None' }}</td>
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
@endsection