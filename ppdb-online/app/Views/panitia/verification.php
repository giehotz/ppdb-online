<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi Data dan Dokumen</h2>
            <nav class="text-sm text-gray-500">
                <a href="/panitia/dashboard">Home</a> /
                <a href="/panitia/registrations">Manajemen Pendaftaran</a> / Verifikasi
            </nav>
        </div>
        <div class="flex space-x-2">
            <a href="/panitia/export/pdf/registration-form/<?= $submission['id'] ?>" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-file-pdf mr-1"></i> Ekspor PDF
            </a>
            <a href="/panitia/export/pdf/registration-receipt/<?= $submission['id'] ?>" target="_blank" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-print mr-1"></i> Cetak Bukti
            </a>
            <a href="/panitia/registrations" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?php if (!$allRequiredDocumentsUploaded): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p><strong>Peringatan:</strong> Masih terdapat dokumen wajib yang belum diunggah oleh siswa:</p>
        <ul class="list-disc list-inside mt-2">
            <?php foreach ($missingRequiredDocuments as $doc): ?>
                <li><?= $doc ?></li>
            <?php endforeach; ?>
        </ul>
        <p class="mt-2">Anda tidak dapat mengubah status pendaftaran menjadi "Terverifikasi" sampai semua dokumen wajib diunggah.</p>
    </div>
<?php elseif (!$allDocumentsVerified): ?>
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        <p><strong>Peringatan:</strong> Masih terdapat dokumen yang belum diverifikasi. Anda tidak dapat mengubah status pendaftaran menjadi "Terverifikasi" sampai semua dokumen diverifikasi.</p>
    </div>
<?php endif; ?>

