<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Pendaftaran</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Manajemen Pendaftaran</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-medium text-gray-900">Daftar Pendaftaran</h3>
        <div class="relative">
            <input type="text" placeholder="Cari pendaftaran..."
                class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <?php if (empty($submissions)): ?>
        <div class="text-center py-8">
            <i class="fas fa-file-alt text-gray-300 text-4xl mb-3"></i>
            <p class="text-gray-500">Tidak ada pendaftaran yang ditemukan</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No. Pendaftaran
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Siswa
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            NISN/NIK
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Pendaftaran
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= $submission['registration_no'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $submission['student_name'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $submission['student_nisn'] ?? 'NISN tidak tersedia' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y H:i', strtotime($submission['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColors[$submission['status']] ?> text-white">
                                    <?= $statusLabels[$submission['status']] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="/panitia/registrations/<?= $submission['id'] ?>"
                                    class="text-blue-500 hover:text-blue-700 mr-3">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <button type="button"
                                    class="text-green-500 hover:text-green-700"
                                    onclick="showUpdateStatusModal(<?= $submission['id'] ?>, '<?= $submission['status'] ?>')">
                                    <i class="fas fa-edit"></i> Ubah Status
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Update Status Modal -->
<div id="updateStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Ubah Status Pendaftaran</h3>
                <button onclick="closeUpdateStatusModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="updateStatusForm">
                <input type="hidden" id="submissionId" name="submission_id">
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status Baru *
                    </label>
                    <select id="status" name="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Status</option>
                        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                        <option value="terverifikasi">Terverifikasi</option>
                        <option value="diterima">Diterima</option>
                        <option value="cadangan">Cadangan</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div id="rejectionReasonField" class="mb-4 hidden">
                    <label for="rejectionReason" class="block text-sm font-medium text-gray-700 mb-1">
                        Alasan Penolakan *
                    </label>
                    <textarea id="rejectionReason" name="rejection_reason" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUpdateStatusModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showUpdateStatusModal(submissionId, currentStatus) {
        document.getElementById('submissionId').value = submissionId;
        document.getElementById('status').value = currentStatus;

        // Show/hide rejection reason field based on selected status
        toggleRejectionReasonField(currentStatus);

        document.getElementById('updateStatusModal').classList.remove('hidden');
    }

    function closeUpdateStatusModal() {
        document.getElementById('updateStatusModal').classList.add('hidden');
    }

    function toggleRejectionReasonField(status) {
        const rejectionReasonField = document.getElementById('rejectionReasonField');
        if (status === 'ditolak') {
            rejectionReasonField.classList.remove('hidden');
            document.getElementById('rejectionReason').setAttribute('required', 'required');
        } else {
            rejectionReasonField.classList.add('hidden');
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
                    closeUpdateStatusModal();
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