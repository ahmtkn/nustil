@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{__('Categories')}}
        <small class="block text-xs opacity-70">
            {{$category->id ? __('Edit') : __('Create')}}
        </small>
    </h2>
@endsection
@section('content')
    <div class="mx-auto max-w-3xl w-full my-4 lg:my-8 xl:my-12">
        <div class="card">
            <form
                action="{{$category->id ? route('dashboard.blog.categories.update',$category) : route('dashboard.blog.categories.store')}}"
                method="POST">
                @csrf
                @if($category->id)
                    @method('PUT')
                @endif
                <div class="mb-4">
                    <label class="form-label" for="name">
                        {{__('Name')}}
                    </label>
                    <input class="form-input"
                           id="name"
                           name="name"
                           type="text"
                           value="{{old('name') ?? $category->name}}"
                           required
                           autofocus/>
                    <x-error field="name"/>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="locale">
                        {{__('Locale')}}
                    </label>
                    <select name="locale" class="form-input">
                        <option disabled {{is_null($category->id) ? 'selected' : ''}}>{{__('Please choose one')}}</option>
                        @foreach(getLocales() as $short => $locale)
                            <option value="{{$short}}"
                                    {{$short== old('locale') || $category->locale == $short  ? 'selected' : ''}}>
                                {{__($locale)}}
                            </option>
                        @endforeach
                    </select>
                    <x-error field="locale"/>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="parent_id">
                        {{__('Parent')}}
                    </label>
                    <select name="parent_id" class="form-input">
                        <option value=""
                                {{is_null($category->id) || is_null($category->parent_id) ? 'selected' : ''}}>
                            {{__('None')}}
                        </option>
                        @foreach(App\Models\BlogCategory::with('descendants')->onlyParents()->get() as $ctg)
                            <option value="{{$ctg->id}}"
                                    {{$ctg->id == old('parent_id') || $ctg->id == $category->parent_id  ? 'selected' : ''}}>
                                {{$ctg->name}}
                            </option>
                            @if($ctg->descendants->count())
                                @foreach($ctg->descendants as $descendant)
                                    @include('dashboard.categories.partials.option', ['category' => $descendant,'editing'=>$category])
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                    <x-error field="parent_id" />
                </div>
                <div class="mb-4">
                    <label class="form-label" for="description">
                        {{__('Description')}}
                    </label>
                    <textarea class="form-input"
                              id="description"
                              name="description"
                              rows="3">{{old('description') ?? $category->description}}</textarea>
                    <x-error field="description" />
                </div>
                <div class="flex items-center justify-end">
                    <button class="btn btn-emerald" type="submit">
                        {{__('Save')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
