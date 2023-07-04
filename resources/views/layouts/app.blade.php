<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex , nofollow" />
        

        <title>{{ config('app.name', 'ボードゲームカフェ') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{asset('img/favicon.png')}}" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!--<div class="min-h-screen bg-gray-100">-->
        <div class="min-h-screen bg-green-100">
            @if(request()->is('admin*'))
                @include('layouts.admin-navigation')
            @else
                @auth
                    @include('layouts.navigation')
                @else
                    @include('layouts.guest-navigation')
                @endauth
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- success message -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto px-6">
                    <div class="mt-4 p-8 w-full rounded-2lx bg-green-700 rounded text-white font-bold font-semibold">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="min-h-screen">
                {{ $slot }}
            </main>
            
            <footer class="w-full text-center border-t border-grey p-4 pin-b bg-white">
                <p class="text-black">© 2023 ボードゲームカフェ　あきこま. All rights reserved.</p>
            </footer>
        </div>
    </body>
</html>
