@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Blog Categories') }}
    </h2>

@endsection

@section('content')
    <div class="flex items-center justify-between my-4 mx-4">
        <div class="flex items-center divide-x">
            {{__('Show')}} :
            @foreach(['all','published','draft','trashed'] as $folder)
                <a href="{{route('dashboard.blog.posts.index',['filter'=>$folder])}}"
                   class="@if($filter == $folder) @if($folder == 'trashed') text-red-500 @else text-emerald-600 @endif font-bold @else text-slate-500 font-medium @endif px-4">
                    {{__(\Str::title($folder))}} ({{$counts->$folder}})
                </a>
            @endforeach

        </div>
        <a href="{{route('dashboard.blog.posts.create')}}"
           class="btn btn-emerald">
            <i icon-name="plus"></i> {{__('Create new post')}}
        </a>
    </div>


    <section class="max-w-7xl mx-auto"
             x-data="{deleting:null,action:null,url:'{{route('dashboard.blog.posts.delete',['post'=>'POST_ID'])}}'}">
        <table class="data-table">
            <thead>
            <tr>
                <th class="whitespace-nowrap -animate-y text-center uppercase hidden sm:table-cell w-5">{{__('Locale')}}</th>
                <th class="whitespace-nowrap -animate-y uppercase">{{__('Title')}}</th>
                <th class="whitespace-nowrap -animate-y text-center uppercase">{{__('Views')}}</th>
                <th class="whitespace-nowrap -animate-y uppercase">{{__('Status')}}</th>
                <th class="whitespace-nowrap -animate-y uppercase">{{__('Category')}}</th>
                @canany(['blogs.update','blogs.delete'])
                    <th class="whitespace-nowrap -animate-y uppercase w-20">{{__('Actions')}}</th>
                @endcanany
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr class="animate-x" x-data="{post:{{$post->toJson()}}}">
                    <td class="text-center hidden sm:table-cell w-5">
                        <x-locale-flag :flag="$post->locale"/>
                    </td>
                    <td>{{Str::limit($post->title,40)}}</td>
                    <td class="text-center">{{number_format($post->views())}}</td>
                    <td>{{__(Str::title($post->status))}}</td>
                    <td>{{$post->categories->first()?->name}}</td>

                    @canany(['blogs.update','blogs.delete'])
                        <td class="text-center hidden md:table-cell w-20">
                            <div class="flex items-center justify-center gap-2">
                                @can('blogs.update')
                                    <a href="{{route('dashboard.blog.posts.edit',$post->slug)}}"
                                       class="btn btn-ghost">
                                        <i icon-name="edit"></i>
                                        <span class="hidden sm:block">{{__('Edit')}}</span>
                                    </a>
                                @endcan
                                @can('blogs.delete')
                                    <a href="javascript:;" data-modal-toggle="post-delete-modal"
                                       @click="deleting=post;url='{{route('dashboard.blog.posts.delete',$post->slug)}}'"
                                       class="btn btn-ghost text-red-500">
                                        <i icon-name="trash-2"></i>
                                        <span class="hidden sm:block">{{__('Delete')}}</span>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    @endcanany
                </tr>
            @endforeach
            </tbody>
        </table>
        <x-dashboard.modal id="post-delete-modal">
            <x-slot name="heading">{{__('Delete product')}}</x-slot>
            <x-slot name="body">
                <p>{{__('Are you sure you want to delete this post?')}}</p>
            </x-slot>
            <x-slot name="footer">
                <form :action="url" method="post" class="w-full">
                    @method('DELETE')
                    <div class="items-center w-full flex flex-1 justify-between">
                        <div class="btn btn-white btn-sm" data-modal-toggle="user-delete-modal">
                            <i icon-name="chevron-left" class="p-1"></i> {{__('Abort')}}
                        </div>
                        <button class="btn btn-danger btn-sm">
                            <i class="p-1" icon-name="trash-2"></i>
                            {{__('Delete')}}
                        </button>
                        @csrf
                    </div>
                </form>
            </x-slot>

        </x-dashboard.modal>
    </section>

    <div class="max-w-7xl mx-auto">
        {{$posts->links()}}
    </div>
@endsection
