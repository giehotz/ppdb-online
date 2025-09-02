<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <!-- Header Section with Gradient Background -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 mb-8 shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2">Dashboard Admin</h1>
                <p class="text-blue-100 text-lg">Selamat datang kembali, <span class="font-semibold text-white"><?= esc($user['username']) ?></span>!</p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                    <p class="text-white/90 text-sm">Tanggal Hari Ini</p>
                    <p class="text-white font-bold text-xl"><?= date('d F Y') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Cards with Enhanced Design -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Statistik Pengguna</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Users Card -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-blue-50 group-hover:bg-blue-100 transition-colors">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                        <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">+12%</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $userCount ?></p>
                    </div>
                </div>
            </div>

            <!-- Students Card -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-emerald-50 group-hover:bg-emerald-100 transition-colors">
                            <i class="fas fa-user-graduate text-2xl text-emerald-600"></i>
                        </div>
                        <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Active</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Siswa</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $studentCount ?></p>
                    </div>
                </div>
            </div>

            <!-- Committee Card -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-amber-50 group-hover:bg-amber-100 transition-colors">
                            <i class="fas fa-user-tie text-2xl text-amber-600"></i>
                        </div>
                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Team</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Panitia</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $committeeCount ?></p>
                    </div>
                </div>
            </div>

            <!-- Admins Card -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-xl bg-purple-50 group-hover:bg-purple-100 transition-colors">
                            <i class="fas fa-user-shield text-2xl text-purple-600"></i>
                        </div>
                        <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-full">Secure</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Admin</p>
                        <p class="text-3xl font-bold text-gray-800"><?= $adminCount ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submission Stats with Modern Cards -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Status Pendaftaran</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-indigo-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-2">Total Pendaftaran</p>
                        <p class="text-3xl font-bold text-indigo-600"><?= $submissionCount ?></p>
                        <p class="text-xs text-gray-500 mt-2">Semua pendaftaran</p>
                    </div>
                    <div class="p-4 bg-indigo-100 rounded-2xl">
                        <i class="fas fa-file-alt text-2xl text-indigo-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-2">Diterima</p>
                        <p class="text-3xl font-bold text-green-600"><?= $acceptedCount ?></p>
                        <p class="text-xs text-gray-500 mt-2">Lolos seleksi</p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-2xl">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-blue-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-2">Terverifikasi</p>
                        <p class="text-3xl font-bold text-blue-600"><?= $verifiedCount ?></p>
                        <p class="text-xs text-gray-500 mt-2">Dokumen lengkap</p>
                    </div>
                    <div class="p-4 bg-blue-100 rounded-2xl">
                        <i class="fas fa-clipboard-check text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-yellow-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-2">Menunggu</p>
                        <p class="text-3xl font-bold text-yellow-600"><?= $waitingVerificationCount ?></p>
                        <p class="text-xs text-gray-500 mt-2">Perlu verifikasi</p>
                    </div>
                    <div class="p-4 bg-yellow-100 rounded-2xl">
                        <i class="fas fa-clock text-2xl text-yellow-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Stats Section -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Statistik Dokumen</h2>
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl mb-4">
                        <i class="fas fa-file-upload text-2xl text-white"></i>
                    </div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Dokumen</p>
                    <p class="text-4xl font-bold text-gray-800"><?= $documentCount ?></p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                            <span>23% dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl mb-4">
                        <i class="fas fa-check-circle text-2xl text-white"></i>
                    </div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Dokumen Terverifikasi</p>
                    <p class="text-4xl font-bold text-gray-800"><?= $verifiedDocumentCount ?></p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-center">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: <?= $documentCount > 0 ? ($verifiedDocumentCount / $documentCount * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 mt-1"><?= $documentCount > 0 ? round($verifiedDocumentCount / $documentCount * 100) : 0 ?>% terverifikasi</span>
                    </div>
                </div>

                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl mb-4">
                        <i class="fas fa-times-circle text-2xl text-white"></i>
                    </div>
                    <p class="text-gray-600 text-sm font-medium mb-2">Dokumen Ditolak</p>
                    <p class="text-4xl font-bold text-gray-800"><?= $rejectedDocumentCount ?></p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            <span>Perlu perbaikan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Madrasah Profile Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-t-2xl">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-school mr-3"></i>
                    Profil Madrasah
                </h3>
            </div>
            <div class="p-6">
                <?php if (!empty($madrasahProfile)): ?>
                    <div class="px-4 md:px-8 lg:px-12 py-6">
                        <h4 class="font-bold text-lg text-gray-800 mb-2"><?= esc($madrasahProfile['name']) ?></h4>
                        <div class="flex items-center text-gray-600 mb-2">
                            <i class="fas fa-user-tie mr-2 text-gray-400"></i>
                            <p class="text-sm">Kepala: <?= esc($madrasahProfile['headmaster_name']) ?></p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Aktif
                        </span>
                    </div>
                    <a href="/admin/madrasah-profile" class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium rounded-xl transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i> Edit Profil
                    </a>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 mb-4">Profil madrasah belum diatur</p>
                        <a href="/admin/madrasah-profile" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i> Tambah Profil
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Academic Year Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 rounded-t-2xl">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Tahun Akademik
                </h3>
            </div>
            <div class="p-6">
                <?php if (!empty($activeAcademicYear)): ?>
                    <div class="px-4 md:px-8 lg:px-12 py-6">
                        <h4 class="font-bold text-lg text-gray-800 mb-3"><?= esc($activeAcademicYear['year_label']) ?></h4>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-wave-square mr-2 text-gray-400"></i>
                                <span>Gelombang: <?= esc($activeAcademicYear['wave']) ?></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                <span><?= date('d M Y', strtotime($activeAcademicYear['start_date'])) ?> - <?= date('d M Y', strtotime($activeAcademicYear['end_date'])) ?></span>
                            </div>
                            <?php if (!empty($activeAcademicYear['quota_total'])): ?>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-users mr-2 text-gray-400"></i>
                                    <span>Kuota: <?= esc($activeAcademicYear['quota_total']) ?> siswa</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Sedang Berlangsung
                            </span>
                        </div>
                    </div>
                    <a href="/admin/academic-years" class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-50 hover:bg-green-100 text-green-600 font-medium rounded-xl transition-colors duration-200">
                        <i class="fas fa-cog mr-2"></i> Kelola Tahun
                    </a>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 mb-4">Belum ada tahun akademik aktif</p>
                        <a href="/admin/academic-years" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i> Tambah Tahun
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- CMS Section Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6 rounded-t-2xl">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-globe mr-3"></i>
                    Konten Website
                </h3>
            </div>
            <div class="p-6">
                <div class="px-4 md:px-8 lg:px-12 py-6">
                    <p class="text-gray-600 leading-relaxed">Kelola konten website seperti pengumuman, informasi umum, dan halaman statis untuk memberikan informasi terkini kepada calon siswa.</p>
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Pengumuman & Berita</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Informasi Pendaftaran</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Halaman Statis</span>
                        </div>
                    </div>
                </div>
                <a href="/admin/cms" class="inline-flex items-center justify-center w-full px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-edit mr-2"></i> Kelola Konten
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8 mb-8">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Aksi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="/admin/users" class="bg-white hover:bg-gray-50 rounded-xl p-4 text-center transition-all duration-200 transform hover:scale-105 shadow-md">
                <i class="fas fa-user-plus text-2xl text-blue-500 mb-2"></i>
                <p class="text-sm font-medium text-gray-700">Tambah Pengguna</p>
            </a>
            <a href="/admin/submissions" class="bg-white hover:bg-gray-50 rounded-xl p-4 text-center transition-all duration-200 transform hover:scale-105 shadow-md">
                <i class="fas fa-clipboard-list text-2xl text-green-500 mb-2"></i>
                <p class="text-sm font-medium text-gray-700">Lihat Pendaftaran</p>
            </a>
            <a href="/admin/documents" class="bg-white hover:bg-gray-50 rounded-xl p-4 text-center transition-all duration-200 transform hover:scale-105 shadow-md">
                <i class="fas fa-file-check text-2xl text-purple-500 mb-2"></i>
                <p class="text-sm font-medium text-gray-700">Verifikasi Dokumen</p>
            </a>
            <a href="/admin/reports" class="bg-white hover:bg-gray-50 rounded-xl p-4 text-center transition-all duration-200 transform hover:scale-105 shadow-md">
                <i class="fas fa-chart-bar text-2xl text-orange-500 mb-2"></i>
                <p class="text-sm font-medium text-gray-700">Lihat Laporan</p>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>