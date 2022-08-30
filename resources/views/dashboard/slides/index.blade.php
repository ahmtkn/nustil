@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Slides') }}
    </h2>
@endsection
@section('content')
    <div class="flex justify-end py-4">
        <a href="{{route('dashboard.slides.create')}}"
           class="btn btn-emerald">
            <i icon-name="plus"></i> {{__('Create new slide')}}
        </a>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 sm:p-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                @foreach($slides as $slide)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        <div class="flex-shrink-0 flex items-center justify-center">
                            <img class="h-48 w-full object-cover"
                                 srcset="{{$slide->getMobileImage()}} 480w,
                                 {{$slide->getDesktopImage()}} 1024w"
                                 sizes="(max-width: 480px) 480px,
                                 1024px"
                                 alt="{{$slide->title}}">
                            <img class="h-48 w-full object-cover" src="{{$slide->getMobileImage()}}">
                        </div>
                        <div class="flex-1 bg-white py-4 px-6 flex flex-col justify-between">
                            <div class="flex items-center justify-between flex-shrink-0">
                                <div class="text-xs flex items-center gap-2">
                                    <x-locale-flag class="w-5" :flag="$slide->locale"/>
                                    <span>•</span>
                                    <span>{{__('Published :timeAgo',['timeAgo'=>$slide->created_at?->diffForHumans()])}}</span>
                                    @if($slide->expires_at != null)
                                        <span>•</span>
                                        @if($slide->expires_at < now())
                                            <span class="text-red-600">{{__('Expired')}}</span>
                                        @else
                                            <span>{{__('Displaying till :timeTill',['timeTill'=>$slide->expires_at?->diffForHumans()])}}</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{route('dashboard.slides.edit', $slide)}}"
                                       class="btn btn-ghost btn-xs">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{route('dashboard.slides.delete',$slide)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-xs text-red-500">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
