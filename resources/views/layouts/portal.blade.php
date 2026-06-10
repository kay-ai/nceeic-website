<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NCEEIC | National Committee on Energy Efficiency, Innovation & Certification Nigeria')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    {{-- Vite: Tailwind + Flowbite + custom CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="antialiased">

    @include('partials.topbar')
    @include('partials.navbar')
    @include('partials.message')

    {{-- Main content --}}
    <main class="min-h-[calc(100vh-56px)]">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    @include('partials.footer')


    @livewireScripts
    @stack('scripts')
</body>
</html>
