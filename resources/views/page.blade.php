@extends('layouts.guest')

@section('content')

    @if($page->options['display_page_title'])
        <section class="bg-emerald-600 text-white">
            <div
                class="container mx-auto max-w-7xl flex flex-col md:flex-row md:items-center md:justify-between py-16 px-4">
                <div class="max-w-2xl">
                    <h1 class="mb-5 font-nunito animate-y font-black tracking-tight text-white text-4xl md:text-5xl sm:leading-none">
                        {{$page->title}}
                    </h1>
                </div>
            </div>
        </section>
    @endif

    @if($page->options['display_breadcrumbs'])
        @if($page->options['display_page_title'])
            <section class="bg-nustil-purple text-white lg:max-w-7xl xl:rounded-full lg:-mt-6 sm:px-8 lg:mx-auto">
                <div
                    class="container mx-auto flex flex-col md:flex-row md:items-center divide-y divide-white/30 md:divide-y-0 md:justify-between p-4">
                    <div class="py-2 md:py-0">
                        {{\Diglactic\Breadcrumbs\Breadcrumbs::render('page',$page)}}
                    </div>

                </div>
            </section>
        @else
            <div class="container mx-auto mt-16 px-4 py-6 mb-24">
                <div class="my-2">
                    {!! \Diglactic\Breadcrumbs\Breadcrumbs::view('vendor.breadcrumbs.tailwind-text-dark','page',$page) !!}
                </div>
            </div>
        @endif
    @endif

    <article
        class="prose @unless($page->options['fullwidth']) container  max-w-7xl  py-16 px-4  @else max-w-full w-full p-0 @endunless mx-auto min-h-[70vh] mb-24">
        {!! Str::markdown($page->content) !!}
    </article>
    @if($page->options['display_last_modified_date'])
        <div class="flex items-center justify-between p-4 container mx-auto border-t">
            <div class="text-sm opacity-60">
                {{__('Last updated')}} {{$page->updated_at->diffForHumans()}}
            </div>
        </div>
    @endif
@endsection
