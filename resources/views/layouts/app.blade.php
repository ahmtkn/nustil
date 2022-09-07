<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&family=Quicksand:wght@400;500;600;700&family=Roboto:wght@100;400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @bukStyles(app()->isProduction())
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>

</head>
<body class="dashboard">
<!-- MOBILE MENU BEGINS -->
<div class="md:hidden mb-1 -mt-1 border-b transition duration-300 border-white/[0.1]" x-data="{menuOpen:false}">
    <div class="h-[70px] flex items-center px-2">
        <a href="{{route('dashboard')}}" class="flex mr-auto">
            <x-application-logo logo="white" class="h-10 w-auto"></x-application-logo>
        </a>
        <a href="javascript:;" @click="menuOpen = !menuOpen">
            {{--            <ion-icon name="menu-outline" class="h-8 w-8 text-white p-2"></ion-icon>--}}
            <i icon-name="bar-chart-2" class="h-10 w-10 text-white text-lg p-1 transform rotate-90 -scale-1"></i>
        </a>
    </div>
    <nav class="border-t py-5 px-2 overflow-y-auto  max-h-[calc(100vh-70px)] border-white/[0.1] origin-top"
         x-transition:enter="transition-all ease-in-out duration-300"
         x-transition:enter-start="transform scale-y-0"
         x-transition:enter-end="transform scale-y-100"
         x-transition:leave="transition ease-in-out duration-300"
         x-transition:leave-start="transform scale-y-100"
         x-transition:leave-end="transform scale-y-0"
         x-show="menuOpen">
        <ul>
            <x-responsive-nav-link href="{{route('dashboard')}}"
                                   :active="\Illuminate\Support\Facades\Route::is('dashboard')">
                <i icon-name="home"></i>
                {{__('Home')}}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{route('dashboard.users.index')}}">
                {{__('Users')}}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{route('dashboard.menus.index')}}">
                {{__('Menus')}}
            </x-responsive-nav-link>
        </ul>
    </nav>
</div>
<!-- MOBILE MENU ENDS -->

<!-- LAYOUT BEGINS -->
<div class="flex items-stretch">
    <x-dashboard.sidebar/>

    <!-- CONTENT BEGINS -->
    <main class="content">
        <x-dashboard.top-bar>
            @yield('header')
        </x-dashboard.top-bar>
        @yield('content')
    </main>
    <!-- CONTENT ENDS -->

</div>
<!-- LAYOUT ENDS -->
@if(session()->has('success'))
    <x-dashboard.toast position="top-right"
                       icon="check"
                       color="emerald"
                       :message="session()->has('new-user')
                                   ? __('User created successfully')
                                   : __('User updated successfully')"/>

@endif
@if(session()->has('errors'))
    <x-dashboard.toast position="top-right"
                       icon="alert-triangle"
                       color="red">
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>
    </x-dashboard.toast>

@endif
@if(session()->has('message'))
    <x-dashboard.toast position="top-right"
                       icon="info"
                       color="blue">
        {{session()->get('message')}}
    </x-dashboard.toast>
@endif
<div class="fixed inset-x-0 top-0 z-[5000]" id="notifArea"></div>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8/dist/lazyload.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://unpkg.com/flowbite@1.4.6/dist/flowbite.js" data-pagespeed-no-defer></script>
@if(!app()->isProduction())
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" data-pagespeed-no-defer></script>
@else
    <script src="https://unpkg.com/lucide@latest" data-pagespeed-no-defer></script>
@endif
<script>
    lucide.createIcons();
</script>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
@bukScripts(app()->isProduction())
@stack('scripts')

</body>
</html>
