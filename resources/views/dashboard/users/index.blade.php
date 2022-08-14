@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}
        <small class="block text-slate-600/[.5] animate-x">
            {{__('Page :page',['page'=>request()->input('page') ?? 1])}}
        </small>
    </h2>
@endsection

@section('content')
    <div x-data="{deleting:'',url:'{{route('dashboard.users.delete',['user'=>'USER_ID'])}}',action:null}">
        @can('users.create')
            <div class="flex items-center justify-end -animate-x p-3">
                <a href="{{route('dashboard.users.create')}}" class="btn btn-emerald btn-sm gap-2">
                    <i icon-name="plus"></i>
                    {{__('Create a new user')}}
                </a>
            </div>
        @endcan

        <section class="my-4 mx-auto max-w-7xl">
            <table class="data-table">
                <thead>
                <tr>
                    <th class="whitespace-nowrap -animate-y text-center hidden sm:table-cell">#</th>
                    <th class="whitespace-nowrap -animate-y uppercase">{{__('Name')}}</th>
                    <th class="whitespace-nowrap -animate-y uppercase">{{__('Email')}}</th>
                    <th class="whitespace-nowrap -animate-y uppercase text-center hidden sm:table-cell">{{__('Role')}}</th>
                    @canany(['users.update','users.delete'])
                        <th class="whitespace-nowrap uppercase -animate-y text-center ">{{__('Actions')}}</th>
                    @endcanany
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="-animate-x nustil-animation-delay-5" x-data="{user:{{$user->toJson()}}}">
                        <td class="text-center hidden sm:table-cell">{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td class="text-opacity-70 text-slate-800 truncate w-56 md:w-auto">{{$user->email}}</td>
                        <td class="text-center hidden sm:table-cell">{{$user->getRoleNames()->last() ?? '-'}}</td>
                        @canany(['users.update','users.delete'])
                            <td class="text-center border-l w-56 ">
                                <div class="flex items-center justify-center gap-2">
                                    @if($user->id == Auth::id())
                                        <a href="{{route('dashboard.users.settings',$user)}}"
                                           class="btn btn-sm btn-ghost text-slate-600">
                                            <i icon-name="cog"></i>
                                            <span class="hidden sm:block">{{__('Account Settings')}}</span>
                                        </a>
                                    @endif
                                    @can('users.update')
                                        <a href="{{route('dashboard.users.edit',$user)}}" class="btn btn-ghost">
                                            <i icon-name="edit"></i>
                                            <span class="hidden sm:block">{{__('Edit')}}</span>
                                        </a>
                                    @endcan
                                    @can('users.delete')
                                        @if($user->id != Auth::id())
                                            <a href="javascript:;" data-modal-toggle="user-delete-modal"
                                               @click="deleting=user;action=url.replace('USER_ID',{{$user->id}})"
                                               class="btn btn-ghost text-red-500">
                                                <i icon-name="trash-2"></i>
                                                <span class="hidden sm:block">{{__('Delete')}}</span>
                                            </a>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
        <div class="p-3">{{$users->links()}}</div>
        <x-dashboard.modal id="user-delete-modal">
            <x-slot name="heading">
                {{__('Confirm action')}}
            </x-slot>
            <x-slot name="body">
                {!! __('You are about to delete this :target :extra. Do you want to proceed this action?',['target'=>__('User'),'extra'=>__("<span x-text='deleting.name'></span>")])!!}
            </x-slot>
            <x-slot name="footer">
                <form :action="action" method="post" class="w-full">
                    @method('DELETE')
                    <div class="items-center w-full flex flex-1 justify-between">
                        <div class="btn btn-white btn-sm" data-modal-toggle="user-delete-modal">
                            <i icon-name="chevron-left" class="p-1"></i> {{__('Abort')}}
                        </div>
                        <button class="btn btn-danger btn-sm">
                            <i class="p-1" icon-name="trash-2"></i>
                            {{__('Delete')}}
                        </button>
                        @csrf
                    </div>
                </form>
            </x-slot>
        </x-dashboard.modal>
    </div>
@endsection
