<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pengumuman</h1>
    
    <?php if (!empty($announcements)): ?>
        <div class="space-y-6">
            <?php foreach ($announcements as $announcement): ?>
                <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">
                        <a href="/announcements/<?= esc($announcement['slug']) ?>" 
                           class="hover:text-blue-600">
                            <?= esc($announcement['title']) ?>
                        </a>
                    </h2>
                    <p class="text-gray-500 text-sm mb-3">
                        <?= date('d M Y', strtotime($announcement['created_at'])) ?>
                    </p>
                    <div class="prose max-w-none text-gray-600">
                        <?= substr(strip_tags($announcement['content']), 0, 300) ?>...
                    </div>
                    <div class="mt-3">
                        <a href="/announcements/<?= esc($announcement['slug']) ?>" 
                           class="text-blue-500 hover:text-blue-700 font-medium">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <i class="fas fa-bullhorn text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500">Belum ada pengumuman.</p>
        </div>
    <?php endif; ?>
    
    <div class="mt-8 pt-6 border-t border-gray-200">
        <a href="/" class="text-blue-500 hover:text-blue-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
        </a>
    </div>
</div>
<?= $this->endSection() ?>