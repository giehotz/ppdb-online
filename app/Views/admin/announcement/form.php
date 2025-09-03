<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        <?= isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?>
    </h1>
    
    <?php if (session()->getFlashdata('error')): ?>
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
    <?php endif; ?>
    
    <form action="<?= isset($announcement) ? '/announcement/update/' . $announcement['id'] : '/announcement/store' ?>" 
          method="post" 
          class="space-y-6">
        <?= csrf_field() ?>
        
        <?php if (isset($announcement)): ?>
        <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="<?= old('title', isset($announcement) ? $announcement['title'] : '') ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('title') ? 'border-red-500' : '' ?>">
            <?php if (isset($validation) && $validation->hasError('title')): ?>
            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('title') ?></p>
            <?php endif; ?>
        </div>
        
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
            <textarea id="content" 
                      name="content" 
                      rows="10"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('content') ? 'border-red-500' : '' ?>"><?= old('content', isset($announcement) ? $announcement['content'] : '') ?></textarea>
            <?php if (isset($validation) && $validation->hasError('content')): ?>
            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('content') ?></p>
            <?php endif; ?>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" 
                       id="date" 
                       name="date" 
                       value="<?= old('date', isset($announcement) ? date('Y-m-d', strtotime($announcement['date'])) : date('Y-m-d')) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('date') ? 'border-red-500' : '' ?>">
                <?php if (isset($validation) && $validation->hasError('date')): ?>
                <p class="mt-1 text-sm text-red-600"><?= $validation->getError('date') ?></p>
                <?php endif; ?>
            </div>
            
            <div>
                <label for="sender" class="block text-sm font-medium text-gray-700 mb-1">Pengirim</label>
                <input type="text" 
                       id="sender" 
                       name="sender" 
                       value="<?= old('sender', isset($announcement) ? $announcement['sender'] : session()->get('name') ?? session()->get('username')) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('sender') ? 'border-red-500' : '' ?>">
                <?php if (isset($validation) && $validation->hasError('sender')): ?>
                <p class="mt-1 text-sm text-red-600"><?= $validation->getError('sender') ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="/announcement" 
               class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <?= isset($announcement) ? 'Simpan Perubahan' : 'Tambah Pengumuman' ?>
            </button>
        </div>
    </form>
</div>

<script>
// Initialize TinyMCE or other rich text editor if needed
document.addEventListener('DOMContentLoaded', function() {
    // Simple character counter if needed
    const contentTextarea = document.getElementById('content');
    if (contentTextarea) {
        contentTextarea.addEventListener('input', function() {
            // Can add character counting functionality here if needed
        });
    }
});
</script>
<?= $this->endSection() ?>