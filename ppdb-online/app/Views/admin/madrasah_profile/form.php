<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <h2 class="text-2xl font-bold text-gray-800">Profil Madrasah</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Profil Madrasah</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form id="madrasahProfileForm" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="<?= $profile['id'] ?? '' ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Madrasah *</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['name'] ?? '' ?>">
            </div>

            <div>
                <label for="npsn" class="block text-sm font-medium text-gray-700 mb-1">NPSN *</label>
                <input type="text" id="npsn" name="npsn" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['npsn'] ?? '' ?>">
            </div>

            <div>
                <label for="nsm" class="block text-sm font-medium text-gray-700 mb-1">NSM</label>
                <input type="text" id="nsm" name="nsm"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['nsm'] ?? '' ?>">
            </div>

            <div>
                <label for="nss" class="block text-sm font-medium text-gray-700 mb-1">NSS</label>
                <input type="text" id="nss" name="nss"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['nss'] ?? '' ?>">
            </div>

            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
                <textarea id="address" name="address" rows="3" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $profile['address'] ?? '' ?></textarea>
            </div>

            <div>
                <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                <input type="text" id="district" name="district" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['district'] ?? '' ?>">
            </div>

            <div>
                <label for="regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                <input type="text" id="regency" name="regency" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['regency'] ?? '' ?>">
            </div>

            <div>
                <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                <input type="text" id="province" name="province" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['province'] ?? '' ?>">
            </div>

            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos *</label>
                <input type="text" id="postal_code" name="postal_code" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['postal_code'] ?? '' ?>">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" id="phone" name="phone"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['phone'] ?? '' ?>">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['email'] ?? '' ?>">
            </div>

            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                <input type="text" id="website" name="website"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['website'] ?? '' ?>">
            </div>

            <div>
                <label for="headmaster_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kepala Madrasah *</label>
                <input type="text" id="headmaster_name" name="headmaster_name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['headmaster_name'] ?? '' ?>">
            </div>

            <div>
                <label for="headmaster_nip" class="block text-sm font-medium text-gray-700 mb-1">NIP Kepala Madrasah</label>
                <input type="text" id="headmaster_nip" name="headmaster_nip"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    value="<?= $profile['headmaster_nip'] ?? '' ?>">
            </div>

            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                <input type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                <?php if (!empty($profile['logo_path'])): ?>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Logo saat ini:</p>
                        <img src="<?= base_url('writable/' . $profile['logo_path']) ?>" alt="Logo" class="mt-1 h-16">
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <label for="letterhead" class="block text-sm font-medium text-gray-700 mb-1">Kop Surat</label>
                <input type="file" id="letterhead" name="letterhead" accept=".jpg,.jpeg,.png"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                <?php if (!empty($profile['letterhead_path'])): ?>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Kop surat saat ini:</p>
                        <img src="<?= base_url('writable/' . $profile['letterhead_path']) ?>" alt="Kop Surat" class="mt-1 h-16">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                Simpan Profil
            </button>
        </div>
    </form>
</div>

<script>
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
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan profil madrasah');
            });
    });
</script>
<?= $this->endSection() ?>