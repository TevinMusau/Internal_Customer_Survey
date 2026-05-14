<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;



class CommentsController extends Controller
{

    function viewAllComments($user_id){
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get all comments
        $comments = Comment::all();

        // get all users
        $users = User::all();

        return view('dashboard.all-comments', compact('comments', 'users'));
    }

    function toEditCommentPage($comment_id, $user_id){
        
        // if user is not logged in, redirect to the login page
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // get the comment
        $comment = Comment::findOrFail($comment_id);

        // get all users except the currently logged in user
        $users = User::where('id', '!=', $user_id)->get();

        // redirect to the edit question details page
        return view('editcomment', compact('comment', 'users'));
    }

    function editCommentDetails(Request $request, $comment_id, $user_id) {
        // find the comment
        $comment = Comment::findOrFail($comment_id);

        // update the question
        $comment->update([
            'comment_by'                => $request->input("comment_author_id"),
            'comment_about'             => $request->input("user_select"),
            'title'                     => $request->input("comment_title"),
            'comment'                   => $request->input("comment"),
        ]);

        return redirect('/dashboard/'.$user_id)->with('success', 'Comment Successfully Updated');
    }

    function createNewComment(Request $request, $user_id){
        // if user is not logged in, redirect to the login page with a warning message
        if(!auth()->user()){
            return redirect('login')->with('warning', 'You Must First Login!');
        }

        // validate form input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title'   => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        $data['comment_by'] = $user_id;
        $data['comment_about'] = $request->user_id;
        $data['title'] = $request->title;
        $data['comment'] = $request->comment;
        $data['date'] = today()->toDateString();;
        $data['comment_type'] = 'General';

        // create the comment
        Comment::create($data);

        // redirect back
        return redirect()->back()->with('success', 'Comment created successfully.');
    }

    function deleteComment($comment_id, $user_id){
        // get the comment
        $comment = Comment::findOrFail($comment_id);

        // delete it
        $comment->delete();

        return redirect('/dashboard/'.$user_id)->with('success', 'Comment Deleted Successfully');
    }
}
