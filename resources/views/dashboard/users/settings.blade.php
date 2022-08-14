@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Account Settings') }}
    </h2>
@endsection

@section('content')
    <form action="{{route('dashboard.users.settings.update',$user)}}" method="post">
        <div class="max-w-xl mx-auto mt-6">
            <div class="card">
                {{--name--}}
                <div class="mt-4">
                    <label for="name" class="form-label">{{__('Name')}}</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{old('name') ?? $user->name}}">
                    <x-error class="text-red-500" field="name"/>
                </div>
                {{--email--}}
                <div class="mt-4">
                    <label for="email" class="form-label">{{__('Email')}}</label>
                    <input type="email" name="email" id="email" class="form-input"
                           value="{{old('email') ?? $user->email}}">
                    <x-error class="text-red-500" field="email"/>
                </div>
                {{--change password--}}
                <hr class="my-4">
                <h3>{{__('Reset Your Password')}}</h3>
                <div class="mt-4">
                    <label for="old_password" class="form-label">{{__('Old Password')}}</label>
                    <input type="password" name="old_password" id="old_password" class="form-input">
                    <x-error class="text-red-500" field="old_password"/>
                </div>
                <div class="mt-4">
                    <label for="password" class="form-label">{{__('New Password')}}</label>
                    <input type="password" name="password" id="password" class="form-input">
                    <x-error class="text-red-500" field="password"/>
                </div>
                <div class="mt-4">
                    <label for="password_confirmation" class="form-label">{{__('Confirm Password')}}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                    <x-error class="text-red-500" field="password_confirmation"/>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-emerald">{{__('Save')}}</button>
            </div>
        </div>
        @csrf
        @method('PATCH')
    </form>
@endsection
