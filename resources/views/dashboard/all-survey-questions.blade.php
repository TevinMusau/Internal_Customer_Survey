@extends('layouts.newapp')

@section('title') All Users @endsection

@section('content')

<style>
    /* Section pills */
    .section-pill {
        background: rgba(0, 97, 104, 0.12);
        color: rgb(0, 97, 104);
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
            Survey Questions
        </h3>
    </div>

{{-- --------------------------------------- CREATE NEW QUESTIONS -------------------------------------------------------- --}}
    <div class="mx-auto mb-4" style="max-width: 680px; border-radius: 16px; border: 0.5px solid rgba(0,0,0,0.1); padding: 1.5rem 2rem;">
                
        <h5 class="mb-3 pb-3">
            Create a new question by:
        </h5>

        <div class="row g-3">
            <div class="col-6">
                <a href="#" class="text-decoration-none">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" 
                        style="border: 0.5px solid rgba(0,0,0,0.1); background: #f8f8f8;"
                        onmouseover="this.style.borderColor='rgb(0,97,104)';"
                        onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='#f8f8f8';"
                        data-bs-toggle="modal" data-bs-target="#existingCategoryModal">
                        
                        <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                            style="width:38px; height:38px; background: rgba(0,97,104,0.12);">
                            <i class="bi bi-folder2-open" style="color: rgb(0,97,104); font-size: 16px;"></i>
                        </div>
                        
                        <div class="">
                            <p class="mb-0" style="font-size: 14px; color: #222;">Selecting an existing category</p>
                            <p class="mb-0" style="font-size: 11px; color: #888;">Pick from categories already created</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6">
                <a href="#" class="text-decoration-none">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                        style="border: 0.5px solid rgba(0,0,0,0.1); background: #f8f8f8;"
                        onmouseover="this.style.borderColor='rgb(232,104,40)';"
                        onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='#f8f8f8';"
                        data-bs-toggle="modal" data-bs-target="#newCategoryModal">

                        <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                            style="width:38px; height:38px; background: rgba(232,104,40,0.12);">
                            <i class="bi bi-plus-circle" style="color: rgb(232,104,40); font-size: 16px;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size: 14px; color: #222;">Making a new category</p>
                            <p class="mb-0" style="font-size: 11px; color: #888;">Create a fresh category from scratch</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

{{-- --------------------------------------- MODALS -------------------------------------------------------- --}}

{{-- Create Question Modal --}}

    <div class="modal fade" id="existingCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                
                <div class="modal-header" style="background: rgb(0,97,104); border-radius: 16px 16px 0 0; border: none;">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-folder2-open me-2"></i> Select an Existing Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="p-1" id="existing_category">
                        <div class="col-12">
                            <form action="{{ route('create.question',['user_id' => auth()->user()->id]) }}" method="POST">
                                @csrf

                                <p class="text-muted">Select a Category: </p>
                                
                                <div class="form-check">
                                    <div class="row g-2 mt-1">
                                        @foreach ($question_categories as $category)
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="border: 0.5px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.15s;"
                                                onmouseover="this.style.borderColor='rgb(0,97,104)'; this.style.background='rgba(0,97,104,0.04)';"
                                                onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='transparent';">
                                                
                                                <input class="category-radio" type="radio" name="question_category" id="question_category" value="{{ $category->id }}" data-departments='@json($category->department->pluck("id"))'>
                                                <label for="question_category">{{ $category->category_name }}</label> <br>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr style="border-color: rgba(0,0,0,0.8);">

                                <p class="text-muted">For which department: </p>

                                <div class="d-flex align-items-center gap-2 p-2 rounded-3 mb-2" style="background: rgba(0,97,104,0.06); border: 0.5px solid rgba(0,97,104,0.3); cursor: pointer;">
                                    <input class="all_depts" type="checkbox" name="question_dept_selection[]" id="question_dept_selection" value="all_depts" style="accent-color: rgb(0,97,104); width: 15px; height: 15px;">
                                    <label for="question_dept_selection" style="font-size: 13px; color: rgb(0,57,61); cursor: pointer;">All Departments</label> <br>
                                </div>
                                
                            
                                <div class="row g-2 mt-1">
                                    @foreach ($departments as $department)
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="border: 0.5px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.15s;"
                                            onmouseover="this.style.borderColor='rgb(0,97,104)'; this.style.background='rgba(0,97,104,0.04)';"
                                            onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='transparent';">
                                            <input type="checkbox" class="other-items department-checkbox" name="question_dept_selection[]" id="question_dept_selection_{{ $department->id }}" value="{{ $department->id }}">
                                            <label for="question_dept_selection_{{ $department->id }}">{{ $department->name }}</label> <br>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <hr style="border-color: rgba(0,0,0,0.8);">

                                <p class="text-muted">Question Details:</p>

                                <div class="form-floating m-3">
                                    <input class="form-control w-100" type="text" name="sub_category_name" placeholder="Sub Category Name">
                                    <label for="sub_category_name">Sub Category Name</label>
                                </div>

                                <div class="form-floating m-3">
                                    <input class="form-control w-100" type="text" name="sub_category_description" placeholder="Sub Category Description">
                                    <label for="sub_category_description">Description</label>
                                </div>

                                <div class="form-floating m-3">
                                    <input class="form-control w-100" type="text" name="question" placeholder="Question">
                                    <label for="question">Question</label>
                                </div>
                                {{-- <p>Which Rating System to be used? </p>

                                <div class="form-check">
                                    <input type="checkbox" name="rating_1" id="rating_1">
                                    <label for="all">Rating_1</label> <br>

                                    <input type="checkbox" class="other-item" name="rating_2" id="rating_2">
                                    <label for="rating_2">Rating 2</label> <br>

                                    <input type="checkbox" class="other-item" name="rating_3" id="rating_3">
                                    <label for="rating_3">Rating 3</label> <br>
                                </div> --}}

                                <hr style="border-color: rgba(0,0,0,0.8);">

                                <p class="text-muted">This question will appear in which survey: </p>

                                <div class="row g-2 mt-1 mb-3">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-2 m-1 p-2 rounded-3" style="border: 0.5px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.15s;"
                                            onmouseover="this.style.borderColor='rgb(0,97,104)'; this.style.background='rgba(0,97,104,0.04)';"
                                            onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='transparent';">

                                            <input type="radio" name="scope" id="scope" value="all_surveys">
                                            <label class="form-check-label" for="scope">All Surveys</label>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 m-1 p-2 rounded-3" style="border: 0.5px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.15s;"
                                            onmouseover="this.style.borderColor='rgb(0,97,104)'; this.style.background='rgba(0,97,104,0.04)';"
                                            onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='transparent';">
                                        
                                            <input type="radio" name="scope" id="scope" value="staff_survey">
                                            <label class="form-check-label" for="scope">Staff Survey</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-2 m-1 p-2 rounded-3" style="border: 0.5px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.15s;"
                                            onmouseover="this.style.borderColor='rgb(0,97,104)'; this.style.background='rgba(0,97,104,0.04)';"
                                            onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='transparent';">
                                        
                                            <input type="radio" name="scope" id="scope" value="mp_survey">
                                            <label class="form-check-label" for="scope">Managing Partner Survey</label>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 m-1 p-2 rounded-3" style="border: 0.5px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.15s;"
                                            onmouseover="this.style.borderColor='rgb(0,97,104)'; this.style.background='rgba(0,97,104,0.04)';"
                                            onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='transparent';">
                                        
                                            <input type="radio" name="scope" id="scope" value="supervisor_survey">
                                            <label class="form-check-label" for="scope">Supervisor Survey</label>
                                        </div>
                                    </div>
                                </div>                               

                                <div class="modal-footer" style="border-top: 0.5px solid rgba(0,0,0,0.1);">
                                    <button type="button" class="btn btn-sm" 
                                        style="border: 0.5px solid rgba(0,0,0,0.15); border-radius: 20px; padding: 6px 16px;"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm text-white" 
                                        style="background: rgb(0,97,104); border-radius: 20px; padding: 6px 16px;">
                                        Create Question
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Make New Category Modal --}}

    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 16px; border: none;">

                <div class="modal-header" style="background: rgb(232,104,40); border-radius: 16px 16px 0 0; border: none;">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-plus-circle me-2"></i> Make a New Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="p-1">
                        <div class="col-12">
                            <form class="form-group" action="{{ route('create.category', ['user_id' => auth()->user()->id]) }}" method="POST">
                                @csrf
                                <div class="form-floating m-3">
                                    <input class="form-control w-100" id="category_name" type="text" name="category_name" placeholder="Enter Category Name" value="{{ old('category_name') }}">
                                    <label for="category_name">Category Name</label>
                                </div>

                                <hr style="border-color: rgba(0,0,0,0.8);">

                                <p class="text-muted">This Category will be seen by which department(s)?</p>

                                <div class="form-check">
                                    <div class="d-flex align-items-center gap-2 p-2 rounded-3 mb-2" style="background: rgba(0,97,104,0.06); border: 0.5px solid rgba(0,97,104,0.3); cursor: pointer;">
                                        <input class="all" type="checkbox" name="dept_selection[]" id="dept_selection" value="all_depts" style="accent-color: rgb(0,97,104); width: 15px; height: 15px;">
                                        <label for="dept_selection" style="font-size: 13px; color: rgb(0,57,61); cursor: pointer;">All Departments</label> <br>
                                    </div>

                                    <div class="row g-2 mt-1 mb-3">
                                        @foreach ($departments as $department)
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="border: 0.5px solid rgba(0,0,0,0.1); cursor: pointer; transition: all 0.15s;"
                                                onmouseover="this.style.borderColor='rgb(232,104,40)'; this.style.background='rgba(232,104,40,0.04)';"
                                                onmouseout="this.style.borderColor='rgba(0,0,0,0.1)'; this.style.background='transparent';">
                                                <input type="checkbox" class="other-item" name="dept_selection[]" id="dept_selection_{{ $department->id }}" value="{{ $department->id }}">
                                                <label for="dept_selection_{{ $department->id }}">{{ $department->name }}</label> <br>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            
                                <div class="modal-footer" style="border-top: 0.5px solid rgba(0,0,0,0.1);">
                                    <button type="button" class="btn btn-sm"
                                        style="border: 0.5px solid rgba(0,0,0,0.15); border-radius: 20px; padding: 6px 16px;"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm text-white"
                                        style="background: rgb(232,104,40); border-radius: 20px; padding: 6px 16px;">
                                        Create Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                

            </div>
        </div>
    </div>

