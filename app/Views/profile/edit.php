<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Update Profile</h2>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <form id="profileForm" action="/profile/update" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= esc(old('name', $user['name'] ?? $user['username'])) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <?php if (!empty($user['profile_photo'])): ?>
                            <img id="previewImage" class="h-16 w-16 rounded-full object-cover" 
                                 src="/uploads/profile_photos/<?= esc($user['profile_photo']) ?>" 
                                 alt="Profile Photo">
                        <?php else: ?>
                            <div id="previewImage" class="h-16 w-16 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-lg">
                                <?= strtoupper(substr(esc($user['name'] ?? $user['username']), 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex flex-col">
                        <label for="profile_photo" 
                               class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer w-fit">
                            Choose File
                        </label>
                        <input type="file" 
                               id="profile_photo" 
                               name="profile_photo" 
                               accept="image/jpg,image/jpeg,image/png"
                               class="hidden">
                        <p class="text-xs text-gray-500 mt-2">JPG, JPEG, PNG up to 2MB</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="<?= $_SERVER['HTTP_REFERER'] ?? '/' ?>" 
                   class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>