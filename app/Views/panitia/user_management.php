<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
            <nav class="text-sm text-gray-500">
                <a href="/panitia/dashboard">Home</a> / Manajemen Pengguna
            </nav>
        </div>
        <a href="/panitia/users/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-1"></i> Tambah Pengguna
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="/panitia/users">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" id="search" value="<?= esc($search) ?>" placeholder="Username atau Email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" <?= !$role || $role === 'all' ? 'selected' : '' ?>>Semua Role</option>
                    <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="panitia" <?= $role === 'panitia' ? 'selected' : '' ?>>Panitia</option>
                    <option value="kepala_sekolah" <?= $role === 'kepala_sekolah' ? 'selected' : '' ?>>Kepala Sekolah</option>
                    <option value="siswa" <?= $role === 'siswa' ? 'selected' : '' ?>>Siswa</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Pengguna</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($user['username']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= esc($user['email']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php if ($user['role'] === 'admin'): ?>
                                    bg-red-100 text-red-800
                                <?php elseif ($user['role'] === 'panitia'): ?>
                                    bg-blue-100 text-blue-800
                                <?php elseif ($user['role'] === 'kepala_sekolah'): ?>
                                    bg-green-100 text-green-800
                                <?php else: ?>
                                    bg-yellow-100 text-yellow-800
                                <?php endif; ?>">
                                    <?= ucfirst(str_replace('_', ' ', $user['role'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y H:i', strtotime($user['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="/panitia/users/edit/<?= $user['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="confirmDelete(<?= $user['id'] ?>)" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada pengguna ditemukan
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (!empty($users)): ?>
        <div class="px-6 py-4 border-t">
            <?= $pager->links('users', 'tailwind') ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmDelete(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            window.location.href = '/panitia/users/delete/' + userId;
        }
    }
</script>
<?= $this->endSection() ?>