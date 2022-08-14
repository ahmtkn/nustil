@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{__('Categories')}}
    </h2>
@endsection
@section('content')
    <div class="flex items-center justify-end my-4 mx-4">
        <a href="{{route('dashboard.categories.create')}}"
           class="btn btn-emerald">
            <i icon-name="plus"></i> {{__('Create new category')}}
        </a>
    </div>
    <section class="max-w-7xl mx-auto"
             x-data="{deleting:null,action:null,url:'{{route('dashboard.categories.delete',['category'=>'CATEGORY_ID'])}}'}">
        <table class="data-table">
            <thead>
            <tr>
                <th class="whitespace-nowrap -animate-y text-center uppercase hidden sm:table-cell w-5">{{__('Locale')}}</th>
                <th class="whitespace-nowrap -animate-y uppercase">{{__('Name')}}</th>
                @canany(['categories.update','categories.delete'])
                    <th class="whitespace-nowrap -animate-y uppercase w-20">{{__('Actions')}}</th>
                @endcanany
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr class="animate-x" x-data="{category:{{$category->toJson()}}}">
                    <td class="text-center hidden sm:table-cell w-5">
                        <x-locale-flag :flag="$category->locale"/>
                    </td>
                    <td>{{$category->name}}</td>
                    @canany(['categories.update','categories.delete'])
                        <td class="text-center hidden md:table-cell w-20">


                            <div class="flex items-center justify-center gap-2">
                                @can('categories.update')
                                    <a href="{{route('dashboard.categories.edit',$category)}}" class="btn btn-ghost">
                                        <i icon-name="edit"></i>
                                        <span class="hidden sm:block">{{__('Edit')}}</span>
                                    </a>
                                @endcan
                                @can('categories.delete')
                                    <a href="javascript:;" data-modal-toggle="category-delete-modal"
                                       @click="deleting=category;action=url.replace('CATEGORY_ID',{{$category->id}})"
                                       class="btn btn-ghost text-red-500">
                                        <i icon-name="trash-2"></i>
                                        <span class="hidden sm:block">{{__('Delete')}}</span>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    @endcanany
                </tr>
                {{-- tree view --}}
                @if($category->descendants->count())
                    @foreach($category->descendants as $descendant)
                        @include('dashboard.categories.partials.tree-view',['category'=>$descendant])
                    @endforeach
                @endif
            @endforeach
            </tbody>
        </table>

        {{$categories->links()}}

        <x-dashboard.modal id="category-delete-modal">
            <x-slot name="heading">
                {{__('Confirm action')}}
            </x-slot>
            <x-slot name="body">
                {!! __('You are about to delete this :target :extra. Do you want to proceed this action?',['target'=>__('Category').' (<b x-text="deleting.name"></b>)','extra'=>""])!!}
            </x-slot>
            <x-slot name="footer">
                <form :action="action" method="post" class="w-full">
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
@endsection
