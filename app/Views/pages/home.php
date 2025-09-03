<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-500 to-indigo-700 rounded-xl shadow-lg p-8 md:p-12 mb-8 text-white">
    <div class="max-w-3xl">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Penerimaan Peserta Didik Baru</h1>
        <p class="text-lg md:text-xl mb-6">MIN 2 Tanggamus - Tahun Ajaran 2025/2026</p>
        <?php if ($isRegistrationOpen): ?>
            <a href="/register"
                class="inline-block bg-white text-blue-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105">
                <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
            </a>
        <?php else: ?>
            <button disabled
                class="inline-block bg-gray-300 text-gray-500 font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                <i class="fas fa-user-plus mr-2"></i>Pendaftaran Ditutup
            </button>
        <?php endif; ?>
    </div>
</div>

<!-- Announcements Section -->
<?php if (!empty($announcements)): ?>
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Pengumuman Terbaru</h2>
            <a href="/announcements" class="text-blue-500 hover:text-blue-700 font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($announcements as $announcement): ?>
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <h3 class="font-bold text-lg text-gray-800 mb-2"><?= esc($announcement['title']) ?></h3>
                    <p class="text-gray-600 text-sm mb-3">
                        <?= substr(strip_tags($announcement['content']), 0, 100) ?>...
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">
                            <?= date('d M Y', strtotime($announcement['created_at'])) ?>
                        </span>
                        <a href="/announcements/<?= esc($announcement['slug']) ?>"
                            class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Info Section -->
<?php if (!empty($infoPosts)): ?>
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi PPDB</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($infoPosts as $info): ?>
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="font-bold text-lg text-gray-800 mb-2"><?= esc($info['title']) ?></h3>
                    <div class="prose max-w-none text-gray-600">
                        <?= $info['content'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Schedule & Quota Section -->
<?php if (!empty($academicYear)): ?>
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Jadwal & Kuota</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Periode Pendaftaran</h3>
                <p class="text-gray-600">
                    <?= date('d M Y', strtotime($academicYear['start_date'])) ?> -
                    <?= date('d M Y', strtotime($academicYear['end_date'])) ?>
                </p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Tanggal Pengumuman</h3>
                <p class="text-gray-600">
                    <?= !empty($academicYear['announcement_date']) ? date('d M Y', strtotime($academicYear['announcement_date'])) : 'Belum ditentukan' ?>
                </p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-bold text-lg text-gray-800 mb-2">Kuota Tersedia</h3>
                <p class="text-gray-600">
                    <?= !empty($academicYear['quota_total']) ? $academicYear['quota_total'] . ' siswa' : 'Belum ditentukan' ?>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Profile Section -->
<div class="bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Profil Madrasah</h2>
    <div class="prose max-w-none text-gray-600">
        <p>Madrasah Ibtidaiyah Negeri (MIN) 2 Tanggamus merupakan lembaga pendidikan dasar di bawah naungan Kementerian Agama yang berkomitmen untuk memberikan pendidikan berkualitas dengan mengintegrasikan nilai-nilai agama dalam setiap aspek pembelajaran.</p>
        <p>Kami berfokus pada pengembangan karakter, akademik, dan keterampilan siswa untuk membentuk generasi yang beriman, berilmu, dan berketerampilan.</p>
        <a href="/pages/madrasah_profil" class="inline-block mt-4 text-blue-500 hover:text-blue-700 font-medium">
            Selengkapnya tentang MIN 2 Tanggamus <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>
<?= $this->endSection() ?>