{{-- ----------------------------------------- FILTERS -------------------------------------------------------- --}}

    {{-- <form method="GET" action="#" class="d-flex flex-wrap gap-2 align-items-center m-3">
        <input type="text" name="name" value="{{ request('name') }}"
                class="form-control form-control-sm" style="width:160px" placeholder="Search name...">

        <select name="dept" class="form-select form-select-sm" style="width:150px">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->name }}" {{ request('dept') == $dept->name ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>

        <select name="role" class="form-select form-select-sm" style="width:140px">
            <option value="">All Roles</option>
            @foreach($users->pluck('role')->unique() as $role)
                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                    {{ $role }}
                </option>
            @endforeach
        </select>

        <select name="level" class="form-select form-select-sm" style="width:140px">
            <option value="">All Levels</option>
            <option value="superAdmin"  {{ request('level') == 'superAdmin'  ? 'selected' : '' }}>superAdmin</option>
            <option value="staffAdmin"  {{ request('level') == 'staffAdmin'  ? 'selected' : '' }}>staffAdmin</option>
            <option value="user"        {{ request('level') == 'user'        ? 'selected' : '' }}>user</option>
        </select>

        <select name="supervisor" class="form-select form-select-sm" style="width:150px">
            <option value="">Supervisor: All</option>
            <option value="Yes" {{ request('supervisor') == 'Yes' ? 'selected' : '' }}>Yes</option>
            <option value="No"  {{ request('supervisor') == 'No'  ? 'selected' : '' }}>No</option>
        </select>

        <a href="#"
            class="btn btn-sm btn-outline-secondary">
            {{ request('sort', 'asc') == 'asc' ? 'A → Z' : 'Z → A' }}
        </a>

        <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>

        <a href="#" class="btn btn-sm btn-outline-secondary">Clear</a>

    </form> --}}

