<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">User Profile</h2>
            <a href="/profile/edit" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                Edit Profile
            </a>
        </div>
        
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
        
        <div class="space-y-6">
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    <?php if (!empty($user['profile_photo'])): ?>
                        <img class="h-24 w-24 rounded-full object-cover" 
                             src="/uploads/profile_photos/<?= esc($user['profile_photo']) ?>" 
                             alt="Profile Photo">
                    <?php else: ?>
                        <div class="h-24 w-24 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-2xl">
                            <?= strtoupper(substr(esc($user['name'] ?? $user['username']), 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900"><?= esc($user['name'] ?? $user['username']) ?></h3>
                    <p class="text-gray-600"><?= esc($user['email']) ?></p>
                    <p class="text-sm text-gray-500 mt-1">Role: <?= esc(ucfirst($user['role'])) ?></p>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h4>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Username</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= esc($user['username']) ?></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= esc($user['email']) ?></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= esc($user['name'] ?? '-') ?></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <?= esc(date('F j, Y', strtotime($user['created_at'] ?? 'now'))) ?>
                        </dd>
                    </div>
                </dl>
            </div>
            
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Account Security</h4>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Password</p>
                        <p class="text-sm text-gray-500">Last updated <?= esc(date('F j, Y', strtotime($user['updated_at'] ?? 'now'))) ?></p>
                    </div>
                    <a href="/profile/edit#change-password" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>