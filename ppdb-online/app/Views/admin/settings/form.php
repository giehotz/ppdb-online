<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Pengaturan</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form id="settingsForm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Situs</label>
                <input type="text" id="site_name" name="site_name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $settings['site_name'] ?? 'PPDB Online' ?>">
            </div>

            <div>
                <label for="site_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Situs</label>
                <input type="text" id="site_description" name="site_description"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $settings['site_description'] ?? 'Sistem Penerimaan Peserta Didik Baru Online' ?>">
            </div>

            <div>
                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email Admin</label>
                <input type="email" id="admin_email" name="admin_email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $settings['admin_email'] ?? '' ?>">
            </div>

            <div>
                <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon Kontak</label>
                <input type="text" id="contact_phone" name="contact_phone"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $settings['contact_phone'] ?? '' ?>">
            </div>

            <div>
                <label for="registration_open" class="block text-sm font-medium text-gray-700 mb-1">Pendaftaran Dibuka</label>
                <select id="registration_open" name="registration_open"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="1" <?= (isset($settings['registration_open']) && $settings['registration_open'] == '1') ? 'selected' : '' ?>>Ya</option>
                    <option value="0" <?= (isset($settings['registration_open']) && $settings['registration_open'] == '0') ? 'selected' : '' ?>>Tidak</option>
                </select>
            </div>

            <div>
                <label for="max_file_upload_size" class="block text-sm font-medium text-gray-700 mb-1">Ukuran Maksimal Upload File (MB)</label>
                <input type="number" id="max_file_upload_size" name="max_file_upload_size" min="1" max="10"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $settings['max_file_upload_size'] ?? '2' ?>">
            </div>

            <div class="md:col-span-2">
                <label for="announcement_text" class="block text-sm font-medium text-gray-700 mb-1">Pengumuman</label>
                <textarea id="announcement_text" name="announcement_text" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $settings['announcement_text'] ?? '' ?></textarea>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/admin/settings/save', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan pengaturan');
            });
    });
</script>
<?= $this->endSection() ?>