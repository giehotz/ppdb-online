<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulir Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .header img {
            width: 80px;
            height: 80px;
            float: left;
            margin-right: 20px;
        }
        
        .header-text {
            text-align: center;
        }
        
        .header-text h1 {
            margin: 0;
            font-size: 18px;
        }
        
        .header-text h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        
        .header-text p {
            margin: 2px 0;
            font-size: 11px;
        }
        
        .clear {
            clear: both;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            background-color: #e0e0e0;
            padding: 5px 10px;
            font-weight: bold;
            border: 1px solid #000;
            margin-bottom: 10px;
        }
        
        .row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .col {
            flex: 1;
            padding: 0 10px;
        }
        
        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }
        
        .value {
            display: inline-block;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table, th, td {
            border: 1px solid #000;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f0f0f0;
        }
        
        .photo {
            width: 100px;
            height: 120px;
            border: 1px solid #000;
            float: right;
            margin: 10px;
            text-align: center;
            line-height: 120px;
            font-size: 10px;
            color: #999;
        }
        
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature {
            text-align: center;
            width: 45%;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-text">
            <h1>FORMULIR PENDAFTARAN PESERTA DIDIK BARU</h1>
            <h2>MIN 2 TANGGAMUS</h2>
            <p>Jl. Lintas Sumatera, Kota Agung, Kabupaten Tanggamus, Lampung</p>
            <p>Telp: (0729) 123456 | Email: min2tanggamus@example.com</p>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="section">
        <div class="section-title">DATA REGISTRASI</div>
        <div class="row">
            <div class="col">
                <span class="label">No. Registrasi:</span>
                <span class="value"><?= esc($submission['registration_no']) ?></span>
            </div>
            <div class="col">
                <span class="label">Tanggal Daftar:</span>
                <span class="value"><?= date('d F Y', strtotime($submission['created_at'])) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Status:</span>
                <span class="value">
                    <?php 
                    $statusLabels = [
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'terverifikasi' => 'Terverifikasi',
                        'diterima' => 'Diterima',
                        'cadangan' => 'Cadangan',
                        'ditolak' => 'Ditolak'
                    ];
                    echo $statusLabels[$submission['status']] ?? $submission['status'];
                    ?>
                </span>
            </div>
            <?php if ($submission['status'] === 'ditolak' && !empty($submission['rejection_reason'])): ?>
            <div class="col">
                <span class="label">Alasan Penolakan:</span>
                <span class="value"><?= esc($submission['rejection_reason']) ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">DATA PRIBADI SISWA</div>
        <?php if ($photo): ?>
        <div class="photo">
            PHOTO<br>(3x4)
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col">
                <span class="label">Nama Lengkap:</span>
                <span class="value"><?= esc($submission['full_name']) ?></span>
            </div>
            <div class="col">
                <span class="label">Username:</span>
                <span class="value"><?= esc($submission['username'] ?? '-') ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">NISN:</span>
                <span class="value"><?= esc($submission['nisn'] ?? '-') ?></span>
            </div>
            <div class="col">
                <span class="label">NIK:</span>
                <span class="value"><?= esc($submission['nik']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Tempat Lahir:</span>
                <span class="value"><?= esc($submission['birth_place']) ?></span>
            </div>
            <div class="col">
                <span class="label">Tanggal Lahir:</span>
                <span class="value"><?= date('d F Y', strtotime($submission['birth_date'])) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Jenis Kelamin:</span>
                <span class="value"><?= $submission['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
            </div>
            <div class="col">
                <span class="label">Kelas yang Dituju:</span>
                <span class="value"><?= esc($submission['class_level']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Kelas Paralel:</span>
                <span class="value"><?= esc($submission['parallel_class'] ?? '-') ?></span>
            </div>
            <div class="col">
                <span class="label">No. Absen:</span>
                <span class="value"><?= esc($submission['attendance_no'] ?? '-') ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Peringkat Kelas:</span>
                <span class="value"><?= esc($submission['class_rank'] ?? '-') ?></span>
            </div>
            <div class="col">
                <span class="label">Status Siswa:</span>
                <span class="value"><?= $submission['student_status'] === 'baru' ? 'Baru' : 'Pindahan' ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Hobi:</span>
                <span class="value"><?= esc($submission['hobby'] ?? '-') ?></span>
            </div>
            <div class="col">
                <span class="label">Cita-cita:</span>
                <span class="value"><?= esc($submission['aspiration'] ?? '-') ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Jumlah Saudara:</span>
                <span class="value"><?= esc($submission['siblings_count']) ?></span>
            </div>
        </div>
    </div>
    
    <?php if (!empty($addresses)): ?>
    <div class="section">
        <div class="section-title">DATA ALAMAT</div>
        <?php foreach ($addresses as $address): ?>
        <div class="row">
            <div class="col">
                <span class="label">Jenis Alamat:</span>
                <span class="value"><?= $address['type'] === 'kk' ? 'Kartu Keluarga' : 'Domisili' ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Alamat:</span>
                <span class="value"><?= esc($address['street_address'] ?? '-') ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Kelurahan/Desa:</span>
                <span class="value"><?= esc($address['village'] ?? '-') ?></span>
            </div>
            <div class="col">
                <span class="label">Kecamatan:</span>
                <span class="value"><?= esc($address['district'] ?? '-') ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Kabupaten/Kota:</span>
                <span class="value"><?= esc($address['regency'] ?? '-') ?></span>
            </div>
            <div class="col">
                <span class="label">Provinsi:</span>
                <span class="value"><?= esc($address['province'] ?? '-') ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Kode Pos:</span>
                <span class="value"><?= esc($address['postal_code'] ?? '-') ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($parents)): ?>
    <div class="section">
        <div class="section-title">DATA ORANG TUA/WALI</div>
        <?php foreach ($parents as $parent): ?>
        <div class="row">
            <div class="col">
                <span class="label">Hubungan:</span>
                <span class="value"><?= ucfirst($parent['relation']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Nama Lengkap:</span>
                <span class="value"><?= esc($parent['full_name']) ?></span>
            </div>
            <div class="col">
                <span class="label">NIK:</span>
                <span class="value"><?= esc($parent['nik']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Pendidikan:</span>
                <span class="value"><?= esc($parent['education']) ?></span>
            </div>
            <div class="col">
                <span class="label">Pekerjaan:</span>
                <span class="value"><?= esc($parent['occupation']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Penghasilan/Bulan:</span>
                <span class="value">Rp <?= number_format($parent['monthly_income'] ?? 0, 0, ',', '.') ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <?php if ($priorSchool): ?>
    <div class="section">
        <div class="section-title">DATA SEKOLAH ASAL</div>
        <div class="row">
            <div class="col">
                <span class="label">Nama Sekolah:</span>
                <span class="value"><?= esc($priorSchool['school_name']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Jenis Sekolah:</span>
                <span class="value"><?= $priorSchool['school_type'] === 'negeri' ? 'Negeri' : 'Swasta' ?></span>
            </div>
            <div class="col">
                <span class="label">Tahun Lulus:</span>
                <span class="value"><?= esc($priorSchool['graduation_year']) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Alamat Sekolah:</span>
                <span class="value"><?= esc($priorSchool['school_address']) ?></span>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="signature-section">
        <div class="signature">
            <p>Mengetahui,<br>Kepala Sekolah</p>
            <br><br><br>
            <p>(___________________________)</p>
        </div>
        <div class="signature">
            <p>Kota Agung, <?= date('d F Y') ?><br>Panitia PPDB</p>
            <br><br><br>
            <p>(___________________________)</p>
        </div>
    </div>
    
    <div class="footer">
        <p>Dicetak pada: <?= date('d F Y H:i:s') ?> | Sistem PPDB MIN 2 Tanggamus</p>
    </div>
</body>
</html>