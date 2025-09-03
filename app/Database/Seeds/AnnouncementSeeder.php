<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Pengumuman Pembukaan PPDB Tahun Ajaran 2025/2026',
                'content' => '<p>Dengan ini kami umumkan bahwa PPDB (Penerimaan Peserta Didik Baru) MIN 2 Tanggamus untuk tahun ajaran 2025/2026 telah dibuka.</p>
                              <p>Persyaratan pendaftaran:</p>
                              <ul>
                                <li>Fotokopi Akta Kelahiran</li>
                                <li>Fotokopi Kartu Keluarga</li>
                                <li>Pas foto 3x4 sebanyak 2 lembar</li>
                                <li>Surat keterangan dari sekolah sebelumnya</li>
                              </ul>
                              <p>Pendaftaran dibuka mulai tanggal 1 September 2025 hingga 30 September 2025.</p>',
                'date' => date('Y-m-d H:i:s'),
                'sender' => 'Panitia PPDB',
            ],
            [
                'title' => 'Perubahan Jadwal Verifikasi Berkas',
                'content' => '<p>Mohon perhatian bapak/ibu calon peserta didik, terjadi perubahan jadwal verifikasi berkas yang semula dijadwalkan pada tanggal 5 Oktober 2025 menjadi tanggal 7 Oktober 2025.</p>
                              <p>Verifikasi berkas akan dilaksanakan di MIN 2 Tanggamus mulai pukul 08.00 WIB sampai dengan selesai.</p>
                              <p>Harap membawa seluruh berkas asli untuk diverifikasi.</p>',
                'date' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'sender' => 'Panitia PPDB',
            ],
            [
                'title' => 'Pengumuman Hasil Seleksi PPDB Gelombang Pertama',
                'content' => '<p>Dengan ini kami umumkan hasil seleksi PPDB gelombang pertama MIN 2 Tanggamus tahun ajaran 2025/2026.</p>
                              <p>Bagi peserta yang dinyatakan <strong>diterima</strong>, silakan melakukan daftar ulang mulai tanggal 15 Oktober 2025 hingga 20 Oktober 2025.</p>
                              <p>Bagi peserta yang masuk dalam daftar <strong>cadangan</strong>, akan dihubungi secara terpisah melalui nomor telepon yang tercantum dalam formulir pendaftaran.</p>',
                'date' => date('Y-m-d H:i:s', strtotime('-1 week')),
                'sender' => 'Panitia PPDB',
            ],
        ];

        // Using Query Builder
        $this->db->table('announcements')->insertBatch($data);
    }
}