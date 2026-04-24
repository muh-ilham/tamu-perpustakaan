<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Insight Kunjungan') }}
            </h2>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl border border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.visitors.index', ['range' => '7']) }}" class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $range == '7' ? 'bg-white dark:bg-gray-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">7 Hari</a>
                    <a href="{{ route('admin.visitors.index', ['range' => '30']) }}" class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $range == '30' ? 'bg-white dark:bg-gray-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">30 Hari</a>
                    <a href="{{ route('admin.visitors.index', ['range' => '90']) }}" class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $range == '90' ? 'bg-white dark:bg-gray-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">90 Hari</a>
                </div>
                
                <button type="button" onclick="confirmDeleteAll()" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-800/50 hover:bg-rose-600 hover:text-white transition-all text-xs font-bold shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Semua
                </button>
                <form id="deleteAllForm" action="{{ route('admin.visitors.destroyAll') }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ 
        showModal: false, 
        selectedVisitor: {}, 
        openDetail(visitor) {
            this.selectedVisitor = visitor;
            this.showModal = true;
        } 
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistika - Overview Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-indigo-600 dark:bg-indigo-700 p-6 rounded-[2rem] shadow-xl shadow-indigo-500/20 text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-medium mb-1">Total Database</p>
                        <h3 class="text-4xl font-black mb-4">{{ number_format($stats['total']) }}</h3>
                        <div class="inline-flex items-center text-xs bg-white/20 backdrop-blur-md px-2 py-1 rounded-full">
                            Semua Waktu
                        </div>
                    </div>
                    <!-- Decorative SVG -->
                    <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 transform group-hover:scale-110 transition-transform duration-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-indigo-200 transition-all duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Hari Ini</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['today'] }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] text-gray-400">Pembaruan: {{ now()->format('H:i') }}</div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-indigo-200 transition-all duration-300">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Periode Aktif</p>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['this_period'] }}</h3>
                        </div>
                    </div>
                    <div class="text-[10px] text-gray-400">Filter: {{ $range }} Hari Terakhir</div>
                </div>

                <!-- Card 4 (Chart Box Mini) -->
                <div class="md:col-span-1 bg-white dark:bg-gray-800 p-4 rounded-[2rem] border border-gray-100 dark:border-gray-700 overflow-hidden relative">
                    <canvas id="miniTrendChart" class="w-full h-full opacity-50"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-4">
                        <span class="text-[10px] font-bold text-gray-400 tracking-tighter uppercase mb-1">Status Sistem</span>
                        <span class="flex items-center gap-1.5 text-emerald-500 font-bold text-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Online
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Area: Chart vs Table -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Main Chart (Large) -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 p-8 relative overflow-hidden">
                        <div class="flex items-center justify-between mb-8 relative z-10">
                            <div>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white">Analisis Tren</h3>
                                <p class="text-sm text-gray-500 line-clamp-1">Kunjungan per hari pada rentang waktu terpilih</p>
                            </div>
                        </div>
                        
                        <div class="h-[380px] w-full relative z-10">
                            <canvas id="visitorChart"></canvas>
                        </div>
                        
                        <!-- Background Accents -->
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl"></div>
                    </div>

                    <!-- Modern Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden px-8 py-2">
                        <div class="py-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-black dark:text-white">Log Terbaru</h3>
                                <p class="text-[10px] text-gray-400 font-medium">Halaman {{ $visitors->currentPage() }} dari {{ $visitors->lastPage() }} (Total {{ $visitors->total() }} Data)</p>
                            </div>
                            
                            <form action="{{ route('admin.visitors.index') }}" method="GET" class="relative group">
                                <input type="hidden" name="range" value="{{ $range }}">
                                <input type="text" name="search" value="{{ $search }}" 
                                    placeholder="Cari nama, pangkat..." 
                                    class="w-full md:w-64 pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none dark:text-white">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                @if($search)
                                    <a href="{{ route('admin.visitors.index', ['range' => $range]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                @endif
                            </form>
                        </div>
                        
                        <div class="overflow-x-auto pb-4">
                            <table class="w-full text-left border-separate border-spacing-y-4">
                                <thead>
                                    <tr class="text-gray-400 text-[10px] uppercase tracking-[0.2em] font-normal">
                                        <th class="px-2">Identitas Tamu</th>
                                        <th class="px-2">Kepentingan</th>
                                        <th class="px-2">Timestamp</th>
                                        <th class="px-2 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($visitors as $visitor)
                                    <tr class="group hover:scale-[1.01] transition-all duration-300">
                                        <td class="bg-gray-50/50 dark:bg-gray-900/30 rounded-l-[1.5rem] py-4 px-4 border-y border-l border-gray-100/50 dark:border-gray-700/50">
                                            <div class="flex items-center gap-3">
                                                <div class="relative">
                                                     @if($visitor->foto_path)
                                                        <img src="{{ asset('storage/' . $visitor->foto_path) }}" class="w-12 h-12 object-cover rounded-2xl shadow-lg group-hover:rotate-3 transition-transform duration-500" alt="">
                                                    @else
                                                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-2xl flex items-center justify-center text-[10px] font-bold text-gray-400">NULL</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900 dark:text-white line-clamp-1">{{ $visitor->nama_lengkap }}</div>
                                                    <div class="text-[10px] font-bold text-indigo-500 uppercase">{{ $visitor->pangkat ?? 'UMUM' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="bg-gray-50/50 dark:bg-gray-900/30 py-4 px-4 border-y border-gray-100/50 dark:border-gray-700/50">
                                            <div class="truncate max-w-[150px] text-sm text-gray-600 dark:text-gray-400 font-medium">
                                                {{ $visitor->judul_buku ?? 'Akses Referensi' }}
                                            </div>
                                        </td>
                                        <td class="bg-gray-50/50 dark:bg-gray-900/30 py-4 px-4 border-y border-gray-100/50 dark:border-gray-700/50 text-xs text-gray-500 font-medium whitespace-nowrap">
                                            {{ $visitor->created_at->format('H:i') }} • {{ $visitor->created_at->format('d/m/y') }}
                                        </td>
                                         <td class="bg-gray-50/50 dark:bg-gray-900/30 rounded-r-[1.5rem] py-4 px-4 border-y border-r border-gray-100/50 dark:border-gray-700/50 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button @click="openDetail({{ json_encode($visitor) }})" 
                                                    class="bg-white dark:bg-gray-800 p-2 rounded-xl border border-gray-200 dark:border-gray-700 text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm group/btn">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                <button type="button" onclick="confirmDelete('{{ $visitor->id }}', '{{ $visitor->nama_lengkap }}')"
                                                    class="bg-white dark:bg-gray-800 p-2 rounded-xl border border-gray-200 dark:border-gray-700 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                                
                                                <form id="deleteForm-{{ $visitor->id }}" action="{{ route('admin.visitors.destroy', $visitor->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-gray-400 text-sm italic">Belum ada kunjungan sesuai filter ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="py-6 border-t border-gray-100 dark:border-gray-700">
                            {{ $visitors->appends(['range' => $range, 'search' => $search])->links() }}
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline / Sidebar Info -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-gray-900 text-white rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-xl font-black mb-1">Monitor Live</h3>
                            <p class="text-gray-400 text-sm mb-8">Pencatatan real-time sistem</p>
                            
                            <div class="space-y-6">
                                @foreach($visitors->take(4) as $v)
                                <div class="flex gap-4 group">
                                    <div class="flex flex-col items-center">
                                        <div class="w-2 h-2 rounded-full bg-indigo-500 scale-125"></div>
                                        <div class="flex-grow w-0.5 bg-gray-800 my-1 group-last:hidden"></div>
                                    </div>
                                    <div class="pb-6">
                                        <p class="text-[10px] font-bold text-gray-500 uppercase">{{ $v->created_at->diffForHumans() }}</p>
                                        <h4 class="text-xs font-bold">{{ $v->nama_lengkap }}</h4>
                                        <p class="text-[10px] text-gray-400">{{ $v->pangkat ?? 'Tamu Umum' }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gradient Circle -->
                        <div class="absolute bottom-0 right-0 w-48 h-48 bg-indigo-500/20 blur-[60px] rounded-full translate-x-12 translate-y-12"></div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 border border-gray-100 dark:border-gray-700">
                        <h4 class="font-black text-gray-900 dark:text-white mb-4">Informasi Sesi</h4>
                        <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 space-y-3">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 font-medium">Versi Aplikasi</span>
                                <span class="dark:text-white font-bold">1.0.4-Stable</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500 font-medium">Load Database</span>
                                <span class="text-emerald-500 font-bold">Optimal (0.2ms)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="showModal" 
            class="fixed inset-0 z-[100] overflow-y-auto" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="showModal = false"></div>

                <div class="relative bg-white dark:bg-gray-800 rounded-[3rem] shadow-2xl w-full max-w-2xl overflow-hidden animate-pulse-once">
                    <!-- Modal Header -->
                    <div class="absolute top-6 right-6 z-10">
                        <button @click="showModal = false" class="w-10 h-10 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-col md:flex-row h-full">
                        <!-- Left: Photo -->
                        <div class="md:w-1/2 relative bg-gray-100 dark:bg-gray-900">
                             <template x-if="selectedVisitor.foto_path">
                                <img :src="'/storage/' + selectedVisitor.foto_path" class="w-full h-full object-cover min-h-[300px]" alt="">
                            </template>
                            <template x-if="!selectedVisitor.foto_path">
                                <div class="w-full h-full flex items-center justify-center text-gray-300 min-h-[300px]">NULL PHOTO</div>
                            </template>
                            <div class="absolute bottom-6 left-6">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase text-indigo-600 border border-white">Visitor Pass</span>
                            </div>
                        </div>

                        <!-- Right: Details -->
                        <div class="md:w-1/2 p-10 space-y-8">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Identitas Pengunjung</p>
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white" x-text="selectedVisitor.nama_lengkap"></h3>
                                <p class="text-xs text-indigo-500 font-bold" x-text="(selectedVisitor.pangkat || 'UMUM') + ' • ' + (selectedVisitor.satuan || 'PENGUNJUNG')"></p>
                            </div>

                            <div class="space-y-4">
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 text-center">Judul Buku / Keperluan</p>
                                    <p class="text-sm font-medium text-center dark:text-gray-200" x-text="selectedVisitor.judul_buku || 'Tujuan Referensi Umum'"></p>
                                </div>
                                <div class="flex justify-between items-center px-2">
                                    <div class="text-center">
                                        <p class="text-[9px] font-bold text-gray-400 uppercase">Kedatangan</p>
                                        <p class="text-xs font-bold dark:text-white" x-text="new Date(selectedVisitor.created_at).toLocaleTimeString('id-ID', {hour:'2-digits', minute:'2-digits'})"></p>
                                    </div>
                                    <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>
                                    <div class="text-center">
                                        <p class="text-[9px] font-bold text-gray-400 uppercase">Tanggal</p>
                                        <p class="text-xs font-bold dark:text-white" x-text="new Date(selectedVisitor.created_at).toLocaleDateString('id-ID', {day:'2-digits', month:'short', year:'2-digit'})"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button @click="showModal = false" class="w-full bg-gray-900 dark:bg-indigo-600 text-white py-4 rounded-2xl font-black text-sm hover:scale-[0.98] transition-transform">Selesai Meninjau</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts & UI Support -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert Delete Confirmations
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Data?',
                text: `Kunjungan dari ${name} akan dihapus permanen.`,
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
                    document.getElementById(`deleteForm-${id}`).submit();
                }
            })
        }

        function confirmDeleteAll() {
            Swal.fire({
                title: 'Bersihkan Database?',
                text: 'Semua data kunjungan akan dihapus. Ketik "HAPUS" untuk konfirmasi:',
                input: 'text',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Hapus Segalanya',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#111827',
                borderRadius: '1.5rem',
                inputValidator: (value) => {
                    if (value !== 'HAPUS') {
                        return 'Ketik "HAPUS" secara tepat!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteAllForm').submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#111827',
                borderRadius: '1.5rem'
            });
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            // Main Trend Chart
            const ctx = document.getElementById('visitorChart').getContext('2d');
            const labels = {!! json_encode($chartData->pluck('date')) !!};
            const data = {!! json_encode($chartData->pluck('count')) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pengunjung',
                        data: data,
                        borderColor: '#6366f1',
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(99, 102, 241, 0)');
                            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.15)');
                            return gradient;
                        },
                        borderWidth: 4,
                        fill: true,
                        tension: 0.45,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        pointHoverBorderWidth: 4,
                        pointHoverBackgroundColor: '#6366f1',
                        pointHoverShadowBlur: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            ticks: { stepSize: 1, color: '#94a3b8', font: { weight: 'bold' } },
                            grid: { color: 'rgba(148, 163, 184, 0.08)' }
                        },
                        x: {
                            border: { display: false },
                            ticks: { color: '#94a3b8', font: { weight: 'bold' } },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleFont: { size: 10, weight: 'bold' },
                            bodyFont: { size: 12, weight: 'black' },
                            padding: 12,
                            borderRadius: 12,
                            displayColors: false
                        }
                    }
                }
            });

            // Mini Mini Chart
            new Chart(document.getElementById('miniTrendChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels.slice(-7),
                    datasets: [{
                        data: data.slice(-7),
                        backgroundColor: '#6366f1',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { display: false }, x: { display: false } },
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>

    <style>
        .animate-pulse-once {
            animation: pulse-once 0.6s ease-out forwards;
        }
        @keyframes pulse-once {
            0% { transform: scale(0.95); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</x-app-layout>
