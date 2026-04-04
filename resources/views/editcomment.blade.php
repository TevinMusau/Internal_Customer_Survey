@extends('layouts.app')

@section('title') Edit Comment @endsection

@section('content')

<div class="container-fluid border border-3 w-50 p-2">
    <div class="col-12">
        <h3 class="text-center fw-bold fst-italic m-5 mb-2" id="Title">
            Edit Comment
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

            <form class="form-group" action="{{ route('edit.comment.post', ['comment_id' => $comment->id, 'user_id' => auth()->user()->id]) }}" method="POST">
                <!-- csrf is a security feature for laravel forms -->
                @csrf
                <div class="col-12 text-center p-3">

                    <input type="hidden" name='comment_author_id' value="{{ $comment->commentor->id }}">

                    <div class="col-12 text-center p-3">
                        <label for="comment_author" class="form-label fw-500">Comment By</label>
                        <input class="form-control" type="text" name='comment_author' disabled value="{{ $comment->commentor->initials }}" placeholder="The Author of this comment" title="This field is disabled">
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="comment_author" class="form-label fw-500">Comment About</label>
                        <select name="user_select" id="user_select" class="form-select">
                            <option value="" disabled>Select a question category</option>
                            @foreach ($users as $user)
                                @if ($user->id == $comment->commentor->id)
                                    <option value="" disabled>{{ $user->first_name }} {{ $user->last_name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="sub_category_description" class="form-label fw-500">Comment Title</label>
                        @if($comment->comment_type == 'End_of_Survey')
                            <input type="hidden" name='comment_title' value="{{ $comment->title }}">
                        @endif
                        <input class="form-control" @disabled($comment->comment_type == 'End_of_Survey') title="{{ $comment->comment_type == 'End_of_Survey' ? 'This field is disabled' : '' }}" type="text" name='comment_title' value="{{ $comment->title }}" placeholder="Enter Comment Title">
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="sub_category_question" class="form-label fw-500">Comment</label>
                        <textarea class="form-control" name='comment' placeholder="Enter Comment" rows="3">{{ $comment->comment }}</textarea>                    
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="sub_category_description" class="form-label fw-500">Comment Creation Date</label>
                        <input class="form-control" disabled title="This field is disabled" type="text" name='comment_creation_date' value="{{ $comment->created_at->format('l, d F Y | g:i A') }}" placeholder="Comment Creation Date">
                    </div>

                    <div class="col-12 text-center p-3">
                        <label for="sub_category_description" class="form-label fw-500">Comment Updated On:</label>
                        <input class="form-control" disabled title="This field is disabled" type="text" name='comment_update_date' value="{{ $comment->updated_at->format('l, d F Y | g:i A') }}" placeholder="Comment Updated On">
                    </div>

                    <div class="row justify-content-center">
                        <div class="text-center m-3">
                            <button class="form-control w-50 btn btn-outline-success">Edit Question</button>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div>

@endsection