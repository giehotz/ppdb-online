<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-2xl font-bold text-gray-800">Laporan</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Laporan</span>
    </nav>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Submissions Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Pendaftaran</p>
                <p class="text-2xl font-bold"><?= $totalSubmissions ?></p>
            </div>
        </div>
    </div>

    <!-- Total Students Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Siswa</p>
                <p class="text-2xl font-bold"><?= $totalStudents ?></p>
            </div>
        </div>
    </div>

    <!-- Total Documents Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                <i class="fas fa-file-contract text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Dokumen</p>
                <p class="text-2xl font-bold"><?= $totalDocuments ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Submission Status Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Pendaftaran</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Menunggu Verifikasi</span>
                    <span class="text-sm font-medium text-gray-700"><?= $submissionStats['menunggu_verifikasi'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" 
                         style="width: <?= $totalSubmissions > 0 ? ($submissionStats['menunggu_verifikasi'] / $totalSubmissions * 100) : 0 ?>%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Terverifikasi</span>
                    <span class="text-sm font-medium text-gray-700"><?= $submissionStats['terverifikasi'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" 
                         style="width: <?= $totalSubmissions > 0 ? ($submissionStats['terverifikasi'] / $totalSubmissions * 100) : 0 ?>%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Diterima</span>
                    <span class="text-sm font-medium text-gray-700"><?= $submissionStats['diterima'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" 
                         style="width: <?= $totalSubmissions > 0 ? ($submissionStats['diterima'] / $totalSubmissions * 100) : 0 ?>%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Cadangan</span>
                    <span class="text-sm font-medium text-gray-700"><?= $submissionStats['cadangan'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" 
                         style="width: <?= $totalSubmissions > 0 ? ($submissionStats['cadangan'] / $totalSubmissions * 100) : 0 ?>%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Ditolak</span>
                    <span class="text-sm font-medium text-gray-700"><?= $submissionStats['ditolak'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" 
                         style="width: <?= $totalSubmissions > 0 ? ($submissionStats['ditolak'] / $totalSubmissions * 100) : 0 ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Status Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Dokumen</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Diunggah</span>
                    <span class="text-sm font-medium text-gray-700"><?= $documentStats['uploaded'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" 
                         style="width: <?= $totalDocuments > 0 ? ($documentStats['uploaded'] / $totalDocuments * 100) : 0 ?>%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Terverifikasi</span>
                    <span class="text-sm font-medium text-gray-700"><?= $documentStats['verified'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" 
                         style="width: <?= $totalDocuments > 0 ? ($documentStats['verified'] / $totalDocuments * 100) : 0 ?>%"></div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Ditolak</span>
                    <span class="text-sm font-medium text-gray-700"><?= $documentStats['rejected'] ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" 
                         style="width: <?= $totalDocuments > 0 ? ($documentStats['rejected'] / $totalDocuments * 100) : 0 ?>%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>