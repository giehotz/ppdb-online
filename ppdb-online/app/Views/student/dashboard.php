<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard Siswa</h2>
    <nav class="text-sm text-gray-500">
        <span>Home</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Selamat Datang, <?= session()->get('username') ?>!</h3>
    <p class="text-gray-600 mb-4">
        Selamat datang di sistem PPDB MIN 2 Tanggamus. Silakan lengkapi data pendaftaran Anda dengan mengikuti langkah-langkah berikut:
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                    1
                </div>
                <h4 class="font-medium text-gray-800">Lengkapi Profil Siswa</h4>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Masukkan data pribadi, alamat, dan informasi orang tua Anda.
            </p>
            <a href="/student/registration" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                <i class="fas fa-edit mr-1"></i> Isi Profil
            </a>
        </div>

        <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                    2
                </div>
                <h4 class="font-medium text-gray-800">Unggah Dokumen</h4>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Unggah dokumen yang diperlukan seperti akta kelahiran, kartu keluarga, dan pas foto.
            </p>
            <a href="/student/documents" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                <i class="fas fa-upload mr-1"></i> Unggah Dokumen
            </a>
            <a href="/student/documents" class="text-blue-500 hover:text-blue-700 text-sm font-medium mt-2 block">
                <i class="fas fa-file-alt mr-1"></i> Lihat Dokumen yang Telah Diunggah
            </a>
        </div>

        <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                    3
                </div>
                <h4 class="font-medium text-gray-800">Ajukan Pendaftaran</h4>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Periksa kembali data Anda dan ajukan pendaftaran untuk diverifikasi.
            </p>
            <?php if (isset($student) && $student && $student['submission_state'] === 'draft'): ?>
                <button id="submitRegistrationBtn" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                    <i class="fas fa-paper-plane mr-1"></i> Ajukan Pendaftaran
                </button>
            <?php elseif (isset($student) && $student && $student['submission_state'] === 'submitted'): ?>
                <span class="text-gray-500 text-sm">
                    <i class="fas fa-check-circle mr-1"></i> Pendaftaran telah diajukan
                </span>
            <?php else: ?>
                <span class="text-gray-500 text-sm">
                    <i class="fas fa-lock mr-1"></i> Selesaikan langkah sebelumnya
                </span>
            <?php endif; ?>
        </div>

        <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                    4
                </div>
                <h4 class="font-medium text-gray-800">Cetak Formulir</h4>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Setelah data diverifikasi, cetak formulir pendaftaran sebagai bukti.
            </p>
            <?php if (isset($submission) && $submission): ?>
                <a href="/student/print-registration" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                    <i class="fas fa-print mr-1"></i> Cetak Formulir
                </a>
            <?php else: ?>
                <span class="text-gray-500 text-sm">
                    <i class="fas fa-lock mr-1"></i> Setelah pendaftaran diverifikasi
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Status Pendaftaran</h3>
    </div>
    <div class="p-6">
        <?php if (isset($submission) && $submission): ?>
            <?php
            $statusLabels = [
                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                'terverifikasi' => 'Terverifikasi',
                'diterima' => 'Diterima',
                'cadangan' => 'Cadangan',
                'ditolak' => 'Ditolak'
            ];

            $statusColors = [
                'menunggu_verifikasi' => 'bg-yellow-500',
                'terverifikasi' => 'bg-blue-500',
                'diterima' => 'bg-green-500',
                'cadangan' => 'bg-purple-500',
                'ditolak' => 'bg-red-500'
            ];

            $currentStatus = $submission['status'];
            ?>
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full <?= $statusColors[$currentStatus] ?> mr-3"></div>
                <span class="text-gray-700">
                    <?= $statusLabels[$currentStatus] ?>
                    <?php if ($submission['registration_no']): ?>
                        (<?= $submission['registration_no'] ?>)
                    <?php endif; ?>
                </span>
            </div>
            <?php if ($currentStatus === 'ditolak' && !empty($submission['rejection_reason'])): ?>
                <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded">
                    <p class="text-sm text-red-700">
                        <span class="font-medium">Alasan penolakan:</span>
                        <?= $submission['rejection_reason'] ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php elseif (isset($student) && $student && $student['submission_state'] === 'submitted'): ?>
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-3"></div>
                <span class="text-gray-700">Pendaftaran dalam proses</span>
            </div>
        <?php else: ?>
            <div class="flex items-center">
                <div class="w-3 h-3 rounded-full bg-yellow-500 mr-3"></div>
                <span class="text-gray-700">Belum mengisi data pribadi</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('submitRegistrationBtn')?.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mengajukan pendaftaran? Setelah diajukan, data tidak dapat diubah.')) {
            fetch('/student/submit-registration', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengajukan pendaftaran');
                });
        }
    });
</script>
<?= $this->endSection() ?>