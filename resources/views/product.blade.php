@extends('layouts.guest')

@section('content')

    <section class="bg-slate-50 overflow-hidden">
        <div
            class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
            <div class="grid gap-5 row-gap-10 lg:grid-cols-2 relative">

                <div class="flex flex-col justify-center relative order-2 lg:order-1">
                    {{--Watermark--}}
                    <div
                        class="absolute opacity-10 left-0 lg:left-20 top-0 flex lg:items-center lg:justify-end transform -rotate-12">
                        <div
                            class="select-none animate-y max-w-md text-justify tracking-widest font-black font-splash text-7xl"
                            style="color: {{$product->color}}">
                            {{$product->name}}
                        </div>
                    </div>
                    {{-- Watermark Ends --}}
                    <div class="max-w-xl mb-6">
                        <h1 class="max-w-xl mb-4 select-none font-nunito text-3xl -animate-x font-black tracking-tight sm:text-4xl lg:text-6xl sm:leading-none"
                            style="color:{{$product->color}}">
                            {{$product->name}}
                        </h1>
                        <div class="flex items-center space-x-3 mb-4 relative nustil-animation-delay-4">
                            @foreach($product->categories as $category)
                                @if($category->locale == app()->getLocale())
                                    <a href="{{route('category.show',$category)}}"
                                       class="text-sm font-nunito text-gray-600 -animate-x hover:text-gray-900">{{$category->name}}</a>
                                    @unless($loop->last)
                                        <span class="text-gray-600 -animate-x">•</span>
                                    @endunless
                                @endif

                            @endforeach
                        </div>
                        <p class="text-base animate-y text-gray-700 md:text-lg">
                            {{$product->tagline}}
                        </p>
                    </div>
                    <div class="flex items-center select-none justify-around mb-6">
                        @if($product->created_at->diff(now())->days < $settings->product['newProductInterval'])
                            <div
                                class="flex flex-col animate-y items-center justify-center rounded-full bg-red-500 w-20 h-20 text-white">
                                <span
                                    class="tracking-wider text-white font-splash text-lg -rotate-12">{{__('New')}}</span>
                            </div>
                        @endif
                        @if($product->isVegan())
                            <div
                                class="flex flex-col animate-y items-center justify-center rounded-full border-2 w-20 h-20 border-emerald-700 text-emerald-700">
                                <div class="icon">
                                    <i icon-name="sprout" class="w-7 h-7"></i>
                                </div>
                                <span class="font-nunito font-bold tracking-wider block">{{__('Vegan')}}</span>
                            </div>
                        @endif
                        @if($product->isGlutenFree())
                            <div
                                class="flex flex-col animate-y items-center justify-center rounded-full border-2 w-20 h-20 border-amber-600 text-amber-600">
                                <div class="icon">
                                    <i icon-name="venetian-mask" class="w-7 h-7"></i>
                                </div>
                                <span
                                    class="font-nunito font-bold text-xs mx-auto text-center block">{{__('Gluten Free')}}</span>
                            </div>
                        @endif
                        @if($product->isOrganic())
                            <div
                                class="flex flex-col animate-y items-center justify-center rounded-full border-2 w-20 h-20 border-emerald-700 text-emerald-700">
                                <div class="icon">
                                    <i icon-name="leaf" class="w-7 h-7"></i>
                                </div>
                                <span
                                    class="font-nunito text-sm font-bold tracking-wider block">{{__('Organic')}}</span>
                            </div>
                        @endif
                    </div>

                    @if($product->purchase_link)
                        <div
                            class="flex items-center relative justify-center my-6 pb-6 animate-y nustil-animation-delay-7">
                            <a href="{{$product->purchase_link}}?ref=nustil.com" target="_blank"
                               class="btn btn-purple btn-rounded w-full hover:bg-transparent font-nunito text-lg hover:font-extrabold hover:tracking-widest">
                                {{__('Buy Now')}}
                            </a>
                        </div>
                    @endif

                    @if($product->ingredients->count())
                        <div>
                            <p class="mb-4 text-sm font-bold tracking-widest animate-y uppercase">{{__('Ingredients')}}</p>
                            <ul class="grid space-y-3 sm:gap-2 grid-cols-2 lg:grid-cols-3 sm:space-y-0">
                                @foreach($product->ingredients as $ingredient)
                                    <li class="flex items-center animate-y">
                                        <div class="mr-2 text-sm">
                                            <i icon-name="circle-dot" class="w-5 h-5"></i>
                                        </div>
                                        <span>{{$ingredient->name}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
                <div class="flex items-center justify-center select-none text-center animate-y order-1 lg:order-2">
                    <img class="h-56 sm:h-96 mx-auto lazy"
                         data-src="{{$product->getImage()}}"
                         alt="{{$product->name}}"/>
                </div>
            </div>
        </div>
    </section>
    @if($product->nutritions->count())
        <section class="bg-emerald-600 animate-y">
            <div
                class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20 relative">
                <svg viewBox="0 0 52 24" fill="currentColor"
                     class="absolute top-0 left-0 z-0 hidden w-32 -mt-8 -ml-20 text-emerald-300 lg:w-32 lg:-ml-28 lg:-mt-10 sm:block">
                    <defs>
                        <pattern id="247432cb-6e6c-4bec-9766-564ed7c230dc" x="0" y="0" width=".135" height=".30">
                            <circle cx="1" cy="1" r=".7"></circle>
                        </pattern>
                    </defs>
                    <rect fill="url(#247432cb-6e6c-4bec-9766-564ed7c230dc)" width="52" height="24"></rect>
                </svg>
                <div class="drop-shadow-lg -mt-17 mb-17 lg:-my-24 lg:bg-white rounded lg:shadow-xl p-4 lg:absolute">
                    <h2 class="max-w-lg font-nunito select-none text-3xl font-black tracking-tight text-white lg:text-nustil-purple sm:text-4xl lg:text-5xl sm:leading-none">
                        {{strtolower(__('Nutritions'))}}
                    </h2>
                </div>
                <div
                    class="grid grid-cols-2 gap-5 row-gap-6 mb-10 sm:grid-cols-3 lg:grid-cols-6 justify-center font-nunito">
                    @foreach($product->nutritions as $nutrition)

                        <div class="text-center animate-y">
                            <div
                                class="flex flex-col items-center justify-center shadow-lg w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-400 sm:w-24 sm:h-24 @if($nutrition->unit == 'kJ') relative @endif">
                                @if($nutrition->unit == 'kJ')
                                    <div
                                        class="absolute -bottom-6 -right-8 rounded-full leading-tight w-14 h-14 shadow-md flex items-center justify-center flex-col sm:w-14 sm:h-14 bg-emerald-800 text-white">
                                        <h3 class="text-base font-extrabold -mb-1">{{\App\Models\Nutrition::convert('kcal','kJ',$nutrition->pivot->value)}}</h3>
                                        <span class="text-xs font-bold">kcal</span>
                                    </div>
                                @endif
                                <div class="text-emerald-900">
                                    <b class="text-lg">
                                        {{number_format($nutrition->pivot->value,1)}}
                                    </b>
                                    <span class="text-sm">
                                {{$nutrition->unit}}
                            </span>
                                </div>
                            </div>
                            <h6 class="mb-2 font-semibold leading-5 text-white">{{__($nutrition->name)}}</h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <section class="my-4 lg:my-8">
        <div class="container animate-y max-w-[65ch] mx-auto px-4 lg:px-0 mb-8">
            <h2 class="text-nustil-purple font-black select-none font-nunito text-5xl text-right">
                {{__('about the product')}}
            </h2>
        </div>
        <div class="container animate-y prose mx-auto px-4 lg:px-0 text-justify">
            {!! Str::markdown($product->description) !!}
        </div>
    </section>

@endsection
