<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('Kelola Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showAddModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">Daftar Admin</h3>
                    <p class="text-xs text-gray-400 font-medium">Kelola siapa saja yang bisa mengakses dashboard ini</p>
                </div>
                <button @click="showAddModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl text-sm font-black transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Admin
                </button>
            </div>

            @if(session('success'))
                <div class="bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-100 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Admin Table -->
            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden px-8 py-2">
                <div class="overflow-x-auto pb-4 mt-4">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-gray-400 text-[10px] uppercase tracking-[0.2em] font-normal">
                                <th class="px-2">Administrator</th>
                                <th class="px-2">Email Address</th>
                                <th class="px-2">Terdaftar Sejak</th>
                                <th class="px-2 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="group">
                                <td class="bg-gray-50/50 dark:bg-gray-900/30 rounded-l-[1.5rem] py-4 px-4 border-y border-l border-gray-100/50 dark:border-gray-700/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white line-clamp-1">{{ $user->name }}</div>
                                            @if($user->id === auth()->id())
                                                <span class="text-[9px] font-black uppercase text-emerald-500">Anda Sedang Login</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="bg-gray-50/50 dark:bg-gray-900/30 py-4 px-4 border-y border-gray-100/50 dark:border-gray-700/50">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ $user->email }}</span>
                                </td>
                                <td class="bg-gray-50/50 dark:bg-gray-900/30 py-4 px-4 border-y border-gray-100/50 dark:border-gray-700/50 text-xs text-gray-500 font-medium italic">
                                    {{ $user->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="bg-gray-50/50 dark:bg-gray-900/30 rounded-r-[1.5rem] py-4 px-4 border-y border-r border-gray-100/50 dark:border-gray-700/50 text-right">
                                    @if($user->id !== auth()->id())
                                        <button type="button" @click="confirmDeleteUser('{{ $user->id }}', '{{ $user->name }}')"
                                            class="bg-white dark:bg-gray-800 p-2 rounded-xl border border-gray-200 dark:border-gray-700 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <form id="deleteUserForm-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <span class="text-[10px] text-gray-400 italic">Self Account</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Admin Modal -->
        <div x-show="showAddModal" 
            class="fixed inset-0 z-[100] overflow-y-auto" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="showAddModal = false"></div>

                <div class="relative bg-white dark:bg-gray-800 rounded-[3rem] shadow-2xl w-full max-w-lg p-10 overflow-hidden">
                    <div class="absolute top-6 right-6">
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-black text-gray-800 dark:text-white uppercase tracking-tight">Otorisasi Admin</h3>
                        <p class="text-xs text-gray-500 font-medium">Daftarkan pengelola sistem baru</p>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Email Address</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Password</label>
                                <input type="password" name="password" required class="w-full bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1 mb-1 block">Konfirmasi</label>
                                <input type="password" name="password_confirmation" required class="w-full bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700 rounded-2xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                        </div>
                        
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl font-black text-sm transition-all shadow-xl shadow-indigo-500/20 active:scale-[0.98]">
                                Daftarkan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Support -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDeleteUser(id, name) {
            Swal.fire({
                title: 'Hapus Akses?',
                text: `${name} tidak akan bisa lagi mengakses dashboard ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#111827',
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteUserForm-${id}`).submit();
                }
            })
        }
    </script>
</x-app-layout>
