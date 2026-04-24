<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $global_settings['app_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top left, #1e1b4b 0%, #0f172a 50%, #020617 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 40%;
            height: 40%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 70%);
            filter: blur(50px);
            z-index: -1;
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .animate-glow {
            animation: glow 6s infinite alternate;
        }
        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(79, 70, 229, 0.1); }
            to { box-shadow: 0 0 40px rgba(79, 70, 229, 0.3); }
        }
        video {
            transform: scaleX(-1);
        }
        .input-premium {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .input-premium:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
    </style>
</head>
<body class="text-white selection:bg-indigo-500 selection:text-white">
    <div class="min-h-screen py-10 md:py-16 px-4 md:px-8 flex items-center justify-center">
        <div class="max-w-6xl w-full relative z-10">
            <div class="text-center mb-12 flex flex-col items-center">
                @if(isset($global_settings['app_logo']) && $global_settings['app_logo'])
                    <div class="mb-6 transform hover:scale-105 transition-transform duration-500">
                        <img src="{{ asset('storage/' . $global_settings['app_logo']) }}" class="h-28 md:h-36 w-auto drop-shadow-[0_0_20px_rgba(99,102,241,0.5)]">
                    </div>
                @endif
                <h1 class="text-3xl md:text-6xl font-black bg-clip-text text-transparent bg-gradient-to-r from-white via-indigo-100 to-indigo-400 mb-4 tracking-tight leading-tight">
                    {{ $global_settings['app_name'] }}
                </h1>
                <div class="flex items-center justify-center gap-3 w-full px-6 text-center">
                    <span class="hidden md:block h-px w-12 bg-indigo-500/30"></span>
                    <p class="text-[10px] md:text-xs text-indigo-300/80 font-black uppercase tracking-[0.4em] leading-relaxed">
                        {{ $global_settings['app_subtitle'] ?? 'Buku Tamu Digital Perpustakaan' }}
                    </p>
                    <span class="hidden md:block h-px w-12 bg-indigo-500/30"></span>
                </div>
            </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Form Section -->
            <div class="glass p-6 md:p-10 rounded-[2rem] animate-glow relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <form id="visitorForm" class="space-y-6 relative z-10">
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required 
                            class="input-premium w-full rounded-2xl px-5 py-4 text-white focus:outline-none placeholder-white/20 font-medium"
                            placeholder="Contoh: Ahmad Subardjo">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-2 ml-1">Pangkat / Golongan</label>
                            <input type="text" name="pangkat" 
                                class="input-premium w-full rounded-2xl px-5 py-4 text-white focus:outline-none placeholder-white/20 font-medium"
                                placeholder="Contoh: Mayor">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-2 ml-1">Instansi / Satuan</label>
                            <input type="text" name="satuan" 
                                class="input-premium w-full rounded-2xl px-5 py-4 text-white focus:outline-none placeholder-white/20 font-medium"
                                placeholder="Contoh: Kodam XIV">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-2 ml-1">Judul Buku (Opsional)</label>
                        <input type="text" name="judul_buku" 
                            class="input-premium w-full rounded-2xl px-5 py-4 text-white focus:outline-none placeholder-white/20 font-medium"
                            placeholder="Judul buku yang dibaca/dicari">
                    </div>

                    <div class="pt-4">
                        <button type="submit" id="btnSubmit" 
                            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-5 rounded-2xl shadow-2xl shadow-indigo-500/40 transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3 group">
                            <span class="uppercase tracking-widest text-sm">Simpan Kunjungan</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-center gap-2 opacity-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="text-[10px] font-bold uppercase tracking-tighter">Kamera akan mengambil foto secara otomatis</p>
                    </div>
                </form>
            </div>

            <!-- Camera Section -->
            <div class="glass p-8 rounded-[2rem] flex flex-col items-center justify-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 ptr-none"></div>
                
                <div id="camera-container" class="w-full aspect-[4/3] rounded-2xl overflow-hidden bg-black/60 relative border border-white/10 shadow-inner group-hover:border-indigo-500/30 transition-colors">
                    <video id="video" class="w-full h-full object-cover" autoplay playsinline></video>
                    <canvas id="canvas" class="hidden"></canvas>
                    
                    <!-- Camera Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-24 h-24 border-2 border-dashed border-indigo-400/50 rounded-full animate-spin-slow"></div>
                    </div>
                    
                    <div class="absolute bottom-6 left-6 flex items-center gap-2 bg-black/40 backdrop-blur-xl px-4 py-2 rounded-2xl border border-white/10">
                        <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse shadow-[0_0_10px_rgb(239,68,68)]"></div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-white/90">Recording Live</span>
                    </div>
                </div>
                
                <div id="preview-container" class="hidden w-full aspect-[4/3] rounded-2xl overflow-hidden bg-black/60 relative border-2 border-indigo-500 shadow-[0_0_30px_rgba(79,70,229,0.3)]">
                    <img id="photo-preview" class="w-full h-full object-cover">
                    <button id="re-take" class="absolute top-6 right-6 bg-white/10 hover:bg-white/20 backdrop-blur-xl p-3 rounded-2xl transition-all border border-white/10 group/btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover/btn:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                    <div class="absolute bottom-6 left-6 bg-indigo-600 px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl">
                        Preview Terpilih
                    </div>
                </div>

                <div class="mt-8 flex flex-col items-center">
                    <div class="h-1 w-12 bg-white/10 rounded-full mb-4"></div>
                    <p class="text-indigo-300/60 text-[10px] font-bold uppercase tracking-[0.2em] text-center max-w-[200px] leading-relaxed">
                        Tangkapan layar akan diproses secara real-time
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mt-16 text-center animate-bounce-slow">
            <a href="{{ route('login') }}" class="group inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/5 transition-all">
                <span class="text-white/40 group-hover:text-white/80 text-[10px] font-black uppercase tracking-widest transition-colors">Akses Administrator</span>
                <svg class="w-4 h-4 text-white/20 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </a>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const photoPreview = document.getElementById('photo-preview');
        const cameraContainer = document.getElementById('camera-container');
        const previewContainer = document.getElementById('preview-container');
        const reTakeBtn = document.getElementById('re-take');
        const form = document.getElementById('visitorForm');
        let stream = null;

        // Start Camera
        async function initCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { width: 640, height: 480 }, 
                    audio: false 
                });
                video.srcObject = stream;
            } catch (err) {
                console.error("Error access camera: ", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Gagal',
                    text: 'Pastikan Anda memberikan akses kamera di browser.',
                    background: '#1e293b',
                    color: '#fff'
                });
            }
        }

        initCamera();

        reTakeBtn.onclick = () => {
            previewContainer.classList.add('hidden');
            cameraContainer.classList.remove('hidden');
        };

        form.onsubmit = async (e) => {
            e.preventDefault();

            // Capture Photo
            const context = canvas.getContext('2d');
            canvas.width = 640;
            canvas.height = 480;
            
            // Mirror image capture
            context.translate(640, 0);
            context.scale(-1, 1);
            context.drawImage(video, 0, 0, 640, 480);
            
            const imageData = canvas.toDataURL('image/png');
            
            // Show preview briefly
            photoPreview.src = imageData;
            cameraContainer.classList.add('hidden');
            previewContainer.classList.remove('hidden');

            const formData = new FormData(form);
            formData.append('foto', imageData);

            const btnSubmit = document.getElementById('btnSubmit');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = 'Memproses...';

            try {
                const response = await fetch("{{ route('visitor.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (!response.ok) {
                    const errorMsg = await response.json();
                    throw new Error(errorMsg.message || 'Gagal menyimpan data (Server Error)');
                }

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: result.message,
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#1e293b',
                        color: '#fff'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(result.message || 'Gagal menyimpan data');
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: err.message,
                    background: '#1e293b',
                    color: '#fff'
                });
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<span>Simpan Kunjungan</span>';
            }
        };
    </script>
</body>
</html>
