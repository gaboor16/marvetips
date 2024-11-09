<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        $request->request->add(['username' => Str::slug($request->username)]);
        
        $request->validate([
            'username'=>['required','unique:users,username,'.Auth::user()->id,'min:3','max:20','not_in:editar-pefil,twitter'],
            'email'=>['required','unique:users,email,'.Auth::user()->id,'email','max:30'],
            'password'=>['confirmed']
        ]);

        if($request->imagen)
        {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            $imagenServidor = Image::read($imagen);
            $imagenServidor->resize(1000,1000);
    
            $imagenPath = public_path('perfiles').'/'.$nombreImagen;
            $imagenServidor->save($imagenPath);
            
            
        }

        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? '';
        $usuario->email= $request->email;
        $usuario->save();

        return redirect()->route('posts.index',$usuario->username);
        
    }
}
