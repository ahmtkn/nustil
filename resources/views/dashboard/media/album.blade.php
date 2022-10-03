@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Media Gallery') }}
    </h2>
@endsection

@section('content')
    <div class="flex items-center justify-end my-4">
        <a href="#" class="btn btn-emerald" data-modal-toggle="uploadModal">
            <i icon-name="upload"></i> {{ __('Upload') }}
        </a>
    </div>
    <x-dashboard.modal id="uploadModal">
        <x-slot name="heading">
            {{ __('Upload') }}
        </x-slot>
        <x-slot name="body">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="flex justify-center items-center w-full droppable">
                    <label for="dropzone-file"
                           class="pseudo-input">
                        <div class="preview hidden">
                            <figure
                                class="mx-auto my-2  w-28 h-28  flex items-center object-cover justify-center rounded-md relative"
                                style="background-image:url({{asset('img/transparent-grid-bg.png')}})">
                            </figure>
                        </div>
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <svg class="mb-3 w-10 h-10 text-gray-400 icon" fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 text">
                                <span class="font-semibold">{{__('Click to upload')}}</span>
                                {{__('or drag and drop')}}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG, GIF</p>
                        </div>
                        <input type="file" id="dropzone-file" name="image" accept="image/*" class="hidden"/>
                    </label>
                </div>
                <div class="my-4">
                    <label class="form-label">{{__('Name')}}</label>
                    <input type="text" name="name" class="form-input" autocomplete="off">
                </div>
                <hr>
                @csrf
                <button class="btn btn-blue w-full mt-4">{{__('Upload')}}</button>
            </form>
        </x-slot>

    </x-dashboard.modal>
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
