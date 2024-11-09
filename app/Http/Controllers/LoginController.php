<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
      

      $request->validate([
        'email'=>['required','email'],
        'password'=>['required'],
      ]);

      if(!Auth::attempt($request->only('email','password'),$request->remenber ) ){
        return back()->with('mensaje', 'Credenciales Incorrectas');
      }
      else{
        return redirect(route('posts.index',Auth::user()->username));
      }
    }
}
