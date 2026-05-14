@extends('layouts.newapp')

@section('title') All Comments @endsection

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
            All Comments
        </h3>
    </div>

{{-- --------------------------------------- ADD NEW COMMENT -------------------------------------------------------- --}}
    <div class="text-end">
        <button type="" class="form-control w-25 btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#newComment"> + New Comment </button>
    </div>

{{-- --------------------------------------- NEW COMMENT MODAL ---------------------------------------------- --}}
<div class="modal fade" id="newComment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newComment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create a New Comment</h1>
            </div>
            <div class="modal-body">
                <form class="form-group" action="{{ route('new.comment', ['user_id'=>auth()->user()->id]) }}" method="POST">
                    @csrf
                    {{-- User dropdown --}}
                    <div class="mb-3">
                        <label for="commentUser" class="form-label text-muted">Who is this comment about?</label>
                        <select class="form-select" id="commentUser" name="user_id" required
                                style="max-height: 200px; overflow-y: auto;">
                            <option value="" disabled selected>Select a user...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Comment title --}}
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="commentTitle"
                            name="title" placeholder="Comment title" required>
                        <label for="commentTitle">Comment title</label>
                    </div>

                    {{-- Comment body --}}
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="commentBody"
                                name="comment" placeholder="Write your comment..."
                                style="height: 120px" required></textarea>
                        <label for="commentBody">Comment</label>
                    </div>
                    <div class="modal-footer">
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save comment</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

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
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Comment By</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Comment About</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Comment Title</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Comment</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Comment Type</th>
                    <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">Date Created</th>
                    @if (auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                        <th class="text-center text-white" style="background-color: rgb(0, 97, 104);">
                            Action
                        </th>
                    @endif                    
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                <tr class="p-5">
                    <td class="text-center">{{ $comment->commentor->first_name }} {{ $comment->commentor->last_name }}</td>
                    <td class="text-center">{{ $comment->commentee->first_name }} {{ $comment->commentee->last_name }}</td>
                    <td class="text-center">{{ $comment->title }}</td>
                    <td class="text-center">{{ $comment->comment }}</td>
                    <td class="text-center">{{ $comment->comment_type }}</td>
                    <td class="text-center">{{ $comment->date }}</td>
                    @if ($comment->comment_by == auth()->user()->id || auth()->user()->level == 'superAdmin' || auth()->user()->level == 'staffAdmin')
                        <td>
                            <span>
                                @if ($comment->comment_by == auth()->user()->id)
                                    <a class="text-decoration-none" href="{{ route('edit.comment', ['comment_id' => $comment->id, 'user_id' => auth()->user()->id]) }}">
                                        <button class="btn btn-outline-primary" title="Edit Comment">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </a>
                                @endif
                            
                                <a class="text-decoration-none" 
                                    onclick="if (!window.confirm('This action is irreversible. Are you sure you want to proceed?')) return false" 
                                    href="{{ route('delete.comment', ['comment_id' => $comment->id, 'user_id' => auth()->user()->id]) }}">
                                    <button class="form-control btn btn-outline-danger mb-3" title="Delete Comment">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </a>
                            </span>
                        </td>
                    @endif   
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection