@extends('layouts.app')
@php($backup = new \App\Models\Menu(['locale'=>$lang,'method'=>'url','to'=>null,'title'=>null,'group'=>$group,'order'=>$items->count(),'payload'=>[]]))
@section('header')
    <h2 class="font-bold text-xl text-gray-800 leading-tight">
        {{ __('Menus') }}
        <small class="flex items-center animate-x text-slate-600/[.5]">
            <x-locale-flag class="w-6 mr-2" :flag="$lang"/>
            <span class="animate-x">{{$group}}</span>
        </small>
    </h2>
@endsection
@section('content')
    <div
        x-data="{menuItem:{{$backup->toJson()}},creating:true,action:null,deleteUrl : '{{route('dashboard.menus.delete',['group'=>$lang.':'.$group,'menu'=>'ITEM_ID'])}}'}">
        <div class="flex items-center pt-2 gap-2 justify-end">
            <a href="javascript:;" @click="diagnose()" class="btn btn-white">
                <i icon-name="check"></i>
                {{__('Detect Problems')}}
            </a>
            <a href="javascript:;" @click="menuItem={{$backup->toJson()}};creating=true"
               data-modal-toggle="menu-item-editor"
               class="btn btn-emerald">
                <i icon-name="plus"></i> {{__('New Menu Item')}}
            </a>
            <x-dashboard.modal id="menu-item-editor">
                <x-slot name="heading">
                    <span x-text="creating ? '{{__('New Menu Item')}}' : '{{__('Edit Menu Item')}}'"></span>
                </x-slot>
                <x-slot name="body">

                    <div>
                        <label class="form-label">{{__('Link type')}}</label>
                        <select class="form-input" name="method" x-model="menuItem.method"
                                @change="menuItem.payload = {};menuItem.to=null,menuItem.title=null">
                            <option value="" disabled :selected="menuItem.method===null">
                                {{__('Please choose one')}}
                            </option>
                            <option value="url">{{__('Custom URL')}}</option>
                            <option value="route">{{__('Existing Source')}}</option>
                        </select>
                    </div>
                    <div x-show="menuItem.method=='route'">
                        <div x-data="{items:[]}" class="space-y-2 mt-2">
                            <div>
                                <label class="form-label">{{__('Source')}}</label>
                                <select name="to" class="form-input" x-model="menuItem.to" @change="
                           items = await getModelDataByRoute(menuItem.to,'{{$lang}}','{{route('api.route.show')}}');
                            ">
                                    @foreach(Route::getRoutes() as $route)
                                        @if(!in_array('POST',$route->methods) && in_array('web',$route->action['middleware'])
                                            && !in_array('auth',$route->action['middleware'])
                                            && $route->getName() && !\Illuminate\Support\Str::contains($route->getName(),'password') && $route->getName() != 'root')
                                            <option
                                                value="{{$route->getName()}}">{{__('routes.'.$route->getname())}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="typeof items == 'object' && Object.values(items)[0].length > 0">
                                <label class="form-label">{{__('Target')}}</label>
                                <select class="form-input"
                                        @change="
                                        menuItem.payload = Object.create({});
                                        menuItem.payload[Object.keys(items)[0]] = $event.target.value;
                                         menuItem.title=$event.target.querySelector('option[value='+$event.target.value+']').innerText;">
                                    <option value="" disabled selected>{{__('Please choose one')}}</option>
                                    <template x-for="list in items">
                                        <template x-for="item in list">
                                            <option :value="item.slug ?? item.id"
                                                    x-text="item.name ?? item.title" @click="alert('Hey')"></option>
                                        </template>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">{{__('Title')}}</label>
                                <input type="text" class="form-input" x-model="menuItem.title">
                            </div>
                        </div>
                    </div>
                    <div x-show="menuItem.method=='url' || menuItem.method!='route'" class="mt-2 space-y-2">
                        <div>
                            <label class="form-label">{{__('Title')}}</label>
                            <input type="text" class="form-input" x-model="menuItem.title">
                        </div>
                        <div>
                            <label class="form-label">{{__('URL')}}</label>
                            <input type="url" class="form-input" x-model="menuItem.to">
                        </div>
                    </div>

                </x-slot>
                <x-slot name="footer">
                    <form
                        :action="!creating ? '{{route('dashboard.menus.update',['group'=>$lang.':'.$group,'menu'=>'ITEM_ID'])}}'.replace('ITEM_ID',menuItem.id):'{{route('dashboard.menus.create',['group'=>$lang.':'.$group])}}'"
                        method="post">
                        @csrf
                        <input name="_method" type="hidden" :value="creating ? 'POST' : 'PATCH'">
                        <template x-for="(value,key) in menuItem">
                            <input type="hidden" :name="key"
                                   :value="typeof value == 'object' ? JSON.stringify(value) : value">
                        </template>
                        <div class="mt-2" x-show="menuItem.method && menuItem.to && menuItem.title">
                            <button class="btn btn-emerald"
                                    x-text="creating ? '{{__('Create')}}' : '{{__('Update')}}'"></button>
                        </div>
                    </form>
                </x-slot>
            </x-dashboard.modal>
        </div>
        <div class="max-w-2xl" id="menuItemList">
            @foreach($items as $item)
                <div class="card animate-x group" id="menuItem{{$item->id}}"
                     data-url="{{\App\Models\Menu::getUrl($item)}}">
                    <div class="card-body">
                        <div class="flex justify-between">
                            <div>
                                <b class="flex items-center">
                                    <span class="diagnose-status inline-block mr-2">
                                        <i icon-name="loader-2"
                                           class="processing text-slate-300 animate-spin hidden"></i>
                                        <i icon-name="check" class="success text-emerald-600 hidden"></i>
                                        <i icon-name="x-octagon" class="warning text-red-500 hidden"></i>
                                    </span>
                                    {{$item->title}}
                                </b>
                            </div>
                            <div class="hidden group-hover:flex items-center gap-2">
                                <a class="text-slate-400 hover:text-emerald-700" href="javascript:;"
                                   data-modal-toggle="menu-item-editor"
                                   data-tooltip-target="menu_item_edit_{{$item->id}}" data-tooltip-placement="top"
                                   @click="menuItem={{$item->toJson()}};creating=false">
                                    <i icon-name="edit"></i>
                                </a>
                                <x-dashboard.menus.move-buttons :item="$item" :last="$items->count()"/>
                                <a class="text-slate-400 hover:text-red-500" href="javascript:;"
                                   data-modal-toggle="menu-item-delete-confirmation"
                                   data-tooltip-target="menu_item_delete_{{$item->id}}" data-tooltip-placement="top"
                                   @click="menuItem={{$item->toJson()}};creating=false;action=deleteUrl.replace('ITEM_ID',{{$item->id}})">
                                    <i icon-name="trash-2"></i>
                                </a>
                                <x-tooltip id="menu_item_delete_{{$item->id}}">{{__('Delete')}}</x-tooltip>
                                <x-tooltip id="menu_item_edit_{{$item->id}}">{{__('Edit')}}</x-tooltip>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <x-dashboard.modal id="menu-item-delete-confirmation">
                <x-slot name="heading">
                    {{__('Confirm action')}}
                </x-slot>
                <x-slot name="body">
                    {!! __('You are about to delete this :target :extra. Do you want to proceed this action?',['target'=>__('Menu Item'),'extra'=>__("<b x-text='menuItem.title'></b>")])!!}
                </x-slot>
                <x-slot name="footer">
                    <form :action="action" method="post" class="w-full">
                        @method('DELETE')
                        <div class="items-center w-full flex flex-1 justify-between">
                            <div class="btn btn-white btn-sm" data-modal-toggle="menu-item-delete-confirmation">
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

    </div>

@endsection

@push('scripts')
    <script>
        async function getModelDataByRoute(route, locale, fetchUrl) {
            let response = await fetch(fetchUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json'
                },
                body: JSON.stringify({
                    route: route,
                    locale: locale
                })
            });
            return await response.json();
        }

        function diagnose() {
            const items = document.querySelectorAll('#menuItemList .card');

            for (let i = 0; i < items.length; i++) {
                let icons = {
                    processing: items[i].querySelector('.processing'),
                    success: items[i].querySelector('.success'),
                    warning: items[i].querySelector('.warning')
                };
                let url = items[i].getAttribute('data-url');
                icons.processing.classList.remove('hidden');
                icons.warning.classList.add('hidden');
                icons.success.classList.add('hidden');

                let diagnostic = async function () {
                    let response = await fetch(url).then(function (response) {
                        if (response.status === 200) {
                            icons.success.classList.remove('hidden');
                            icons.processing.classList.add('hidden');
                            icons.warning.classList.add('hidden');
                        } else {
                            icons.warning.classList.remove('hidden');
                            icons.processing.classList.add('hidden');
                            icons.success.classList.add('hidden');
                        }
                        return response.status;
                    }).catch(function (error) {
                        return error.status;
                    });
                }();
            }
        }
    </script>
@endpush
