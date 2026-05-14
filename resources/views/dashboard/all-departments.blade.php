@extends('layouts.newapp')

@section('title') All Departments @endsection

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

<div id="departments" class="row">
    <div class="section-pill fw-bold d-flex justify-content-center align-items-center">
        <h3 class="fw-bold p-2 m-0">
            All Departments
        </h3>
    </div>

{{-- --------------------------------------- ADD NEW DEPARTMENT -------------------------------------------------------- --}}
    <div class="text-end">
        <a class="" href="{{ route('create.department', ['admin_id'=>auth()->user()->id]) }}">
            <button class="form-control w-25 btn btn-outline-primary mb-3"> + New Department </button>
        </a>
    </div>

{{-- ----------------------------------------- FILTERS -------------------------------------------------------- --}}

    <form method="GET" action="#" class="d-flex flex-wrap gap-2 align-items-center m-3">

        <select name="dept" class="form-select form-select-sm" style="width:150px">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->name }}" {{ request('dept') == $dept->name ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
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
            <tbody>
                <thead>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Department ID</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Department Name</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Users in Department</th>
                    @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);" colspan="5">Action</th>
                    @endif
                </thead>
                @foreach ($departments as $department)
                <tr>
                    <td class="text-center">{{ $department->id }}</td>
                    <td class="text-center">{{ $department->name }}</td>
                    @if ($department->users->count())
                    <td class="text-center">
                        @foreach ($department->users as $department_user)
                            {{ $department_user->initials }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    @else
                        <td class="text-center">No Users</td>
                    @endif
                    
                    @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                        <td class="text-center">
                            <a class="text-decoration-none" href="{{ route('edit.department', ['admin_id' => auth()->user()->id, 'department_id' => $department->id]) }}">
                                <button class="btn btn-outline-primary" title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="text-decoration-none" 
                                onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" 
                                href="{{ route('delete.department', ['admin_id' => auth()->user()->id, 'department_id' => $department->id]) }}">
                                <button class="form-control btn btn-outline-danger mb-3" title="Delete Department">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </a>
                        </td>
                    @endif
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection