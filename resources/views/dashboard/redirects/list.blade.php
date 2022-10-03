@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{__('Redirects')}}
    </h2>

@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <table class="data-table mb-8">
            <thead>
            <tr>
                <th>{{__('deprecated url')}}</th>
                <th>{{__('current url')}}</th>
                <th>{{__('redirect status')}}</th>
                <th>{{__('actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($redirects as $redirect)
                <tr>
                    <td>{{$redirect->deprecated}}</td>
                    <td>{{$redirect->current}}</td>
                    <td>{{$redirect->status}}</td>
                    <td class="items-center">
                        <a href="{{url($redirect->deprecated)}}" class="btn btn-blue text-blue-500 btn-sm"
                           target="_blank">
                            {{__('Test et')}}</a>
                        <a href="{{route('dashboard.redirects.delete',$redirect)}}"
                           class="btn btn-sm btn-red">{{__('Delete')}}</a></td>
                </tr>
            @endforeach
            <form method="post" action="{{route('dashboard.redirects.store')}}">
                @csrf
                <tr>
                    <td><input type="text" class="form-input" name="deprecated" autocomplete="off"></td>
                    <td><input type="text" class="form-input" name="current" autocomplete="off"></td>
                    <td><select class="form-input" name="status">
                            <option>301</option>
                            <option>302</option>
                        </select></td>
                    <td>
                        <button class="btn btn-emerald">{{__('Redirect')}}</button>
                    </td>
                </tr>
            </form>
            </tbody>
        </table>
        <hr class="mb-8">
        {{$redirects->links()}}
    </div>
@endsection
