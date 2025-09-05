<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 md:px-8 lg:px-12 py-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-green-800">Formulir Pendaftaran Siswa</h2>
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

<!-- Progress Bar -->
<div class="bg-white rounded-lg shadow mx-4 md:mx-8 lg:mx-12 p-4 mb-6">
    <div class="flex justify-between relative">
        <!-- Progress line -->
        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -z-10 transform -translate-y-1/2"></div>
        <div id="progress-line" class="absolute top-1/2 left-0 h-1 bg-blue-500 -z-10 transform -translate-y-1/2 transition-all duration-300" style="width: 20%"></div>

        <!-- Step indicators -->
        <div class="flex flex-col items-center step-indicator active" data-step="1">
            <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-2">1</div>
            <span class="text-xs font-medium text-center">Data<br>Pribadi</span>
        </div>
        <div class="flex flex-col items-center step-indicator" data-step="2">
            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-2">2</div>
            <span class="text-xs font-medium text-center">Sekolah<br>Asal</span>
        </div>
        <div class="flex flex-col items-center step-indicator" data-step="3">
            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-2">3</div>
            <span class="text-xs font-medium text-center">Alamat</span>
        </div>
        <div class="flex flex-col items-center step-indicator" data-step="4">
            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-2">4</div>
            <span class="text-xs font-medium text-center">Orang<br>Tua</span>
        </div>
        <div class="flex flex-col items-center step-indicator" data-step="5">
            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-2">5</div>
            <span class="text-xs font-medium text-center">Kartu<br>Keluarga</span>
        </div>
    </div>
</div>

