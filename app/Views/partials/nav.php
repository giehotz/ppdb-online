<?php
// Definisikan menu berdasarkan role
$menuConfig = [
    'siswa' => [
        ['url' => '/student/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
        ['url' => '/student/profile', 'label' => 'Profil Siswa', 'icon' => 'fas fa-user'],
        ['url' => '/student/documents', 'label' => 'Dokumen', 'icon' => 'fas fa-file'],
        ['url' => '/student/submission', 'label' => 'Pendaftaran', 'icon' => 'fas fa-edit'],
        ['url' => '/student/print-registration', 'label' => 'Cetak Formulir', 'icon' => 'fas fa-print'],
    ],
    'panitia' => [
        ['url' => '/panitia/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
        ['url' => '/panitia/students', 'label' => 'Data Siswa', 'icon' => 'fas fa-users'],
        ['url' => '/panitia/verifications', 'label' => 'Verifikasi', 'icon' => 'fas fa-check-circle'],
        ['url' => '/panitia/reports', 'label' => 'Laporan', 'icon' => 'fas fa-chart-bar'],
    ],
    'kepala_sekolah' => [
        ['url' => '/kepala/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
        ['url' => '/kepala/reports', 'label' => 'Laporan', 'icon' => 'fas fa-chart-bar'],
        ['url' => '/kepala/approvals', 'label' => 'Persetujuan', 'icon' => 'fas fa-thumbs-up'],
    ],
    'admin' => [
        ['url' => '/admin/dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-home'],
        ['url' => '/admin/users', 'label' => 'Manajemen User', 'icon' => 'fas fa-users-cog'],
        ['url' => '/admin/madrasah-profile', 'label' => 'Profil Madrasah', 'icon' => 'fas fa-school'],
        ['url' => '/admin/academic-years', 'label' => 'Tahun Akademik', 'icon' => 'fas fa-calendar-alt'],
        ['url' => '/admin/settings', 'label' => 'Pengaturan', 'icon' => 'fas fa-cog'],
    ],
    'public' => [
        ['url' => '/', 'label' => 'Beranda', 'icon' => 'fas fa-home'],
        ['url' => '/announcement', 'label' => 'Pengumuman', 'icon' => 'fas fa-bullhorn'],
        ['url' => '/contact', 'label' => 'Kontak', 'icon' => 'fas fa-phone'],
    ]
];

// Ambil role dari session
$role = session()->get('role') ?? 'public';

// Tentukan menu sesuai role
$menus = $menuConfig[$role] ?? $menuConfig['public'];
