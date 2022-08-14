@php($alignment = $alignment ?? 'right')
<div class="lang-selector cursor-pointer animate-x">
    {{--    <x-dropdown :align="$alignment">--}}
    {{--        <x-slot:trigger>--}}
    {{--            <x-locale-flag :flag="app()->getLocale()" class="w-6"/>--}}
    {{--        </x-slot:trigger>--}}
    {{--        <x-slot name="content">--}}
    {{--            {{json_encode(getLocales())}}--}}
    {{--            @foreach(getLocales() as $locale => $name)--}}
    {{--                <x-dropdown-link href="{{url($locale)}}" class="flex items-center">--}}
    {{--                    <x-locale-flag :flag="$locale" class="w-4 h-4 mr-2"/>--}}
    {{--                    {{$name}}--}}
    {{--                </x-dropdown-link>--}}
    {{--            @endforeach--}}
    {{--        </x-slot>--}}
    {{--    </x-dropdown>--}}
    {{dd(app())}}
    <x-dropdown>

        <x-slot name="trigger">
            asd
        </x-slot>
        <x-slot name="content">

        </x-slot>
    </x-dropdown>
</div>
