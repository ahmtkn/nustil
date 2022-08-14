<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::with('commentable')->orderByDesc('id')->get()->sortBy('approved');

        return view('dashboard.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->approve();

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        $comment->reject();

        return redirect()->back();
    }

}
