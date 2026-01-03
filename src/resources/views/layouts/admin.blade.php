<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-bs-theme-primary="blue" data-bs-theme-base="slate">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - ' . config('app.name', 'Laravel'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Scripts - Admin uses Vue.js -->
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
</head>
<body class="layout-boxed">
    <div class="page">
        @include('admin.layouts.navigation')
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
