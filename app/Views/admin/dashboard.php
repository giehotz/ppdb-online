<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class=" sm:px-6 lg:px-8 py-8">

    <!-- Header Halaman -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="mt-1 text-gray-500">Selamat datang kembali, <?= session()->get('username') ?>!</p>
    </header>

    <!-- Kartu Aksi Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Kartu Manajemen User -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <i class="fas fa-users text-2xl text-blue-500"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Manajemen User</h2>
                    <p class="text-gray-600 text-sm">Kelola user, role, dan hak akses.</p>
                </div>
            </div>
            <a href="/admin/users" class="text-blue-600 hover:text-blue-800 font-medium text-sm inline-flex items-center">
                Buka Manajemen User <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- Kartu Pengaturan Sistem -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                    <i class="fas fa-cog text-2xl text-green-500"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Pengaturan</h2>
                    <p class="text-gray-600 text-sm">Konfigurasi parameter dan setelan sistem.</p>
                </div>
            </div>
            <a href="/admin/settings" class="text-green-600 hover:text-green-800 font-medium text-sm inline-flex items-center">
                Akses Pengaturan <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- Kartu Laporan -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                    <i class="fas fa-chart-bar text-2xl text-purple-500"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Laporan</h2>
                    <p class="text-gray-600 text-sm">Lihat dan unduh laporan sistem.</p>
                </div>
            </div>
            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium text-sm inline-flex items-center">
                Lihat Laporan <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mt-10">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Stats</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border rounded-lg p-4 shadow-sm text-center">
                <div class="text-3xl font-bold text-blue-500">24</div>
                <div class="text-gray-600 mt-1">Total User</div>
            </div>
            <div class="bg-white border rounded-lg p-4 shadow-sm text-center">
                <div class="text-3xl font-bold text-green-500">18</div>
                <div class="text-gray-600 mt-1">Siswa</div>
            </div>
            <div class="bg-white border rounded-lg p-4 shadow-sm text-center">
                <div class="text-3xl font-bold text-purple-500">5</div>
                <div class="text-gray-600 mt-1">Panitia</div>
            </div>
            <div class="bg-white border rounded-lg p-4 shadow-sm text-center">
                <div class="text-3xl font-bold text-yellow-500">1</div>
                <div class="text-gray-600 mt-1">Admin</div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>