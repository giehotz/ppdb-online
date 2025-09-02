<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CMSSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'type' => 'page',
                'title' => 'Profil Madrasah',
                'slug' => 'profil-madrasah',
                'content' => '<p>Madrasah Ibtidaiyah Negeri (MIN) 2 Tanggamus merupakan lembaga pendidikan dasar di bawah naungan Kementerian Agama yang berkomitmen untuk memberikan pendidikan berkualitas dengan mengintegrasikan nilai-nilai agama dalam setiap aspek pembelajaran.</p>
                              <p>Kami berfokus pada pengembangan karakter, akademik, dan keterampilan siswa untuk membentuk generasi yang beriman, berilmu, dan berketerampilan.</p>
                              <h3>Visi</h3>
                              <p>Menjadi madrasah unggulan yang menghasilkan generasi berkarakter, berprestasi, dan berwawasan kebangsaan.</p>
                              <h3>Misi</h3>
                              <ul>
                                <li>Menyelenggarakan pendidikan berkualitas berbasis iman dan taqwa</li>
                                <li>Mengembangkan potensi peserta didik secara optimal</li>
                                <li>Membentuk karakter dan kepribadian yang unggul</li>
                                <li>Meningkatkan kompetensi guru dan tenaga kependidikan</li>
                                <li>Menjalin kerjasama yang harmonis dengan seluruh pemangku kepentingan</li>
                              </ul>',
                'status' => 'published',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'page',
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => '<p>Hubungi kami untuk informasi lebih lanjut:</p>
                              <p><strong>Alamat:</strong><br>
                              Jl. Raya Pematang Panggang - Kota Agung, Pematang Panggang, Kabupaten Tanggamus, Lampung 35612</p>
                              <p><strong>Telepon:</strong><br>
                              (0729) 123456</p>
                              <p><strong>Email:</strong><br>
                              info@min2tanggamus.sch.id</p>',
                'status' => 'published',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'info',
                'title' => 'Alur Pendaftaran',
                'slug' => 'alur-pendaftaran',
                'content' => '<p>Berikut adalah langkah-langkah pendaftaran siswa baru di MIN 2 Tanggamus:</p>
                              <ol>
                                <li><strong>Pendaftaran Akun</strong> - Calon siswa membuat akun di website PPDB</li>
                                <li><strong>Pengisian Formulir</strong> - Mengisi data diri dan data keluarga secara lengkap</li>
                                <li><strong>Upload Dokumen</strong> - Mengunggah dokumen yang diperlukan</li>
                                <li><strong>Verifikasi Berkas</strong> - Panitia memverifikasi kelengkapan berkas</li>
                                <li><strong>Pengumuman Hasil</strong> - Pengumuman hasil seleksi</li>
                                <li><strong>Daftar Ulang</strong> - Siswa yang diterima melakukan daftar ulang</li>
                              </ol>',
                'status' => 'published',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'info',
                'title' => 'Syarat Pendaftaran',
                'slug' => 'syarat-pendaftaran',
                'content' => '<p>Syarat-syarat yang harus dipenuhi untuk pendaftaran siswa baru:</p>
                              <ul>
                                <li>Beragama Islam</li>
                                <li>Berusia minimal 6 tahun pada awal tahun ajaran</li>
                                <li>Sehat jasmani dan rohani</li>
                                <li>Membayar biaya pendaftaran</li>
                                <li>Menyerahkan fotokopi Kartu Keluarga (KK)</li>
                                <li>Menyerahkan fotokopi Akta Kelahiran</li>
                                <li>Menyerahkan fotokopi KTP orang tua</li>
                                <li>Menyerahkan pas foto 3x4 sebanyak 3 lembar</li>
                                <li>Menyerahkan fotokopi rapor semester 1-5 (bagi yang sudah memiliki)</li>
                              </ul>',
                'status' => 'published',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'announcement',
                'title' => 'Pengumuman Penting',
                'slug' => 'pengumuman-penting',
                'content' => '<p>Dengan ini kami sampaikan bahwa pendaftaran siswa baru MIN 2 Tanggamus tahun ajaran 2025/2026 akan dibuka mulai tanggal 1 Juni 2025 hingga 31 Agustus 2025.</p>
                              <p>Pastikan untuk menyiapkan seluruh dokumen yang diperlukan sebelum melakukan pendaftaran online.</p>',
                'status' => 'published',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Using Query Builder
        $this->db->table('cms_posts')->insertBatch($data);
    }
}