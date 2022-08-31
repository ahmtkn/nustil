@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Recipes') }}
    </h2>
@endsection

@section('content')

    <div class="flex items-center justify-end p-4">
        <a href="{{route('dashboard.recipes.create')}}"
           class="btn btn-emerald">
            <i icon-name="plus"></i> {{__('Create new recipe')}}
        </a>
    </div>

    <section class="max-w-7xl mx-auto"
             x-data="{deleting:null,action:null,url:'{{route('dashboard.recipes.destroy',['recipe'=>'RECIPE_ID'])}}'}">
        <table class="data-table">
            <thead>
            <th class="whitespace-nowrap -animate-y text-center uppercase hidden sm:table-cell w-5">{{__('Locale')}}</th>
            <th class="whitespace-nowrap -animate-y uppercase">{{__('Title')}}</th>
            <th class="whitespace-nowrap -animate-y text-center uppercase">{{__('Views')}}</th>
            @canany(['products.update','products.delete'])
                <th class="whitespace-nowrap -animate-y uppercase w-20">{{__('Actions')}}</th>
            @endcanany
            </thead>
            <tbody>
            @foreach($recipes as $recipe)
                <tr class="animate-x" x-data="{recipe:{{$recipe->toJson()}}}">
                    <td class="whitespace-nowrap text-center hidden sm:table-cell">
                        <x-locale-flag :flag="$recipe->locale"/>
                    </td>
                    <td class="whitespace-nowrap">
                        <a href="{{route('dashboard.recipes.edit',$recipe)}}"
                           class="text-slate-600 font-medium hover:text-emerald-600">
                            {{$recipe->name}}
                        </a>
                    </td>
                    <td class="whitespace-nowrap text-center">
                        {{number_format($recipe->views())}}
                    </td>
                    @canany(['products.update','products.delete'])
                        <td class="whitespace-nowrap text-center">
                            <div class="flex justify-center">
                                @can('products.update')
                                    <a href="{{route('dashboard.recipes.edit',$recipe)}}"
                                       class="text-gray-600 btn btn-ghost">
                                        <i icon-name="edit"></i> {{__('Edit')}}
                                    </a>
                                @endcan
                                @can('products.delete')
                                    <a href="javascript:;" data-modal-toggle="recipe-delete-modal"
                                       class="text-red-500 btn btn-ghost"
                                       @click.prevent="deleting=recipe;url='{{route('dashboard.recipes.destroy',$recipe)}}'">
                                        <i icon-name="trash"></i>
                                        {{__('Delete')}}
                                    </a>
                                @endcan
                            </div>
                        </td>
                    @endcanany
                </tr>
            @endforeach
            </tbody>
        </table>
        <x-dashboard.modal id="recipe-delete-modal">
            <x-slot name="heading">{{__('Delete product')}}</x-slot>
            <x-slot name="body">
                <p>{{__('Are you sure you want to delete this post?')}}</p>
            </x-slot>
            <x-slot name="footer">
                <form :action="url" method="post" class="w-full">
                    @method('DELETE')
                    <div class="items-center w-full flex flex-1 justify-between">
                        <div class="btn btn-white btn-sm" data-modal-toggle="recipe-delete-modal">
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
