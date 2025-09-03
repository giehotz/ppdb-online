<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><?= $title ?></h2>
            <nav class="text-sm text-gray-500">
                <a href="/admin/cms">Manajemen Konten</a> > <span><?= $title ?></span>
            </nav>
        </div>
        <a href="/admin/cms" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form id="cmsForm">
        <input type="hidden" id="id" name="id" value="<?= $post['id'] ?? '' ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul *</label>
                <input type="text" id="title" name="title" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $post['title'] ?? '' ?>">
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe *</label>
                <select id="type" name="type" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Tipe</option>
                    <option value="announcement" <?= (isset($post['type']) && $post['type'] === 'announcement') ? 'selected' : '' ?>>Pengumuman</option>
                    <option value="info" <?= (isset($post['type']) && $post['type'] === 'info') ? 'selected' : '' ?>>Informasi Umum</option>
                    <option value="page" <?= (isset($post['type']) && $post['type'] === 'page') ? 'selected' : '' ?>>Halaman Statis</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                <select id="status" name="status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Status</option>
                    <option value="draft" <?= (isset($post['status']) && $post['status'] === 'draft') ? 'selected' : '' ?>>Draft</option>
                    <option value="published" <?= (isset($post['status']) && $post['status'] === 'published') ? 'selected' : '' ?>>Publikasi</option>
                </select>
            </div>

            <div>
                <label for="publish_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi</label>
                <input type="date" id="publish_at" name="publish_at"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $post['publish_at'] ?? '' ?>">
            </div>
        </div>

        <div class="px-4 md:px-8 lg:px-12 py-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten *</label>
            <textarea id="content" name="content" rows="10" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $post['content'] ?? '' ?></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                Simpan Konten
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('cmsForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/admin/cms/save', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.href = '/admin/cms';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan konten');
            });
    });
</script>
<?= $this->endSection() ?>