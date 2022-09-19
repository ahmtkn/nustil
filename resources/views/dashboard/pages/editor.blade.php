@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pages') }}
        <small class="block text-xs opacity-70">
            {{$editing ? __('Edit') : __('Create')}}
        </small>
    </h2>
@endsection

@section('content')
    {{--  Page editor form  --}}
    <form action="{{$editing ? route('dashboard.pages.update',$page) : route('dashboard.pages.store',$page)}}"
          method="post">
        @if($editing)
            @method('PUT')
        @endif
        @csrf
        <div class="flex justify-end gap-4 mt-4">
            @unless($editing)
                <button type="submit" name="status" value="draft"
                        class="btn btn-white">{{__('Save as draft')}}</button>
            @endunless
            <button type="submit" name="status" value="published"
                    class="btn btn-emerald">{{$editing ? __('Save') : __('Publish')}}</button>
        </div>
        <div class="grid md:grid-cols-3 xl:grid-cols-4 gap-4 pb-24">
            <div class="col-span-2 xl:col-span-3">
                {{-- page title starts --}}
                <div class="card animate-y">
                    <label for="title" class="form-label">{{__('Title')}}</label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-input"
                           value="{{old('title') ?? $page->title}}"
                           required>
                    <x-error class="text-red-500" field="title"/>
                </div>
                {{-- page title ends --}}
                {{-- page content starts --}}
                <div class="card animate-y">
                    <x-easy-mde name="content"
                                class="-m-4"
                                :options="['autosave'=>['enabled'=>false,'delay'=>5000,'uniqueId'=>$page->slug ?? Str::uuid(),'text'=>__('Autosaved at').' '],'spellChecker'=>false]">{{$page->content}}</x-easy-mde>
                    <x-error class="text-red-500" field="content"/>
                </div>
                {{-- page content ends --}}
            </div>
            <div>
                {{-- page locale selector starts--}}
                <div class="card animate-y">
                    <header>
                        <label for="locale">{{__('Locale')}}</label>
                    </header>
                    <select name="locale" class="form-input">
                        <option disabled {{is_null($page->id) ? 'selected' : ''}}>{{__('Please choose one')}}</option>
                        @foreach(getLocales() as $short => $lcl)
                            <option value="{{$short}}"
                                    {{$page->locale === $short ? 'selected' : ''}}>{{$lcl}}</option>
                        @endforeach
                    </select>
                    <x-error class="text-red-500" field="locale"/>
                </div>
                {{-- page locale selector ends--}}
                {{-- page options starts--}}
                <div class="card animate-y">
                    <header>
                        <label for="options">{{__('Options')}}</label>
                    </header>
                    @foreach($page->options ?? $page->defaultOptions as $option => $value)
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="options[{{$option}}]"
                                   id="options[{{$option}}]"
                                   class="form-checkbox"
                                   value="1"
                                   @if($value) checked @endif>
                            <label for="options[{{$option}}]"
                                   class="form-label ml-2">{{__($option)}}</label>
                        </div>
                    @endforeach

                    <x-error class="text-red-500" field="options"/>
                </div>
                {{-- page options ends--}}
            </div>
        </div>
    </form>
@endsection
