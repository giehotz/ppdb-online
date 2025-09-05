<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="p-4 md:p-8 lg:p-12">
    <div class="mb-8">
        <div class="flex items-center justify-between flex-wrap">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Siswa</h1>
                <p class="text-sm font-medium text-indigo-600 mt-1">PPDB MIN 2 Tanggamus</p>
            </div>
            <div class="flex-shrink-0">
                <p class="text-xl font-semibold text-gray-700">Selamat Datang, <?= session()->get('username') ?>!</p>
            </div>
        </div>
        <div class="mt-4 p-6 bg-white rounded-xl shadow-lg border border-gray-100">
            <p class="text-gray-600 leading-relaxed">
                Silakan lengkapi data pendaftaran Anda dengan mengikuti langkah-langkah di bawah ini untuk memulai proses pendaftaran.
            </p>
        </div>
    </div>

    <!-- Step-by-Step Guide -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Step 1: Lengkapi Profil Siswa -->
        <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 flex flex-col items-start transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 font-bold mb-3">
                <i class="fas fa-user text-lg"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-1">1. Lengkapi Profil</h3>
            <p class="text-gray-500 text-sm flex-grow">
                Isi data pribadi, alamat, dan informasi orang tua.
            </p>
            <a href="/student/registration" class="mt-4 inline-flex items-center font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                <i class="fas fa-edit mr-2 text-sm"></i>
                Isi Profil
            </a>
        </div>

        <!-- Step 2: Unggah Dokumen -->
        <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 p-6 flex flex-col items-start transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-cyan-50 text-cyan-600 font-bold mb-3">
                <i class="fas fa-file-upload text-lg"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-1">2. Unggah Dokumen</h3>
            <p class="text-gray-500 text-sm flex-grow">
                Unggah akta kelahiran, kartu keluarga, dan pas foto.
            </p>
            <div class="mt-4 flex flex-col items-start space-y-2">
                <a href="/student/documents" class="inline-flex items-center font-medium text-cyan-600 hover:text-cyan-800 transition-colors">
                    <i class="fas fa-file-upload mr-2 text-sm"></i>
                    Unggah Dokumen
                </a>
                <a href="/student/documents" class="inline-flex items-center font-medium text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-file-alt mr-2 text-sm"></i>
                    Lihat Dokumen
                </a>
            </div>
        </div>

        <!-- Step 3: Ajukan Pendaftaran -->
        <div class="bg-white rounded-2xl shadow-lg border border-teal-100 p-6 flex flex-col items-start transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-teal-50 text-teal-600 font-bold mb-3">
                <i class="fas fa-paper-plane text-lg"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-1">3. Ajukan Pendaftaran</h3>
            <p class="text-gray-500 text-sm flex-grow">
                Periksa kembali data Anda sebelum diajukan untuk diverifikasi.
            </p>
            <div class="mt-4">
                <?php if (isset($student) && $student && $student['submission_state'] === 'draft'): ?>
                    <button id="submitRegistrationBtn" class="inline-flex items-center font-medium text-teal-600 hover:text-teal-800 transition-colors">
                        <i class="fas fa-paper-plane mr-2 text-sm"></i>
                        Ajukan Pendaftaran
                    </button>
                <?php elseif (isset($student) && $student && $student['submission_state'] === 'submitted'): ?>
                    <span class="inline-flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        Pendaftaran telah diajukan
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center text-gray-500 text-sm">
                        <i class="fas fa-lock mr-2 text-gray-400"></i>
                        Selesaikan langkah sebelumnya
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Step 4: Cetak Formulir -->
        <div class="bg-white rounded-2xl shadow-lg border border-green-100 p-6 flex flex-col items-start transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-50 text-green-600 font-bold mb-3">
                <i class="fas fa-print text-lg"></i>
            </div>
            <h3 class="font-bold text-lg text-gray-800 mb-1">4. Cetak Formulir</h3>
            <p class="text-gray-500 text-sm flex-grow">
                Cetak formulir setelah data diverifikasi sebagai bukti pendaftaran.
            </p>
            <div class="mt-4">
                <?php if (isset($submission) && $submission): ?>
                    <a href="/student/print-registration" class="inline-flex items-center font-medium text-green-600 hover:text-green-800 transition-colors">
                        <i class="fas fa-print mr-2 text-sm"></i>
                        Cetak Formulir
                    </a>
                <?php else: ?>
                    <span class="inline-flex items-center text-gray-500 text-sm">
                        <i class="fas fa-lock mr-2 text-gray-400"></i>
                        Setelah pendaftaran diverifikasi
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Submission Status -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900">Status Pendaftaran</h3>
        </div>
        <div class="p-6">
            <?php if (isset($submission) && $submission): ?>
                <?php
                $statusLabels = [
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'terverifikasi' => 'Terverifikasi',
                    'diterima' => 'Diterima',
                    'cadangan' => 'Cadangan',
                    'ditolak' => 'Ditolak'
                ];

                $statusColors = [
                    'menunggu_verifikasi' => 'bg-yellow-500',
                    'terverifikasi' => 'bg-blue-500',
                    'diterima' => 'bg-green-500',
                    'cadangan' => 'bg-purple-500',
                    'ditolak' => 'bg-red-500'
                ];

                $currentStatus = $submission['status'];
                ?>
                <div class="flex items-center p-4 rounded-lg <?= $statusColors[$currentStatus] ?> bg-opacity-20 border border-current">
                    <div class="w-4 h-4 rounded-full <?= $statusColors[$currentStatus] ?> mr-4 animate-pulse"></div>
                    <span class="text-lg font-semibold text-gray-800">
                        <?= $statusLabels[$currentStatus] ?>
                        <?php if ($submission['registration_no']): ?>
                            (<?= $submission['registration_no'] ?>)
                        <?php endif; ?>
                    </span>
                </div>
                <?php if ($currentStatus === 'ditolak' && !empty($submission['rejection_reason'])): ?>
                    <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-200 shadow-sm">
                        <p class="text-sm text-red-700">
                            <span class="font-bold">Alasan penolakan:</span>
                            <?= $submission['rejection_reason'] ?>
                        </p>
                    </div>
                <?php endif; ?>
            <?php elseif (isset($student) && $student && $student['submission_state'] === 'submitted'): ?>
                <div class="flex items-center p-4 rounded-lg bg-yellow-500 bg-opacity-20 border border-yellow-500">
                    <div class="w-4 h-4 rounded-full bg-yellow-500 mr-4 animate-pulse"></div>
                    <span class="text-lg font-semibold text-gray-800">Pendaftaran dalam proses</span>
                </div>
            <?php else: ?>
                <div class="flex items-center p-4 rounded-lg bg-gray-500 bg-opacity-20 border border-gray-500">
                    <div class="w-4 h-4 rounded-full bg-gray-500 mr-4"></div>
                    <span class="text-lg font-semibold text-gray-800">Belum mengisi data pribadi</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Modal Kustom untuk Konfirmasi -->
