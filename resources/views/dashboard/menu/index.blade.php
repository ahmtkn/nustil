@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Menus') }}
    </h2>
@endsection

@section('content')
    <div class="mx-auto max-w-3xl w-full my-4 lg:my-8 xl:my-12">
        <table class="table data-table">
            <thead>
            <tr>
                <th class="-animate-y">{{__('Language')}}</th>
                <th class="-animate-y">{{__('Group')}}</th>
                <th class="-animate-y">{{__('Elements')}}</th>
                <th class="-animate-y">{{__('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($menus as $locale => $groups)
                @foreach($groups as $group => $links)
                    @php($slug = $locale.':'.$group)
                    <tr class="animate-x group">
                        <td>
                            <a href="{{route('dashboard.menus.show',['group'=>$slug])}}">
                                <x-locale-flag class="w-6" :flag="$locale"/>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('dashboard.menus.show',['group'=>$slug])}}" class="group-hover:text-emerald-500">{{$group}}</a></td>
                        <td>{{count($links)}}</td>
                        <td>#</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
