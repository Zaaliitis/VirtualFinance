<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>VirtualFinance</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="bg-customDarkGreen">
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <img src="{{url("/images/LogoTextWhite.png")}}" alt="logo" class="w-60 mt-32 pt-11">
        </div>
        <div class="flex justify-center mt-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="font-semibold text-gray-600 hover:text-gray-900 ">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                       class="font-semibold underline text-2xl text-gray-100 mr-3 hover:text-gray-900">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="ml-4 font-semibold text-2xl underline ml-3 text-gray-100 hover:text-gray-900">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    </body>
</html>
