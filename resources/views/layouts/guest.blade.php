<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @if(config('app.env') != 'production')
        <meta name="robots" content="noindex,nofollow">
    @endif
    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Splash&family=Nunito:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&family=Quicksand:wght@400;500;600;700&family=Roboto:wght@100;400;500;700;900&display=swap"
        rel="stylesheet">


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    @if(config('nustil.designDebug',false))
        <style>
            main * {
                outline: 1px solid red;
            }
        </style>
    @endif
</head>
<body class="app font-sans antialiased">
<x-header/>
<main class="mt-[4.5rem] lg:mt-20 min-h-screen block">
    @yield('content')
</main>
<x-footer/>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8/dist/lazyload.min.js"></script>
<script src="https://unpkg.com/flowbite@1.4.6/dist/flowbite.js" data-pagespeed-no-defer></script>
@if(!app()->isProduction())
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" data-pagespeed-no-defer></script>
@else
    <script src="https://unpkg.com/lucide@latest" data-pagespeed-no-defer></script>
@endif
<script>
    lucide.createIcons();
</script>
@stack('scripts')
</body>
</html>
