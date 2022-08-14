@extends('layouts.guest')

@section('content')
    <section class="bg-emerald-600 text-white">
        <div class="container mx-auto flex flex-col md:flex-row md:items-center md:justify-between py-16 px-4">
            <div class="max-w-2xl">
                <h1 class="mb-5 font-nunito animate-y font-black tracking-tight text-white text-4xl md:text-5xl sm:leading-none">
                    {{$category->name}}
                </h1>
                <p class="font-nunito text-lg animate-y delay-700 font-medium text-white sm:text-xl md:text-2xl sm:leading-none nustil-animation-delay-2">
                    {{$category->description}}
                </p>
            </div>

        </div>
    </section>
    <section class="bg-nustil-purple text-white lg:max-w-7xl xl:rounded-full lg:-mt-6 sm:px-8 lg:mx-auto">
        <div
            class="container mx-auto flex flex-col md:flex-row md:items-center divide-y divide-white/30 md:divide-y-0 md:justify-between p-4">
            <div class="py-2 md:py-0">
                {{\Diglactic\Breadcrumbs\Breadcrumbs::render(__('route.category'), $category)}}
            </div>
            @if($category->children && $category->children->count())
                <div class="flex items-center py-2 md:py-0">
                    @foreach($category->children as $child)
                        <a href="{{route('category.show',$child)}}"
                           class="text-base font-black tracking-wide font-nunito text-white/80 animate-y nustil-animation-delay-4 hover:text-white">{{$child->name}}</a>
                        @unless($loop->last)
                            <span class="text-white mx-4 animate-y nustil-animation-delay-4">•</span>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <div class="container mx-auto my-32">
        <div
            class="grid sm:grid-cols-2 lg:grid-cols-3 items-center xl:grid-cols-4 2xl:grid-cols-5 px-4 lg:gap-y-12 gap-4 font-nunito">
            @foreach($category->products as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
    </div>

@endsection
