@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Comments') }}
    </h2>
@endsection
@section('content')
    {{--  List comments  --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($comments as $comment)
            <div class="card border @if($comment->approved) border-emerald-600 @else border-red-500 @endif">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="-mb-2 text-sm md:text-base font-bold text-gray-900 dark:text-white">
                            {{$comment->name}}
                        </h5>
                        <div class="text-xs md:text-sm text-gray-500 dark:text-gray-400">
                            {{$comment->email}}
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{$comment->created_at->diffForHumans()}}
                    </div>
                </div>
                <hr>
                <p class="text-sm md:text-base text-gray-900 dark:text-white">
                    {{$comment->body}}
                </p>

                <div class="flex justify-end items-center gap-2">
                    @if(!$comment->approved)
                        <form action="{{route('dashboard.comments.approve',$comment)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-emerald btn-xs">
                                {{__('Approve')}}
                            </button>
                        </form>
                    @endif
                    <form action="{{route('dashboard.comments.delete',$comment)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red btn-xs">
                            {{__('Delete')}}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
