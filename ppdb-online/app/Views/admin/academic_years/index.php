<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tahun Akademik</h2>
            <nav class="text-sm text-gray-500">
                <span>Dashboard</span> > <span>Tahun Akademik</span>
            </nav>
        </div>
        <a href="/admin/academic-years/form" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
            <i class="fas fa-plus mr-1"></i> Tambah Tahun Akademik
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tahun Pelajaran
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gelombang
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Periode
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kuota
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
                <?php if (empty($academicYears)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada tahun akademik yang tersedia
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($academicYears as $year): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= esc($year['year_label']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($year['wave']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($year['start_date'])) ?> - <?= date('d M Y', strtotime($year['end_date'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $year['quota_total'] ? esc($year['quota_total']) : '-' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($year['status'] === 'active'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Arsip
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="/admin/academic-years/form/<?= $year['id'] ?>"
                                    class="text-blue-500 hover:text-blue-700 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <?php if ($year['status'] !== 'active'): ?>
                                    <button type="button"
                                        class="text-green-500 hover:text-green-700 mr-3"
                                        onclick="setActive(<?= $year['id'] ?>)">
                                        <i class="fas fa-check"></i> Aktifkan
                                    </button>
                                <?php endif; ?>

                                <button type="button"
                                    class="text-red-500 hover:text-red-700"
                                    onclick="deleteAcademicYear(<?= $year['id'] ?>)">
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
    function deleteAcademicYear(id) {
        if (confirm('Apakah Anda yakin ingin menghapus tahun akademik ini?')) {
            fetch(`/admin/academic-years/delete/${id}`, {
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
                    alert('Terjadi kesalahan saat menghapus tahun akademik');
                });
        }
    }

    function setActive(id) {
        if (confirm('Apakah Anda yakin ingin mengatur tahun akademik ini sebagai aktif?')) {
            fetch(`/admin/academic-years/set-active/${id}`, {
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
                    alert('Terjadi kesalahan saat mengatur tahun akademik sebagai aktif');
                });
        }
    }
</script>
<?= $this->endSection() ?>