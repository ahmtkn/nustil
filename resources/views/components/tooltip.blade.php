@php($class = "inline-block absolute invisible z-[100] py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700")
<div {{$attributes->merge(['class'=>$class])}} role="tooltip">
    <div>
        {{$slot}}
    </div>
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
{{-- z-[100] --}}
