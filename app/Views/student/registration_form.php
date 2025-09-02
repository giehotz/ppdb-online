<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Formulir Pendaftaran Siswa</h2>
    <nav class="text-sm text-gray-500">
        <span>Dashboard</span> > <span>Formulir Pendaftaran</span>
    </nav>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-6">
            <button class="py-3 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                Data Pribadi
            </button>
            <button class="py-3 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                Sekolah Asal
            </button>
            <button class="py-3 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                Alamat
            </button>
            <button class="py-3 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                Orang Tua/Wali
            </button>
            <button class="py-3 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                Kartu Keluarga
            </button>
        </nav>
    </div>

    <form id="registrationForm">
        <!-- Student Personal Data Section -->
        <div id="personalDataSection">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pribadi Siswa</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" id="full_name" name="full_name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                    <input type="text" id="nisn" name="nisn" maxlength="10"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Nomor Induk Siswa Nasional (10 digit)</p>
                </div>
                
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                    <input type="text" id="nik" name="nik" maxlength="16"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Nomor Induk Kependudukan (16 digit)</p>
                </div>
                
                <div>
                    <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
                    <input type="text" id="birth_place" name="birth_place"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
                    <input type="date" id="birth_date" name="birth_date"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                    <select id="gender" name="gender"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                
                <div>
                    <label for="student_status" class="block text-sm font-medium text-gray-700 mb-1">Status Siswa *</label>
                    <select id="student_status" name="student_status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Status</option>
                        <option value="baru">Baru</option>
                        <option value="pindahan">Pindahan</option>
                    </select>
                </div>
                
                <div>
                    <label for="hobby" class="block text-sm font-medium text-gray-700 mb-1">Hobi</label>
                    <input type="text" id="hobby" name="hobby"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="aspiration" class="block text-sm font-medium text-gray-700 mb-1">Cita-cita</label>
                    <input type="text" id="aspiration" name="aspiration"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="siblings_count" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Saudara</label>
                    <input type="number" id="siblings_count" name="siblings_count" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="flex justify-between">
                <div></div> <!-- Empty div for spacing -->
                <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                    Selanjutnya
                </button>
            </div>
        </div>
        
        <!-- Hidden sections for other parts of the form -->
        <div id="schoolDataSection" class="hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Sekolah Asal</h3>
            <p class="text-gray-500">Formulir data sekolah asal akan muncul di sini.</p>
        </div>
        
        <div id="addressSection" class="hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Alamat</h3>
            <p class="text-gray-500">Formulir data alamat akan muncul di sini.</p>
        </div>
        
        <div id="parentSection" class="hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Orang Tua/Wali</h3>
            <p class="text-gray-500">Formulir data orang tua/wali akan muncul di sini.</p>
        </div>
        
        <div id="familyCardSection" class="hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Kartu Keluarga</h3>
            <p class="text-gray-500">Formulir data kartu keluarga akan muncul di sini.</p>
        </div>
    </form>
</div>

<div class="flex justify-between">
    <button class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md">
        Simpan Draft
    </button>
    <button class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md">
        Kirim Pendaftaran
    </button>
</div>
<?= $this->endSection() ?>