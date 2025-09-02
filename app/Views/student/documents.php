<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Unggah Dokumen</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Unggah Dokumen</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <p class="text-gray-600 mb-6">
        Unggah dokumen persyaratan pendaftaran Anda. Format yang diizinkan: JPG, PNG, PDF. Ukuran maksimal 2MB per file.
    </p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Document Upload Form -->
    <div class="border border-gray-200 rounded-lg p-6 mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Unggah Dokumen Baru</h3>
        
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="doc_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Dokumen *</label>
                    <select id="doc_type" name="doc_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis Dokumen</option>
                        <?php foreach ($documentTypes as $key => $label): ?>
                            <option value="<?= $key ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Pilih File *</label>
                    <input type="file" id="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, PDF. Maksimal 2MB.</p>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                    Unggah Dokumen
                </button>
            </div>
        </form>
    </div>

    <!-- Uploaded Documents List -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen yang Telah Diunggah</h3>
        
        <?php if (empty($documents)): ?>
            <div class="text-center py-8">
                <i class="fas fa-file-upload text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">Belum ada dokumen yang diunggah</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis Dokumen
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama File
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ukuran
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= $documentTypes[$document['doc_type']] ?? $document['doc_type'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $document['file_name'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= number_format($document['size_bytes'] / 1024, 2) ?> KB
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($document['status'] === 'uploaded'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Diverifikasi
                                        </span>
                                    <?php elseif ($document['status'] === 'verified'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Terverifikasi
                                        </span>
                                    <?php elseif ($document['status'] === 'rejected'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                        <?php if (!empty($document['notes'])): ?>
                                            <p class="text-xs text-red-600 mt-1"><?= $document['notes'] ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('d M Y H:i', strtotime($document['uploaded_at'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="/documents/download/<?= $document['id'] ?>" 
                                       class="text-blue-500 hover:text-blue-700 mr-3">
                                        <i class="fas fa-download"></i> Unduh
                                    </a>
                                    <?php if ($document['status'] === 'rejected'): ?>
                                        <button type="button" 
                                                class="text-red-500 hover:text-red-700"
                                                onclick="deleteDocument(<?= $document['id'] ?>)">
                                            <i class="fas fa-trash"></i> Hapus
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
</div>

<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/documents/upload', {
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
        alert('Terjadi kesalahan saat mengunggah dokumen');
    });
});

function deleteDocument(documentId) {
    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
        // In a real implementation, you would send a request to delete the document
        alert('Fitur hapus dokumen akan diimplementasikan di tahap berikutnya');
    }
}
</script>
<?= $this->endSection() ?>