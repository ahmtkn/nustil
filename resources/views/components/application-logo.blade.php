@props(['logo'])
@php($shade = $logo ?? 'dark')

<img src="{{asset('img/logos/logo-'.$shade.'.png')}}" {{$attributes->merge(['class'=>'max-h-[90px] select-none'])}}>
