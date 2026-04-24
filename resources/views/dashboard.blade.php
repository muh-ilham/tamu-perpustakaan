<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Kunjungan Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-indigo-50 border-white/5 p-8 transition-all hover:scale-[1.02] duration-300">
                    <div class="flex items-center gap-6">
                        <div class="p-4 bg-indigo-500/10 rounded-2xl">
                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-indigo-500 uppercase tracking-[0.2em] mb-1">Total Kunjungan</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Kunjungan Hari Ini Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-purple-50 border-white/5 p-8 transition-all hover:scale-[1.02] duration-300">
                    <div class="flex items-center gap-6">
                        <div class="p-4 bg-purple-500/10 rounded-2xl">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-purple-500 uppercase tracking-[0.2em] mb-1">Hari Ini</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ number_format($stats['today']) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Akses Cepat Card -->
                <div class="bg-indigo-600 overflow-hidden shadow-xl sm:rounded-2xl p-8 group cursor-pointer" onclick="window.location='{{ route('admin.visitors.index') }}'">
                    <div class="flex flex-col justify-between h-full">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white/10 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-200 uppercase tracking-[0.2em]">Quick Action</span>
                        </div>
                        <div class="mt-4">
                            <p class="text-white font-black text-lg">Kelola Pengunjung</p>
                            <p class="text-indigo-100/60 text-xs">Lihat daftar lengkap data tamu</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 border-white/5">
                <div class="p-10 text-center">
                    <div class="mb-4 inline-flex p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-full">
                        <svg class="w-12 h-12 text-indigo-600 dark:text-indigo-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Sistem Buku Tamu Digital siap mengelola data kunjungan Anda hari ini.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
