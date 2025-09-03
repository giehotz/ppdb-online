<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-start mb-4">
        <h1 class="text-2xl font-bold text-gray-800"><?= esc($announcement['title']) ?></h1>
        <a href="/announcement" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
    
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <span class="mr-4">
                <i class="far fa-calendar-alt mr-1"></i>
                <?= date('d M Y H:i', strtotime($announcement['date'])) ?>
            </span>
            <span>
                <i class="fas fa-user mr-1"></i>
                oleh <?= esc($announcement['sender']) ?>
            </span>
        </div>
        
        <div class="prose max-w-none border-t border-b border-gray-200 py-6">
            <?= $announcement['content'] ?>
        </div>
    </div>
    
    <?php if (in_array(session()->get('role'), ['admin', 'panitia'])): ?>
    <div class="flex space-x-2 mt-6">
        <a href="/announcement/edit/<?= $announcement['id'] ?>" 
           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            <i class="fas fa-edit mr-2"></i>Edit
        </a>
        <a href="/announcement/delete/<?= $announcement['id'] ?>" 
           class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
           onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
            <i class="fas fa-trash mr-2"></i>Hapus
        </a>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>