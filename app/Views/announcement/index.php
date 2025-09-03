<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengumuman</h1>
        <?php if (in_array(session()->get('role'), ['admin', 'panitia'])): ?>
        <a href="/announcement/create" 
           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i>Tambah Pengumuman
        </a>
        <?php endif; ?>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
    <?php endif; ?>
    
    <?php if (empty($announcements)): ?>
    <div class="text-center py-12">
        <i class="fas fa-bullhorn text-gray-300 text-5xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada pengumuman</h3>
        <p class="text-gray-500">Belum ada pengumuman yang dipublikasikan.</p>
    </div>
    <?php else: ?>
    <div class="space-y-4">
        <?php foreach ($announcements as $announcement): ?>
        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
            <div class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-900">
                    <a href="/announcement/<?= $announcement['id'] ?>" class="hover:text-blue-600">
                        <?= esc($announcement['title']) ?>
                    </a>
                </h3>
                <span class="text-sm text-gray-500">
                    <?= date('d M Y', strtotime($announcement['date'])) ?>
                </span>
            </div>
            <div class="mt-2 text-gray-600">
                <?= esc(substr(strip_tags($announcement['content']), 0, 150)) ?>...
            </div>
            <div class="mt-3 flex justify-between items-center">
                <span class="text-sm text-gray-500">
                    oleh <span class="font-medium"><?= esc($announcement['sender']) ?></span>
                </span>
                <?php if (in_array(session()->get('role'), ['admin', 'panitia'])): ?>
                <div class="flex space-x-2">
                    <a href="/announcement/edit/<?= $announcement['id'] ?>" 
                       class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="/announcement/delete/<?= $announcement['id'] ?>" 
                       class="text-red-600 hover:text-red-900"
                       onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>