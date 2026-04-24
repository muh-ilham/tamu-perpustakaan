<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('Pengaturan Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-[2.5rem] border border-gray-100 dark:border-gray-700">
                <div class="p-10">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        @if(session('success'))
                            <div class="bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- App Name -->
                            <div class="space-y-2">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest pl-1">Judul Aplikasi</label>
                                <input type="text" name="app_name" value="{{ $settings['app_name'] }}" required
                                    class="w-full bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-2xl px-4 py-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all dark:text-white font-bold">
                                @error('app_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Logo Upload -->
                            <div class="space-y-2" x-data="{ photoName: null, photoPreview: null }">
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest pl-1">Logo Aplikasi</label>
                                
                                <div class="flex items-center gap-6">
                                    <div class="relative group">
                                        @if($settings['app_logo'])
                                            <img src="{{ asset('storage/' . $settings['app_logo']) }}" class="w-20 h-20 object-contain bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 p-2 shadow-sm">
                                        @else
                                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center text-[10px] font-bold text-gray-400">NO LOGO</div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1">
                                        <input type="file" name="app_logo" class="hidden" x-ref="photo"
                                            x-on:change="
                                                photoName = $refs.photo.files[0].name;
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    photoPreview = e.target.result;
                                                };
                                                reader.readAsDataURL($refs.photo.files[0]);
                                            ">
                                        <button type="button" x-on:click.prevent="$refs.photo.click()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-lg shadow-indigo-500/20">
                                            Pilih File Logo
                                        </button>
                                        <p class="text-[10px] text-gray-400 mt-2">Format: JPG, PNG, SGV. Max: 2MB.</p>
                                    </div>
                                </div>
                                
                                @error('app_logo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                            <button type="submit" class="bg-gray-900 dark:bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black text-sm hover:scale-[0.98] transition-transform shadow-xl shadow-indigo-500/10">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
