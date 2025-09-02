<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pendaftaran</title>
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
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
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
        
        .content {
            margin: 20px 0;
        }
        
        .receipt-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .info-table td {
            padding: 8px;
        }
        
        .label {
            width: 30%;
            font-weight: bold;
        }
        
        .separator {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }
        
        .instructions {
            margin: 20px 0;
            padding: 10px;
            border: 1px dashed #000;
        }
        
        .instructions h3 {
            margin-top: 0;
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
        
        .qr-code {
            text-align: center;
            margin: 20px 0;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-text">
            <h1>BUKTI PENDAFTARAN</h1>
            <h2>MIN 2 TANGGAMUS</h2>
            <p>Jl. Lintas Sumatera, Kota Agung, Kabupaten Tanggamus, Lampung</p>
            <p>Telp: (0729) 123456 | Email: min2tanggamus@example.com</p>
        </div>
    </div>
    
    <div class="content">
        <div class="receipt-title">FORMULIR PENDAFTARAN PESERTA DIDIK BARU</div>
        
        <table class="info-table">
            <tr>
                <td class="label">No. Registrasi</td>
                <td>: <?= esc($submission['registration_no']) ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Daftar</td>
                <td>: <?= date('d F Y', strtotime($submission['created_at'])) ?></td>
            </tr>
            <tr>
                <td class="label">Nama Lengkap</td>
                <td>: <?= esc($submission['full_name']) ?></td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td>: <?= esc($submission['nisn'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td>: <?= esc($submission['nik']) ?></td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td>: <?= esc($submission['birth_place']) ?>, <?= date('d F Y', strtotime($submission['birth_date'])) ?></td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>: <?= $submission['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
            </tr>
        </table>
        
        <div class="separator">------------------------------</div>
        
        <div class="instructions">
            <h3>INFORMASI PENTING</h3>
            <ol>
                <li>Simpan bukti pendaftaran ini sebagai dokumen resmi pendaftaran Anda.</li>
                <li>Pastikan Anda mengecek status pendaftaran secara berkala di sistem PPDB MIN 2 Tanggamus.</li>
                <li>Jika status pendaftaran berubah menjadi "Diterima", segera melengkapi berkas administrasi sesuai jadwal yang telah ditentukan.</li>
                <li>Apabila ada pertanyaan, silakan menghubungi panitia PPDB di nomor (0729) 123456.</li>
            </ol>
        </div>
        
        <div class="qr-code">
            [KODE QR UNTUK VERIFIKASI]<br>
            Scan kode QR ini untuk memverifikasi keaslian dokumen
        </div>
    </div>
    
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