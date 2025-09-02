<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dasbor Panitia</h2>
    <nav class="text-sm text-gray-500">
        <span>Home</span>
    </nav>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-4">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Pendaftar</p>
                <h3 class="text-2xl font-bold"><?= $totalRegistrants ?></h3>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-green-100 text-green-500 flex items-center justify-center mr-4">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Diterima</p>
                <h3 class="text-2xl font-bold"><?= $acceptedRegistrants ?></h3>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center mr-4">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Perlu Verifikasi</p>
                <h3 class="text-2xl font-bold"><?= $pendingVerification ?></h3>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-500 flex items-center justify-center mr-4">
                <i class="fas fa-file-upload"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Dokumen Baru</p>
                <h3 class="text-2xl font-bold"><?= $newDocuments ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="/panitia/registrations" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                    <i class="fas fa-list"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-800">Manajemen Pendaftaran</h4>
                    <p class="text-gray-600 text-sm">Kelola semua pendaftaran</p>
                </div>
            </div>
        </a>
        
        <a href="/panitia/users" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-green-100 text-green-500 flex items-center justify-center mr-3">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-800">Manajemen Pengguna</h4>
                    <p class="text-gray-600 text-sm">Kelola akun pengguna</p>
                </div>
            </div>
        </a>
        
        <a href="/panitia/export" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-500 flex items-center justify-center mr-3">
                    <i class="fas fa-file-export"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-800">Ekspor Data</h4>
                    <p class="text-gray-600 text-sm">Ekspor PDF/Excel</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Registration Trend Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Pendaftaran (7 Hari Terakhir)</h3>
        <div class="h-64 flex items-center justify-center" id="registrationTrendChart">
            <canvas id="registrationTrend"></canvas>
        </div>
    </div>
    
    <!-- Status Composition Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Komposisi Status</h3>
        <div class="h-64 flex items-center justify-center" id="statusCompositionChart">
            <canvas id="statusComposition"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Geographic Distribution Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Sebaran Geografis</h3>
        <div class="h-64 flex items-center justify-center" id="geographicDistributionChart">
            <canvas id="geographicDistribution"></canvas>
        </div>
    </div>
    
    <!-- School Type Distribution Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Asal Sekolah</h3>
        <div class="h-64 flex items-center justify-center" id="schoolTypeDistributionChart">
            <canvas id="schoolTypeDistribution"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Registration Trend Data
const registrationTrendData = <?= json_encode($registrationTrend) ?>;
const registrationTrendLabels = registrationTrendData.map(item => item.date);
const registrationTrendValues = registrationTrendData.map(item => item.count);

// Status Composition Data
const statusCompositionData = <?= json_encode($statusComposition) ?>;
const statusLabels = statusCompositionData.map(item => {
    const statusMap = {
        'menunggu_verifikasi': 'Menunggu Verifikasi',
        'terverifikasi': 'Terverifikasi',
        'diterima': 'Diterima',
        'cadangan': 'Cadangan',
        'ditolak': 'Ditolak'
    };
    return statusMap[item.status] || item.status;
});
const statusValues = statusCompositionData.map(item => item.count);

// Geographic Distribution Data
const geographicData = <?= json_encode($geographicDistribution) ?>;
const geographicLabels = geographicData.map(item => item.region);
const geographicValues = geographicData.map(item => item.count);

// School Type Distribution Data
const schoolTypeData = <?= json_encode($schoolTypeDistribution) ?>;
const schoolTypeLabels = schoolTypeData.map(item => item.school_type === 'negeri' ? 'Negeri' : 'Swasta');
const schoolTypeValues = schoolTypeData.map(item => item.count);

// Initialize Charts when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Registration Trend Chart
    const registrationTrendCtx = document.getElementById('registrationTrend').getContext('2d');
    new Chart(registrationTrendCtx, {
        type: 'line',
        data: {
            labels: registrationTrendLabels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: registrationTrendValues,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Status Composition Chart
    const statusCompositionCtx = document.getElementById('statusComposition').getContext('2d');
    new Chart(statusCompositionCtx, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 205, 86)',
                    'rgb(153, 102, 255)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Geographic Distribution Chart
    const geographicCtx = document.getElementById('geographicDistribution').getContext('2d');
    new Chart(geographicCtx, {
        type: 'bar',
        data: {
            labels: geographicLabels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: geographicValues,
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // School Type Distribution Chart
    const schoolTypeCtx = document.getElementById('schoolTypeDistribution').getContext('2d');
    new Chart(schoolTypeCtx, {
        type: 'bar',
        data: {
            labels: schoolTypeLabels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: schoolTypeValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>