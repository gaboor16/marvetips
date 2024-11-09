@extends('layouts.app')

@section('titulo')
    Pagina principal
@endsection

@section('contenido')

    <x-listar-post :posts="$posts"/>
    {{-- @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6 ">
            @foreach ($posts as $post)
                <div class="container flex ">
                    <div class="md:w-1/2 p-5 md:items-center bg-white  rounded-lg shadow-xl mt-10 md:mt-0">
                    <a href="{{ route('posts.show', ['user' => $post->user, 'post' => $post]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                    </a>
                    <div class="p-2">
                        <p class="font-bold"> {{$post->likes->count()}}
                            <span class="font-normal">@choice('Like|Likes',$post->likes->count()) </span>
                            
                            </p>
                        <a  href="{{route('posts.index',$post->user->username)}}" class="font-bold">{{ $post->user->username }}</a>
                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        <p class="mt-5">{{ $post->descripcion }}</p>
                        <x-listar-post/> --}}
                    {{-- </div>
                </div>
            </div>
            @endforeach
        </div> --}}
{{-- 
        <div class=" my-10">
            {{ $posts->links() }}
        </div>
    @else
        no hay posts
    @endif --}}
@endsection
