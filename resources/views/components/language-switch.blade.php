<div class="relative cursor-pointer" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        <x-locale-flag :flag="app()->getLocale()" class="w-6"/>
    </div>
    <div
        x-show="open"
        style="display:none;width:{{$width}}"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-[5000] mt-2 rounded-full ring-1 ring-black ring-opacity-5  shadow-lg {{ $alignmentClasses }}"
    >
        <div
            class="rounded-full relative flex items-center gap-2 justify-center shadow-lg py-1 bg-white">
            @foreach(getLocales() as $code => $localeName)
                <a href="{{ url($code) }}"
                   class="flex items-center animate-y">
                    <x-locale-flag :flag="$code" class="w-8" data-tooltip-target="switcher-{{$code}}"
                                   data-tooltip-placement="bottom"/>
                    <x-tooltip id="switcher-{{$code}}">
                        <span class="text-sm font-medium">{{ $localeName }}</span>
                    </x-tooltip>
                </a>
            @endforeach
        </div>
    </div>
</div>
