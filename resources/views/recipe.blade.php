@extends('layouts.guest')

@section('content')
    <div class="container max-w-[65ch] mx-auto mt-16 px-4 mb-24">

        <h1 class="inline-block font-nunito text-3xl mt-6 font-extrabold leading-none tracking-tight text-black transition-colors duration-200 sm:text-4xl">
            {{$recipe->name}}
        </h1>
        <div class="mb-6">
            {!! \Diglactic\Breadcrumbs\Breadcrumbs::view('vendor.breadcrumbs.tailwind-text-dark','recipes',$recipe) !!}
        </div>
        <div class="prose lg:prose-lg">
            <div class="w-full h-72 mx-auto">
                <img data-src="{{$recipe->image->url}}" alt="{{$recipe->name}}"
                     class="w-full h-72 object-cover lazy rounded-xl">
            </div>

            <h3>{{__('Description')}}</h3>
            <p>{!! Str::markdown($recipe->description) !!}</p>

            <h3>{{__('Ingredients')}}</h3>
            <ul>
                @foreach($recipe->ingredients as $ingredient)
                    <li>{{$ingredient}}</li>
                @endforeach
            </ul>

            <h3>{{__('Included Products')}}</h3>
        </div>
        <div class="grid grid-cols-2 gap-4 max-w-[65ch] mx-auto my-10">
            @foreach($recipe->products as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
        <div class="prose lg:prose-lg mt-10">
            <h3>{{__('Instructions')}}</h3>
            <ul>
                @foreach($recipe->instructions as $instruction)
                    <li>{{$instruction}}</li>
                @endforeach
            </ul>

            <h3>{{__('Notes')}}</h3>
            <p>{!! Str::markdown($recipe->notes) !!}</p>
        </div>

    </div>
@endsection
