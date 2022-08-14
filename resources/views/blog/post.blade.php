@extends('layouts.guest')
@php($views = $post->views())
@section('content')

    <div class="container mx-auto mt-16 px-4 mb-24">

        <h1 class="inline-block font-nunito text-3xl mt-6 font-extrabold leading-none tracking-tight text-black transition-colors duration-200 sm:text-4xl">
            {{$post->title}}
        </h1>
        <div class="mb-6">
            {!! \Diglactic\Breadcrumbs\Breadcrumbs::view('vendor.breadcrumbs.tailwind-text-dark','post',$post) !!}
        </div>
        @if($settings->blog['showPublishedAt'] ||$settings->blog['showReadTime'] || $settings->blog['showViewCount'] || $settings->blog['showCategories'])
            <div class="flex items-end justify-between border-b-2 border-slate-200 mb-6 mt-8 pb-2">
                @if($settings->blog['showPublishedAt'])
                    <div class="flex items-center">
                        <div class="flex flex-col">
                            <div class="text-slate-700/60 text-xs">{{__('Published at')}}</div>
                            <b>{{$post->publishTimeDiff()}}</b>
                        </div>
                    </div>
                @endif
                @if($settings->blog['showCategories'])
                    <div class="hidden md:flex items-center justify-center">
                        @foreach($post->categories as $category)
                            <a href="{{route('blog.category',$category)}}"
                               class="font-bold text-emerald-600 mr-2 hover:underline">
                                {{$category->name}}
                            </a>
                            @unless($loop->last)
                                <span class="text-slate-400 mr-2">•</span>
                            @endunless
                        @endforeach
                    </div>
                @endif
                <div class="flex items-center justify-end gap-4">
                    @if($settings->blog['showViewCount'])
                        <div class="flex flex-col">
                            <div class="text-slate-700/60 text-xs">{{__('Views')}}</div>
                            <b>{{number_shorten($views,$views > 1000 ? 1 : 0)}}</b>
                        </div>
                    @endif
                    @if($settings->blog['showReadTime'])
                        <div class="flex flex-col">
                            <div class="text-slate-700/60 text-xs">{{__('Average Reading Time')}}</div>
                            <b>{{$post->read_time}} {{__('min')}}</b>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div class="grid lg:grid-cols-7 gap-4">
            <div
                class="@if($settings->blog['showSidebar']) lg:col-span-5 @else lg:col-span-7 @endif @if($settings->blog['showSidebar']) prose lg:prose-lg @else sm:prose prose-sm mx-auto @endif max-w-full">
                @if($post->image)
                    <div class="mb-6 -mt-8 max-w-full px-4">
                        <img src="{{$post->image->url}}" alt="{{$post->title}}" class="w-full rounded-xl">
                    </div>
                @endif
                <div class="text-justify prose lg:prose-lg max-w-full @if($settings->blog['showSidebar']) pr-4 @endif">
                    {!! \Illuminate\Support\Str::markdown($post->body) !!}
                </div>
            </div>
            <x-blog.sidebar/>
        </div>
    </div>
@endsection
