<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');




Route::get('/crear-cuenta', [RegisterController::class, 'index'])->name('register');
Route::post('/crear-cuenta', [RegisterController::class, 'store'])->name('register');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}',[PostController::class,'show'])->name('posts.show');
Route::post('/{user:username}/posts/{post}',[ComentarioController::class,'store'])->name('comentarios.store');
Route::delete('/posts/{post}',[PostController::class,'distroy'])->name('posts.distroy');



Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// Like a las fotos

Route::post('/posts/{post}/likes',[LikeController::class,'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes',[LikeController::class,'distroy'])->name('posts.like.distroy');

//Rutas para  el perfil
Route::get('{user:username}/editar-perfil',[PerfilController::class,'index'])->name('perfil.index');
Route::post('{user:username}/editar-perfil',[PerfilController::class,'store'])->name('perfil.store');

//Siguiendo usuario

Route::post('/{user:username}/follow',[FollowerController::class,'store'])->name('users.follows');
Route::delete('/{user:username}/unfollow',[FollowerController::class,'destroy'])->name('users.unfollows');