@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{__('dashboard.Ingredients')}}</h2>

@endsection

@section('content')

    <div class="flex items-center justify-end mt-4">
        <a href="{{route('dashboard.ingredients.create')}}" class="btn btn-emerald">
            <i icon-name="plus"></i>
            {{__('Create new ingredient')}}
        </a>
    </div>
    <div
        x-data="{deleting:'',url:'{{route('dashboard.ingredients.delete',['ingredient'=>'INGREDIENT_ID'])}}',action:null}">
        <div class="max-w-6xl mx-auto">
            <table class="data-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th class="text-center">Locale</th>
                    <th class="text-center">Details</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ingredients as $ingredient)
                    <tr>
                        <td>{{$ingredient->id}}</td>
                        <td>{{$ingredient->name}}</td>
                        <td>
                            <x-locale-flag class="w-5 mx-auto" :flag="$ingredient->locale"/>
                        </td>
                        <td>
                            <div class="flex items-center justify-center gap-2">
                                @if($ingredient->is_vegan)
                                    <i icon-name="sprout" data-tooltip-target="ingredientVegan-{{$ingredient->id}}"
                                       data-tooltip-placement="left" class="w-5"></i>
                                    <x-tooltip id="ingredientVegan-{{$ingredient->id}}">{{__('Vegan')}}</x-tooltip>
                                @endif
                                @if(!$ingredient->contains_gluten)
                                    <i icon-name="venetian-mask"
                                       data-tooltip-target="ingredientGluten-{{$ingredient->id}}"
                                       data-tooltip-placement="left" class="w-5"></i>
                                    <x-tooltip
                                        id="ingredientGluten-{{$ingredient->id}}">{{__('Gluten Free')}}</x-tooltip>
                                @endif
                                @if($ingredient->is_organic)
                                    <i icon-name="leaf" data-tooltip-target="ingredientOrganic-{{$ingredient->id}}"
                                       data-tooltip-placement="left" class="w-5"></i>
                                    <x-tooltip id="ingredientOrganic-{{$ingredient->id}}">{{__('Organic')}}</x-tooltip>
                                @endif
                            </div>
                        </td>
                        <td class="text-right">
                            <a href="{{route('dashboard.ingredients.edit',$ingredient)}}"
                               class="btn btn-ghost">
                                <i icon-name="edit" class="w-5 h-5"></i>
                                <span class="hidden sm:block text-xs"> {{__('Edit')}}</span>
                            </a>
                            <button class="btn btn-ghost text-red-500"
                                    data-modal-toggle="deleteIngredient"
                                    @click="deleting=true;action='{{route('dashboard.ingredients.delete',$ingredient)}}'">
                                <i icon-name="trash" class="w-5 h-5"></i>
                                <span class="hidden sm:block text-xs"> {{__('Delete')}}</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-dashboard.modal id="deleteIngredient">
            <x-slot name="heading">{{__('Delete ingredient')}}</x-slot>
            <x-slot name="body">
                <p>{{__('Are you sure you want to delete this ingredient?')}}</p>
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
    </div>
@endsection
