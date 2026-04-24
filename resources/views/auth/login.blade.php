<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Email Address</label>
            <x-text-input id="email" class="block mt-1 w-full !rounded-2xl !bg-gray-50 !border-gray-100 dark:!bg-gray-900 dark:!border-gray-700 font-bold" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Secret Password</label>
            <x-text-input id="password" class="block mt-1 w-full !rounded-2xl !bg-gray-50 !border-gray-100 dark:!bg-gray-900 dark:!border-gray-700 font-bold"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-lg border-gray-200 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-xs font-bold text-gray-500 uppercase tracking-tighter">{{ __('Keep me signed in') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-[10px] font-bold text-indigo-600 hover:text-indigo-400 uppercase tracking-tighter transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot Secret?') }}
                 </a>
            @endif
        </div>

        <div class="mt-10">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-500/30 transition-all transform hover:scale-[0.98] active:scale-95 flex items-center justify-center gap-2">
                <span>{{ __('Authorize Login') }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>
