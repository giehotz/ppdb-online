<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Formulir Pendaftaran Siswa</h2>
            <nav class="text-sm text-gray-500">
                <span>Dashboard</span> > <span>Formulir Pendaftaran</span>
            </nav>
        </div>
        <?php if (!empty($academicYear)): ?>
            <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                <span class="font-medium">Tahun Akademik:</span> <?= esc($academicYear['year_label']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <!-- Progress Steps -->
    <div class="px-6 py-4 border-b">
        <div class="flex justify-between">
            <button id="prevBtn" onclick="nextPrev(-1)" class="px-4 py-2 text-gray-600 hover:text-gray-800 hidden">
                <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
            </button>
            <button id="nextBtn" onclick="nextPrev(1)" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 ml-auto">
                Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>

    <!-- Form Steps -->
    <form id="registrationForm" class="p-6">
        <!-- Step 1: Personal Data -->
        <div class="step">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pribadi</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN *</label>
                    <input type="text" id="nisn" name="nisn" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['nisn'] ?? '' ?>">
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                    <input type="text" id="nik" name="nik" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['nik'] ?? '' ?>">
                </div>

                <div class="md:col-span-2">
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" id="full_name" name="full_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['full_name'] ?? '' ?>">
                </div>

                <div>
                    <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
                    <input type="text" id="birth_place" name="birth_place" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['birth_place'] ?? '' ?>">
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
                    <input type="date" id="birth_date" name="birth_date" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['birth_date'] ?? '' ?>">
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
                        <option value="">Pilih Status Siswa</option>
                        <option value="anak_kandung" <?= (isset($student['student_status']) && $student['student_status'] === 'anak_kandung') ? 'selected' : '' ?>>Anak Kandung</option>
                        <option value="anak_angkat" <?= (isset($student['student_status']) && $student['student_status'] === 'anak_angkat') ? 'selected' : '' ?>>Anak Angkat</option>
                    </select>
                </div>

                <div>
                    <label for="hobby" class="block text-sm font-medium text-gray-700 mb-1">Hobi</label>
                    <input type="text" id="hobby" name="hobby"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['hobby'] ?? '' ?>">
                </div>

                <div class="md:col-span-2">
                    <label for="aspiration" class="block text-sm font-medium text-gray-700 mb-1">Aspirasi</label>
                    <textarea id="aspiration" name="aspiration" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['aspiration'] ?? '' ?></textarea>
                </div>
            </div>
        </div>

        <!-- Step 2: School Information -->
        <div class="step hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Sekolah Asal</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="school_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah *</label>
                    <input type="text" id="school_name" name="school_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['prior_school']['school_name'] ?? '' ?>">
                </div>

                <div>
                    <label for="school_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Sekolah *</label>
                    <select id="school_type" name="school_type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis Sekolah</option>
                        <option value="negeri" <?= (isset($student['prior_school']['school_type']) && $student['prior_school']['school_type'] === 'negeri') ? 'selected' : '' ?>>Negeri</option>
                        <option value="swasta" <?= (isset($student['prior_school']['school_type']) && $student['prior_school']['school_type'] === 'swasta') ? 'selected' : '' ?>>Swasta</option>
                    </select>
                </div>

                <div>
                    <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus *</label>
                    <input type="text" id="graduation_year" name="graduation_year" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['prior_school']['graduation_year'] ?? '' ?>">
                </div>

                <div class="md:col-span-2">
                    <label for="school_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Sekolah</label>
                    <textarea id="school_address" name="school_address" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['prior_school']['school_address'] ?? '' ?></textarea>
                </div>
            </div>
        </div>

        <!-- Step 3: Address Information -->
        <div class="step hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Alamat</h3>

            <!-- KK Address -->
            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                <h4 class="font-medium text-gray-800 mb-3">Alamat Kartu Keluarga</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="kk_street_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
                        <textarea id="kk_street_address" name="kk_street_address" rows="2" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['addresses']['kk']['street_address'] ?? '' ?></textarea>
                    </div>

                    <div>
                        <label for="kk_village" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa *</label>
                        <input type="text" id="kk_village" name="kk_village" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['kk']['village'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                        <input type="text" id="kk_district" name="kk_district" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['kk']['district'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                        <input type="text" id="kk_regency" name="kk_regency" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['kk']['regency'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                        <input type="text" id="kk_province" name="kk_province" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['kk']['province'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" id="kk_postal_code" name="kk_postal_code"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['kk']['postal_code'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- Domisili Address -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-800 mb-3">Alamat Domisili</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="domisili_street_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
                        <textarea id="domisili_street_address" name="domisili_street_address" rows="2" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['addresses']['domisili']['street_address'] ?? '' ?></textarea>
                    </div>

                    <div>
                        <label for="domisili_village" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa *</label>
                        <input type="text" id="domisili_village" name="domisili_village" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['domisili']['village'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                        <input type="text" id="domisili_district" name="domisili_district" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['domisili']['district'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                        <input type="text" id="domisili_regency" name="domisili_regency" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['domisili']['regency'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                        <input type="text" id="domisili_province" name="domisili_province" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['domisili']['province'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" id="domisili_postal_code" name="domisili_postal_code"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['addresses']['domisili']['postal_code'] ?? '' ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Parents Information -->
        <div class="step hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Orang Tua/Wali</h3>

            <!-- Father Information -->
            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                <h4 class="font-medium text-gray-800 mb-3">Data Ayah</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="father_full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="father_full_name" name="father_full_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['father']['full_name'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="father_nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                        <input type="text" id="father_nik" name="father_nik" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['father']['nik'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="father_birth_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lahir</label>
                        <input type="text" id="father_birth_year" name="father_birth_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['father']['birth_year'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="father_education" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                        <select id="father_education" name="father_education"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="sd" <?= (isset($student['parents']['father']['education']) && $student['parents']['father']['education'] === 'sd') ? 'selected' : '' ?>>SD/Sederajat</option>
                            <option value="smp" <?= (isset($student['parents']['father']['education']) && $student['parents']['father']['education'] === 'smp') ? 'selected' : '' ?>>SMP/Sederajat</option>
                            <option value="sma" <?= (isset($student['parents']['father']['education']) && $student['parents']['father']['education'] === 'sma') ? 'selected' : '' ?>>SMA/Sederajat</option>
                            <option value="d3" <?= (isset($student['parents']['father']['education']) && $student['parents']['father']['education'] === 'd3') ? 'selected' : '' ?>>D3</option>
                            <option value="s1" <?= (isset($student['parents']['father']['education']) && $student['parents']['father']['education'] === 's1') ? 'selected' : '' ?>>S1</option>
                            <option value="s2" <?= (isset($student['parents']['father']['education']) && $student['parents']['father']['education'] === 's2') ? 'selected' : '' ?>>S2</option>
                            <option value="s3" <?= (isset($student['parents']['father']['education']) && $student['parents']['father']['education'] === 's3') ? 'selected' : '' ?>>S3</option>
                        </select>
                    </div>

                    <div>
                        <label for="father_occupation" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" id="father_occupation" name="father_occupation"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['father']['occupation'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="father_monthly_income" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan Bulanan</label>
                        <input type="number" id="father_monthly_income" name="father_monthly_income"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['father']['monthly_income'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="father_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="father_phone" name="father_phone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['father']['phone'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- Mother Information -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-800 mb-3">Data Ibu</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="mother_full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="mother_full_name" name="mother_full_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['mother']['full_name'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="mother_nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                        <input type="text" id="mother_nik" name="mother_nik" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['mother']['nik'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="mother_birth_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lahir</label>
                        <input type="text" id="mother_birth_year" name="mother_birth_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['mother']['birth_year'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="mother_education" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                        <select id="mother_education" name="mother_education"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="sd" <?= (isset($student['parents']['mother']['education']) && $student['parents']['mother']['education'] === 'sd') ? 'selected' : '' ?>>SD/Sederajat</option>
                            <option value="smp" <?= (isset($student['parents']['mother']['education']) && $student['parents']['mother']['education'] === 'smp') ? 'selected' : '' ?>>SMP/Sederajat</option>
                            <option value="sma" <?= (isset($student['parents']['mother']['education']) && $student['parents']['mother']['education'] === 'sma') ? 'selected' : '' ?>>SMA/Sederajat</option>
                            <option value="d3" <?= (isset($student['parents']['mother']['education']) && $student['parents']['mother']['education'] === 'd3') ? 'selected' : '' ?>>D3</option>
                            <option value="s1" <?= (isset($student['parents']['mother']['education']) && $student['parents']['mother']['education'] === 's1') ? 'selected' : '' ?>>S1</option>
                            <option value="s2" <?= (isset($student['parents']['mother']['education']) && $student['parents']['mother']['education'] === 's2') ? 'selected' : '' ?>>S2</option>
                            <option value="s3" <?= (isset($student['parents']['mother']['education']) && $student['parents']['mother']['education'] === 's3') ? 'selected' : '' ?>>S3</option>
                        </select>
                    </div>

                    <div>
                        <label for="mother_occupation" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" id="mother_occupation" name="mother_occupation"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['mother']['occupation'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="mother_monthly_income" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan Bulanan</label>
                        <input type="number" id="mother_monthly_income" name="mother_monthly_income"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['mother']['monthly_income'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="mother_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="mother_phone" name="mother_phone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['parents']['mother']['phone'] ?? '' ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Family Card Information -->
        <div class="step hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Kartu Keluarga</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="family_card_no" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu Keluarga *</label>
                    <input type="text" id="family_card_no" name="family_card_no" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['family_card_no'] ?? '' ?>">
                </div>

                <div>
                    <label for="father_name_on_card" class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah (sesuai KK) *</label>
                    <input type="text" id="father_name_on_card" name="father_name_on_card" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['father_name'] ?? '' ?>">
                </div>

                <div>
                    <label for="mother_name_on_card" class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu (sesuai KK) *</label>
                    <input type="text" id="mother_name_on_card" name="mother_name_on_card" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['mother_name'] ?? '' ?>">
                </div>

                <div class="md:col-span-2">
                    <label for="family_card_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat (sesuai KK)</label>
                    <textarea id="family_card_address" name="family_card_address" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['family_card']['address'] ?? '' ?></textarea>
                </div>

                <div>
                    <label for="family_card_rt" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                    <input type="text" id="family_card_rt" name="family_card_rt"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['rt'] ?? '' ?>">
                </div>

                <div>
                    <label for="family_card_rw" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                    <input type="text" id="family_card_rw" name="family_card_rw"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['rw'] ?? '' ?>">
                </div>

                <div>
                    <label for="family_card_village" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa</label>
                    <input type="text" id="family_card_village" name="family_card_village"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['village'] ?? '' ?>">
                </div>

                <div>
                    <label for="family_card_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" id="family_card_district" name="family_card_district"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['district'] ?? '' ?>">
                </div>

                <div>
                    <label for="family_card_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                    <input type="text" id="family_card_regency" name="family_card_regency"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['regency'] ?? '' ?>">
                </div>

                <div>
                    <label for="family_card_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <input type="text" id="family_card_province" name="family_card_province"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['province'] ?? '' ?>">
                </div>

                <div>
                    <label for="family_card_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                    <input type="text" id="family_card_postal_code" name="family_card_postal_code"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['postal_code'] ?? '' ?>">
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Current step
    let currentStep = 0;

    // Show the current step
    function showStep(n) {
        // Get all steps
        let steps = document.getElementsByClassName("step");

        // Hide all steps
        for (let i = 0; i < steps.length; i++) {
            steps[i].classList.add("hidden");
        }

        // Show the current step
        steps[n].classList.remove("hidden");

        // Update buttons
        if (n == 0) {
            document.getElementById("prevBtn").classList.add("hidden");
        } else {
            document.getElementById("prevBtn").classList.remove("hidden");
        }

        if (n == (steps.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Kirim Formulir <i class='fas fa-paper-plane ml-2'></i>";
        } else {
            document.getElementById("nextBtn").innerHTML = "Selanjutnya <i class='fas fa-arrow-right ml-2'></i>";
        }
    }

    // Next/previous step
    function nextPrev(n) {
        // Get all steps
        let steps = document.getElementsByClassName("step");

        // If moving forward and current step is not the last
        if (n == 1 && currentStep < steps.length - 1) {
            // Save current step data
            saveCurrentStep();
            return;
        }

        // If moving backward and current step is not the first
        if (n == -1 && currentStep > 0) {
            currentStep += n;
            showStep(currentStep);
            return;
        }

        // If on the last step, submit the form
        if (currentStep == steps.length - 1) {
            submitForm();
            return;
        }

        // Move to next step
        currentStep += n;
        showStep(currentStep);
    }

    // Save current step data
    function saveCurrentStep() {
        // Get form data
        let formData = new FormData(document.getElementById("registrationForm"));
        formData.append("step", getCurrentStepName());

        // Send data to server
        fetch("/student/save-draft", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    // Move to next step
                    currentStep++;
                    showStep(currentStep);
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat menyimpan data");
            });
    }

    // Get current step name
    function getCurrentStepName() {
        const stepNames = ["personal", "school", "address", "parents", "family_card"];
        return stepNames[currentStep];
    }

    // Submit the form
    function submitForm() {
        if (confirm("Apakah Anda yakin ingin mengirim formulir pendaftaran? Pastikan semua data telah diisi dengan benar.")) {
            fetch("/student/submit-registration", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        window.location.href = "/student/dashboard";
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat mengirim formulir");
                });
        }
    }

    // Initialize the form
    document.addEventListener("DOMContentLoaded", function() {
        showStep(currentStep);
    });
</script>
<?= $this->endSection() ?>