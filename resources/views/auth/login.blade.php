<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ show: false }">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Email Address</label>
            <x-text-input id="email" class="block mt-1 w-full !rounded-2xl !bg-gray-50 dark:!bg-gray-900/50 !border-gray-100 dark:!border-gray-700 font-bold text-gray-900 dark:text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Secret Password</label>
            <div class="relative">
                <x-text-input id="password" 
                                class="block mt-1 w-full !rounded-2xl !bg-gray-50 dark:!bg-gray-900/50 !border-gray-100 dark:!border-gray-700 font-bold text-gray-900 dark:text-white pr-12"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
                
                <button type="button" 
                        @click="show = !show"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500 transition-colors focus:outline-none">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L12 12m4.839 4.839L12 12m4.839 4.839A9.99 9.99 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.405.235-3.441.659m4.792 4.792a3 3 0 11-4.243 4.243" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-all cursor-pointer" name="remember">
                <span class="ms-2 text-xs font-bold text-gray-500 dark:text-gray-400 group-hover:text-indigo-500 uppercase tracking-tighter transition-colors">{{ __('Keep me signed in') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-400 dark:hover:text-white uppercase tracking-tighter transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot Secret?') }}
                 </a>
            @endif
        </div>

        <div class="mt-10">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-500/30 transition-all transform hover:scale-[1.01] active:scale-[0.98] flex items-center justify-center gap-2 group">
                <span>{{ __('Authorize Login') }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>
