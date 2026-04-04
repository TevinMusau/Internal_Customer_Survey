<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;



class CommentsController extends Controller
{
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

    function deleteComment($comment_id, $user_id){
        // get the comment
        $comment = Comment::findOrFail($comment_id);

        // delete it
        $comment->delete();

        return redirect('/dashboard/'.$user_id)->with('success', 'Comment Deleted Successfully');
    }
}
