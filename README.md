# Dokumentasi Aplikasi Perpustakaan (UJK)

## Deskripsi
Aplikasi ini adalah sistem CRUD perpustakaan berbasis Laravel untuk kebutuhan UJK.
Fitur utama mencakup:
- Kelola data anggota
- Kelola data buku
- Kelola data peminjaman
- Dashboard ringkasan data

## Teknologi
- PHP 8.3
- Laravel 13
- MySQL
- Blade Template
- Tailwind CSS (CDN)

## Modul dan Fitur

### 1. Dashboard
Menampilkan statistik utama:
- Jumlah buku
- Jumlah anggota
- Total peminjam
- Sudah dikembalikan
- Belum dikembalikan
- Terlambat

### 2. Anggota
- Tambah anggota (popup modal)
- Lihat daftar anggota
- Edit anggota
- Hapus anggota dengan popup konfirmasi
- Validasi input per field (pesan merah)
- Proteksi hapus jika masih dipakai di peminjaman

### 3. Buku
- Tambah buku (popup modal)
- Lihat daftar buku
- Edit buku
- Hapus buku dengan popup konfirmasi
- Validasi input per field (pesan merah)
- Proteksi hapus jika masih dipakai di peminjaman

### 4. Peminjaman
- Tambah peminjaman (popup modal)
- Lihat daftar peminjaman
- Edit peminjaman
- Hapus peminjaman dengan popup konfirmasi
- Validasi input per field (pesan merah)

## Struktur Database

### Tabel anggota
- id (primary key)
- nomor_induk (string, unique)
- nama (string)
- alamat (string)
- created_at, updated_at

### Tabel buku
- id (primary key)
- judul (string)
- pengarang (string)
- penerbit (string)
- tahun (year)
- created_at, updated_at

### Tabel peminjaman
- id (primary key)
- anggota_id (foreign key -> anggota.id)
- buku_id (foreign key -> buku.id)
- tanggal_pinjam (date)
- tanggal_kembali (date, nullable)
- status (dipinjam | dikembalikan | terlambat)
- created_at, updated_at

Catatan relasi:
- FK pada peminjaman menggunakan restrict delete untuk menjaga integritas data.

## Alur CRUD

### Anggota
1. Klik menu Anggota.
2. Klik tombol Tambah Anggota.
3. Isi form dan simpan.
4. Gunakan Edit/Hapus pada tabel.

### Buku
1. Klik menu Buku.
2. Klik tombol Tambah Buku.
3. Isi form dan simpan.
4. Gunakan Edit/Hapus pada tabel.

### Peminjaman
1. Klik menu Peminjaman.
2. Klik tombol Tambah Peminjaman.
3. Pilih anggota dan buku, isi tanggal/status.
4. Simpan, lalu kelola data melalui tabel.


## Rute Utama
- GET / -> dashboard
- GET /anggota
- POST /anggota
- PUT /anggota/{id}
- DELETE /anggota/{id}
- GET /buku
- POST /buku
- PUT /buku/{id}
- DELETE /buku/{id}
- GET /peminjaman
- POST /peminjaman
- PUT /peminjaman/{id}
- DELETE /peminjaman/{id}

## Cara Menjalankan
1. Install dependency:

```bash
composer install
```

2. Salin env dan generate key:

```bash
copy .env.example .env
php artisan key:generate
```

3. Atur koneksi database pada file .env.

4. Jalankan migrasi:

```bash
php artisan migrate
```

5. Jalankan server:

```bash
php artisan serve
```

6. Buka aplikasi:
- http://127.0.0.1:8000

## Pengujian
Menjalankan test:

```bash
php artisan test
```

Test yang tersedia:
- Feature test alur CRUD
- Feature test validasi dan relasi

## Persiapan Presentasi UJK
- Buka aplikasi di browser (dashboard + form CRUD)
- Buka source code (route, controller, migration, view)
- Buka database (tabel anggota, buku, peminjaman)
- Siapkan penjelasan variabel, method, library, dan error handling

## Catatan
Dokumentasi ini dibuat untuk memenuhi ketentuan dokumen kode program pada UJK.
