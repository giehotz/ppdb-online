<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Pendaftaran</h2>
            <nav class="text-sm text-gray-500">
                <a href="/panitia/dashboard">Home</a> / 
                <a href="/panitia/registrations">Manajemen Pendaftaran</a> / Detail
            </nav>
        </div>
        <div class="flex space-x-2">
            <a href="/panitia/export/pdf/registration-form/<?= $submission['id'] ?>" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-file-pdf mr-1"></i> Ekspor PDF
            </a>
            <a href="/panitia/export/pdf/registration-receipt/<?= $submission['id'] ?>" target="_blank" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-print mr-1"></i> Cetak Bukti
            </a>
            <a href="/panitia/registrations" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Informasi Pendaftaran</h3>
            <a href="/panitia/verification/<?= $submission['id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                <i class="fas fa-edit mr-1"></i> Verifikasi
            </a>
        </div>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nomor Registrasi</p>
                <p class="font-medium"><?= $submission['registration_no'] ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama Siswa</p>
                <p class="font-medium"><?= $submission['student_name'] ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColors[$submission['status']] ?> text-white">
                    <?= $statusLabels[$submission['status']] ?>
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Pendaftaran</p>
                <p class="font-medium"><?= date('d M Y H:i', strtotime($submission['created_at'])) ?></p>
            </div>
            <?php if (!empty($submission['rejection_reason'])): ?>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Alasan Penolakan</p>
                <p class="font-medium text-red-600"><?= $submission['rejection_reason'] ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h4 class="text-md font-medium text-gray-900 mb-3">Data Pendaftaran</h4>
            <table class="min-w-full">
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500 w-40">No. Pendaftaran</td>
                    <td class="py-2 text-sm text-gray-900"><?= $submission['registration_no'] ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Tanggal Pendaftaran</td>
                    <td class="py-2 text-sm text-gray-900"><?= date('d M Y H:i', strtotime($submission['created_at'])) ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Status</td>
                    <td class="py-2 text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColors[$submission['status']] ?> text-white">
                            <?= $statusLabels[$submission['status']] ?>
                        </span>
                    </td>
                </tr>
                <?php if (!empty($submission['rejection_reason'])): ?>
                    <tr>
                        <td class="py-2 text-sm font-medium text-gray-500">Alasan Penolakan</td>
                        <td class="py-2 text-sm text-gray-900"><?= $submission['rejection_reason'] ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        
        <div>
            <h4 class="text-md font-medium text-gray-900 mb-3">Data Siswa</h4>
            <table class="min-w-full">
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500 w-40">Nama Siswa</td>
                    <td class="py-2 text-sm text-gray-900"><?= $submission['student_name'] ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">NISN</td>
                    <td class="py-2 text-sm text-gray-900"><?= $submission['nisn'] ?? 'Tidak tersedia' ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">NIK</td>
                    <td class="py-2 text-sm text-gray-900"><?= $submission['nik'] ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Tanggal Lahir</td>
                    <td class="py-2 text-sm text-gray-900"><?= date('d M Y', strtotime($submission['birth_date'])) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <h4 class="text-md font-medium text-gray-900 mb-3">Ubah Status Pendaftaran</h4>
        
        <form id="updateStatusForm" class="max-w-md">
            <input type="hidden" name="submission_id" value="<?= $submission['id'] ?>">
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Status Baru *
                </label>
                <select id="status" name="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Status</option>
                    <option value="menunggu_verifikasi" <?= $submission['status'] === 'menunggu_verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                    <option value="terverifikasi" <?= $submission['status'] === 'terverifikasi' ? 'selected' : '' ?>>Terverifikasi</option>
                    <option value="diterima" <?= $submission['status'] === 'diterima' ? 'selected' : '' ?>>Diterima</option>
                    <option value="cadangan" <?= $submission['status'] === 'cadangan' ? 'selected' : '' ?>>Cadangan</option>
                    <option value="ditolak" <?= $submission['status'] === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div id="rejectionReasonField" class="mb-4" <?= $submission['status'] !== 'ditolak' ? 'style="display: none;"' : '' ?>>
                <label for="rejectionReason" class="block text-sm font-medium text-gray-700 mb-1">
                    Alasan Penolakan *
                </label>
                <textarea id="rejectionReason" name="rejection_reason" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $submission['rejection_reason'] ?? '' ?></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleRejectionReasonField(status) {
    const rejectionReasonField = document.getElementById('rejectionReasonField');
    if (status === 'ditolak') {
        rejectionReasonField.style.display = 'block';
        document.getElementById('rejectionReason').setAttribute('required', 'required');
    } else {
        rejectionReasonField.style.display = 'none';
        document.getElementById('rejectionReason').removeAttribute('required');
    }
}

document.getElementById('status').addEventListener('change', function() {
    toggleRejectionReasonField(this.value);
});

document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/panitia/update-registration-status', {
        method: 'POST',
        body: formData
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
        alert('Terjadi kesalahan saat memperbarui status');
    });
});
</script>
<?= $this->endSection() ?>