@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Media Gallery') }}
    </h2>
@endsection

@section('content')
    <div class="my-8">
        <div class="columns-4">
            @foreach($images as $image)
                @php($model = explode('\\',$image->imageable_type??'\\Unknown'))
                @php($model = end($model))
                <div class="w-full h-full m-2 rounded-lg overflow-hidden relative group"
                     x-data="{image:{{$image->toJson()}}}"
                     style="background-image:url({{asset('img/transparent-grid-bg.png')}})">
                    <img data-src="{{$image->url}}" class="lazy mx-auto w-full" alt="{{$image->name}}">
                    <div
                        class="absolute bottom-0 p-4 group-hover:pb-8 transition-all text-slate-700 duration-300 ease-in-out inset-x-0 bg-white/60 backdrop-blur-sm bg-blend-overlay">
                        <div class="flex flex-col">
                            <div
                                class="font-bold text-sm">{{$image->imageable->title ?? $image->imageable->name ?? $image->name}}</div>
                            <div class="flex items-center justify-between text-xs">
                                <div>{{__($model)}}</div>
                                <div class="hidden lg:block">{{$image->created_at->translatedFormat('d F Y')}}</div>
                                <div class="group-hover:pt-4 group-hover:-mb-4 transition-all duration-300 ease-in-out">
                                    <div @click="$clipboard(image.url)">
                                        <i icon-name="link"
                                           class="cursor-pointer w-5 h-5 hover:opacity-100 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{$images->links()}}
@endsection
