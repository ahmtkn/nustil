@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Recipes') }}
        <small class="block text-xs opacity-70">
            {{$editing ? __('Edit') : __('Create')}}
        </small>
    </h2>
@endsection

@section('content')
    <form action="{{$editing ? route('dashboard.recipes.update',$recipe) : route('dashboard.recipes.store')}}"
          method="post" enctype="multipart/form-data">
        @if($editing)
            @method('PUT')
        @endif
        @csrf
        <div class="flex justify-end gap-4 mt-4">
            <button type="submit"
                    class="btn btn-emerald">{{$editing ? __('Save Changes') : __('Publish')}}</button>
        </div>

        <div class="grid md:grid-cols-3 xl:grid-cols-4 gap-4 pb-24">
            <div class="col-span-2 xl:col-span-3">
                {{-- recipe title starts --}}
                <div class="card animate-y">
                    <label for="name" class="form-label">{{__('Title')}}</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-input"
                           value="{{old('name') ?? $recipe->name}}"
                           required>
                    <x-error class="text-red-500" field="name"/>
                </div>
                {{-- recipe title ends --}}
                <div class="grid grid-cols-2 gap-x-4">
                    {{-- recipe description starts --}}
                    <div class="card animate-y">
                        <header>
                            <label for="description">{{__('Description')}}</label>
                        </header>

                        <textarea name="description"
                                  id="description"
                                  class="form-input"
                                  rows="7">{{old('description') ?? $recipe->description}}</textarea>
                        <x-error class="text-red-500" field="description"/>
                    </div>
                    {{-- recipe description ends --}}
                    {{-- recipe ingredients starts --}}
                    <div class="card animate-y">
                        <header>
                            <label for="ingredients">{{__('Ingredients')}}</label>
                            <small class="block text-slate-500">
                                {{__('Everyline creates a new item in the list')}}
                            </small>
                        </header>

                        <textarea name="ingredients"
                                  id="ingredients"
                                  class="form-input"
                                  rows="7">{{old('ingredients') ?? ($editing ? implode("\n",$recipe->ingredients) : '')}}</textarea>
                        <x-error class="text-red-500" field="ingredients"/>
                    </div>
                    {{-- recipe ingredients ends --}}
                    {{-- recipe instructions starts --}}
                    <div class="card animate-y">
                        <header>
                            <label for="instructions">{{__('Instructions')}}</label>
                            <small class="block text-slate-500">
                                {{__('Everyline creates a new item in the list')}}
                            </small>
                        </header>
                        <textarea name="instructions"
                                  id="instructions"
                                  class="form-input"
                                  rows="7">{{old('instructions') ?? ($editing ? implode("\n",$recipe->instructions) : '')}}</textarea>
                        <x-error class="text-red-500" field="instructions"/>
                    </div>
                    {{-- recipe instructions ends --}}
                    {{-- recipe notes starts --}}
                    <div class="card animate-y">
                        <header>
                            <label for="notes">{{__('Notes')}}</label>
                        </header>
                        <textarea name="notes"
                                  id="notes"
                                  class="form-input"
                                  rows="7">{{old('notes') ?? $recipe->notes}}</textarea>
                        <x-error class="text-red-500" field="notes"/>
                    </div>
                </div>

            </div>

            <div>
                {{-- recipe image starts --}}
                <div class="card animate-y">
                    <header>{{__('Image')}}</header>
                    <div class="card-body">
                        <div class="flex justify-center items-center w-full droppable">
                            <label for="dropzone-file"
                                   class="pseudo-input">
                                <div class="preview  @if(!$editing) hidden @endif ">
                                    <figure
                                        class="mx-auto my-2  w-28 h-28  flex items-center object-cover justify-center rounded-md relative"
                                        style="background-image:url({{asset('img/transparent-grid-bg.png')}})">
                                        <img
                                            data-src="{{$recipe->image ? $recipe->image->url :''}}"
                                            alt="{{$recipe->name}}"
                                            class="lazy w-auto h-full bg-cover mx-auto"/>
                                    </figure>
                                </div>
                                <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                    <svg class="mb-3 w-10 h-10 text-gray-400 icon" fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 text">
                                        <span class="font-semibold">{{__('Click to upload')}}</span>
                                        {{__('or drag and drop')}}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG, GIF</p>
                                </div>
                                <input type="file" id="dropzone-file" name="image" accept="image/*" class="hidden"/>
                            </label>
                        </div>
                        <x-error class="text-red-500" field="image"/>
                    </div>
                </div>
                {{-- recipe image ends --}}
                {{-- recipe category starts --}}
                {{-- recipe locale selector starts --}}
                <div class="card animate-y">
                    <header>
                        <label for="locale">{{__('Locale')}}</label>
                    </header>
                    <select name="locale" class="form-input">
                        <option disabled {{is_null($recipe->id) ? 'selected' : ''}}>{{__('Please choose one')}}</option>
                        @foreach(getLocales() as $short => $lcl)
                            <option value="{{$short}}"
                                {{$recipe->locale == $short ? 'selected' : ''}}>{{$lcl}}</option>
                        @endforeach
                    </select>
                    <x-error class="text-red-500" field="locale"/>
                </div>
                {{-- recipe locale selector ends --}}

                {{-- products contained by the recipe starts --}}
                <div class="card animate-y">
                    <header>
                        <label for="products">{{__('Products')}}</label>
                        <small class="block text-slate-500">{{__('Press CTRL for multiple selection.')}}</small>
                    </header>
                    <select name="products[]" class="form-input h-40" id="products" multiple>
                        @foreach($products as $lcl => $prds)
                            <optgroup label="{{__($lcl)}}">
                                @foreach($prds as $product)
                                    <option value="{{$product->id}}"
                                        {{in_array($product->id,$recipe->products->pluck('id')->toArray())  ? 'selected' : ''}}>
                                        {{Str::limit($product->name,20)}}
                                        &emsp;({{$product->weight}}gr.)
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <x-error class="text-red-500" field="products"/>
                </div>
                {{-- products contained by the recipe ends --}}
            </div>
        </div>
        <div class="flex justify-end gap-4 w-full mt-4">
            <button type="submit"
                    class="btn btn-emerald">{{$editing ? __('Save Changes') : __('Publish')}}</button>
        </div>
    </form>
@endsection
