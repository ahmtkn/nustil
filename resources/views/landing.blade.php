@extends('layouts.guest')

@section('content')
    <x-slider/>

    <div class="px-4 py-16 mx-auto container md:px-24 lg:px-8 lg:py-20">
        <div class="flex flex-col mb-10 lg:justify-between lg:flex-row md:mb-12">
            <h2 class="max-w-lg mb-5 font-nunito text-3xl font-black text-nustil-purple tracking-tight text-gray-900 sm:text-4xl sm:leading-none md:mb-6 group">
      <span class="inline-block mb-1 text-nustil-purple sm:mb-4 animate-y">
        {{__('Our products')}}
      </span>
                <div
                    class="h-1 mr-auto duration-300 animate-y rounded-full origin-left w-1/4 lg:w-1/2 transform bg-emerald-600 scale-x-30 group-hover:scale-x-100"></div>
            </h2>
            <p class="text-slate-700 lg:text-base text-sm lg:max-w-md animate-x nustil-animation-delay-5">
                {{$settings->home['latestProductsDescription-'.$locale]}}
            </p>
        </div>
        <div class="grid gap-6 row-gap-5 mb-8 lg:grid-cols-4 sm:row-gap-6 items-stretch sm:grid-cols-2">
            @foreach($latestProducts as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
    </div>

@endsection
