<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id' => 'required'
        ]);
    
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->author_id = 1;
        $comment->article_id = $request->article_id;
        $comment->save();
    
        return redirect()->route('article.show', ['article' => $request->article_id]);
    }

    public function delete($comment_id) {
        $comment = Comment::findOrFail($comment_id);
        $article_id = $comment->article_id;
        $comment->delete();
        return redirect()->route('article.show', ['article' => $article_id]);
    }

    public function update(Request $request, $comment_id) {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);
    
        $comment = Comment::findOrFail($comment_id);
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->save();
    
        return redirect()->route('article.show', ['article' => $comment->article_id]);
    }

    public function edit($comment_id) {
        $comment = Comment::findOrFail($comment_id);
        return view('comment.edit_comment', ['comment' => $comment]);
    }

    
}
