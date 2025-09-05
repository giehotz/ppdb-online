<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header Halaman -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Manajemen User</h1>
        <p class="mt-2 text-sm text-gray-500">
            Kelola, tambah, edit, atau hapus akun pengguna yang terdaftar dalam sistem.
        </p>
    </header>

    <!-- Notifikasi Sukses -->
    <?php if (session()->has('success')): ?>
        <div class="rounded-md bg-green-50 p-4 mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800"><?= session()->get('success') ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Notifikasi Error -->
    <?php if (session()->has('error')): ?>
        <div class="rounded-md bg-red-50 p-4 mb-6" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800"><?= session()->get('error') ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Konten Utama: Tabel User -->
    <main class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Daftar User</h3>
                    <p class="mt-2 text-sm text-gray-700">Daftar semua user yang terdaftar di akun Anda.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a href="/admin/users/create" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        Tambah User
                    </a>
                </div>
            </div>

            <!-- Wrapper untuk tabel agar responsif (scroll horizontal di layar kecil) -->
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">ID</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Username</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal Dibuat</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"><?= $user['id'] ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $user['username'] ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $user['email'] ?></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset 
                                                    <?php
                                                    $role = $user['role'];
                                                    if ($role === 'admin') echo 'bg-purple-50 text-purple-700 ring-purple-600/20';
                                                    elseif ($role === 'panitia') echo 'bg-blue-50 text-blue-700 ring-blue-600/20';
                                                    elseif ($role === 'siswa') echo 'bg-green-50 text-green-700 ring-green-600/20';
                                                    else echo 'bg-gray-50 text-gray-600 ring-gray-500/10';
                                                    ?>">
                                                    <?= ucfirst($role) ?>
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <?= date('d M Y, H:i', strtotime($user['created_at'])) ?>
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <a href="/admin/users/<?= $user['id'] ?>/edit" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <?php if ($user['id'] != session()->get('user_id')): ?>
                                                    <form action="/admin/users/<?= $user['id'] ?>/delete" method="post" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                    <a href="/admin/users/<?= $user['id'] ?>/reset-password" class="ml-4 text-yellow-600 hover:text-yellow-900" onclick="return confirm('Apakah Anda yakin ingin mereset password user ini?')">Reset Password</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center py-10 px-4 sm:px-6 lg:px-8">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak Ada User</h3>
                                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan user baru untuk memulai.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->endSection(); ?>