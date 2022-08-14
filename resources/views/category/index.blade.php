@extends('layouts.guest')

@section('content')
    <section class="border-b mb-16">
        <div class="container mx-auto">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 py-12 px-4">
                @php($span = 1)
                @foreach($categories as $category)
                    @php($loop->row = ceil($loop->iteration / $span))
                    @php($loop->column = $loop->iteration % $loop->row)
                    @php($isRowspan = ($loop->iteration % $span == 0) && ($loop->iteration <= $loop->count -4 ))
                    @if($isRowspan)
                        @php($span+=4)
                    @endif
                    <x-category-card :rows="$isRowspan ? 2 : 1" :category="$category"/>
                @endforeach
            </div>
        </div>
    </section>
    <div class="container mx-auto mb-16">
        <h1 class="mb-5 text-3xl lowercase font-black text-nustil-purple animate-y nustil-animation-delay-5">{{__('All Products')}}</h1>
        <div
            class="grid sm:grid-cols-2 items-center lg:grid-cols-3 nustil-animation-delay-5 xl:grid-cols-4 2xl:grid-cols-5 px-4 lg:gap-y-12 mt-12 gap-4 font-nunito">
            @foreach($products as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
    </div>

@endsection
