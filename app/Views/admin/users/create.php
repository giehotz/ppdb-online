<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Tambah User</h2>
    <nav class="text-sm text-gray-500">
        <a href="/admin/dashboard" class="text-blue-500 hover:underline">Dashboard</a>
        <span class="mx-1">/</span>
        <a href="/admin/users" class="text-blue-500 hover:underline">Manajemen User</a>
        <span class="mx-1">/</span>
        <span>Tambah User</span>
    </nav>
</div>

<?php if (session()->has('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <ul class="list-disc pl-5 mt-2">
            <?php foreach (session()->get('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Form Tambah User</h3>
    
    <form action="/admin/users/store" method="post">
        <?= csrf_field() ?>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Username
            </label>
            <input type="text" name="username" id="username" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   value="<?= old('username') ?>" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input type="email" name="email" id="email" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   value="<?= old('email') ?>" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input type="password" name="password" id="password" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirm">
                Konfirmasi Password
            </label>
            <input type="password" name="password_confirm" id="password_confirm" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                Role
            </label>
            <select name="role" id="role" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                <option value="">Pilih Role</option>
                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="siswa" <?= old('role') == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                <option value="panitia" <?= old('role') == 'panitia' ? 'selected' : '' ?>>Panitia</option>
                <option value="kepala_sekolah" <?= old('role') == 'kepala_sekolah' ? 'selected' : '' ?>>Kepala Sekolah</option>
            </select>
        </div>
        
        <div class="flex items-center justify-between">
            <a href="/admin/users" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-save mr-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>