# Reset Password Massal

Script ini digunakan untuk mereset password semua user ke password default berdasarkan role masing-masing.

## Cara Menggunakan

1. Buka terminal/command prompt
2. Navigasi ke direktori root proyek
3. Jalankan perintah:
   ```
   php reset_passwords.php
   ```

## Password Default Berdasarkan Role

- **siswa**: siswa123
- **panitia**: panitia123
- **admin**: admin123
- **kepala_sekolah**: kepala123

## Apa yang Dilakukan Script

1. Mengambil semua user dari database
2. Untuk setiap user:
   - Menentukan password default berdasarkan role
   - Meng-hash password dengan `password_hash()`
   - Mengatur `first_login = 1` agar user diminta mengganti password saat login pertama
   - Menyimpan perubahan ke database

## Keamanan

- Semua password disimpan dalam bentuk hash, tidak dalam bentuk plaintext
- Setelah direset, user akan diminta mengganti password saat login pertama kali
- Script ini hanya boleh dijalankan oleh administrator sistem

## Konfirmasi

Script akan meminta konfirmasi sebelum menjalankan reset password massal untuk mencegah eksekusi yang tidak disengaja.

## Troubleshooting

Jika terjadi error saat menjalankan script:
1. Pastikan Anda berada di direktori root proyek
2. Pastikan database dapat diakses
3. Pastikan Anda memiliki hak akses untuk mengubah data user