<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CmsPostSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'type' => 'announcement',
                'title' => 'Pengumuman Pembukaan PPDB Tahun Ajaran 2025/2026',
                'slug' => 'pengumuman-pembukaan-ppdb-2025-2026',
                'content' => '<p>Dengan ini kami umumkan bahwa Penerimaan Peserta Didik Baru (PPDB) MIN 2 Tanggamus untuk tahun ajaran 2025/2026 telah dibuka. Kami mengundang para calon peserta didik untuk mendaftar mulai tanggal 1 September 2025 hingga 30 Juni 2026.</p>
                              <p>Syarat pendaftaran:
                              <ul>
                                <li>Fotokopi akta kelahiran</li>
                                <li>Fotokopi kartu keluarga</li>
                                <li>Pas foto 3x4 sebanyak 2 lembar</li>
                                <li>Surat keterangan lulus dari jenjang sebelumnya</li>
                              </ul>
                              </p>',
                'attachment_path' => null,
                'status' => 'published',
                'publish_at' => '2025-08-28 10:07:46',
                'author_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'type' => 'info',
                'title' => 'Persyaratan Pendaftaran Siswa Baru',
                'slug' => 'persyaratan-pendaftaran-siswa-baru',
                'content' => '<p>Berikut adalah persyaratan pendaftaran yang harus dipenuhi oleh calon peserta didik:</p>
                              <ol>
                                <li>Warga Negara Indonesia (WNI)</li>
                                <li>Beragama Islam</li>
                                <li>Berusia maksimal 12 tahun pada awal Juli 2025</li>
                                <li>Dalam keadaan sehat jasmani dan rohani</li>
                                <li>Memiliki prestasi akademik dan non-akademik yang baik</li>
                              </ol>
                              <p>Calon peserta didik diwajibkan membawa dokumen asli dan fotokopi saat verifikasi berkas.</p>',
                'attachment_path' => null,
                'status' => 'published',
                'publish_at' => '2025-08-28 10:07:46',
                'author_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'type' => 'page',
                'title' => 'Tentang MIN 2 Tanggamus',
                'slug' => 'tentang-min-2-tanggamus',
                'content' => '<p>Madrasah Ibtidaiyah Negeri (MIN) 2 Tanggamus merupakan lembaga pendidikan dasar di bawah naungan Kementerian Agama Republik Indonesia. Berdiri sejak tahun 1980, MIN 2 Tanggamus telah melahirkan banyak alumni yang berprestasi dan berkontribusi dalam berbagai bidang.</p>
                              <h3>Visi</h3>
                              <p>Terwujudnya Madrasah yang unggul dalam prestasi, berakhlak mulia, dan berwawasan kebangsaan berlandaskan iman dan taqwa.</p>
                              <h3>Misi</h3>
                              <ul>
                                <li>Menyelenggarakan pendidikan yang berkualitas</li>
                                <li>Meningkatkan penghayatan dan pengamalan terhadap ajaran agama Islam</li>
                                <li>Mengembangkan sikap disiplin, tanggung jawab, dan mandiri</li>
                                <li>Menumbuhkan rasa cinta tanah air dan persatuan bangsa</li>
                                <li>Meningkatkan potensi diri melalui kegiatan ekstrakurikuler</li>
                              </ul>',
                'attachment_path' => null,
                'status' => 'published',
                'publish_at' => '2025-08-28 10:07:46',
                'author_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'type' => 'announcement',
                'title' => 'Jadwal Seleksi PPDB 2025/2026',
                'slug' => 'jadwal-seleksi-ppdb-2025-2026',
                'content' => '<p>Berikut adalah jadwal seleksi PPDB MIN 2 Tanggamus tahun ajaran 2025/2026:</p>
                              <table class="table table-bordered">
                                <tr>
                                  <th>Kegiatan</th>
                                  <th>Tanggal</th>
                                  <th>Waktu</th>
                                </tr>
                                <tr>
                                  <td>Pendaftaran Online</td>
                                  <td>1 September - 30 Juni 2026</td>
                                  <td>24 Jam</td>
                                </tr>
                                <tr>
                                  <td>Verifikasi Berkas</td>
                                  <td>5-10 Juli 2026</td>
                                  <td>08.00-15.00 WIB</td>
                                </tr>
                                <tr>
                                  <td>Tes Masuk</td>
                                  <td>15 Juli 2026</td>
                                  <td>08.00-12.00 WIB</td>
                                </tr>
                                <tr>
                                  <td>Pengumuman Hasil</td>
                                  <td>20 Juli 2026</td>
                                  <td>10.00 WIB</td>
                                </tr>
                              </table>',
                'attachment_path' => null,
                'status' => 'published',
                'publish_at' => '2025-08-28 10:07:46',
                'author_id' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ];

        // Using Query Builder
        $this->db->table('cms_posts')->insertBatch($data);
    }
}