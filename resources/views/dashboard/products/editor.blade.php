@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-slate-800">{{$editing ? __('Editing Product'):__('New Product')}}</h2>
@endsection

@section('content')
    <form action="{{$editing ? route('dashboard.products.update', $product->id) : route('dashboard.products.store')}}"
          method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @if($editing)
            @method('PUT')
        @endif
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
                <div class="card animate-y">
                    {{-- Name Input --}}
                    <div class="mb-4">
                        <label for="name" class="form-label">{{__('Name')}}</label>
                        <input id="name" name="name" type="text" class="form-input"
                               value="{{old('name') ?? $product->name}}">
                        <x-error class="text-red-500" field="name"/>
                    </div>
                    {{-- Name Input Ends --}}

                </div>

                <div class="animate-y bg-white rounded-lg shadow-md">
                    {{-- Description Input --}}
                    <x-easy-mde name="description"
                                :options="['autosave'=>['enabled'=>true,'delay'=>5000,'uniqueId'=>$product->slug ?? Str::uuid(),'text'=>__('Autosaved at').' '],'spellChecker'=>false]">{{$product->description}}</x-easy-mde>
                    <x-error class="text-red-500" field="description"/>
                    {{-- Description Input Ends --}}
                </div>

                <div class="card animate-y">
                    <header>
                        {{__('Nutritions')}}
                        <small class="block text-slate-500">per 100g.</small>
                    </header>
                    <div class="card-body">
                        <x-error class="text-red-500" field="nutritions"/>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-6 gap-4">
                            @foreach(App\Models\Nutrition::all() as $nutrition)
                                <div class="col-span-1">
                                    <label for="nutrition-{{$nutrition->id}}"
                                           class="form-label">{{__($nutrition->name)}} ({{$nutrition->unit}})</label>
                                    <input id="nutrition-{{$nutrition->id}}" name="nutritions[{{$nutrition->id}}]"
                                           type="text" class="form-input"
                                           value="{{old('nutritions.'.$nutrition->id) ?? ($editing ? $product->nutritions->where('id',$nutrition->id)->first()?->pivot->value: 0)}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="card animate-y">
                    <label for="tagline" class="form-label">{{__('Tagline')}}</label>
                    <textarea id="tagline" name="tagline" class="form-input"
                              rows="3">{{old('tagline') ?? $product->tagline}}</textarea>
                    <x-error class="text-red-500" field="tagline"/>
                </div>

                <div class="card animate-y">
                    <label for="purchase_link" class="form-label">{{__('Purchase Link')}}</label>
                    <input id="purchase_link" name="purchase_link" type="text" class="form-input"
                           value="{{old('purchase_link') ?? $product->purchase_link}}">
                    <x-error class="text-red-500" field="purchase_link"/>
                </div>
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
                                        <img data-src="{{$product->getImage()}}"
                                             alt="{{$product->name}}"
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

                <div class="card animate-y">
                    <header>
                        {{__('Categories')}}
                        <small class="block text-slate-500">{{__('Press CTRL for multiple selection.')}}</small>
                    </header>
                    <div class="card-body">
                        <select name="categories[]" multiple class="form-input h-60">
                            @foreach(\App\Models\Category::with('descendants')->onlyParents()->orderBy('locale')->get()->groupBy('locale') as $locale => $categories)
                                <optgroup label="{{__($locale)}}">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                            {{in_array($category->id,old('categories')??[]) || $product->categories->contains($category) ? 'selected' : ''}}>
                                            {{$category->name}}
                                        </option>
                                        @if($category->has('children'))
                                            @foreach($category->children as $child)
                                                @include('dashboard.product.partials.category-option',['category'=>$child,'product' =>$product])
                                            @endforeach
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card animate-y">
                    <div class="flex items-center justify-between">
                        <b class="font-semibold">{{__('Color')}}</b>
                        <x-color-picker name="color" required :value="old('color',$product->color ?? '#065f46')"/>
                    </div>
                    <x-error class="text-red-500" field="color"/>
                </div>

                <div class="card animate-y">
                    <div class="flex items-center justify-between gap-4">
                        <b class="font-semibold">{{__('Locale')}}</b>
                        <select name="locale" class="form-input">
                            <option disabled {{!$editing ? 'selected' : ''}}>{{__('Please choose one')}}</option>
                            @foreach(getLocales() as $short => $locale)
                                <option value="{{$short}}"
                                    {{$short== old('locale') || $product->locale == $short ? 'selected' : ''}}>
                                    {{__($locale)}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-error class="text-red-500" field="locale"/>
                </div>

                <div class="card animate-y">
                    <div class="flex items-center justify-between gap-4">
                        <b class="font-semibold flex items-center gap-1">
                            {{__('Weight')}}
                            <small class="text-slate-500">(g)</small>
                        </b>
                        <input type="text" name="weight" class="form-input"
                               value="{{old('weight', $product->weight)}}">
                    </div>
                    <x-error class="text-red-500" field="weight"/>
                </div>

                @if($settings->ecommerce['pricing'])
                    <div class="card animate-y">
                        <div class="flex items-center justify-between gap-4">
                            <b class="font-semibold flex items-center gap-1">
                                {{__('Price')}}
                                <small class="text-slate-500">(TL)</small>
                            </b>
                            <input type="text" name="price" class="form-input"
                                   value="{{old('price', $product->price)}}">
                        </div>
                        <x-error class="text-red-500" field="price"/>
                    </div>
                @endif

                <div class="card animate-y">
                    <header>
                        {{__('Ingredients')}}
                        <small class="block text-slate-500">{{__('Press CTRL for multiple selection.')}}</small>
                    </header>
                    <div class="card-body">
                        <select name="ingredients[]" multiple class="form-input">
                            @foreach(App\Models\Ingredient::all()->groupBy('locale') as $locale => $ingredients)
                                <optgroup label="{{__($locale)}}">
                                    @foreach($ingredients as $ingredient)
                                        <option value="{{$ingredient->id}}"
                                            {{in_array($ingredient->id,old('ingredients') ?? []) ||
                                        $product->ingredients->contains($ingredient->id)  ? 'selected' : ''}} >
                                            {{__($ingredient->name)}}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                        <x-error class="text-red-500" field="ingredients"/>
                    </div>
                </div>

            </div>
        </div>


        <div class="flex justify-end gap-4 my-4">
            @unless($editing)
                <button type="submit" name="status" value="draft"
                        class="btn btn-white">{{__('Save as draft')}}</button>
            @endunless
            <button type="submit" name="status" value="published"
                    class="btn btn-emerald">{{$editing ? __('Save') : __('Publish')}}</button>
        </div>
    </form>

@endsection


