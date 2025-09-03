<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><?= $title ?></h2>
            <nav class="text-sm text-gray-500">
                <a href="/admin/academic-years">Tahun Akademik</a> > <span><?= $title ?></span>
            </nav>
        </div>
        <a href="/admin/academic-years" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form id="academicYearForm">
        <input type="hidden" id="id" name="id" value="<?= $academicYear['id'] ?? '' ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="year_label" class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelajaran *</label>
                <input type="text" id="year_label" name="year_label" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $academicYear['year_label'] ?? '' ?>" placeholder="Contoh: 2025/2026">
                <p class="mt-1 text-sm text-gray-500">Format: YYYY/YYYY</p>
            </div>

            <div>
                <label for="wave" class="block text-sm font-medium text-gray-700 mb-1">Gelombang</label>
                <input type="number" id="wave" name="wave" min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $academicYear['wave'] ?? '1' ?>">
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai *</label>
                <input type="date" id="start_date" name="start_date" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $academicYear['start_date'] ?? '' ?>">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai *</label>
                <input type="date" id="end_date" name="end_date" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $academicYear['end_date'] ?? '' ?>">
            </div>

            <div>
                <label for="announcement_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengumuman</label>
                <input type="date" id="announcement_date" name="announcement_date"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $academicYear['announcement_date'] ?? '' ?>">
            </div>

            <div>
                <label for="quota_total" class="block text-sm font-medium text-gray-700 mb-1">Kuota Total</label>
                <input type="number" id="quota_total" name="quota_total" min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $academicYear['quota_total'] ?? '' ?>">
            </div>

            <div class="md:col-span-2">
                <label for="quota_per_class" class="block text-sm font-medium text-gray-700 mb-1">Kuota per Kelas</label>
                <textarea id="quota_per_class" name="quota_per_class" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder='Contoh: {"VIIA": 30, "VIIB": 30, "VIIC": 30}'><?= $academicYear['quota_per_class'] ?? '' ?></textarea>
                <p class="mt-1 text-sm text-gray-500">Format JSON: {"kelas": kuota, ...}</p>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="active" <?= (isset($academicYear['status']) && $academicYear['status'] === 'active') ? 'selected' : '' ?>>Aktif</option>
                    <option value="archived" <?= (isset($academicYear['status']) && $academicYear['status'] === 'archived') ? 'selected' : '' ?>>Arsip</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                Simpan Tahun Akademik
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('academicYearForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/admin/academic-years/save', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.href = '/admin/academic-years';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan tahun akademik');
            });
    });
</script>
<?= $this->endSection() ?>