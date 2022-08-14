@extends('layouts.auth')

@section('content')

    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <div class="hidden relative xl:flex flex-col justify-center min-h-screen">
                <a href="{{route('landing')}}" class="-animate-x flex items-center pt-5">
                    <x-application-logo logo="white"/>
                </a>

            </div>
            <div class="h-screen animate-x xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">

                <div
                    class="my-auto animate-x mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="animate-x mt-2 text-slate-400 xl:hidden text-center">
                            <a href="{{route('landing')}}"
                               class="animate-x flex justify-center items-center -mt-16 mb-4">
                                <x-application-logo class="h-10 mx-auto drop-shadow-lg shadow-white"/>
                            </a>
                        </div>
                        <h1 class="animate-x font-poppins text-slate-700 mt-1 font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            {{__('Sign in')}}.
                        </h1>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')"/>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                        <div class="animate-x mt-8 relative">
                            <x-input id="email" class="form-input"
                                     type="email"
                                     name="email"
                                     :value="old('email')"
                                     required
                                     placeholder="{{__('Email')}}"
                                     autofocus
                                     autocomplete="off"/>

                            <x-input id="password" class="form-input mt-4"
                                     type="password"
                                     name="password"
                                     placeholder="{{__('Password')}}"
                                     required
                                     autocomplete="current-password"/>
                        </div>
                        <div class="flex text-slate-600 text-xs sm:text-sm mt-4 justify-between animate-x">
                            <label for="remember_me" class="inline-flex items-center select-none">
                                <input id="remember_me" type="checkbox"
                                       class="rounded border-gray-300 text-nustil-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       name="remember">
                                <span class="ml-2 text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-gray-600 hover:text-nustil-500 animate-x"
                                   href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="animate-x mt-5 xl:mt-8 text-center xl:text-left flex">
                            <button
                                class="btn btn-emerald py-3 font-semibold px-4 flex-1 w-full xl:w-32 xl:mr-3 align-top">
                                {{__('Submit')}}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
