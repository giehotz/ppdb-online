<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= esc($page['title']) ?></h1>
    
    <div class="prose max-w-none text-gray-600 mb-6">
        <?= $page['content'] ?>
    </div>
    
    <?php if (!empty($page['attachment_path'])): ?>
        <div class="mt-6">
            <a href="<?= base_url($page['attachment_path']) ?>" 
               class="inline-flex items-center text-blue-500 hover:text-blue-700 font-medium"
               download>
                <i class="fas fa-download mr-2"></i> Unduh Lampiran
            </a>
        </div>
    <?php endif; ?>
    
    <div class="mt-8 pt-6 border-t border-gray-200">
        <a href="/" class="text-blue-500 hover:text-blue-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
        </a>
    </div>
</div>
<?= $this->endSection() ?>