<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-2xl font-bold text-gray-800">Verifikasi Dokumen</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Verifikasi Dokumen</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-medium text-gray-900">Daftar Dokumen Siswa</h3>
        <div class="relative">
            <input type="text" placeholder="Cari dokumen..."
                class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <?php if (empty($documents)): ?>
        <div class="text-center py-8">
            <i class="fas fa-file-alt text-gray-300 text-4xl mb-3"></i>
            <p class="text-gray-500">Tidak ada dokumen yang perlu diverifikasi</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Siswa
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis Dokumen
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama File
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Unggah
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($documents as $document): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= $document['student_name'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $documentTypes[$document['doc_type']] ?? $document['doc_type'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $document['file_name'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($document['status'] === 'uploaded'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?= $statusLabels[$document['status']] ?>
                                    </span>
                                <?php elseif ($document['status'] === 'verified'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <?= $statusLabels[$document['status']] ?>
                                    </span>
                                <?php elseif ($document['status'] === 'rejected'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <?= $statusLabels[$document['status']] ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y H:i', strtotime($document['uploaded_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="/panitia/documents/<?= $document['id'] ?>"
                                    class="text-blue-500 hover:text-blue-700 mr-3">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <?php if ($document['status'] === 'uploaded'): ?>
                                    <button type="button"
                                        class="text-green-500 hover:text-green-700 mr-3"
                                        onclick="verifyDocument(<?= $document['id'] ?>, 'verified')">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                    <button type="button"
                                        class="text-red-500 hover:text-red-700"
                                        onclick="showRejectModal(<?= $document['id'] ?>)">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Reject Document Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tolak Dokumen</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="rejectForm">
                <input type="hidden" id="rejectDocumentId" name="document_id">
                <div class="mb-4">
                    <label for="rejectNotes" class="block text-sm font-medium text-gray-700 mb-1">
                        Alasan Penolakan *
                    </label>
                    <textarea id="rejectNotes" name="notes" rows="3" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Tolak Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function verifyDocument(documentId, status) {
        if (!confirm('Apakah Anda yakin ingin ' + (status === 'verified' ? 'menyetujui' : 'menolak') + ' dokumen ini?')) {
            return;
        }

        const formData = new FormData();
        formData.append('document_id', documentId);
        formData.append('status', status);

        fetch('/panitia/verify-document', {
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
                alert('Terjadi kesalahan saat memverifikasi dokumen');
            });
    }

    function showRejectModal(documentId) {
        document.getElementById('rejectDocumentId').value = documentId;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    document.getElementById('rejectForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('status', 'rejected');

        fetch('/panitia/verify-document', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    closeRejectModal();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menolak dokumen');
            });
    });
</script>
<?= $this->endSection() ?>