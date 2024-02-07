<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use App\Jobs\ArticleMailJob;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        $articles = Article::latest()->paginate(6);
        return view('article.all_articles', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
	public function create()
	{
        Gate::authorize('create', [self::class]);
		return view('article.create_article');
	}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', [self::class]);
        $request->validate([
            'name'=>'required',
            'short_desc'=>'required|min:6',
            'desc'=>'required|min:6',
            'date'=>'required',
        ]);

        $article = new Article;
        $article->name = $request->name;
        $article->short_desc = $request->short_desc;
        $article->desc = $request->desc;
        $article->date = $request->date;
        $article->author_id = 1;
        $article->save();

        ArticleMailJob::dispatch($article);

        return redirect('/article');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $comments = Comment::where('article_id', $article->id)->latest()->get(); // Получение комментариев для статьи
        return view('article.one_article', ['article' => $article, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', [self::class, $article]);
        return view('article.edit_article', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', [self::class, $article]);

        $request->validate([
            'name'=>'required',
            'short_desc'=>'required|min:6',
            'desc'=>'required|min:6',
            'date'=>'required',
        ]);

        $article->name = $request->name;
        $article->short_desc = $request->short_desc;
        $article->desc = $request->desc;
        $article->date = $request->date;
        $article->save();
        return redirect()->route('article.show', ['article' => $article]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', [self::class, $article]);
        $article->delete();
        return redirect('/article');
    }
}
