# 🚀 Project Handoff: Laravel Guestbook Admin Dashboard

Dokumen ini berisi konteks teknis untuk melanjutkan pengembangan proyek **Buku Tamu Digital**.

## 📌 Informasi Dasar
- **Framework**: Laravel 11.x
- **Environment**: Shared Hosting (Rumahweb) via FTP Deployment.
- **URL**: [bukutamu.bintalxivhasanuddin.com](https://bukutamu.bintalxivhasanuddin.com)
- **Repo**: `muh-ilham/tamu-perpustakaan`

## 🛠 Konfigurasi CI/CD (GitHub Actions)
Jika deployment gagal di masa depan, periksa poin ini:
- **Workflow**: `.github/workflows/deploy.yml`
- **Connection**: Menggunakan FTP (Port 21).
- **Firewall Server**: Jika timeout, pastikan IP GitHub atau IP lokal Anda tidak diblokir. Terakhir digunakan IP: `202.10.43.152`.
- **Sync Folders**: Folder `public/storage` harus ada di server dengan permission `777` atau `775` agar upload foto berjalan.

## ✨ Fitur yang Sudah Selesai
1.  **Branding Dinamis**: Logo, Judul, dan Subjudul halaman depan diatur via dashboard admin.
2.  **Smart Visitor Log**: Tabel pengunjung dengan filter pencarian instan (Nama/Pangkat/Satuan) dan rentang waktu.
3.  **Secure Admin CRUD**: 
    - Bisa tambah, edit data, ganti password admin lain.
    - Dilengkapi ikon mata (toggle visibility) pada password.
    - Proteksi: Tidak bisa hapus diri sendiri dan tidak bisa hapus semua admin (minimal sisa 1).
4.  **Real-time Camera**: Capture foto pengunjung via webcam di halaman depan.

## 📝 Instruksi untuk Pengembang/AI Selanjutnya
Untuk melanjutkan, berikan instruksi ini:
1.  **Revisi UI**: Gunakan Tailwind CSS. Fokus pada estetika *Glassmorphism* dan *Dark Mode* yang premium.
2.  **Tambah Fitur**: Pastikan route baru didaftarkan di `routes/web.php` di dalam group `middleware(['auth'])`.
3.  **Update Database**: Jika ada migrasi baru, jalankan manual di phpMyAdmin cPanel karena shared hosting tidak mendukung `php artisan migrate` otomatis via Actions.
4.  **Deployment**: Cukup jalankan `git push` setelah commit. GitHub Actions akan menangani sisanya.

## ⚠️ Known Issues / Tips
- **Favicon**: Jika ganti logo tapi tab browser tidak berubah, lakukan *Hard Refresh* (Ctrl+F5) atau buka mode Incognito.
- **Storage Link**: Pastikan folder `public/storage` di server sudah terhubung ke `storage/app/public`.

---
*Created by Antigravity - Senior Developer AI Assistant*
