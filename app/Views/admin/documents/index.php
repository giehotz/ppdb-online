<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Dokumen</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Manajemen Dokumen</span>
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
            <p class="text-gray-500">Tidak ada dokumen yang ditemukan</p>
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
                                <a href="/admin/documents/<?= $document['id'] ?>"
                                    class="text-blue-500 hover:text-blue-700 mr-3">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>