<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= esc($announcement['title']) ?></h1>
    
    <p class="text-gray-500 mb-6">
        <i class="far fa-calendar-alt mr-2"></i>
        <?= date('d M Y', strtotime($announcement['created_at'])) ?>
    </p>
    
    <div class="prose max-w-none text-gray-600 mb-6">
        <?= $announcement['content'] ?>
    </div>
    
    <?php if (!empty($announcement['attachment_path'])): ?>
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h3 class="font-medium text-gray-800 mb-2">Lampiran</h3>
            <a href="<?= base_url($announcement['attachment_path']) ?>" 
               class="inline-flex items-center text-blue-500 hover:text-blue-700 font-medium"
               download>
                <i class="fas fa-download mr-2"></i> Unduh Lampiran
            </a>
        </div>
    <?php endif; ?>
    
    <div class="mt-8 pt-6 border-t border-gray-200">
        <a href="/announcements" class="text-blue-500 hover:text-blue-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Pengumuman
        </a>
    </div>
</div>
<?= $this->endSection() ?>