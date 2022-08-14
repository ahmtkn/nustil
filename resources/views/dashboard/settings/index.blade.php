@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-xl text-gray-800 leading-tight">
        {{ __('Settings') }}
    </h2>
@endsection
@section('content')
    <div class="max-w-4xl mx-auto mt-2">
        <div class="card">
            <form action="{{ route('dashboard.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid lg:grid-cols-2 gap-4">
                    @foreach($settings as $key => $value)
                        @if(is_array($value))

                            <div class="flex flex-col col-span-2">
                                <label class="text-gray-800 font-bold text-base my-2 border-b">{{__($key)}}</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($value as $k => $v)

                                        @if(gettype($v) === 'boolean')
                                            <div class="flex flex-col space-x-2">
                                                <label for="setting_{{$key.'_'.$k}}"
                                                       class="text-gray-800 font-semibold text-base">{{__($k)}}</label>
                                                {{-- switch toggle button --}}
                                                <label for="setting_{{$key.'_'.$k}}"
                                                       class="inline-flex relative items-center cursor-pointer">
                                                    <input type="checkbox" id="setting_{{$key.'_'.$k}}"
                                                           name="{{$key}}[{{$k}}]"
                                                           @checked($v)
                                                           class="peer sr-only" id="setting_{{$key.'_'.$k}}">
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 dark:peer-focus:ring-emerald-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                                                </label>
                                                {{-- switch ends --}}
                                            </div>
                                        @else
                                            <div class="flex flex-col space-y-2">

                                                <label class="text-gray-800 font-medium text-sm">{{__($k)}}</label>
                                                <input type="text" class="form-input" name="{{$key}}[{{$k}}]"
                                                       value="{{$v}}">
                                            </div>
                                        @endif

                                    @endforeach
                                </div>
                            </div>
                        @elseif(gettype($value) === 'boolean')
                            <div class="flex items-center justify-between col-span-2">
                                <label class="text-gray-800 font-bold text-base my-2 border-b">{{__($key)}}</label>
                                <input type="checkbox" name="{{$key}}" {{$value ? 'checked' : ''}}>
                            </div>
                        @else
                            <div class="flex flex-col space-y-2">
                                <label class="text-gray-800 font-medium text-sm">{{__($key)}}</label>
                                <input type="text" class="form-input" name="{{$key}}" value="{{$value}}">
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="py-4 mt-2 flex items-center justify-end">
                    <button class="btn btn-emerald">{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
        <form action="{{route('dashboard.settings.reset')}}" method="POST">
            @csrf
            @method('DELETE')
            <div class="py-4 mt-2 flex items-center justify-between">
                <button class="btn btn-red">{{ __('Reset Settings') }}</button>
            </div>
        </form>
    </div>
@endsection
