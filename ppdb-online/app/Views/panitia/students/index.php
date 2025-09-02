<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Data Siswa</h2>
            <nav class="text-sm text-gray-500">
                <span>Home</span> > <span>Manajemen Data Siswa</span>
            </nav>
        </div>
        <a href="/panitia/students/create" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
            <i class="fas fa-plus mr-1"></i> Tambah Siswa
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Siswa
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        NISN
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
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data siswa
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($students as $index => $student): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $index + 1 ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($student['full_name']) ?></div>
                                <div class="text-sm text-gray-500"><?= esc($student['username'] ?? '-') ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($student['nisn'] ?? '-') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($student['submission_status']): ?>
                                    <?php
                                    $statusLabels = [
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'terverifikasi' => 'Terverifikasi',
                                        'diterima' => 'Diterima',
                                        'cadangan' => 'Cadangan',
                                        'ditolak' => 'Ditolak'
                                    ];
                                    $statusClasses = [
                                        'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-800',
                                        'terverifikasi' => 'bg-blue-100 text-blue-800',
                                        'diterima' => 'bg-green-100 text-green-800',
                                        'cadangan' => 'bg-purple-100 text-purple-800',
                                        'ditolak' => 'bg-red-100 text-red-800'
                                    ];
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClasses[$student['submission_status']] ?>">
                                        <?= $statusLabels[$student['submission_status']] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Belum Daftar
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="/panitia/students/edit/<?= $student['id'] ?>"
                                    class="text-blue-500 hover:text-blue-700 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button"
                                    class="text-red-500 hover:text-red-700"
                                    onclick="deleteStudent(<?= $student['id'] ?>)">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteStudent(studentId) {
        if (confirm('Apakah Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.')) {
            fetch(`/panitia/students/delete/${studentId}`, {
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
                    alert('Terjadi kesalahan saat menghapus data siswa');
                });
        }
    }
</script>
<?= $this->endSection() ?>