@extends('layouts.app')
@php($isNew = is_null($user->id))
@php($action = $isNew ? route('dashboard.users.store') : route('dashboard.users.update',$user))
@php($permGroup = [])
@section('header')
    <h2 class="font-bold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}<small
            class="block text-slate-600/[.5] animate-x">{{$user->name}}</small>
    </h2>
@endsection
@section('content')
    <form action="{{$action}}" method="post" autocomplete="off">
        <div class="flex items-center justify-end p-3">
            <!-- Validation Errors -->

            <button class="btn btn-emerald -animate-x btn-sm gap-2">
                @if($isNew)
                    <i icon-name="plus"></i> {{__('Create')}}
                @else
                    <i icon-name="save"></i> {{__('Save')}}
                @endif
            </button>
        </div>
        @if(!$isNew)
            @method('PATCH')
        @endempty
        @csrf
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:mt-8 items-start">
            <div class="box w-full animate-y">
                <header>
                    <div class="title">{{__('Account Details')}}</div>
                </header>
                <div class="form">
                    <div class="mb-6">
                        <label for="name"
                               class="form-label">{{__('Name')}}</label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="John Doe" required
                               @error('name') aria-describedby="name-error-text" @enderror
                               autocomplete="off" value="{{old('name') ?? $user->name}}">
                        @error('name')
                        <p id="name-error-text" class="mt-2 text-sm text-red-500">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="email"
                               class="form-label">{{__('Email')}}</label>
                        <input type="email" name="email" id="email" class="form-input" placeholder="name@example.com"
                               required
                               @error('email') aria-describedby="email-error-text" @enderror
                               autocomplete="off" value="{{old('email') ?? $user->email}}">
                        @error('email')
                        <p id="email-error-text" class="mt-2 text-sm text-red-500">{{$message}}</p>
                        @enderror
                    </div>
                    @if($isNew)
                        <div class="mb-6">
                            <label for="password"
                                   class="form-label">{{__('Password')}}</label>
                            <input type="password" name="password" id="password" class="form-input" placeholder=""
                                   required
                                   @error('password') aria-describedby="password-error-text" @enderror
                                   autocomplete="off" value="{{old('password')}}">
                            @error('password')
                            <p id="password-error-text" class="mt-2 text-sm text-red-500">{{$message}}</p>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
            @canany(['permissions.update','roles.update'])
                <div class="box w-full animate-y"
                     x-data="{roles:{{$roles->toJson()}},perms:{{ $user->permissions ? $user->permissions->toJson() : '[]'}}}">
                    <header>
                        <div class="title">{{__('Permissions & Roles')}}</div>
                    </header>
                    <div class="-my-4 divide-y w-full items-center justify-center flex flex-col">
                        <div class="p-4 w-full -animate-y">
                            <label for="role"
                                   class="form-label">{{__('Role')}}</label>
                            <select id="role" name="role"
                                    class="form-input"
                                    x-on:change="let roleIndex = $event.target.value -1;perms=roles[roleIndex].permissions;">
                                @if($isNew || !$user->hasAnyRole($roles))
                                    <option disabled selected>{{__('Please choose one')}}</option>
                                @endif
                                @foreach($roles as $role)
                                    <option
                                        value="{{$role->id}}" @selected(!$isNew && $user->getRoleNames()->last() == $role->name)>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="p-4 w-full grid md:grid-cols-2 xl:grid-cols-3">
                            @foreach($permissions as $permission)
                                @php($group = Str::title(explode('.',$permission->name)[0]))
                                @php($permGroup[$group][] = $permission)
                            @endforeach
                            @foreach($permGroup as $group => $perms)
                                <div class="mb-3 animate-x">
                                    <div class="form-label animate-x">{{__($group)}}</div>
                                    <ul>
                                        @foreach($perms as $perm)
                                            <li x-data="{permission:{{$perm->toJson()}}}" class="animate-x">
                                                <div class="flex items-center mb-4">
                                                    <input id="permission.{{$perm->name}}" type="checkbox"
                                                           value="{{$perm->id}}"
                                                           name="permissions[]"
                                                           :checked="perms.length > 0 &&
                                                          perms.find(perm => {
                                                               for(key in permission){
                                                                   if(!(key in perm)) return false;
                                                                   if(perm[key] !== permission[key]) return false;
                                                               }
                                                               return true;
                                                           }) !== undefined"
                                                           @checked(!$isNew && $user->hasPermissionTo($perm) || ($user->hasAnyRole($roles) && $user->roles->last()->hasPermissionTo($perm)))
                                                           class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="permission.{{$perm->name}}"
                                                           class="ml-2 text-sm font-regular text-gray-900 dark:text-gray-300">
                                                        {{__('permission.'.explode('.',$perm->name)[1])}}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endcanany
        </div>
    </form>
@endsection
