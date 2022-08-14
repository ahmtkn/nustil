<?php

$direction = $direction ?? 'bottom';
$active = $active ?? false;
$id = uniqid('move_');
switch ($direction) {
    case 'top':
        $icon = 'chevrons-up';
        $text = 'Move to Top';
        break;
    case 'up':
        $icon = 'chevron-up';
        $text = 'Move up';
        break;
    case 'down':
        $icon = 'chevron-down';
        $text = 'Move down';
        break;
    case 'bottom':
        $icon = 'chevrons-down';
        $text = 'Move to Bottom';
        break;
}

?>

@if($active)
    <a data-tooltip-target="{{$id}}" data-tooltip-placement="top"
       class="text-slate-400 hover:text-emerald-700"
       href="{{route('dashboard.menus.move',['group'=>$item->locale.':'.$item->group,'menu'=>$item->id,'direction'=>$direction])}}">
        <i icon-name="{{$icon}}"></i>
    </a>
    <x-tooltip id="{{$id}}">{{__($text)}}</x-tooltip>
@endif
