<?php

// Script untuk memeriksa data user
// Cara menjalankan: php check_users.php

// Definisikan konstanta yang diperlukan
define('ROOTPATH', __DIR__);
define('APPPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'app');
define('SYSTEMPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'codeigniter4' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'system');
define('WRITEPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'writable');

// Load autoloader
require_once 'vendor/autoload.php';

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

// Ambil beberapa user dari tabel users
try {
    $stmt = $pdo->query("SELECT id, username, email, role, password_hash, first_login FROM users LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Gagal mengambil data user: " . $e->getMessage() . "\n";
    exit(1);
}

if (empty($users)) {
    echo "Tidak ada user ditemukan.\n";
    exit;
}

echo "Data User:\n";
echo str_repeat("=", 100) . "\n";
printf("%-5s %-20s %-30s %-15s %-10s %-15s\n", "ID", "Username", "Email", "Role", "FirstLogin", "HashLength");
echo str_repeat("-", 100) . "\n";

foreach ($users as $user) {
    printf("%-5s %-20s %-30s %-15s %-10s %-15s\n", 
        $user['id'], 
        $user['username'], 
        $user['email'], 
        $user['role'], 
        $user['first_login'], 
        strlen($user['password_hash'])
    );
}

echo str_repeat("=", 100) . "\n";

// Coba verifikasi password untuk user admin
echo "\nVerifikasi password untuk user admin:\n";
$stmt = $pdo->prepare("SELECT id, username, password_hash, first_login FROM users WHERE username = ?");
$stmt->execute(['admin']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "User ditemukan: " . $user['username'] . "\n";
    echo "Password hash: " . $user['password_hash'] . "\n";
    echo "Panjang hash: " . strlen($user['password_hash']) . "\n";
    echo "First login: " . $user['first_login'] . "\n";
    
    // Coba verifikasi password admin123
    if (strlen($user['password_hash']) === 32) {
        echo "Hash adalah MD5 (lama)\n";
        if (md5('admin123') === $user['password_hash']) {
            echo "Password 'admin123' cocok dengan hash MD5\n";
        } else {
            echo "Password 'admin123' TIDAK cocok dengan hash MD5\n";
        }
    } else {
        echo "Hash adalah bcrypt (baru)\n";
        if (password_verify('admin123', $user['password_hash'])) {
            echo "Password 'admin123' cocok dengan hash bcrypt\n";
        } else {
            echo "Password 'admin123' TIDAK cocok dengan hash bcrypt\n";
        }
    }
} else {
    echo "User admin tidak ditemukan\n";
}