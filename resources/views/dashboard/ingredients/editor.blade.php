@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{__('dashboard.Ingredients')}}
        <small class="block text-xs opacity-70">
            {{$editing ? __('Edit') : __('Create')}}
        </small>
    </h2>
@endsection

@section('content')
    <form
        action="{{$editing ? route('dashboard.ingredients.update',$ingredient) : route('dashboard.ingredients.store')}}"
        method="post" autocomplete="off">
        @csrf
        @if($editing)
            @method('PUT')
        @endif
        <div class="max-w-2xl mt-6 mx-auto">
            <div class="card">
                <div class="mb-4">
                    <label for="name" class="form-label">
                        {{__('Name')}}
                    </label>
                    <input type="text" name="name" id="name" class="form-input"
                           value="{{old('name') ?? $ingredient->name}}">
                </div>
                <div class="mb-4">
                    <label for="locale" class="form-label">
                        {{__('Locale')}}
                    </label>
                    <select name="locale" class="form-input">
                        <option disabled @selected(!$editing)>{{__('Please choose one')}}</option>
                        @foreach(getLocales() as $short => $locale)
                            <option value="{{$short}}"
                                @selected(old('locale') == $ingredient->locale || $ingredient->locale == $short)>
                                {{$locale}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2">
                    @foreach(['is_vegan','contains_gluten','is_nuts','is_organic','is_saturated_fat'] as $detail)
                        <div class="col-span-1">
                            <div class="form-checkbox">
                                <input type="checkbox" class="text-emerald-600" name="{{$detail}}" id="{{$detail}}"
                                       value="1"
                                       @if(old($detail) ?? $ingredient->$detail) checked @endif>
                                <label for="{{$detail}}">
                                    {{__('dashboard.ingredients.'.$detail)}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="btn btn-emerald">
                <i icon-name="{{$editing ? 'edit' : 'plus'}}" class="w-5"></i>
                {{$editing ? __('Update') : __('Create')}}
            </button>
        </div>
    </form>

@endsection
