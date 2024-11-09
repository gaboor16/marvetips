<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }
    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('layouts.dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'titulo' => ['required', 'max:255'],
                'descripcion' => ['required'],
                'imagen' => ['required']
            ]
        );

        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => Auth::user()->id
        ]);

        // otra manera de regisrar en la base de datos

        //$post = new Post;
        //$post->titulo = $request->titulo;
        //$post->descripcion = $request->descripcion;
        //$post->imagen = $request->imagen;
        //$post->user_id = Auth::user()->id;
        //$post->save();

        //tercera forma de registrar datos

        // $request->user()->postS()->create([
        //         'titulo' => $request->titulo,
        //         'descripcion' => $request->descripcion,
        //         'imagen' => $request->imagen,
        //         'user_id' => Auth::user()->id
        //     ]);



        return redirect()->route('posts.index', Auth::user()->username);
    }

    public function show(User $user, Post $post)
    {

        return view('post.show', [
            'post' => $post,
            'user' => $user,
        ]);
    }
    public function authorize($abikity, $arguments = [])
    {
        return true;
    }
    public function distroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/'.$post->imagen);
        if(File::exists($imagen_path)){
            unlink($imagen_path);
        }
        return redirect()->route('posts.index', Auth::user()->username)->with('mensaje','Post eliminado');
    }
}