{{-- ------------------------------------------ TABLE -------------------------------------------------------- --}}

    <div class="table-responsive">
        <table class="table table-hover table-striped table-borderless m-3">
            <thead>
                <tr>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">#</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Question Category</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Sub Category Name</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Sub Category Description</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Question</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Appears In (Surveys)</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Departments Affected</th>
                    @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                        <th class="text-center text-white" colspan="5" style="background-color: rgb(0, 97, 104);">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach ($all_questions as $category => $rows)
                    @foreach ($rows as $index => $row)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            @if ($index === 0)
                                <td rowspan="{{ count($rows) }}">{{ $category }}</td>
                            @endif
                            <td>{{ $row->sub_category_name }}</td>
                            <td>{{ $row->description }}</td>
                            <td>{{ $row->question }}</td>
                            <td>
                                {{ match($row->appears_in){
                                        0 => "All Surveys",
                                        1 => "Staff Survey",
                                        2 => "Supervisor Survey",
                                        3 => "Managing Partner Survey"
                                    } 
                                }}
                            </td>
                            <td>
                                @if ($row->departments_affected == 1)
                                    <span class="badge bg-success">All Departments</span>
                                @else
                                    @foreach ($row->survey_question as $sq)
                                        @if ($sq->id == $row->survey_question_id)
                                            @foreach ($sq->department as $department)
                                                <span class="badge bg-info">{{ $department->name }}</span>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <span>
                                    <a class="text-decoration-none" href="{{ route('edit.question', ['survey_question_id' => $row->survey_question_id, 'user_id' => auth()->user()->id]) }}">
                                        <button class="btn btn-outline-primary" title="Edit Question">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </a>
                                
                                    <a class="text-decoration-none" 
                                        onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" 
                                        href="{{ route('delete.question', ['survey_question_id' => $row->survey_question_id, 'user_id' => auth()->user()->id]) }}">
                                        <button class="btn btn-outline-danger" title="Delete Question">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    const allDeptsCheckbox = document.querySelector('.all_depts');
    const departmentCheckboxes = document.querySelectorAll('.department-checkbox');
    const totalDepartments = departmentCheckboxes.length;

    document.querySelectorAll('.category-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            const allowedDepartments = JSON.parse(this.dataset.departments);

            // Case 1: Category applies to ALL departments
            if (allowedDepartments.length === totalDepartments) {
                allDeptsCheckbox.disabled = false;
                allDeptsCheckbox.checked = true;

                departmentCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                });

                return;
            }

            // Case 2: Category applies to SPECIFIC departments
            allDeptsCheckbox.checked = false;
            allDeptsCheckbox.disabled = true;

            departmentCheckboxes.forEach(cb => {
                const deptId = parseInt(cb.value);

                if (allowedDepartments.includes(deptId)) {
                    cb.disabled = false;
                } else {
                    cb.checked = false;
                    cb.disabled = true;
                }
            });
        });
    });

    // for the selection of departments in question categories
    document.addEventListener('DOMContentLoaded', function () {
        const all_deparments_selection = document.querySelector('.all');
        const others = document.querySelectorAll('.other-item');

        function updateState() {
            const anyOtherChecked = Array.from(others).some(cb => cb.checked);

            if (all_deparments_selection.checked) {
                // Item 1 is checked → disable others
                others.forEach(cb => {
                    cb.disabled = true;
                    cb.checked = false; // optional: force uncheck
                });
            } else if (anyOtherChecked) {
                // One of Item 2/3 is checked → disable Item 1
                all_deparments_selection.disabled = true;
            } else {
                // None checked → enable all
                all_deparments_selection.disabled = false;
                others.forEach(cb => {
                    cb.disabled = false;
                });
            }
        }

        // Attach listeners
        all_deparments_selection.addEventListener('change', updateState);
        others.forEach(cb => cb.addEventListener('change', updateState));
    });

    // for the selection of departments in questions
    document.addEventListener('DOMContentLoaded', function () {
        const all_deparments_selection = document.querySelector('.all_depts');
        const others = document.querySelectorAll('.other-items');

        function updateState() {
            const anyOtherChecked = Array.from(others).some(cb => cb.checked);

            if (all_deparments_selection.checked) {
                // Item 1 is checked → disable others
                others.forEach(cb => {
                    cb.disabled = true;
                    cb.checked = false; // optional: force uncheck
                });
            } else if (anyOtherChecked) {
                // One of Item 2/3 is checked → disable Item 1
                all_deparments_selection.disabled = true;
            } else {
                // None checked → enable all
                all_deparments_selection.disabled = false;
                others.forEach(cb => {
                    cb.disabled = false;
                });
            }
        }

        // Attach listeners
        all_deparments_selection.addEventListener('change', updateState);
        others.forEach(cb => cb.addEventListener('change', updateState));
    });
</script>

@endsection