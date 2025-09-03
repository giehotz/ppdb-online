<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"><?= isset($student) ? 'Edit Data Siswa' : 'Tambah Data Siswa' ?></h2>
            <nav class="text-sm text-gray-500">
                <a href="/panitia/students">Manajemen Data Siswa</a> > <span><?= isset($student) ? 'Edit Data Siswa' : 'Tambah Data Siswa' ?></span>
            </nav>
        </div>
        <a href="/panitia/students" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <?php if (!isset($student)): ?>
        <!-- Form for adding new student (offline registration) -->
        <form id="studentForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username *</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                    <input type="text" id="nisn" name="nisn" maxlength="10"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                    <input type="text" id="nik" name="nik" required maxlength="16"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" id="full_name" name="full_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
                    <input type="text" id="birth_place" name="birth_place" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
                    <input type="date" id="birth_date" name="birth_date" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                    <select id="gender" name="gender" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label for="student_status" class="block text-sm font-medium text-gray-700 mb-1">Status Siswa *</label>
                    <select id="student_status" name="student_status" required
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
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                    Simpan Data Siswa
                </button>
            </div>
        </form>
    <?php else: ?>
        <!-- Form for editing existing student data -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="flex space-x-8">
                <button onclick="showTab('personal')" id="personal-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                    Data Pribadi
                </button>
                <button onclick="showTab('school')" id="school-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Data Sekolah
                </button>
                <button onclick="showTab('address')" id="address-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Alamat
                </button>
                <button onclick="showTab('parents')" id="parents-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Data Orang Tua
                </button>
                <button onclick="showTab('family_card')" id="family_card-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Kartu Keluarga
                </button>
            </nav>
        </div>

        <!-- Personal Data Tab -->
        <div id="personal-tab-content" class="tab-content">
            <form id="personalForm">
                <input type="hidden" name="step" value="personal">
                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                        <input type="text" id="nisn" name="nisn" maxlength="10" value="<?= esc($student['nisn'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                        <input type="text" id="nik" name="nik" required maxlength="16" value="<?= esc($student['nik'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="full_name" name="full_name" required value="<?= esc($student['full_name'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
                        <input type="text" id="birth_place" name="birth_place" required value="<?= esc($student['birth_place'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
                        <input type="date" id="birth_date" name="birth_date" required value="<?= esc($student['birth_date'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                        <select id="gender" name="gender" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" <?= (isset($student['gender']) && $student['gender'] === 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= (isset($student['gender']) && $student['gender'] === 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label for="student_status" class="block text-sm font-medium text-gray-700 mb-1">Status Siswa *</label>
                        <select id="student_status" name="student_status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Status</option>
                            <option value="baru" <?= (isset($student['student_status']) && $student['student_status'] === 'baru') ? 'selected' : '' ?>>Baru</option>
                            <option value="pindahan" <?= (isset($student['student_status']) && $student['student_status'] === 'pindahan') ? 'selected' : '' ?>>Pindahan</option>
                        </select>
                    </div>

                    <div>
                        <label for="hobby" class="block text-sm font-medium text-gray-700 mb-1">Hobi</label>
                        <input type="text" id="hobby" name="hobby" value="<?= esc($student['hobby'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="aspiration" class="block text-sm font-medium text-gray-700 mb-1">Cita-cita</label>
                        <input type="text" id="aspiration" name="aspiration" value="<?= esc($student['aspiration'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                        Simpan Data Pribadi
                    </button>
                </div>
            </form>
        </div>

        <!-- School Data Tab -->
        <div id="school-tab-content" class="tab-content hidden">
            <form id="schoolForm">
                <input type="hidden" name="step" value="school">
                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="school_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah *</label>
                        <input type="text" id="school_name" name="school_name" required value="<?= esc($priorSchool['school_name'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="school_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Sekolah *</label>
                        <select id="school_type" name="school_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Jenis Sekolah</option>
                            <option value="negeri" <?= (isset($priorSchool['school_type']) && $priorSchool['school_type'] === 'negeri') ? 'selected' : '' ?>>Negeri</option>
                            <option value="swasta" <?= (isset($priorSchool['school_type']) && $priorSchool['school_type'] === 'swasta') ? 'selected' : '' ?>>Swasta</option>
                        </select>
                    </div>

                    <div>
                        <label for="school_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Sekolah</label>
                        <textarea id="school_address" name="school_address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= esc($priorSchool['school_address'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus *</label>
                        <input type="number" id="graduation_year" name="graduation_year" required min="1900" max="2100" value="<?= esc($priorSchool['graduation_year'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                        Simpan Data Sekolah
                    </button>
                </div>
            </form>
        </div>

        <!-- Address Data Tab -->
        <div id="address-tab-content" class="tab-content hidden">
            <form id="addressForm">
                <input type="hidden" name="step" value="address">
                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

                <h3 class="text-lg font-medium text-gray-800 mb-4">Alamat Kartu Keluarga</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="md:col-span-2">
                        <label for="kk_street_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Jalan *</label>
                        <textarea id="kk_street_address" name="kk_street_address" rows="2" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= esc($kkAddress['street_address'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label for="kk_village" class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan *</label>
                        <input type="text" id="kk_village" name="kk_village" required value="<?= esc($kkAddress['village'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="kk_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                        <input type="text" id="kk_district" name="kk_district" required value="<?= esc($kkAddress['district'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="kk_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                        <input type="text" id="kk_regency" name="kk_regency" required value="<?= esc($kkAddress['regency'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="kk_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                        <input type="text" id="kk_province" name="kk_province" required value="<?= esc($kkAddress['province'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="kk_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" id="kk_postal_code" name="kk_postal_code" value="<?= esc($kkAddress['postal_code'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <h3 class="text-lg font-medium text-gray-800 mb-4">Alamat Domisili</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="md:col-span-2">
                        <label for="domisili_street_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Jalan *</label>
                        <textarea id="domisili_street_address" name="domisili_street_address" rows="2" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= esc($domisiliAddress['street_address'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label for="domisili_village" class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan *</label>
                        <input type="text" id="domisili_village" name="domisili_village" required value="<?= esc($domisiliAddress['village'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="domisili_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                        <input type="text" id="domisili_district" name="domisili_district" required value="<?= esc($domisiliAddress['district'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="domisili_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                        <input type="text" id="domisili_regency" name="domisili_regency" required value="<?= esc($domisiliAddress['regency'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="domisili_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                        <input type="text" id="domisili_province" name="domisili_province" required value="<?= esc($domisiliAddress['province'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="domisili_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" id="domisili_postal_code" name="domisili_postal_code" value="<?= esc($domisiliAddress['postal_code'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                        Simpan Data Alamat
                    </button>
                </div>
            </form>
        </div>

        <!-- Parents Data Tab -->
        <div id="parents-tab-content" class="tab-content hidden">
            <form id="parentsForm">
                <input type="hidden" name="step" value="parents">
                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

                <h3 class="text-lg font-medium text-gray-800 mb-4">Data Ayah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="father_full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="father_full_name" name="father_full_name" required value="<?= esc($father['full_name'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="father_nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                        <input type="text" id="father_nik" name="father_nik" required maxlength="16" value="<?= esc($father['nik'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="father_birth_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lahir</label>
                        <input type="number" id="father_birth_year" name="father_birth_year" min="1900" max="2100" value="<?= esc($father['birth_year'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="father_education" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                        <select id="father_education" name="father_education"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="sd" <?= (isset($father['education']) && $father['education'] === 'sd') ? 'selected' : '' ?>>SD/Sederajat</option>
                            <option value="smp" <?= (isset($father['education']) && $father['education'] === 'smp') ? 'selected' : '' ?>>SMP/Sederajat</option>
                            <option value="sma" <?= (isset($father['education']) && $father['education'] === 'sma') ? 'selected' : '' ?>>SMA/Sederajat</option>
                            <option value="d3" <?= (isset($father['education']) && $father['education'] === 'd3') ? 'selected' : '' ?>>D3</option>
                            <option value="s1" <?= (isset($father['education']) && $father['education'] === 's1') ? 'selected' : '' ?>>S1</option>
                            <option value="s2" <?= (isset($father['education']) && $father['education'] === 's2') ? 'selected' : '' ?>>S2</option>
                            <option value="s3" <?= (isset($father['education']) && $father['education'] === 's3') ? 'selected' : '' ?>>S3</option>
                        </select>
                    </div>

                    <div>
                        <label for="father_occupation" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" id="father_occupation" name="father_occupation" value="<?= esc($father['occupation'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="father_monthly_income" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan Bulanan</label>
                        <input type="number" id="father_monthly_income" name="father_monthly_income" value="<?= esc($father['monthly_income'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="father_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="father_phone" name="father_phone" value="<?= esc($father['phone'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <h3 class="text-lg font-medium text-gray-800 mb-4">Data Ibu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="mother_full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="mother_full_name" name="mother_full_name" required value="<?= esc($mother['full_name'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="mother_nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                        <input type="text" id="mother_nik" name="mother_nik" required maxlength="16" value="<?= esc($mother['nik'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="mother_birth_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lahir</label>
                        <input type="number" id="mother_birth_year" name="mother_birth_year" min="1900" max="2100" value="<?= esc($mother['birth_year'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="mother_education" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                        <select id="mother_education" name="mother_education"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="sd" <?= (isset($mother['education']) && $mother['education'] === 'sd') ? 'selected' : '' ?>>SD/Sederajat</option>
                            <option value="smp" <?= (isset($mother['education']) && $mother['education'] === 'smp') ? 'selected' : '' ?>>SMP/Sederajat</option>
                            <option value="sma" <?= (isset($mother['education']) && $mother['education'] === 'sma') ? 'selected' : '' ?>>SMA/Sederajat</option>
                            <option value="d3" <?= (isset($mother['education']) && $mother['education'] === 'd3') ? 'selected' : '' ?>>D3</option>
                            <option value="s1" <?= (isset($mother['education']) && $mother['education'] === 's1') ? 'selected' : '' ?>>S1</option>
                            <option value="s2" <?= (isset($mother['education']) && $mother['education'] === 's2') ? 'selected' : '' ?>>S2</option>
                            <option value="s3" <?= (isset($mother['education']) && $mother['education'] === 's3') ? 'selected' : '' ?>>S3</option>
                        </select>
                    </div>

                    <div>
                        <label for="mother_occupation" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" id="mother_occupation" name="mother_occupation" value="<?= esc($mother['occupation'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="mother_monthly_income" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan Bulanan</label>
                        <input type="number" id="mother_monthly_income" name="mother_monthly_income" value="<?= esc($mother['monthly_income'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="mother_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="mother_phone" name="mother_phone" value="<?= esc($mother['phone'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                        Simpan Data Orang Tua
                    </button>
                </div>
            </form>
        </div>

        <!-- Family Card Data Tab -->
        <div id="family_card-tab-content" class="tab-content hidden">
            <form id="familyCardForm">
                <input type="hidden" name="step" value="family_card">
                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="family_card_no" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu Keluarga *</label>
                        <input type="text" id="family_card_no" name="family_card_no" required value="<?= esc($familyCard['family_card_no'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="father_name_on_card" class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah (di KK) *</label>
                        <input type="text" id="father_name_on_card" name="father_name_on_card" required value="<?= esc($familyCard['father_name'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="mother_name_on_card" class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu (di KK) *</label>
                        <input type="text" id="mother_name_on_card" name="mother_name_on_card" required value="<?= esc($familyCard['mother_name'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="family_card_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat (di KK)</label>
                        <textarea id="family_card_address" name="family_card_address" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= esc($familyCard['address'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label for="family_card_rt" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                        <input type="text" id="family_card_rt" name="family_card_rt" value="<?= esc($familyCard['rt'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="family_card_rw" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                        <input type="text" id="family_card_rw" name="family_card_rw" value="<?= esc($familyCard['rw'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="family_card_village" class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan</label>
                        <input type="text" id="family_card_village" name="family_card_village" value="<?= esc($familyCard['village'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="family_card_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <input type="text" id="family_card_district" name="family_card_district" value="<?= esc($familyCard['district'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="family_card_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                        <input type="text" id="family_card_regency" name="family_card_regency" value="<?= esc($familyCard['regency'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="family_card_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <input type="text" id="family_card_province" name="family_card_province" value="<?= esc($familyCard['province'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="family_card_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" id="family_card_postal_code" name="family_card_postal_code" value="<?= esc($familyCard['postal_code'] ?? '') ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md">
                        Simpan Data Kartu Keluarga
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    <?php if (!isset($student)): ?>
        // Handle form submission for new student
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/panitia/students/store', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data siswa');
                });
        });
    <?php else: ?>
        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show the selected tab content
            document.getElementById(tabName + '-tab-content').classList.remove('hidden');

            // Add active class to the selected tab button
            document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById(tabName + '-tab').classList.add('border-blue-500', 'text-blue-600');
        }

        // Handle form submissions for existing student
        document.getElementById('personalForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/panitia/students/update/<?= $student['id'] ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });

        document.getElementById('schoolForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/panitia/students/update/<?= $student['id'] ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });

        document.getElementById('addressForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/panitia/students/update/<?= $student['id'] ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });

        document.getElementById('parentsForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/panitia/students/update/<?= $student['id'] ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });

        document.getElementById('familyCardForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/panitia/students/update/<?= $student['id'] ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>