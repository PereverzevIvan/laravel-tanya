<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'show_all_articles']);
Route::get('/one_article', [MainController::class, 'show_one_article']);

Route::get('/about_us', [MainController::class, 'show_about_us']);
Route::get('/contacts', [MainController::class, 'show_contacts']);

Route::get('/create_user', [AuthController::class, 'create']);
Route::post('/register', [AuthController::class, 'register']);

use App\Http\Controllers\ArticleController;

// Руты для работы со статьями
Route::resource('/article', ArticleController::class);

// Руты для работы с комментариями к статьям
Route::group(['prefix' => '/comment'], function() {
	Route::post('/store', [CommentController::class, 'store']);
	Route::get('/edit/{id}', [CommentController::class, 'edit']);
	Route::post('/update/{id}', [CommentController::class, 'update']);
	Route::get('/delete/{id}', [CommentController::class, 'delete']);
});