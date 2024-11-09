@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection
@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="md:w-8/12 lg:w-6/12 px-5">
                <img src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                    alt="imagen usuario">
            </div>
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
                <div class="flex items gap-2">
                    <p class="text-gray-700 text-2xl mb-3">{{ $user->username }}</p>
                    @auth
                        @if ($user->id === Auth::user()->id)
                            <a href="{{ route('perfil.index', $user) }}"
                                class="text-gray-500 hover:text-gray-700 cursor-pointer  ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>

                            </a>
                        @endif
                    @endauth
                </div>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{$user->followers->count()}}
                    <span class="font-normal">@choice('Seguidor|Seguidores',$user->followers->count()) </span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold ">
                  {{$user->followings->count()}}
                    <span class="font-normal">Siguiendo</span>

                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $posts->count() }}
                    <span class="font-normal">Post</span>
                </p>
                @auth
                    @if ($user->id !== Auth::user()->id)
                        @if (!$user->siguiendo(Auth::user()))
                            <form action="{{ route('users.follows', $user) }}" method="POST">
                                @csrf


                                <button type="submit"
                                    class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>
                                </button>

                            </form>
                        @else
                            <form action="{{ route('users.unfollows', $user) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>

                                </button>
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class=" text-4xl text-center font-black my-10">Publicaciones</h2>
        @if (session('mensaje'))
            <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                {{ session('mensaje') }}
            </div>
        @endif
        @if ($posts->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 ">
                @foreach ($posts as $post)
                    <div>
                        <a href="{{ route('posts.show', ['user' => $user, 'post' => $post]) }}">
                            <img src="{{ asset('uploads') . '/' . $post->imagen }}"
                                alt="Imagen del post {{ $post->titulo }}">
                        </a>
                    </div>
                @endforeach
            </div>

            <div class=" my-10">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-600 uppercase text-sm text-center font-bold">No hay posts</p>
        @endif
    </section>
@endsection
