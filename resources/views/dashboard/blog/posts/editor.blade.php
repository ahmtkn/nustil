@extends('layouts.app')
@php($editing = !is_null($post->id))
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{__('Blog Post')}}
        <small class="block text-xs opacity-70">
            {{$editing ? __('Edit') : __('Create')}}
        </small>
    </h2>
@endsection

@section('content')
    <form action="{{$editing ? route('dashboard.blog.posts.update',$post->slug):route('dashboard.blog.posts.store')}}"
          method="post" autocomplete="off" enctype="multipart/form-data">
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
                {{-- post title starts --}}
                <div class="card animate-y">
                    <label for="title" class="form-label">{{__('Title')}}</label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-input"
                           value="{{old('title') ?? $post->title}}"
                           required>
                    <x-error class="text-red-500" field="title"/>
                </div>
                {{-- post title ends --}}
                {{-- post content starts --}}
                <div class="card animate-y">
                    <x-easy-mde name="body"
                                class="-m-4"
                                :options="['autosave'=>['enabled'=>true,'delay'=>5000,'uniqueId'=>$post->slug ?? Str::uuid(),'text'=>__('Autosaved at').' '],'spellChecker'=>false]">{{$post->body}}</x-easy-mde>
                    <x-error class="text-red-500" field="body"/>
                </div>
                {{-- post content ends --}}
            </div>
            <div>
                {{-- post locale selector starts--}}
                <div class="card animate-y">
                    <header>
                        <label for="locale">{{__('Locale')}}</label>
                    </header>
                    <select name="locale" class="form-input">
                        <option disabled {{is_null($post->id) ? 'selected' : ''}}>{{__('Please choose one')}}</option>
                        @foreach(getLocales() as $short => $locale)
                            <option value="{{$short}}"
                                    {{$short== old('locale') || $post->locale == $short ? 'selected' : ''}}>
                                {{__($locale)}}
                            </option>
                        @endforeach
                    </select>
                    <x-error class="text-red-500" field="locale"/>
                </div>
                {{-- post locale selector ends--}}
                {{-- post categories selector start --}}
                <div class="card animate-y">
                    <header>
                        <label for="categories">
                            {{__('Categories')}}
                        </label>
                        <small class="block text-slate-500">{{__('Press CTRL for multiple selection.')}}</small>

                    </header>
                    <select name="categories[]" id="categories" multiple class="form-input">
                        @foreach(App\Models\BlogCategory::with('descendants')->onlyParents()->get()->groupBy('locale') as $postLocale => $categories)
                            <optgroup label="{{__($postLocale)}}">
                                @foreach($categories as $ctg)
                                    <option value="{{$ctg->id}}"
                                            {{in_array($ctg->id, old('categories') ?? []) ||
                                        $post->categories->contains($ctg)  ? 'selected' : ''}}>
                                        {{$ctg->name}}
                                    </option>
                                    @if($ctg->descendants->count())
                                        @foreach($ctg->descendants as $descendant)
                                            @include('dashboard.categories.partials.option', ['category' => $descendant,'editing'=>$post])
                                        @endforeach
                                    @endif
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                </div>
                {{-- post categories selector end --}}
                {{--post thumbnail starts--}}
                <div class="card animate-y">
                    <header>{{__('Image')}}</header>
                    <div class="card-body">
                        <div class="flex justify-center items-center w-full droppable">
                            <label for="dropzone-file"
                                   class="pseudo-input">
                                <div class="preview object-cover @if(!$editing) hidden @endif ">
                                    <figure
                                        class="mx-auto my-2 w-28 h-28  flex items-center object-cover justify-center rounded-md relative"
                                        style="background-image:url({{asset('img/transparent-grid-bg.png')}})">
                                        <img data-src="{{$post->image?->url}}"
                                             alt="{{$post->title}}"
                                             class="lazy w-auto h-full object-cover mx-auto"/>
                                    </figure>
                                </div>
                                <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                    <svg class="mb-3 w-10 h-10 text-gray-400 icon @if($editing) hidden @endif"
                                         fill="none"
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
                {{--post thumbnail ends--}}
            </div>
        </div>


    </form>
@endsection
