<?php

// Script untuk reset password massal semua user
// Cara menjalankan: php reset_passwords.php

echo "Reset Password Massal\n";
echo "====================\n\n";

// Konfigurasi database dari file .env
$db_hostname = 'localhost';
$db_username = 'root';
$db_password = '';
$db_database = 'fresh-ppdb';
$db_port = 3306;

try {
    // Membuat koneksi ke database
    $pdo = new PDO("mysql:host=$db_hostname;port=$db_port;dbname=$db_database;charset=utf8mb4", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage() . "\n";
    exit(1);
}

// Ambil semua user dari tabel users
try {
    $stmt = $pdo->query("SELECT id, username, email, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Gagal mengambil data user: " . $e->getMessage() . "\n";
    exit(1);
}

if (empty($users)) {
    echo "Tidak ada user ditemukan.\n";
    exit;
}

echo "Ditemukan " . count($users) . " user.\n\n";

// Konfirmasi
echo "Apakah Anda yakin ingin mereset password semua user? (y/N): ";
$handle = fopen("php://stdin", "r");
$input = trim(fgets($handle));
fclose($handle);

if (strtolower($input) !== 'y') {
    echo "Operasi dibatalkan.\n";
    exit;
}

// Fungsi untuk mendapatkan password default berdasarkan role
function getDefaultPassword($role) {
    switch ($role) {
        case 'siswa':
            return 'siswa123';
        case 'panitia':
            return 'panitia123';
        case 'admin':
            return 'admin123';
        case 'kepala_sekolah':
            return 'kepala123';
        default:
            return 'default123';
    }
}

$successCount = 0;
$errorCount = 0;

echo "\nProses reset password:\n";
echo "--------------------\n";

foreach ($users as $user) {
    $defaultPassword = getDefaultPassword($user['role']);
    $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
    
    // Update password dan set first_login = 1
    try {
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ?, first_login = 1 WHERE id = ?");
        $result = $stmt->execute([$hashedPassword, $user['id']]);
        
        if ($result) {
            echo "✓ Reset password untuk user {$user['username']} ({$user['role']})\n";
            $successCount++;
        } else {
            echo "✗ Gagal reset password untuk user {$user['username']}\n";
            $errorCount++;
        }
    } catch (PDOException $e) {
        echo "✗ Error untuk user {$user['username']}: " . $e->getMessage() . "\n";
        $errorCount++;
    }
}

echo "\n====================\n";
echo "Proses selesai:\n";
echo "Berhasil: $successCount\n";
echo "Gagal: $errorCount\n";
echo "Total: " . ($successCount + $errorCount) . "\n";

echo "\nPassword default berdasarkan role:\n";
echo "- siswa: siswa123\n";
echo "- panitia: panitia123\n";
echo "- admin: admin123\n";
echo "- kepala_sekolah: kepala123\n";
echo "\nSetelah reset, semua user harus mengganti password saat login pertama kali.\n";