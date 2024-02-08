<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdminCommentMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCommentNotify;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Метод отображения всех комментариев
    public function index() {
        Gate::authorize('comment-admin');
        $comments = Comment::latest()->paginate(10);
        return view('comment.index', ['comments' => $comments]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id' => 'required'
        ]);
        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->author_id = Auth::id();
        $comment->article_id = $request->article_id;
        $res = $comment->save();

        Mail::to('i.d.pereverzev@mail.ru')->send(new AdminCommentMail($comment));
    
        return redirect()->route('article.show', ['article' => $request->article_id, 'res'=>$res]);
    }

    public function delete($comment_id) {
        $comment = Comment::findOrFail($comment_id);
        Gate::authorize('comment', $comment); // Проверка на право доступа

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
        Gate::authorize('comment', $comment); // Проверка на право доступа

        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->save();
    
        return redirect()->route('article.show', ['article' => $comment->article_id]);
    }

    public function edit($comment_id) {
        $comment = Comment::findOrFail($comment_id);
        Gate::authorize('comment', $comment); // Проверка на право доступа

        return view('comment.edit_comment', ['comment' => $comment]);
    }

    // Метод для одобрения комментария
    public function accept($comment_id) {
        Gate::authorize('comment-admin');

        $comment = Comment::findOrFail($comment_id);
        $comment->status = true;
        $comment->save();

        $article = Article::findOrFail($comment->article_id);
        // Получаем всех пользователей кроме того, кто оставил комментарий
	    $users = User::where('id', '!=', $comment->author_id)->get();

        Notification::send($users, new NewCommentNotify($article));

        return redirect()->route('comments');
    }

    // Метод для отклонения комментария
    public function reject($comment_id) {
        Gate::authorize('comment-admin');

        $comment = Comment::findOrFail($comment_id);
        $comment->status = false;
        $comment->save();

        return redirect()->route('comments');
    }    
}
