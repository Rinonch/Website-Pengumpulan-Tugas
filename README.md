# Pengumpulan Tugas Sekolah

## Deskripsi
Pengumpulan Tugas Sekolah adalah sebuah website yang dirancang untuk memudahkan siswa dalam mengumpulkan tugas sekolah. Website ini memiliki fitur upload tugas, halaman admin untuk pengelolaan tugas, serta halaman konten untuk menampilkan foto, audio, dan video.

## Struktur Proyek
Proyek ini memiliki struktur sebagai berikut:

```
pengumpulan-tugas-sekolah
├── src
│   ├── index.html        # Halaman beranda
│   ├── admin.html       # Halaman admin
│   ├── upload.html      # Halaman untuk mengupload tugas
│   ├── foto.html        # Halaman untuk menampilkan foto
│   ├── audio.html       # Halaman untuk menampilkan audio
│   ├── video.html       # Halaman untuk menampilkan video
│   ├── css
│   │   └── styles.css   # File CSS untuk styling
│   ├── js
│   │   └── main.js      # File JavaScript untuk fungsionalitas
│   └── assets
│       ├── foto         # Folder untuk menyimpan foto
│       ├── audio        # Folder untuk menyimpan audio
│       └── video        # Folder untuk menyimpan video
├── package.json         # File konfigurasi npm
└── README.md            # Dokumentasi proyek
```

## Fitur
- **Upload Tugas**: Siswa dapat mengupload tugas mereka melalui halaman upload.
- **Halaman Admin**: Admin dapat mengelola dan melihat tugas yang telah diupload.
- **Konten Multimedia**: Halaman khusus untuk menampilkan foto, audio, dan video yang diupload.
- **Responsif**: Menggunakan Bootstrap untuk memastikan tampilan yang responsif di berbagai perangkat.

## Cara Menjalankan Proyek
1. Clone repositori ini ke mesin lokal Anda.
2. Masuk ke direktori proyek.
3. Jalankan `npm install` untuk menginstal dependensi yang diperlukan.
4. Buka file `src/index.html` di browser untuk melihat halaman beranda.

## Kontribusi
Kontribusi sangat diterima! Silakan buat pull request untuk menambahkan fitur atau memperbaiki bug.