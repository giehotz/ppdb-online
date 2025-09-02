<?php
// Define navigation menus based on user roles
$menus = [];

if (session()->has('role')) {
    $role = session()->get('role');

    if ($role === 'siswa') {
        $menus = [
            ['url' => '/student/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
            ['url' => '/student/profile', 'label' => 'Profil Siswa', 'icon' => 'fas fa-user'],
            ['url' => '/student/documents', 'label' => 'Dokumen', 'icon' => 'fas fa-file'],
            ['url' => '/student/submission', 'label' => 'Pendaftaran', 'icon' => 'fas fa-edit'],
            ['url' => '/student/print-registration', 'label' => 'Cetak Formulir', 'icon' => 'fas fa-print'],
        ];
    } elseif ($role === 'panitia') {
        $menus = [
            ['url' => '/panitia/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
            ['url' => '/panitia/students', 'label' => 'Data Siswa', 'icon' => 'fas fa-users'],
            ['url' => '/panitia/verifications', 'label' => 'Verifikasi', 'icon' => 'fas fa-check-circle'],
            ['url' => '/panitia/reports', 'label' => 'Laporan', 'icon' => 'fas fa-chart-bar'],
        ];
    } elseif ($role === 'kepala_sekolah') {
        $menus = [
            ['url' => '/kepala/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
            ['url' => '/kepala/reports', 'label' => 'Laporan', 'icon' => 'fas fa-chart-bar'],
            ['url' => '/kepala/approvals', 'label' => 'Persetujuan', 'icon' => 'fas fa-thumbs-up'],
        ];
    } elseif ($role === 'admin') {
        $menus = [
            ['url' => '/admin/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
            ['url' => '/admin/users', 'label' => 'Manajemen User', 'icon' => 'fas fa-users-cog'],
            ['url' => '/admin/settings', 'label' => 'Pengaturan', 'icon' => 'fas fa-cog'],
        ];
    }
} else {
    // Public menu (for non-logged in users)
    $menus = [
        ['url' => '/', 'label' => 'Beranda', 'icon' => 'fas fa-home'],
        ['url' => '/announcement', 'label' => 'Pengumuman', 'icon' => 'fas fa-bullhorn'],
        ['url' => '/contact', 'label' => 'Kontak', 'icon' => 'fas fa-phone'],
    ];
}
