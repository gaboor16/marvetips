<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        //modificar request
        $request->request->add(['username' => Str::slug($request->username)]);
        // validacion
        $request->validate([
            'name' => ['required', 'max:20', 'alpha'],
            'username' => ['required', 'unique:users', 'min:3', 'max:20'],
            'email' => ['required', 'unique:users', 'email', 'max:60'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        User::create([
            'name' => $request->input('name'),
            'username' => $request->username,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        //autenticar
        //Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        Auth::attempt($request->only('email', 'password'));

        //redireccionar
        return redirect()->route('posts.index', Auth::user()->username);
    }
}
