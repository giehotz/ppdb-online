<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftaran</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .table-data {
            background-color: #f7fafc;
            /* Tailwind: gray-100 */
        }

        .status-badge {
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            text-align: center;
            color: white;
        }

        .status-menunggu {
            background-color: #f6ad55;
            /* Tailwind: yellow-500 */
        }

        .status-terverifikasi {
            background-color: #4299e1;
            /* Tailwind: blue-500 */
        }

        .status-diterima {
            background-color: #48bb78;
            /* Tailwind: green-500 */
        }

        .status-cadangan {
            background-color: #a0aec0;
            /* Tailwind: gray-500 */
        }

        .status-ditolak {
            background-color: #f56565;
            /* Tailwind: red-500 */
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto px-4 md:px-8 lg:px-12 py-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-800">Detail Pendaftaran</h1>
            <a href="<?= base_url('/admin/submissions'); ?>" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pendaftaran</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody>
                        <tr>
                            <td class="py-2 pr-4 font-semibold w-1/3">Nama Siswa</td>
                            <td class="py-2 pl-4 table-data rounded-md"><?= esc($submission['student_name']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 font-semibold w-1/3">NISN</td>
                            <td class="py-2 pl-4 table-data rounded-md"><?= esc($submission['nisn']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 font-semibold w-1/3">NIK</td>
                            <td class="py-2 pl-4 table-data rounded-md"><?= esc($submission['nik']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 font-semibold w-1/3">Tempat, Tanggal Lahir</td>
                            <td class="py-2 pl-4 table-data rounded-md"><?= esc($submission['birth_place']); ?>, <?= date('d M Y', strtotime($submission['birth_date'])); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 font-semibold w-1/3">No. Pendaftaran</td>
                            <td class="py-2 pl-4 table-data rounded-md"><?= esc($submission['registration_no']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 font-semibold w-1/3">Status</td>
                            <td class="py-2 pl-4">
                                <?php
                                // Mempertahankan logika PHP untuk menampilkan badge status
                                $statusClass = '';
                                $statusText = '';
                                switch ($submission['status']) {
                                    case 'menunggu_verifikasi':
                                        $statusClass = 'status-menunggu';
                                        $statusText = 'Menunggu Verifikasi';
                                        break;
                                    case 'terverifikasi':
                                        $statusClass = 'status-terverifikasi';
                                        $statusText = 'Terverifikasi';
                                        break;
                                    case 'diterima':
                                        $statusClass = 'status-diterima';
                                        $statusText = 'Diterima';
                                        break;
                                    case 'cadangan':
                                        $statusClass = 'status-cadangan';
                                        $statusText = 'Cadangan';
                                        break;
                                    case 'ditolak':
                                        $statusClass = 'status-ditolak';
                                        $statusText = 'Ditolak';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?= $statusClass; ?>"><?= $statusText; ?></span>
                            </td>
                        </tr>
                        <?php if ($submission['status'] == 'ditolak' && !empty($submission['rejection_reason'])): ?>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Alasan Penolakan</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($submission['rejection_reason']); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="py-2 pr-4 font-semibold w-1/3">Tanggal Pendaftaran</td>
                            <td class="py-2 pl-4 table-data rounded-md"><?= date('d M Y H:i:s', strtotime($submission['created_at'])); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($priorSchool): ?>
            <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Sekolah Asal</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Nama Sekolah</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($priorSchool['school_name']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">NPSN</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($priorSchool['npsn']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Alamat Sekolah</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($priorSchool['school_address']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Kabupaten/Kota</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($priorSchool['regency']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Provinsi</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($priorSchool['province']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Tahun Lulus</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($priorSchool['graduation_year']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Nomor Ijazah</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($priorSchool['diploma_number']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Alamat</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($addresses as $address): ?>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold mb-2"><?= $address['address_type'] == 'kk' ? 'Alamat KK' : 'Alamat Domisili'; ?></h3>
                        <table class="w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Alamat</td>
                                    <td class="py-1"><?= esc($address['address']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">RT/RW</td>
                                    <td class="py-1"><?= esc($address['rt']); ?>/<?= esc($address['rw']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Kelurahan</td>
                                    <td class="py-1"><?= esc($address['village']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Kecamatan</td>
                                    <td class="py-1"><?= esc($address['district']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Kabupaten/Kota</td>
                                    <td class="py-1"><?= esc($address['regency']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Provinsi</td>
                                    <td class="py-1"><?= esc($address['province']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Kode Pos</td>
                                    <td class="py-1"><?= esc($address['postal_code']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Orang Tua</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($parents as $parent): ?>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold mb-2"><?= $parent['relation'] == 'ayah' ? 'Data Ayah' : 'Data Ibu'; ?></h3>
                        <table class="w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Nama</td>
                                    <td class="py-1"><?= esc($parent['name']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">NIK</td>
                                    <td class="py-1"><?= esc($parent['nik']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Tahun Lahir</td>
                                    <td class="py-1"><?= esc($parent['birth_year']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Pendidikan</td>
                                    <td class="py-1"><?= esc($parent['education']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Pekerjaan</td>
                                    <td class="py-1"><?= esc($parent['job']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Penghasilan</td>
                                    <td class="py-1"><?= esc($parent['income']); ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-4 font-medium w-1/3">Berkebutuhan Khusus</td>
                                    <td class="py-1"><?= $parent['special_needs'] == 'Ya' ? 'Ya' : 'Tidak'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($familyCard): ?>
            <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Kartu Keluarga</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">No. KK</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($familyCard['kk_number']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Kepala Keluarga</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($familyCard['head_of_family']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Alamat</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($familyCard['address']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">RT/RW</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($familyCard['rt']); ?>/<?= esc($familyCard['rw']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Kelurahan</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($familyCard['village']); ?></td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold w-1/3">Kecamatan</td>
                                <td class="py-2 pl-4 table-data rounded-md"><?= esc($familyCard['district']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>