<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $global_settings['app_name'] ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .login-gradient {
                background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 login-gradient">
            <div class="mb-4">
                <a href="/">
                    @if($global_settings['app_logo'])
                        <img src="{{ asset('storage/' . $global_settings['app_logo']) }}" class="h-20 w-auto drop-shadow-2xl">
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-white" />
                    @endif
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-[2.5rem] border border-white/10">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Login Portal</h2>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Akses Admin {{ $global_settings['app_name'] }}</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
