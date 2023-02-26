@extends('layouts.guest')

@section('content')
    <section class="bg-emerald-600 text-white">
        <div
            class="container mx-auto max-w-7xl flex flex-col md:flex-row md:items-center md:justify-between py-16 px-4">
            <div class="max-w-2xl">
                <h1 class="mb-5 font-nunito animate-y font-black tracking-tight text-white text-4xl md:text-5xl sm:leading-none">
                    {{__('Contact')}}
                </h1>
            </div>
        </div>
    </section>
    <!-- COMPONENT CODE -->
    <div class="container mx-auto my-4 px-4 lg:px-20">

        <div
            class="w-full lg:max-w-2xl mx-auto p-8 my-4 border md:px-12 lg:mt-28 lg:w-9/12 lg:pl-20 lg:pr-40 mr-auto rounded-2xl shadow-2xl relative">
            <div class="absolute hidden lg:block -top-24 -left-24 max-w-sm bg-white border rounded-2xl p-4">
                <h1 class="font-bold text-5xl font-nunito leading-none tracking-tight text-emerald-600 text-center font-extrabold">{{__('Send us a message')}}</h1>
            </div>
            <div class="flex mb-8 lg:hidden">
                <h1 class="font-bold uppercase text-5xl">{{__('Send us a message')}}</h1>
            </div>
            <form action="{{route('contact.store')}}" method="POST">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 mt-5">
                    <label class="col-span-2">
                    <input
                        autocomplete="off"
                        class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg col-span-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-600 focus:shadow-outline"
                        type="text" name="name" placeholder="{{__('Name')}}*" value="{{old('name')}}"/>
                    @error('name')
                    <span class="text-xs text-red-500 font-bold">{{$message}}</span>
                    @enderror
                    </label>
                    <label>
                    <input
                        autocomplete="off"
                        class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:ring-emerald-500 focus:border-emerald-600 focus:shadow-outline"
                        type="email" name="email" placeholder="Email*" value="{{old('email')}}"/>
                    @error('email') <span class="text-xs text-red-500 font-bold">{{$message}}</span> @enderror
                    </label>
                    <label>
                    <input
                        autocomplete="off"
                        class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:ring-emerald-500 focus:border-emerald-600 focus:shadow-outline"
                        type="text" name="phone" placeholder="{{__('Phone')}}" value="{{old('phone')}}"/>
                    @error('phone') <span class="text-xs text-red-500 font-bold">{{$message}}</span> @enderror
                    </label>
                    <label class="col-span-2">
                    <input
                        autocomplete="off"
                        class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg col-span-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-600 focus:shadow-outline"
                        type="text" name="subject" placeholder="{{__('Subject')}}*" value="{{old('subject')}}"
                    />
                    @error('subject') <span class="text-xs text-red-500 font-bold">{{$message}}</span> @enderror
                    </label>
                </div>
                <div class="my-4">
                <textarea placeholder="{{__('Message')}}*" name="message"
                          class="w-full h-32 bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:ring-emerald-500 focus:border-emerald-600 focus:shadow-outline"></textarea>
                    @error('message') <span class="text-xs text-red-500 font-bold">{{$message}}</span> @enderror
                </div>
                @csrf
                <div class="my-2 w-1/2 lg:w-1/4">
                    <button class="btn btn-emerald">
                        {{__('Send')}}
                    </button>
                </div>
            </form>
        </div>

        <div
            class="w-full max-w-sm lg:-mt-72 lg:w-2/6 relative px-8 py-12 ml-auto bg-emerald-600 rounded-2xl shadow-2xl">
            <div class="flex flex-col text-white">
                <div class="flex mb-4 w-2/3">
                    <div class="flex flex-col">
                        <i icon-name="map" class="w-10 mt-1"></i>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-2xl">{{__('Our Office')}}</h2>
                        <p class="text-emerald-200">{{$settings->address}}</p>
                    </div>
                </div>

                <div class="flex my-4 w-2/3">
                    <div class="flex flex-col">
                        <i icon-name="phone" class="mt-1 w-10"></i>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-2xl">{{__('Call Us')}}</h2>
                        <a href="tel:{{Str::replace(' ','',$settings->phone_number)}}"
                           class="text-emerald-200">{{$settings->phone_number}}</a>

                    </div>
                </div>

                <div class="flex my-4 w-2/3 lg:w-1/2">
                    @foreach($settings->social_media as $platform => $url)
                        <a href="https://{{$platform}}.com/{{$url}}"
                           rel="noopener noreferrer" target="_blank"
                           class="rounded-full h-8 w-8 hover:h-9 hover:w-9 hover:-mt-1 border-2 border-transparent hover:border-white/20 hover:pt-1.5 inline-block items-center justify-center text-emerald-600 bg-white hover:bg-white/30 hover:text-white transition-all duration-300 mx-1 text-center pt-1">
                            <i icon-name="{{$platform}}" class="w-5 h-5 block mx-auto"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- COMPONENT CODE -->

@endsection
