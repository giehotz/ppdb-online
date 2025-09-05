<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-3xl font-bold text-gray-900">Profil Madrasah</h2>
    <nav class="text-sm text-gray-500 mt-1">
        <span>Dashboard</span> > <span class="text-blue-500 font-medium">Profil Madrasah</span>
    </nav>
</div>

<div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
    <form id="madrasahProfileForm" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="<?= $profile['id'] ?? '' ?>">

        <!-- Section: Informasi Dasar -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 pb-2">Informasi Dasar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Madrasah *</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['name'] ?? '' ?>">
            </div>

            <div>
                <label for="npsn" class="block text-sm font-medium text-gray-700 mb-1">NPSN *</label>
                <input type="text" id="npsn" name="npsn" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['npsn'] ?? '' ?>">
            </div>

            <div>
                <label for="nsm" class="block text-sm font-medium text-gray-700 mb-1">NSM</label>
                <input type="text" id="nsm" name="nsm"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['nsm'] ?? '' ?>">
            </div>

            <div>
                <label for="nss" class="block text-sm font-medium text-gray-700 mb-1">NSS</label>
                <input type="text" id="nss" name="nss"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['nss'] ?? '' ?>">
            </div>

            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
                <textarea id="address" name="address" rows="3" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"><?= $profile['address'] ?? '' ?></textarea>
            </div>
        </div>

        <!-- Section: Detail Lokasi -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 pb-2">Detail Lokasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                <input type="text" id="district" name="district" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['district'] ?? '' ?>">
            </div>

            <div>
                <label for="regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                <input type="text" id="regency" name="regency" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['regency'] ?? '' ?>">
            </div>

            <div>
                <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                <input type="text" id="province" name="province" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['province'] ?? '' ?>">
            </div>

            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos *</label>
                <input type="text" id="postal_code" name="postal_code" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['postal_code'] ?? '' ?>">
            </div>
        </div>

        <!-- Section: Kontak & Kepala Madrasah -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 pb-2">Kontak & Kepala Madrasah</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" id="phone" name="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['phone'] ?? '' ?>">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['email'] ?? '' ?>">
            </div>

            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                <input type="text" id="website" name="website"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['website'] ?? '' ?>">
            </div>

            <div>
                <label for="headmaster_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kepala Madrasah *</label>
                <input type="text" id="headmaster_name" name="headmaster_name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['headmaster_name'] ?? '' ?>">
            </div>

            <div>
                <label for="headmaster_nip" class="block text-sm font-medium text-gray-700 mb-1">NIP Kepala Madrasah</label>
                <input type="text" id="headmaster_nip" name="headmaster_nip"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    value="<?= $profile['headmaster_nip'] ?? '' ?>">
            </div>
        </div>

        <!-- Section: Logo dan Kop Surat -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 pb-2">Logo & Kop Surat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                <input type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                <div class="mt-4" id="logo-preview-container">
                    <?php if (!empty($profile['logo_path'])): ?>
                        <div class="border border-gray-300 rounded-lg p-2 bg-gray-50 shadow-sm flex items-center justify-center h-48 w-full max-w-xs overflow-hidden">
                            <img src="<?= base_url('writable/' . $profile['logo_path']) ?>" alt="Logo saat ini" class="h-full w-auto object-contain">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <label for="letterhead" class="block text-sm font-medium text-gray-700 mb-1">Kop Surat</label>
                <input type="file" id="letterhead" name="letterhead" accept=".jpg,.jpeg,.png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                <div class="mt-4" id="letterhead-preview-container">
                    <?php if (!empty($profile['letterhead_path'])): ?>
                        <div class="border border-gray-300 rounded-lg p-2 bg-gray-50 shadow-sm flex items-center justify-center h-48 w-full max-w-xs overflow-hidden">
                            <img src="<?= base_url('writable/' . $profile['letterhead_path']) ?>" alt="Kop surat saat ini" class="h-full w-auto object-contain">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-md shadow-md transition duration-300 transform hover:scale-105">
                Simpan Profil
            </button>
        </div>
    </form>
</div>

<!-- Modal untuk notifikasi -->
<div id="notification-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full mx-4">
        <h4 class="text-lg font-semibold text-gray-900 mb-4" id="notification-title"></h4>
        <p class="text-gray-700 mb-4" id="notification-message"></p>
        <div class="flex justify-end">
            <button id="close-modal" class="px-4 py-2 bg-blue-500 text-white rounded-md">OK</button>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan modal notifikasi
    function showModal(title, message) {
        document.getElementById('notification-title').innerText = title;
        document.getElementById('notification-message').innerText = message;
        document.getElementById('notification-modal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal notifikasi
    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('notification-modal').classList.add('hidden');
    });

    // Fungsi untuk pratinjau gambar
    function setupImagePreview(inputId, previewContainerId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Pratinjau Gambar';
                    img.classList.add('h-full', 'w-auto', 'object-contain', 'rounded-md');

                    const previewWrapper = document.createElement('div');
                    previewWrapper.classList.add('border', 'border-gray-300', 'rounded-lg', 'p-2', 'bg-gray-50', 'shadow-sm', 'flex', 'items-center', 'justify-center', 'h-48', 'w-full', 'max-w-xs', 'overflow-hidden');

                    previewWrapper.appendChild(img);

                    // Bersihkan pratinjau lama sebelum menambahkan yang baru
                    while (previewContainer.firstChild) {
                        previewContainer.removeChild(previewContainer.firstChild);
                    }
                    previewContainer.appendChild(previewWrapper);
                };

                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Panggil fungsi pratinjau untuk setiap input file
    setupImagePreview('logo', 'logo-preview-container');
    setupImagePreview('letterhead', 'letterhead-preview-container');

    // Mengganti alert() dengan modal kustom
    document.getElementById('madrasahProfileForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/admin/madrasah-profile/save', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showModal('Berhasil', data.message);
                    setTimeout(() => location.reload(), 2000); // Reload setelah 2 detik
                } else {
                    showModal('Error', 'Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('Error', 'Terjadi kesalahan saat menyimpan profil madrasah.');
            });
    });
</script>
<?= $this->endSection() ?>