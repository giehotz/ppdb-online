<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Detail Dokumen</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Verifikasi Dokumen</span> > <span>Detail</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-medium text-gray-900">Informasi Dokumen</h3>
        <a href="/panitia/documents" class="text-blue-500 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h4 class="text-md font-medium text-gray-900 mb-3">Data Dokumen</h4>
            <table class="min-w-full">
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500 w-40">Jenis Dokumen</td>
                    <td class="py-2 text-sm text-gray-900"><?= $documentTypes[$document['doc_type']] ?? $document['doc_type'] ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Nama File</td>
                    <td class="py-2 text-sm text-gray-900"><?= $document['file_name'] ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Ukuran</td>
                    <td class="py-2 text-sm text-gray-900"><?= number_format($document['size_bytes'] / 1024, 2) ?> KB</td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Tipe MIME</td>
                    <td class="py-2 text-sm text-gray-900"><?= $document['mime_type'] ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Tanggal Unggah</td>
                    <td class="py-2 text-sm text-gray-900"><?= date('d M Y H:i', strtotime($document['uploaded_at'])) ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">Status</td>
                    <td class="py-2 text-sm">
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
                </tr>
                <?php if (!empty($document['notes'])): ?>
                    <tr>
                        <td class="py-2 text-sm font-medium text-gray-500">Catatan</td>
                        <td class="py-2 text-sm text-gray-900"><?= $document['notes'] ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        
        <div>
            <h4 class="text-md font-medium text-gray-900 mb-3">Data Siswa</h4>
            <table class="min-w-full">
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500 w-40">Nama Siswa</td>
                    <td class="py-2 text-sm text-gray-900"><?= $document['student_name'] ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm font-medium text-gray-500">ID Dokumen</td>
                    <td class="py-2 text-sm text-gray-900"><?= $document['id'] ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Verifikasi</h4>
        
        <?php if ($document['status'] === 'uploaded'): ?>
            <div class="flex space-x-4">
                <button type="button" 
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        onclick="verifyDocument(<?= $document['id'] ?>, 'verified')">
                    <i class="fas fa-check mr-1"></i> Setujui Dokumen
                </button>
                
                <button type="button" 
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="showRejectModal(<?= $document['id'] ?>)">
                    <i class="fas fa-times mr-1"></i> Tolak Dokumen
                </button>
            </div>
        <?php else: ?>
            <p class="text-gray-500">
                Dokumen ini sudah <?= strtolower($statusLabels[$document['status']]) ?>.
                <?php if ($document['status'] === 'verified'): ?>
                    Terverifikasi oleh panitia pada <?= date('d M Y H:i', strtotime($document['verified_at'])) ?>.
                <?php elseif ($document['status'] === 'rejected' && !empty($document['verified_at'])): ?>
                    Ditolak oleh panitia pada <?= date('d M Y H:i', strtotime($document['verified_at'])) ?>.
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h4 class="text-md font-medium text-gray-900 mb-3">Pratinjau Dokumen</h4>
    
    <?php if (in_array($document['mime_type'], ['image/jpeg', 'image/png', 'image/jpg'])): ?>
        <div class="text-center">
            <img src="/panitia/documents/<?= $document['id'] ?>/preview" alt="Pratinjau Dokumen" 
                 class="max-w-full h-auto max-h-96 mx-auto border border-gray-200 rounded">
        </div>
    <?php else: ?>
        <div class="text-center py-8">
            <i class="fas fa-file-pdf text-gray-300 text-4xl mb-3"></i>
            <p class="text-gray-500 mb-4">Pratinjau tidak tersedia untuk dokumen ini</p>
            <a href="/documents/download/<?= $document['id'] ?>" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-download mr-2"></i> Unduh Dokumen
            </a>
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
                <input type="hidden" id="rejectDocumentId" name="document_id" value="<?= $document['id'] ?>">
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

function showRejectModal() {
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