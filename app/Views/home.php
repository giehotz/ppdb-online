<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di PPDB MIN 2 Tanggamus</h1>
    <p class="text-gray-600 mb-6">
        Sistem Penerimaan Peserta Didik Baru (PPDB) MIN 2 Tanggamus merupakan platform digital yang memudahkan 
        proses pendaftaran siswa baru secara online. Dengan sistem ini, calon siswa dapat mendaftar kapan saja 
        dan di mana saja.
    </p>
    
    <?php if (!session()->has('user_id')): ?>
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Mulai Pendaftaran</h2>
        <p class="text-gray-600 mb-4">
            Jika Anda belum memiliki akun, silakan daftar terlebih dahulu untuk memulai proses pendaftaran.
        </p>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/register" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg text-center">
                Daftar Sekarang
            </a>
            <a href="/login" class="bg-white hover:bg-gray-100 text-blue-500 border border-blue-500 font-medium py-2 px-4 rounded-lg text-center">
                Sudah Punya Akun
            </a>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Lanjutkan Pendaftaran</h2>
        <p class="text-gray-600 mb-4">
            Halo, <?= session()->get('username') ?>! Anda sudah masuk ke sistem. Lanjutkan proses pendaftaran Anda.
        </p>
        <a href="/<?= session()->get('role') ?>/dashboard" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg inline-block">
            Buka Dashboard
        </a>
    </div>
    <?php endif; ?>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="border border-gray-200 rounded-lg p-5">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mb-4">
                <i class="fas fa-edit fa-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pendaftaran Online</h3>
            <p class="text-gray-600 text-sm">
                Proses pendaftaran yang mudah dan cepat hanya dengan menggunakan perangkat digital.
            </p>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-5">
            <div class="w-12 h-12 rounded-full bg-green-100 text-green-500 flex items-center justify-center mb-4">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Verifikasi Cepat</h3>
            <p class="text-gray-600 text-sm">
                Proses verifikasi dokumen yang cepat dan transparan dengan status real-time.
            </p>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-5">
            <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-500 flex items-center justify-center mb-4">
                <i class="fas fa-print fa-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Cetak Formulir</h3>
            <p class="text-gray-600 text-sm">
                Cetak formulir pendaftaran dan dokumen lainnya kapan saja Anda butuhkan.
            </p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Pengumuman Terbaru</h2>
    </div>
    <div class="p-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
            <h3 class="font-medium text-gray-800 mb-1">Jadwal Pendaftaran Tahun Ajaran 2025/2026</h3>
            <p class="text-gray-600 text-sm mb-2">Diposting pada 1 Agustus 2025</p>
            <p class="text-gray-600">
                Pendaftaran dibuka mulai 1 Agustus 2025 hingga 30 September 2025. Pastikan Anda mendaftar sebelum batas akhir.
            </p>
        </div>
        <div class="border-b border-gray-200 pb-4 mb-4">
            <h3 class="font-medium text-gray-800 mb-1">Perubahan Ketentuan Dokumen</h3>
            <p class="text-gray-600 text-sm mb-2">Diposting pada 15 Juli 2025</p>
            <p class="text-gray-600">
                Mulai tahun ini, dokumen tambahan berupa sertifikat vaksin COVID-19 diperlukan untuk pendaftaran.
            </p>
        </div>
        <div class="text-center">
            <a href="/announcement" class="text-blue-500 hover:text-blue-700 font-medium">
                Lihat Semua Pengumuman <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>