# PPDB Online - Penerimaan Peserta Didik Baru

Sistem Penerimaan Peserta Didik Baru (PPDB) Online berbasis web menggunakan CodeIgniter 4. Aplikasi ini dirancang untuk memudahkan proses pendaftaran siswa baru di lembaga pendidikan, khususnya untuk Madrasah Ibtidaiyah (MI).

## Fitur Utama

### 1. Sistem Otentikasi dan Otorisasi
- **Registrasi Pengguna**: Pendaftaran akun untuk calon siswa
- **Login Multi-role**: Dukungan untuk tiga peran pengguna:
  - **Siswa**: Mengisi formulir pendaftaran dan mengunggah dokumen
  - **Panitia**: Memverifikasi pendaftaran dan mengelola data siswa
  - **Admin**: Manajemen pengguna, konten, dan pengaturan sistem
- **Proteksi Akses**: Filter berbasis peran untuk setiap fitur

### 2. Formulir Pendaftaran Siswa
- **Data Pribadi**: Informasi siswa termasuk NISN, NIK, tempat/tanggal lahir
- **Data Sekolah Asal**: Informasi sekolah sebelumnya
- **Alamat**: Alamat Kartu Keluarga dan domisili
- **Data Orang Tua/Wali**: Informasi ayah, ibu, atau wali
- **Kartu Keluarga**: Data kartu keluarga
- **Kebutuhan Khusus**: Dukungan untuk siswa berkebutuhan khusus

### 3. Manajemen Dokumen
- **Unggah Dokumen**: Mendukung PDF, JPEG, dan PNG
- **Verifikasi Dokumen**: Panitia dapat memverifikasi atau menolak dokumen
- **Tipe Dokumen**:
  - Akte Kelahiran (wajib)
  - Kartu Keluarga (wajib)
  - Pas Foto (wajib)
  - Rapor (opsional)
  - KIP (opsional)
  - Dokumen Lainnya (opsional)

### 4. Manajemen Data Siswa
- **Pendaftaran Offline**: Panitia dapat menambahkan data siswa secara manual
- **Edit Data**: Pengelolaan data siswa lengkap (biodata, alamat, orang tua, dokumen)
- **Status Pendaftaran**: Pelacakan status verifikasi, diterima, cadangan, atau ditolak
- **Hapus Data**: Soft-delete untuk menjaga integritas data

### 5. Content Management System (CMS)
- **Pengumuman**: Manajemen pengumuman untuk ditampilkan di halaman depan
- **Informasi Umum**: Informasi proses pendaftaran dan persyaratan
- **Halaman Statis**: Profil madrasah, kontak, dan informasi lainnya

### 6. Ekspor Data
- **Ekspor PDF**: Cetak formulir pendaftaran dan bukti pendaftaran
- **Ekspor Excel**: Ekspor data pendaftar untuk keperluan administrasi

### 7. Dashboard dan Statistik
- **Dashboard Siswa**: Status pendaftaran dan dokumen
- **Dashboard Panitia**: Statistik pendaftaran dan aksi cepat
- **Dashboard Admin**: Statistik pengguna dan pengelolaan konten

## Struktur Database

### Tabel Utama
- `users`: Manajemen akun pengguna
- `students`: Data siswa
- `prior_schools`: Riwayat sekolah sebelumnya
- `addresses`: Alamat KK dan domisili
- `parents`: Data orang tua/wali
- `family_cards`: Informasi kartu keluarga
- `documents`: Dokumen siswa
- `submissions`: Status pendaftaran
- `cms_posts`: Konten CMS (pengumuman, info, halaman)
- `settings`: Pengaturan sistem
- `academic_years`: Tahun akademik dan gelombang pendaftaran
- `madrasah_profile`: Profil madrasah
- `audit_logs`: Log aktivitas pengguna
- `sequences`: Penomoran pendaftaran
- `special_needs`: Daftar kebutuhan khusus
- `student_special_needs`: Relasi siswa dengan kebutuhan khusus

## Teknologi yang Digunakan

- **Framework**: CodeIgniter 4
- **Bahasa Pemrograman**: PHP 7.4+
- **Frontend**: HTML5, CSS3, JavaScript, Tailwind CSS
- **Database**: MySQL 5.7+
- **PDF Generation**: Dompdf
- **Image Processing**: Intervention Image
- **Autentikasi**: Native PHP session dengan password_hash

## Instalasi

1. **Kloning Repository**
   ```bash
   git clone <repository-url>
   cd ppdb-online
   ```

2. **Instalasi Dependensi**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   - Salin file `env` ke `.env`
   - Sesuaikan konfigurasi database dan pengaturan lainnya

4. **Migrasi Database**
   ```bash
   php spark migrate
   php spark db:seed MainSeeder
   ```

5. **Jalankan Aplikasi**
   ```bash
   php spark serve
   ```

## Penggunaan

### Peran Siswa
1. Registrasi akun di halaman pendaftaran
2. Login dan lengkapi formulir pendaftaran
3. Unggah dokumen yang diperlukan
4. Submit formulir pendaftaran
5. Pantau status pendaftaran di dashboard

### Peran Panitia
1. Login dengan akun panitia
2. Verifikasi dokumen siswa
3. Update status pendaftaran
4. Kelola data siswa (offline registration)
5. Ekspor data untuk keperluan administrasi

### Peran Admin
1. Login dengan akun admin
2. Kelola pengguna (siswa, panitia)
3. Kelola konten CMS
4. Konfigurasi pengaturan sistem
5. Kelola profil madrasah dan tahun akademik

## Pengaturan Sistem

### Tahun Akademik
- Manajemen tahun pelajaran dan gelombang pendaftaran
- Pengaturan kuota per kelas
- Penjadwalan periode pendaftaran

### Profil Madrasah
- Informasi resmi madrasah
- Data kontak dan alamat
- Informasi kepala madrasah
- Logo dan kop surat untuk keperluan cetak

### Pengaturan Pendaftaran
- Toggle pembukaan/tutup pendaftaran
- Konfigurasi persyaratan dokumen
- Pengaturan ukuran maksimum file

## Keamanan

- Password di-hash menggunakan `password_hash()`
- Validasi dan sanitasi input
- Proteksi CSRF
- Filter berbasis peran
- Soft-delete untuk menjaga integritas data

## Lisensi

Aplikasi ini dikembangkan untuk keperluan pendidikan dan dapat digunakan secara bebas sesuai dengan kebutuhan institusi pendidikan.

## Pengembangan Lanjutan

Aplikasi ini dirancang dengan arsitektur modular yang memungkinkan pengembangan fitur tambahan sesuai kebutuhan, termasuk:
- Integrasi dengan sistem eksternal
- Notifikasi email/SMS
- Dashboard analitik yang lebih lengkap
- Mobile application