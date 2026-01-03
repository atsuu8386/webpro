<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Scripts - Web uses jQuery -->
    @vite(['resources/css/web.css', 'resources/js/web.js'])
</head>
<body>
    @include('web.layouts.header')

    <main>
        @yield('content')
    </main>

    @include('web.layouts.footer')

    @stack('scripts')
</body>
</html>
