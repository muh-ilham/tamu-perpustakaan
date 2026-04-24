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
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            min-height: 100vh;
        }
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .animate-glow {
            animation: glow 4s infinite alternate;
        }
        @keyframes glow {
            from { box-shadow: 0 0 10px rgba(99, 102, 241, 0.2); }
            to { box-shadow: 0 0 30px rgba(99, 102, 241, 0.5); }
        }
        video {
            transform: scaleX(-1);
        }
    </style>
</head>
<body class="text-white p-4 md:p-8 flex items-center justify-center">
    <div class="max-w-6xl w-full">
        <div class="text-center mb-10 flex flex-col items-center">
            @if($global_settings['app_logo'])
                <img src="{{ asset('storage/' . $global_settings['app_logo']) }}" class="h-20 w-auto mb-6 drop-shadow-2xl">
            @endif
            <h1 class="text-4xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400 mb-2">
                {{ $global_settings['app_name'] }}
            </h1>
            <p class="text-gray-400">Silakan isi data kunjungan Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Form Section -->
            <div class="glass p-8 rounded-3xl animate-glow">
                <form id="visitorForm" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Pangkat</label>
                            <input type="text" name="pangkat" 
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                                placeholder="Contoh: Mayor">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Satuan</label>
                            <input type="text" name="satuan" 
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                                placeholder="Contoh: Kodam">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Judul Buku (Opsional)</label>
                        <input type="text" name="judul_buku" 
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                            placeholder="Buku yang sedang dibaca">
                    </div>

                    <button type="submit" id="btnSubmit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2">
                        <span>Simpan Kunjungan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    <p class="text-center text-xs text-gray-500">Pastikan kamera di sebelah kanan aktif untuk mengambil foto.</p>
                </form>
            </div>

            <!-- Camera Section -->
            <div class="glass p-6 rounded-3xl flex flex-col items-center justify-center relative overflow-hidden group">
                <div id="camera-container" class="w-full aspect-[4/3] rounded-2xl overflow-hidden bg-black/40 relative border border-white/5">
                    <video id="video" class="w-full h-full object-cover" autoplay playsinline></video>
                    <canvas id="canvas" class="hidden"></canvas>
                    
                    <!-- Camera Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-20 h-20 border-2 border-dashed border-indigo-400 rounded-full animate-pulse"></div>
                    </div>
                    
                    <div class="absolute bottom-4 left-4 flex items-center gap-2 bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10">
                        <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-semibold uppercase tracking-wider">Live Camera</span>
                    </div>
                </div>
                
                <div id="preview-container" class="hidden w-full aspect-[4/3] rounded-2xl overflow-hidden bg-black/40 relative border-2 border-indigo-500">
                    <img id="photo-preview" class="w-full h-full object-cover">
                    <button id="re-take" class="absolute top-4 right-4 bg-white/10 hover:bg-white/20 backdrop-blur-md p-2 rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 flex flex-col items-center">
                    <div class="text-gray-400 text-sm mb-2">Tangkapan layar akan otomatis tersimpan saat submit</div>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition-colors">Masuk sebagai Admin</a>
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