<!-- Student Information -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Informasi Siswa</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <p class="font-medium"><?= esc($submission['student_name']) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NISN</p>
                <p class="font-medium"><?= esc($submission['nisn'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIK</p>
                <p class="font-medium"><?= esc($submission['nik']) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                <p class="font-medium"><?= esc($submission['birth_place']) ?>, <?= date('d F Y', strtotime($submission['birth_date'])) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jenis Kelamin</p>
                <p class="font-medium"><?= $submission['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kelas yang Dituju</p>
                <p class="font-medium"><?= esc($submission['class_level']) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nomor Registrasi</p>
                <p class="font-medium"><?= esc($submission['registration_no']) ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Daftar</p>
                <p class="font-medium"><?= date('d F Y H:i', strtotime($submission['created_at'])) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Parents Information -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Data Orang Tua/Wali</h3>
    </div>
    <div class="p-6">
        <?php if (!empty($parents)): ?>
            <?php foreach ($parents as $parent): ?>
                <div class="mb-4 last:mb-0">
                    <h4 class="font-medium text-gray-700 mb-2"><?= ucfirst($parent['relation']) ?></h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium"><?= esc($parent['full_name']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="font-medium"><?= esc($parent['nik']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pendidikan</p>
                            <p class="font-medium"><?= esc($parent['education']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pekerjaan</p>
                            <p class="font-medium"><?= esc($parent['occupation']) ?></p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Penghasilan Bulanan</p>
                            <p class="font-medium">Rp <?= number_format($parent['monthly_income'] ?? 0, 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">Tidak ada data orang tua/wali.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Address Information -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Alamat</h3>
    </div>
    <div class="p-6">
        <?php if (!empty($addresses)): ?>
            <?php foreach ($addresses as $address): ?>
                <div class="mb-4 last:mb-0">
                    <h4 class="font-medium text-gray-700 mb-2">
                        <?= $address['type'] === 'kk' ? 'Alamat Kartu Keluarga' : 'Alamat Domisili' ?>
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium"><?= esc($address['street_address'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kelurahan/Desa</p>
                            <p class="font-medium"><?= esc($address['village'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kecamatan</p>
                            <p class="font-medium"><?= esc($address['district'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kabupaten/Kota</p>
                            <p class="font-medium"><?= esc($address['regency'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Provinsi</p>
                            <p class="font-medium"><?= esc($address['province'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kode Pos</p>
                            <p class="font-medium"><?= esc($address['postal_code'] ?? '-') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">Tidak ada data alamat.</p>
        <?php endif; ?>
    </div>
</div>

<!-- School Information -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Data Sekolah Asal</h3>
    </div>
    <div class="p-6">
        <?php if ($priorSchool): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Nama Sekolah</p>
                    <p class="font-medium"><?= esc($priorSchool['school_name']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jenis Sekolah</p>
                    <p class="font-medium"><?= $priorSchool['school_type'] === 'negeri' ? 'Negeri' : 'Swasta' ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Alamat Sekolah</p>
                    <p class="font-medium"><?= esc($priorSchool['school_address']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tahun Lulus</p>
                    <p class="font-medium"><?= esc($priorSchool['graduation_year']) ?></p>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-500">Tidak ada data sekolah asal.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Required Documents Status -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Status Dokumen Wajib</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($requiredDocuments as $docType => $docLabel): ?>
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-800"><?= $docLabel ?></h4>
                        <?php if (isset($uploadedDocuments[$docType])): ?>
                            <?php $doc = $uploadedDocuments[$docType]; ?>
                            <p class="text-sm text-gray-600 mt-1"><?= $doc['file_name'] ?></p>
                            <p class="text-xs text-gray-500"><?= date('d M Y H:i', strtotime($doc['uploaded_at'])) ?></p>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 mt-1">Belum diunggah</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if (isset($uploadedDocuments[$docType])): ?>
                            <?php $doc = $uploadedDocuments[$docType]; ?>
                            <?php if ($doc['status'] === 'uploaded'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    Menunggu Verifikasi
                                </span>
                            <?php elseif ($doc['status'] === 'verified'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Terverifikasi
                                </span>
                            <?php elseif ($doc['status'] === 'rejected'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                Belum Diunggah
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Documents -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Semua Dokumen</h3>
    </div>
    <div class="p-6">
        <?php if (!empty($documents)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($documents as $document): ?>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium text-gray-800"><?= esc(ucwords(str_replace('_', ' ', $document['doc_type']))) ?></h4>
                            <span class="px-2 py-1 text-xs rounded-full 
                            <?php if ($document['status'] === 'verified'): ?>
                                bg-green-100 text-green-800
                            <?php elseif ($document['status'] === 'rejected'): ?>
                                bg-red-100 text-red-800
                            <?php else: ?>
                                bg-yellow-100 text-yellow-800
                            <?php endif; ?>">
                                <?= ucfirst($document['status']) ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3"><?= esc($document['file_name']) ?></p>
                        <div class="flex space-x-2">
                            <a href="/documents/download/<?= $document['id'] ?>" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                <i class="fas fa-download mr-1"></i> Unduh
                            </a>
                            <?php if ($document['status'] !== 'verified'): ?>
                                <button onclick="verifyDocument(<?= $document['id'] ?>)" class="text-green-500 hover:text-green-700 text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i> Verifikasi
                                </button>
                            <?php endif; ?>
                            <?php if ($document['status'] !== 'rejected'): ?>
                                <button onclick="rejectDocument(<?= $document['id'] ?>)" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500">Tidak ada dokumen yang diunggah.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Final Decision Panel -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Keputusan Akhir</h3>
    </div>
    <div class="p-6">
        <form id="statusForm">
            <input type="hidden" name="submission_id" value="<?= $submission['id'] ?>">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Pendaftaran</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php foreach ($statusLabels as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $submission['status'] === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4 hidden" id="rejectionReasonField">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                <textarea name="rejection_reason" id="rejection_reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?= esc($submission['rejection_reason'] ?? '') ?></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" <?= (!$allRequiredDocumentsUploaded || !$allDocumentsVerified) && $submission['status'] !== 'ditolak' ? 'disabled' : '' ?>>
                    <i class="fas fa-save mr-1"></i> Simpan Keputusan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show/hide rejection reason field based on status selection
    document.getElementById('status').addEventListener('change', function() {
        const rejectionReasonField = document.getElementById('rejectionReasonField');
        if (this.value === 'ditolak') {
            rejectionReasonField.classList.remove('hidden');
        } else {
            rejectionReasonField.classList.add('hidden');
        }
    });

    // Initialize rejection reason field visibility on page load
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const rejectionReasonField = document.getElementById('rejectionReasonField');
        if (statusSelect.value === 'ditolak') {
            rejectionReasonField.classList.remove('hidden');
        }
    });

    // Handle form submission
    document.getElementById('statusForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/panitia/update-registration-status', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui status.');
            });
    });

    // Document verification functions
    function verifyDocument(documentId) {
        if (confirm('Apakah Anda yakin ingin memverifikasi dokumen ini?')) {
            fetch('/panitia/verify-document', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'document_id=' + documentId + '&status=verified'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memverifikasi dokumen.');
                });
        }
    }

    function rejectDocument(documentId) {
        const reason = prompt('Masukkan alasan penolakan dokumen:');
        if (reason !== null && reason.trim() !== '') {
            fetch('/panitia/verify-document', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'document_id=' + documentId + '&status=rejected&rejection_reason=' + encodeURIComponent(reason)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menolak dokumen.');
                });
        }
    }
</script>
<?= $this->endSection() ?>