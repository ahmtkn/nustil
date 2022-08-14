@extends('layouts.guest')

@section('content')
    <section class="bg-emerald-600 text-white">
        <div class="container mx-auto flex flex-col md:flex-row md:items-center md:justify-between py-16 px-4">
            <div class="max-w-2xl">
                <h1 class="mb-5 font-nunito animate-y font-black tracking-tight text-white text-4xl md:text-5xl sm:leading-none">
                    Blog
                </h1>

            </div>

        </div>
    </section>
    <section class="bg-nustil-purple text-white lg:max-w-7xl xl:rounded-full lg:-mt-6 sm:px-8 lg:mx-auto">
        <div
            class="container mx-auto flex flex-col md:flex-row md:items-center divide-y divide-white/30 md:divide-y-0 md:justify-between p-4">
            <div class="py-2 md:py-0">
                {{\Diglactic\Breadcrumbs\Breadcrumbs::render('blog')}}
            </div>
        </div>
    </section>
    <div class="container mx-auto my-16 px-4">
        <div class="grid lg:grid-cols-7 gap-4">
            <div class="@if($settings->blog['showSidebar']) lg:col-span-5 @else lg:col-span-7 @endif">
                <div class="grid gap-4 xl:grid-cols-4 sm:grid-cols-2">
                    @foreach($posts as $post)

                        <x-post-card :post="$post" :colspan="$loop->iteration <=2"/>
                    @endforeach
                </div>
            </div>
            <x-blog.sidebar/>
        </div>
    </div>

@endsection