<div id="confirmationModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-xl p-6 w-11/12 max-w-sm transform transition-all duration-300 scale-95">
        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Konfirmasi Pengajuan</h3>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="py-4">
            <p class="text-gray-600">Apakah Anda yakin ingin mengajukan pendaftaran? Data yang telah diajukan tidak dapat diubah lagi.</p>
        </div>
        <div class="flex justify-end space-x-2">
            <button id="cancelBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium focus:outline-none">Batal</button>
            <button id="confirmBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium focus:outline-none">Ya, Ajukan</button>
        </div>
    </div>
</div>

<!-- Modal Kustom untuk Notifikasi -->
<div id="notificationModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-xl p-6 w-11/12 max-w-sm transform transition-all duration-300 scale-95">
        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Notifikasi</h3>
            <button id="closeNotificationModalBtn" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="py-4">
            <p id="notificationMessage" class="text-gray-600"></p>
        </div>
        <div class="flex justify-end">
            <button id="okBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium focus:outline-none">Tutup</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitBtn = document.getElementById('submitRegistrationBtn');
        const modal = document.getElementById('confirmationModal');
        const confirmBtn = document.getElementById('confirmBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');

        const notificationModal = document.getElementById('notificationModal');
        const notificationMessage = document.getElementById('notificationMessage');
        const closeNotificationModalBtn = document.getElementById('closeNotificationModalBtn');
        const okBtn = document.getElementById('okBtn');

        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
                modal.querySelector('.transform').classList.remove('scale-95');
            });
        }

        function hideModal() {
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function showNotification(message, callback) {
            notificationMessage.textContent = message;
            notificationModal.classList.remove('hidden');
            notificationModal.querySelector('.transform').classList.remove('scale-95');

            okBtn.onclick = () => {
                hideNotification();
                if (callback) callback();
            };
            closeNotificationModalBtn.onclick = hideNotification;
        }

        function hideNotification() {
            notificationModal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => notificationModal.classList.add('hidden'), 300);
        }

        cancelBtn.addEventListener('click', hideModal);
        closeModalBtn.addEventListener('click', hideModal);

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal();
            }
        });

        confirmBtn.addEventListener('click', function() {
            hideModal();
            fetch('/student/submit-registration', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showNotification(data.message, () => location.reload());
                    } else {
                        showNotification('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat mengajukan pendaftaran.');
                });
        });
    });
</script>

<?= $this->endSection() ?>