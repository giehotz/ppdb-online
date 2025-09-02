<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Ekspor Data</h2>
            <nav class="text-sm text-gray-500">
                <a href="/panitia/dashboard">Home</a> / Ekspor Data
            </nav>
        </div>
    </div>
</div>

<!-- PDF Export Section -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Ekspor PDF</h3>
    </div>
    <div class="p-6">
        <p class="text-gray-600 mb-4">
            Ekspor data individu siswa ke dalam format PDF untuk keperluan administrasi dan arsip.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-800 mb-2">Formulir Pendaftaran</h4>
                <p class="text-gray-600 text-sm mb-3">
                    Dokumen lengkap berisi semua data siswa dalam format formulir yang dapat dicetak.
                </p>
                <p class="text-gray-600 text-sm mb-3">
                    <strong>Cara penggunaan:</strong> Akses melalui halaman detail pendaftar, klik tombol "Ekspor PDF" untuk mengunduh formulir.
                </p>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-800 mb-2">Bukti Pendaftaran</h4>
                <p class="text-gray-600 text-sm mb-3">
                    Dokumen ringkas yang berisi informasi utama pendaftaran sebagai bukti resmi.
                </p>
                <p class="text-gray-600 text-sm mb-3">
                    <strong>Cara penggunaan:</strong> Akses melalui halaman detail pendaftar, klik tombol "Cetak Bukti" untuk mengunduh bukti.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Excel/CSV Export Section -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Ekspor Excel/CSV</h3>
    </div>
    <div class="p-6">
        <p class="text-gray-600 mb-4">
            Ekspor data kolektif siswa ke dalam format Excel atau CSV untuk keperluan analisis dan pelaporan.
        </p>
        
        <form action="/panitia/export/submissions" method="POST">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter Berdasarkan Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Semua Status</option>
                        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                        <option value="terverifikasi">Terverifikasi</option>
                        <option value="diterima">Diterima</option>
                        <option value="cadangan">Cadangan</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                
                <div>
                    <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Format File</label>
                    <select name="format" id="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="xlsx">Excel (.xlsx)</option>
                        <option value="csv">CSV (.csv)</option>
                    </select>
                </div>
                
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="flex flex-wrap gap-4">
                <button type="submit" name="export_type" value="basic" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-file-excel mr-1"></i> Ekspor Laporan Dasar
                </button>
                
                <button type="submit" name="export_type" value="detailed" formaction="/panitia/export/detailed-report" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-file-excel mr-1"></i> Ekspor Laporan Detail
                </button>
            </div>
        </form>
        
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="font-medium text-gray-800 mb-2">Perbedaan Jenis Laporan</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded">
                    <h5 class="font-medium text-gray-700 mb-2">Laporan Dasar</h5>
                    <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                        <li>Informasi inti pendaftar</li>
                        <li>Nama, NISN, NIK, tanggal lahir</li>
                        <li>Status pendaftaran</li>
                        <li>Tanggal pendaftaran</li>
                    </ul>
                </div>
                
                <div class="bg-gray-50 p-4 rounded">
                    <h5 class="font-medium text-gray-700 mb-2">Laporan Detail</h5>
                    <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                        <li>Semua data dari laporan dasar</li>
                        <li>Data alamat dan orang tua</li>
                        <li>Informasi sekolah asal</li>
                        <li>Semua kolom data siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>