<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Profil Madrasah</h1>
        
        <?php if (isset($profile) && $profile): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Logo Madrasah -->
                <div class="flex justify-center items-center">
                    <?php if (!empty($profile['logo_path'])): ?>
                        <img src="<?= base_url('writable/' . $profile['logo_path']) ?>" alt="Logo <?= esc($profile['name']) ?>" class="max-w-full h-auto rounded-lg shadow">
                    <?php else: ?>
                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-48 h-48 flex items-center justify-center">
                            <span class="text-gray-500">Logo tidak tersedia</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Informasi Utama -->
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4"><?= esc($profile['name']) ?></h2>
                    
                    <div class="space-y-3">
                        <div class="flex">
                            <div class="w-48 font-semibold">NPSN</div>
                            <div>: <?= esc($profile['npsn']) ?></div>
                        </div>
                        
                        <?php if (!empty($profile['nsm'])): ?>
                        <div class="flex">
                            <div class="w-48 font-semibold">NSM</div>
                            <div>: <?= esc($profile['nsm']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($profile['nss'])): ?>
                        <div class="flex">
                            <div class="w-48 font-semibold">NSS</div>
                            <div>: <?= esc($profile['nss']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="flex">
                            <div class="w-48 font-semibold">Alamat</div>
                            <div>: <?= esc($profile['address']) ?></div>
                        </div>
                        
                        <div class="flex">
                            <div class="w-48 font-semibold">Kecamatan</div>
                            <div>: <?= esc($profile['district']) ?></div>
                        </div>
                        
                        <div class="flex">
                            <div class="w-48 font-semibold">Kabupaten/Kota</div>
                            <div>: <?= esc($profile['regency']) ?></div>
                        </div>
                        
                        <div class="flex">
                            <div class="w-48 font-semibold">Provinsi</div>
                            <div>: <?= esc($profile['province']) ?></div>
                        </div>
                        
                        <div class="flex">
                            <div class="w-48 font-semibold">Kode Pos</div>
                            <div>: <?= esc($profile['postal_code']) ?></div>
                        </div>
                        
                        <?php if (!empty($profile['phone'])): ?>
                        <div class="flex">
                            <div class="w-48 font-semibold">Telepon</div>
                            <div>: <?= esc($profile['phone']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($profile['email'])): ?>
                        <div class="flex">
                            <div class="w-48 font-semibold">Email</div>
                            <div>: <?= esc($profile['email']) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($profile['website'])): ?>
                        <div class="flex">
                            <div class="w-48 font-semibold">Website</div>
                            <div>: <?= esc($profile['website']) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Informasi Kepala Madrasah -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Kepala Madrasah</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex">
                        <div class="w-48 font-semibold">Nama Kepala Madrasah</div>
                        <div>: <?= esc($profile['headmaster_name']) ?></div>
                    </div>
                    
                    <?php if (!empty($profile['headmaster_nip'])): ?>
                    <div class="flex">
                        <div class="w-48 font-semibold">NIP</div>
                        <div>: <?= esc($profile['headmaster_nip']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Kop Surat -->
            <?php if (!empty($profile['letterhead_path'])): ?>
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Kop Surat</h3>
                <div class="flex justify-center">
                    <img src="<?= base_url('writable/' . $profile['letterhead_path']) ?>" alt="Kop Surat <?= esc($profile['name']) ?>" class="max-w-full h-auto rounded-lg shadow">
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p>Profil madrasah belum tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>