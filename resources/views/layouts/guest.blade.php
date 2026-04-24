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
                background: radial-gradient(circle at top left, #1e1b4b 0%, #0f172a 50%, #020617 100%);
                position: relative;
                overflow: hidden;
            }
            .login-gradient::before {
                content: '';
                position: absolute;
                top: -10%;
                left: -10%;
                width: 40%;
                height: 40%;
                background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, transparent 70%);
                filter: blur(50px);
                z-index: 0;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            @media (max-width: 640px) {
                .glass-card {
                    border: none;
                    background: transparent;
                    backdrop-filter: none;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6 login-gradient">
            <div class="relative z-10 w-full flex flex-col items-center">
                <div class="mb-8 transform hover:scale-105 transition-transform duration-500">
                    <a href="/" class="flex flex-col items-center gap-4">
                        @if(isset($global_settings['app_logo']) && $global_settings['app_logo'])
                            <img src="{{ asset('storage/' . $global_settings['app_logo']) }}" class="h-24 w-auto drop-shadow-[0_0_25px_rgba(79,70,229,0.5)]">
                        @else
                            <div class="p-4 bg-indigo-600 rounded-3xl shadow-2xl shadow-indigo-500/50">
                                <x-application-logo class="w-16 h-16 fill-current text-white" />
                            </div>
                        @endif
                    </a>
                </div>

                <div class="w-full sm:max-w-md px-8 py-10 glass-card shadow-2xl overflow-hidden sm:rounded-[2.5rem] relative transition-all duration-500">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-black text-white uppercase tracking-tight mb-2">Login Portal</h2>
                        <div class="flex items-center justify-center gap-2">
                            <span class="h-px w-8 bg-indigo-500/50"></span>
                            <p class="text-[10px] text-indigo-400 font-black uppercase tracking-[0.2em]">Sistem Buku Tamu</p>
                            <span class="h-px w-8 bg-indigo-500/50"></span>
                        </div>
                    </div>
                    {{ $slot }}
                </div>

                <div class="mt-8 text-center sm:block hidden">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-widest">&copy; {{ date('Y') }} {{ $global_settings['app_name'] ?? config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>
