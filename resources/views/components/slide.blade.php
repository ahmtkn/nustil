@props(['loop', 'itemCount' => 0, 'slide' => null])
<div
    class="duration-700 ease-in-out absolute inset-0 transition-all transform translate-x-0 z-20"
    @if($itemCount > 1) @if($loop->first) data-carousel-item="active" @else data-carousel-item @endif @endif
>

    <img data-src="{{$slide->image?->url}}"
         class="block absolute top-1/2 left-1/2 lazy w-full -translate-x-1/2 -translate-y-1/2"
         alt="{{$slide->title}}">

    <div class="relative w-full bg-slate-900/30 h-full flex items-center justify-center flex-col lg:pt-24">
        @if($slide->title)
            <h1 class="text-4xl font-black animate-y font-nunito text-white">{{$slide->title}}</h1>
        @endif

        @if($slide->subtitle)
            <p class="text-base md:text-lg lg:text-xl animate-y nustil-animation-delay-4 font-bold text-white/70 tracking-wide">
                {{$slide->subtitle}}
            </p>
        @endif

        @if($slide->buttons && count($slide->buttons))
            <div
                class="mt-4 md:mt-6 lg:mt-12 flex items-center justify-center gap-4 nustil-animation-delay-6 animate-y">
                @foreach($slide->buttons as $button)
                    <x-slider-button :props="$button"/>
                @endforeach
            </div>
        @endif
    </div>
</div>
