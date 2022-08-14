@php($last = $last  ?? 0)

<x-dashboard.menus.move :item="$item" direction="top" :active="$item->order > 0"/>
<x-dashboard.menus.move :item="$item" direction="up" :active="$item->order > 0"/>
<x-dashboard.menus.move :item="$item" direction="down" :active="$item->order < $last -1"/>
<x-dashboard.menus.move :item="$item" direction="bottom" :active="$item->order < $last-1"/>
