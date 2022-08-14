@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('New Slide') }}
    </h2>
@endsection
@php($editing = !is_null($slide->id))
@section('content')

    {{--  Slide form  --}}
    <form action="{{$editing ? route('dashboard.slides.update',$slide) : route('dashboard.slides.store')}}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if($editing)
            @method('PUT')
        @endif
        <div class="card animate-y">
            <div class="card-body">
                <div class="flex justify-center items-center w-full droppable">
                    <label for="dropzone-file"
                           class="pseudo-input flex flex-col justify-center items-center w-full bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-500 dark:hover:border-gray-500 dark:hover:bg-gray-500">
                        <div class="preview ">
                            <figure
                                class="mx-auto my-2  w-28 h-28  flex items-center object-cover justify-center rounded-md relative"
                                style="background-image:url({{asset('img/transparent-grid-bg.png')}})">
                                <img data-srcset="{{$slide->srcSet() ?? '#'}}"
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

                <div class="mt-4">
                    {{--                    locale--}}

                    <label for="locale" class="form-label">{{__('Locale')}}</label>
                    <select name="locale" id="locale" class="form-input">
                        <option disabled
                                value="" @selected(is_null($slide->locale))>{{__('Please choose one')}}</option>
                        @foreach(getLocales() as $lcl => $name)
                            <option value="{{$lcl}}"
                                @selected(old('locale') == $lcl || $slide->locale == $lcl)>
                                {{__($lcl)}}
                            </option>
                        @endforeach
                    </select>
                    <x-error class="text-red-500" field="locale"/>
                </div>

                {{--     Slide title       --}}
                <div class="mt-4">
                    <label for="title" class="form-label">
                        {{__('Title')}}
                    </label>
                    <input type="text" name="title" id="title"
                           class="form-input"
                           value="{{$slide->title ?? ''}}"/>
                    <x-error class="text-red-500" field="title"/>
                </div>
                {{--            slide subtitle --}}
                <div class="mt-4">
                    <label for="subtitle" class="form-label">
                        {{__('Subtitle')}}
                    </label>
                    <input type="text" name="subtitle" id="subtitle"
                           class="form-input"
                           value="{{$slide->subtitle ?? ''}}"/>
                    <x-error class="text-red-500" field="subtitle"/>
                </div>
                <div class="flex items-center w-full gap-4 mt-4">
                    <div class="w-full">
                        <label for="buttonText" class="form-label">{{__('Button Text')}}</label>
                        <input type="text" name="button[text]" id="buttonText" class="form-input"
                               value="{{old('button.text') ?? $slide->buttons[0]['text'] ?? ''}}"/>
                    </div>
                    <div class="w-full">
                        <label for="buttonColor" class="form-label">{{__('Button Color')}}</label>
                        <select class="form-input" name="button[color]" id="buttonColor">
                            {{-- Tailwindcss colors --}}
                            @foreach($colors as $color)
                                <option value="{{$color}}"
                                        class="bg-{{$color}}-500" @selected(old('button.color') == $color || ($slide->buttons[0]['color'] ?? '') == $color)>{{Str::ucfirst($color)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="buttonHref" class="form-label">{{__('Button Link')}}</label>
                        <input type="url" name="button[href]"
                               value="{{old('button.href') ?? $slide->buttons[0]['href'] ?? ''}}"
                               id="buttonHref" class="form-input"/>
                    </div>

                    <div class="w-full">
                        <label for="buttonTarget" class="form-label">{{__('Button Target')}}</label>
                        <select class="form-input" name="button[target]" id="buttonTarget">
                            <option
                                value="_self"
                                @selected(old('button.target') == '_self' || ($slide->buttons[0]['target'] ?? '') == '_self')>
                                {{__('Same Window')}}
                            </option>
                            <option
                                value="_blank"
                                @selected(old('button.target') == '_blank' || ($slide->buttons[0]['target'] ?? '') == '_blank')>
                                {{__('New Window')}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex items-center flex-col">
                    <label class="form-label">{{__('Publishing Duration')}} <small
                            class="block opacity-70">{{__('From')}} - {{__('Until')}}</small></label>
                    <div date-rangepicker datepicker-format="dd/mm/yyyy" class="flex items-center">
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                     fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input name="published_at" type="text"
                                   value="{{old('published_at') ?? ($slide->published_at ?? now())->format('d/m/Y')}}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="{{__('Select a date to publish')}}">
                        </div>
                        <span class="mx-4 text-gray-500">-</span>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                     fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input name="expires_at" type="text"
                                   value="{{old('expires_at') ?? ($slide->expires_at ?? now()->modify('+1 month'))->format('d/m/Y')}}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="{{__('Select a date to expire')}}">
                        </div>
                    </div>
                    <x-error class="text-red-500" field="published_at"/>
                    <x-error class="text-red-500" field="expires_at"/>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <button type="submit" class="btn btn-emerald animate-y">
                {{__('Save')}}
            </button>
        </div>
    </form>
@endsection
@push('scripts')
    <script src="https://unpkg.com/flowbite@1.5.1/dist/datepicker.js"></script>
@endpush
<!--
     bg-slate-500
     bg-gray-500
     bg-zinc-500
     bg-neutral-500
     bg-stone-500
     bg-red-500
     bg-orange-500
     bg-amber-500
     bg-yellow-500
     bg-lime-500
     bg-green-500
     bg-emerald-500
     bg-teal-500
     bg-cyan-500
     bg-sky-500
     bg-blue-500
     bg-indigo-500
     bg-violet-500
     bg-purple-500
     bg-fuchsia-500
     bg-pink-500
     bg-rose-500
-->