<!-- Registration Form -->
<form id="registrationForm" class="bg-white rounded-lg shadow mx-4 md:mx-8 lg:mx-12 p-4 md:p-6">
    <?= csrf_field() ?>
    <input type="hidden" id="student_id" name="student_id" value="<?= $student['id'] ?? session('student_id') ?? '' ?>">
    <input type="hidden" id="submission_state" name="submission_state" value="draft">

    <!-- Steps Container -->
    <div class="steps-container">
        <!-- Step 1: Personal Information -->
        <div class="step" id="step-1">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pribadi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nis_local" class="block text-sm font-medium text-gray-700 mb-1">NIS Lokal</label>
                    <input type="text" id="nis_local" name="nis_local" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['nis_local'] ?? '' ?>">
                </div>
                
                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN *</label>
                    <input type="text" id="nisn" name="nisn" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['nisn'] ?? '' ?>" maxlength="10">
                </div>
                
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                    <input type="text" id="nik" name="nik" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['nik'] ?? '' ?>" maxlength="16">
                </div>
                
                <div>
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
                    <label for="class_level" class="block text-sm font-medium text-gray-700 mb-1">Tingkat Kelas *</label>
                    <select id="class_level" name="class_level" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tingkat Kelas</option>
                        <option value="1" <?= (isset($student['class_level']) && $student['class_level'] == 1) ? 'selected' : '' ?>>1 (Satu)</option>
                        <option value="2" <?= (isset($student['class_level']) && $student['class_level'] == 2) ? 'selected' : '' ?>>2 (Dua)</option>
                        <option value="3" <?= (isset($student['class_level']) && $student['class_level'] == 3) ? 'selected' : '' ?>>3 (Tiga)</option>
                        <option value="4" <?= (isset($student['class_level']) && $student['class_level'] == 4) ? 'selected' : '' ?>>4 (Empat)</option>
                        <option value="5" <?= (isset($student['class_level']) && $student['class_level'] == 5) ? 'selected' : '' ?>>5 (Lima)</option>
                        <option value="6" <?= (isset($student['class_level']) && $student['class_level'] == 6) ? 'selected' : '' ?>>6 (Enam)</option>
                    </select>
                </div>

                <div>
                    <label for="parallel_class" class="block text-sm font-medium text-gray-700 mb-1">Kelas Paralel</label>
                    <input type="text" id="parallel_class" name="parallel_class"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['parallel_class'] ?? '' ?>">
                </div>

                <div>
                    <label for="attendance_no" class="block text-sm font-medium text-gray-700 mb-1">Nomor Absen</label>
                    <input type="number" id="attendance_no" name="attendance_no"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['attendance_no'] ?? '' ?>">
                </div>

                <div>
                    <label for="class_rank" class="block text-sm font-medium text-gray-700 mb-1">Peringkat Kelas</label>
                    <input type="number" id="class_rank" name="class_rank"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['class_rank'] ?? '' ?>">
                </div>

                <div>
                    <label for="student_status" class="block text-sm font-medium text-gray-700 mb-1">Status Siswa *</label>
                    <select id="student_status" name="student_status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Status Siswa</option>
                        <option value="baru" <?= (isset($student['student_status']) && $student['student_status'] === 'baru') ? 'selected' : '' ?>>Baru</option>
                        <option value="pindahan" <?= (isset($student['student_status']) && $student['student_status'] === 'pindahan') ? 'selected' : '' ?>>Pindahan</option>
                    </select>
                </div>

                <div>
                    <label for="siblings_count" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Saudara</label>
                    <input type="number" id="siblings_count" name="siblings_count" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['siblings_count'] ?? '0' ?>">
                </div>

                <div>
                    <label for="hobby" class="block text-sm font-medium text-gray-700 mb-1">Hobi</label>
                    <input type="text" id="hobby" name="hobby"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['hobby'] ?? '' ?>">
                </div>

                <div>
                    <label for="aspiration" class="block text-sm font-medium text-gray-700 mb-1">Cita-cita</label>
                    <textarea id="aspiration" name="aspiration" rows="1"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['aspiration'] ?? '' ?></textarea>
                </div>
            </div>
        </div>

        <!-- Step 2: School Information -->
        <div class="step hidden" id="step-2">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Sekolah Asal</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="school_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah *</label>
                    <input type="text" id="school_name" name="school_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['prior_school']['school_name'] ?? '' ?>">
                </div>

                <div>
                    <label for="school_level" class="block text-sm font-medium text-gray-700 mb-1">Jenjang Sekolah *</label>
                    <select id="school_level" name="school_level" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenjang Sekolah</option>
                        <option value="TK" <?= (isset($student['prior_school']['school_level']) && $student['prior_school']['school_level'] === 'TK') ? 'selected' : '' ?>>TK</option>
                        <option value="RA" <?= (isset($student['prior_school']['school_level']) && $student['prior_school']['school_level'] === 'RA') ? 'selected' : '' ?>>RA</option>
                        <option value="SD" <?= (isset($student['prior_school']['school_level']) && $student['prior_school']['school_level'] === 'SD') ? 'selected' : '' ?>>SD</option>
                        <option value="Lainnya" <?= (isset($student['prior_school']['school_level']) && $student['prior_school']['school_level'] === 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                    </select>
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
                    <label for="accreditation_status" class="block text-sm font-medium text-gray-700 mb-1">Status Akreditasi *</label>
                    <select id="accreditation_status" name="accreditation_status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Status Akreditasi</option>
                        <option value="terakreditasi" <?= (isset($student['prior_school']['accreditation_status']) && $student['prior_school']['accreditation_status'] === 'terakreditasi') ? 'selected' : '' ?>>Terakreditasi</option>
                        <option value="tidak_terakreditasi" <?= (isset($student['prior_school']['accreditation_status']) && $student['prior_school']['accreditation_status'] === 'tidak_terakreditasi') ? 'selected' : '' ?>>Tidak Terakreditasi</option>
                        <option value="unknown" <?= (isset($student['prior_school']['accreditation_status']) && $student['prior_school']['accreditation_status'] === 'unknown') ? 'selected' : '' ?>>Tidak Diketahui</option>
                    </select>
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Kota *</label>
                    <input type="text" id="city" name="city" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['prior_school']['city'] ?? '' ?>">
                </div>
            </div>
        </div>

        <!-- Step 3: Address Information -->
        <div class="step hidden" id="step-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Alamat</h3>

            <!-- KK Address -->
            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                <h4 class="font-medium text-gray-800 mb-3">Alamat Kartu Keluarga</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="kk_address_line" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                        <textarea id="kk_address_line" name="kk_address_line" required rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['kk_address']['address_line'] ?? '' ?></textarea>
                    </div>

                    <div>
                        <label for="kk_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                        <input type="text" id="kk_province" name="kk_province" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['kk_address']['province'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                        <input type="text" id="kk_regency" name="kk_regency" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['kk_address']['regency'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                        <input type="text" id="kk_district" name="kk_district" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['kk_address']['district'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_village" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa *</label>
                        <input type="text" id="kk_village" name="kk_village" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['kk_address']['village'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos *</label>
                        <input type="text" id="kk_postal_code" name="kk_postal_code" required maxlength="5"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['kk_address']['postal_code'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_distance_km" class="block text-sm font-medium text-gray-700 mb-1">Jarak dari Madrasah (km)</label>
                        <input type="number" id="kk_distance_km" name="kk_distance_km" step="0.1" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['kk_address']['distance_km'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="kk_transport_mode" class="block text-sm font-medium text-gray-700 mb-1">Moda Transportasi *</label>
                        <select id="kk_transport_mode" name="kk_transport_mode" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Moda Transportasi</option>
                            <option value="jalan_kaki" <?= (isset($student['kk_address']['transport_mode']) && $student['kk_address']['transport_mode'] === 'jalan_kaki') ? 'selected' : '' ?>>Jalan Kaki</option>
                            <option value="sepeda" <?= (isset($student['kk_address']['transport_mode']) && $student['kk_address']['transport_mode'] === 'sepeda') ? 'selected' : '' ?>>Sepeda</option>
                            <option value="motor" <?= (isset($student['kk_address']['transport_mode']) && $student['kk_address']['transport_mode'] === 'motor') ? 'selected' : '' ?>>Motor</option>
                            <option value="mobil" <?= (isset($student['kk_address']['transport_mode']) && $student['kk_address']['transport_mode'] === 'mobil') ? 'selected' : '' ?>>Mobil</option>
                            <option value="angkot" <?= (isset($student['kk_address']['transport_mode']) && $student['kk_address']['transport_mode'] === 'angkot') ? 'selected' : '' ?>>Angkot</option>
                            <option value="lainnya" <?= (isset($student['kk_address']['transport_mode']) && $student['kk_address']['transport_mode'] === 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Domisili Address -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-800 mb-3">Alamat Domisili</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="domisili_address_line" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                        <textarea id="domisili_address_line" name="domisili_address_line" required rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?= $student['domisili_address']['address_line'] ?? '' ?></textarea>
                    </div>

                    <div>
                        <label for="domisili_province" class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                        <input type="text" id="domisili_province" name="domisili_province" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['domisili_address']['province'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_regency" class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                        <input type="text" id="domisili_regency" name="domisili_regency" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['domisili_address']['regency'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_district" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                        <input type="text" id="domisili_district" name="domisili_district" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['domisili_address']['district'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_village" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa *</label>
                        <input type="text" id="domisili_village" name="domisili_village" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['domisili_address']['village'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos *</label>
                        <input type="text" id="domisili_postal_code" name="domisili_postal_code" required maxlength="5"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['domisili_address']['postal_code'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_distance_km" class="block text-sm font-medium text-gray-700 mb-1">Jarak dari Madrasah (km)</label>
                        <input type="number" id="domisili_distance_km" name="domisili_distance_km" step="0.1" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['domisili_address']['distance_km'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="domisili_transport_mode" class="block text-sm font-medium text-gray-700 mb-1">Moda Transportasi *</label>
                        <select id="domisili_transport_mode" name="domisili_transport_mode" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Moda Transportasi</option>
                            <option value="jalan_kaki" <?= (isset($student['domisili_address']['transport_mode']) && $student['domisili_address']['transport_mode'] === 'jalan_kaki') ? 'selected' : '' ?>>Jalan Kaki</option>
                            <option value="sepeda" <?= (isset($student['domisili_address']['transport_mode']) && $student['domisili_address']['transport_mode'] === 'sepeda') ? 'selected' : '' ?>>Sepeda</option>
                            <option value="motor" <?= (isset($student['domisili_address']['transport_mode']) && $student['domisili_address']['transport_mode'] === 'motor') ? 'selected' : '' ?>>Motor</option>
                            <option value="mobil" <?= (isset($student['domisili_address']['transport_mode']) && $student['domisili_address']['transport_mode'] === 'mobil') ? 'selected' : '' ?>>Mobil</option>
                            <option value="angkot" <?= (isset($student['domisili_address']['transport_mode']) && $student['domisili_address']['transport_mode'] === 'angkot') ? 'selected' : '' ?>>Angkot</option>
                            <option value="lainnya" <?= (isset($student['domisili_address']['transport_mode']) && $student['domisili_address']['transport_mode'] === 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Parents Information -->
        <div class="step hidden" id="step-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Orang Tua</h3>

            <!-- Father Information -->
            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                <h4 class="font-medium text-gray-800 mb-3">Data Ayah</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="father_full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="father_full_name" name="father_full_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['father']['full_name'] ?? '' ?>">
                        <input type="hidden" id="father_relation" name="father_relation" value="ayah">
                    </div>

                    <div>
                        <label for="father_nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                        <input type="text" id="father_nik" name="father_nik" required maxlength="16"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['father']['nik'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="father_education" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan *</label>
                        <select id="father_education" name="father_education" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD" <?= (isset($student['father']['education']) && $student['father']['education'] === 'SD') ? 'selected' : '' ?>>SD</option>
                            <option value="SMP" <?= (isset($student['father']['education']) && $student['father']['education'] === 'SMP') ? 'selected' : '' ?>>SMP</option>
                            <option value="SMA" <?= (isset($student['father']['education']) && $student['father']['education'] === 'SMA') ? 'selected' : '' ?>>SMA</option>
                            <option value="D1" <?= (isset($student['father']['education']) && $student['father']['education'] === 'D1') ? 'selected' : '' ?>>D1</option>
                            <option value="D2" <?= (isset($student['father']['education']) && $student['father']['education'] === 'D2') ? 'selected' : '' ?>>D2</option>
                            <option value="D3" <?= (isset($student['father']['education']) && $student['father']['education'] === 'D3') ? 'selected' : '' ?>>D3</option>
                            <option value="S1" <?= (isset($student['father']['education']) && $student['father']['education'] === 'S1') ? 'selected' : '' ?>>S1</option>
                            <option value="S2" <?= (isset($student['father']['education']) && $student['father']['education'] === 'S2') ? 'selected' : '' ?>>S2</option>
                            <option value="S3" <?= (isset($student['father']['education']) && $student['father']['education'] === 'S3') ? 'selected' : '' ?>>S3</option>
                            <option value="Lainnya" <?= (isset($student['father']['education']) && $student['father']['education'] === 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="father_occupation" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan *</label>
                        <input type="text" id="father_occupation" name="father_occupation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['father']['occupation'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="father_monthly_income" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan Bulanan</label>
                        <input type="number" id="father_monthly_income" name="father_monthly_income" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['father']['monthly_income'] ?? '' ?>">
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
                            value="<?= $student['mother']['full_name'] ?? '' ?>">
                        <input type="hidden" id="mother_relation" name="mother_relation" value="ibu">
                    </div>

                    <div>
                        <label for="mother_nik" class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                        <input type="text" id="mother_nik" name="mother_nik" required maxlength="16"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['mother']['nik'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="mother_education" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan *</label>
                        <select id="mother_education" name="mother_education" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'SD') ? 'selected' : '' ?>>SD</option>
                            <option value="SMP" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'SMP') ? 'selected' : '' ?>>SMP</option>
                            <option value="SMA" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'SMA') ? 'selected' : '' ?>>SMA</option>
                            <option value="D1" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'D1') ? 'selected' : '' ?>>D1</option>
                            <option value="D2" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'D2') ? 'selected' : '' ?>>D2</option>
                            <option value="D3" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'D3') ? 'selected' : '' ?>>D3</option>
                            <option value="S1" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'S1') ? 'selected' : '' ?>>S1</option>
                            <option value="S2" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'S2') ? 'selected' : '' ?>>S2</option>
                            <option value="S3" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'S3') ? 'selected' : '' ?>>S3</option>
                            <option value="Lainnya" <?= (isset($student['mother']['education']) && $student['mother']['education'] === 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="mother_occupation" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan *</label>
                        <input type="text" id="mother_occupation" name="mother_occupation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['mother']['occupation'] ?? '' ?>">
                    </div>

                    <div>
                        <label for="mother_monthly_income" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan Bulanan</label>
                        <input type="number" id="mother_monthly_income" name="mother_monthly_income" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="<?= $student['mother']['monthly_income'] ?? '' ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Family Card Information -->
        <div class="step hidden" id="step-5">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Kartu Keluarga</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="kk_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu Keluarga *</label>
                    <input type="text" id="kk_number" name="kk_number" required maxlength="16"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="<?= $student['family_card']['kk_number'] ?? '' ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between mt-8">
        <button type="button" id="prevBtn" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 hidden">
            Sebelumnya
        </button>
        <button type="button" id="nextBtn" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Selanjutnya
        </button>
        <button type="button" id="submitBtn" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 hidden">
            Kirim Formulir
        </button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentStep = 1;
    const totalSteps = 5;

    document.addEventListener('DOMContentLoaded', function() {
        showStep(currentStep);
        
        // Next button event
        document.getElementById('nextBtn').addEventListener('click', function() {
            if (validateStep(currentStep)) {
                if (currentStep === 1) {
                    // For step 1, save personal data first
                    savePersonalData().then(success => {
                        if (success) {
                            if (currentStep < totalSteps) {
                                currentStep++;
                                showStep(currentStep);
                            }
                        }
                    });
                } else {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        showStep(currentStep);
                    }
                }
            }
        });
        
        // Previous button event
        document.getElementById('prevBtn').addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
        
        // Submit button event
        document.getElementById('submitBtn').addEventListener('click', function() {
            submitForm();
        });

        // "Sama dengan Alamat KK" checkbox logic
        document.getElementById('same_as_kk').addEventListener('change', function() {
            const isChecked = this.checked;
            const kkFields = {
                address_line: document.getElementById('kk_address_line'),
                province: document.getElementById('kk_province'),
                regency: document.getElementById('kk_regency'),
                district: document.getElementById('kk_district'),
                village: document.getElementById('kk_village'),
                postal_code: document.getElementById('kk_postal_code'),
                distance_km: document.getElementById('kk_distance_km'),
                transport_mode: document.getElementById('kk_transport_mode'),
            };

            const domisiliFields = {
                address_line: document.getElementById('domisili_address_line'),
                province: document.getElementById('domisili_province'),
                regency: document.getElementById('domisili_regency'),
                district: document.getElementById('domisili_district'),
                village: document.getElementById('domisili_village'),
                postal_code: document.getElementById('domisili_postal_code'),
                distance_km: document.getElementById('domisili_distance_km'),
                transport_mode: document.getElementById('domisili_transport_mode'),
            };

            for (const key in domisiliFields) {
                if (isChecked) {
                    domisiliFields[key].value = kkFields[key].value;
                    domisiliFields[key].setAttribute('disabled', 'disabled');
                } else {
                    domisiliFields[key].removeAttribute('disabled');
                    domisiliFields[key].value = ''; // Reset the value
                }
            }
        });
    });

    function showStep(step) {
        // Hide all steps
        document.querySelectorAll('.step').forEach(stepEl => {
            stepEl.classList.add('hidden');
        });
        
        // Show current step
        document.getElementById('step-' + step).classList.remove('hidden');
        
        // Update progress bar
        const progressPercentage = (step / totalSteps) * 100;
        document.getElementById('progress-line').style.width = progressPercentage + '%';
        
        // Update step indicators
        document.querySelectorAll('.step-indicator').forEach(indicator => {
            const indicatorStep = parseInt(indicator.getAttribute('data-step'));
            const circle = indicator.querySelector('div');
            const text = indicator.querySelector('span');
            
            if (indicatorStep < step) {
                circle.classList.remove('bg-gray-200', 'text-gray-500');
                circle.classList.add('bg-green-500', 'text-white');
            } else if (indicatorStep === step) {
                circle.classList.remove('bg-gray-200', 'text-gray-500');
                circle.classList.add('bg-blue-500', 'text-white');
            } else {
                circle.classList.remove('bg-blue-500', 'bg-green-500', 'text-white');
                circle.classList.add('bg-gray-200', 'text-gray-500');
            }
        });
        
        // Show/hide buttons
        if (step === 1) {
            document.getElementById('prevBtn').classList.add('hidden');
        } else {
            document.getElementById('prevBtn').classList.remove('hidden');
        }
        
        if (step === totalSteps) {
            document.getElementById('nextBtn').classList.add('hidden');
            document.getElementById('submitBtn').classList.remove('hidden');
        } else {
            document.getElementById('nextBtn').classList.remove('hidden');
            document.getElementById('submitBtn').classList.add('hidden');
        }
    }

    function validateStep(step) {
        let isValid = true;
        const currentStepEl = document.getElementById('step-' + step);
        const requiredFields = currentStepEl.querySelectorAll('[required]:not([disabled])');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        return isValid;
    }

    function showMessage(type, message) {
        Swal.fire({
            icon: type,
            title: type === 'success' ? 'Berhasil' : (type === 'error' ? 'Error' : 'Info'),
            html: message,
            showConfirmButton: true,
            timer: type === 'success' ? 3000 : null
        });
    }

    function savePersonalData() {
        return new Promise((resolve) => {
            // Submit personal data via AJAX
            const formData = new FormData(document.getElementById('registrationForm'));
            
            fetch('/student/save-personal', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update the hidden student_id field with the returned ID
                    document.getElementById('student_id').value = data.student_id;
                    showMessage('success', data.message);
                    resolve(true);
                } else {
                    let errorMessage = data.message;
                    if (data.errors) {
                        errorMessage += '<br><br>Detail kesalahan:<br>' + Object.values(data.errors).join('<br>');
                    }
                    showMessage('error', errorMessage);
                    resolve(false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'Terjadi kesalahan saat menyimpan data pribadi. Silakan coba lagi.');
                resolve(false);
            });
        });
    }

    function submitForm() {
        // Submit the form via AJAX
        const formData = new FormData(document.getElementById('registrationForm'));

        fetch('/student/submit-final', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showMessage('success', data.message);
                    setTimeout(() => {
                        window.location.href = '/student/dashboard';
                    }, 2000);
                } else {
                    let errorMessage = data.message;
                    if (data.errors) {
                        errorMessage += '<br><br>Detail kesalahan:<br>' + Object.values(data.errors).join('<br>');
                    }
                    showMessage('error', errorMessage);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'Terjadi kesalahan saat mengirim formulir. Silakan coba lagi.');
            });
    }
</script>

<?= $this->endSection() ?>