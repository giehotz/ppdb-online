-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2025 at 07:31 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `address_type` enum('kk','domisili') COLLATE utf8mb4_general_ci NOT NULL,
  `address_line` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `regency` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `district` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `village` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `distance_km` decimal(5,2) NOT NULL,
  `transport_mode` enum('jalan_kaki','sepeda','motor','mobil','angkot','lainnya') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int UNSIGNED NOT NULL,
  `actor_user_id` int UNSIGNED NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `entity_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `entity_id` int NOT NULL,
  `before_json` text COLLATE utf8mb4_general_ci COMMENT 'Full row snapshot atau hanya changed fields',
  `after_json` text COLLATE utf8mb4_general_ci COMMENT 'Full row snapshot atau hanya changed fields',
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_posts`
--

CREATE TABLE `cms_posts` (
  `id` int UNSIGNED NOT NULL,
  `type` enum('announcement','info','page') COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `attachment_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `publish_at` datetime DEFAULT NULL,
  `author_id` int UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_posts`
--

INSERT INTO `cms_posts` (`id`, `type`, `title`, `slug`, `content`, `attachment_path`, `status`, `publish_at`, `author_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'announcement', 'Pengumuman Pembukaan PPDB Tahun Ajaran 2025/2026', 'pengumuman-pembukaan-ppdb-2025-2026', '<p>Dengan ini kami umumkan bahwa Penerimaan Peserta Didik Baru (PPDB) MIN 2 Tanggamus untuk tahun ajaran 2025/2026 telah dibuka. Kami mengundang para calon peserta didik untuk mendaftar mulai tanggal 1 September 2025 hingga 30 Juni 2026.</p>\n                              <p>Syarat pendaftaran:\n                              <ul>\n                                <li>Fotokopi akta kelahiran</li>\n                                <li>Fotokopi kartu keluarga</li>\n                                <li>Pas foto 3x4 sebanyak 2 lembar</li>\n                                <li>Surat keterangan lulus dari jenjang sebelumnya</li>\n                              </ul>\n                              </p>', NULL, 'published', '2025-08-28 10:07:46', 1, NULL, NULL, NULL),
(2, 'info', 'Persyaratan Pendaftaran Siswa Baru', 'persyaratan-pendaftaran-siswa-baru', '<p>Berikut adalah persyaratan pendaftaran yang harus dipenuhi oleh calon peserta didik:</p>\n                              <ol>\n                                <li>Warga Negara Indonesia (WNI)</li>\n                                <li>Beragama Islam</li>\n                                <li>Berusia maksimal 12 tahun pada awal Juli 2025</li>\n                                <li>Dalam keadaan sehat jasmani dan rohani</li>\n                                <li>Memiliki prestasi akademik dan non-akademik yang baik</li>\n                              </ol>\n                              <p>Calon peserta didik diwajibkan membawa dokumen asli dan fotokopi saat verifikasi berkas.</p>', NULL, 'published', '2025-08-28 10:07:46', 1, NULL, NULL, NULL),
(3, 'page', 'Tentang MIN 2 Tanggamus', 'tentang-min-2-tanggamus', '<p>Madrasah Ibtidaiyah Negeri (MIN) 2 Tanggamus merupakan lembaga pendidikan dasar di bawah naungan Kementerian Agama Republik Indonesia. Berdiri sejak tahun 1980, MIN 2 Tanggamus telah melahirkan banyak alumni yang berprestasi dan berkontribusi dalam berbagai bidang.</p>\n                              <h3>Visi</h3>\n                              <p>Terwujudnya Madrasah yang unggul dalam prestasi, berakhlak mulia, dan berwawasan kebangsaan berlandaskan iman dan taqwa.</p>\n                              <h3>Misi</h3>\n                              <ul>\n                                <li>Menyelenggarakan pendidikan yang berkualitas</li>\n                                <li>Meningkatkan penghayatan dan pengamalan terhadap ajaran agama Islam</li>\n                                <li>Mengembangkan sikap disiplin, tanggung jawab, dan mandiri</li>\n                                <li>Menumbuhkan rasa cinta tanah air dan persatuan bangsa</li>\n                                <li>Meningkatkan potensi diri melalui kegiatan ekstrakurikuler</li>\n                              </ul>', NULL, 'published', '2025-08-28 10:07:46', 1, NULL, NULL, NULL),
(4, 'announcement', 'Jadwal Seleksi PPDB 2025/2026', 'jadwal-seleksi-ppdb-2025-2026', '<p>Berikut adalah jadwal seleksi PPDB MIN 2 Tanggamus tahun ajaran 2025/2026:</p>\n                              <table class=\"table table-bordered\">\n                                <tr>\n                                  <th>Kegiatan</th>\n                                  <th>Tanggal</th>\n                                  <th>Waktu</th>\n                                </tr>\n                                <tr>\n                                  <td>Pendaftaran Online</td>\n                                  <td>1 September - 30 Juni 2026</td>\n                                  <td>24 Jam</td>\n                                </tr>\n                                <tr>\n                                  <td>Verifikasi Berkas</td>\n                                  <td>5-10 Juli 2026</td>\n                                  <td>08.00-15.00 WIB</td>\n                                </tr>\n                                <tr>\n                                  <td>Tes Masuk</td>\n                                  <td>15 Juli 2026</td>\n                                  <td>08.00-12.00 WIB</td>\n                                </tr>\n                                <tr>\n                                  <td>Pengumuman Hasil</td>\n                                  <td>20 Juli 2026</td>\n                                  <td>10.00 WIB</td>\n                                </tr>\n                              </table>', NULL, 'published', '2025-08-28 10:07:46', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `doc_type` enum('birth_certificate','family_card','photo','rapor','kip','other') COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `size_bytes` int NOT NULL,
  `status` enum('uploaded','verified','rejected') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'uploaded',
  `notes` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uploaded_by` int UNSIGNED NOT NULL,
  `uploaded_at` datetime NOT NULL,
  `verified_by` int UNSIGNED DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `family_cards`
--

CREATE TABLE `family_cards` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `kk_number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(16, '2025-08-26-141816', 'App\\Database\\Migrations\\Users', 'default', 'App', 1756253547, 1),
(17, '2025-08-26-141822', 'App\\Database\\Migrations\\Students', 'default', 'App', 1756253548, 1),
(18, '2025-08-26-141846', 'App\\Database\\Migrations\\PriorSchools', 'default', 'App', 1756253548, 1),
(19, '2025-08-26-141851', 'App\\Database\\Migrations\\Addresses', 'default', 'App', 1756253549, 1),
(20, '2025-08-26-141857', 'App\\Database\\Migrations\\SpecialNeeds', 'default', 'App', 1756253549, 1),
(21, '2025-08-26-141902', 'App\\Database\\Migrations\\StudentSpecialNeeds', 'default', 'App', 1756253550, 1),
(22, '2025-08-26-141909', 'App\\Database\\Migrations\\Parents', 'default', 'App', 1756253550, 1),
(23, '2025-08-26-141913', 'App\\Database\\Migrations\\FamilyCards', 'default', 'App', 1756253551, 1),
(24, '2025-08-26-141918', 'App\\Database\\Migrations\\Documents', 'default', 'App', 1756253551, 1),
(25, '2025-08-26-141923', 'App\\Database\\Migrations\\Submissions', 'default', 'App', 1756253552, 1),
(26, '2025-08-26-141927', 'App\\Database\\Migrations\\CmsPosts', 'default', 'App', 1756253553, 1),
(27, '2025-08-26-141932', 'App\\Database\\Migrations\\Settings', 'default', 'App', 1756253553, 1),
(28, '2025-08-26-141954', 'App\\Database\\Migrations\\AuditLogs', 'default', 'App', 1756253554, 1),
(29, '2025-08-26-141959', 'App\\Database\\Migrations\\Sequences', 'default', 'App', 1756253554, 1),
(30, '2025-08-27-000000', 'App\\Database\\Migrations\\CreateAuthTokenLogins', 'default', 'App', 1756253555, 1),
(31, '2025-08-27-000001', 'App\\Database\\Migrations\\CreateAuthTables', 'default', 'App', 1756253787, 2),
(32, '2025-08-27-000002', 'App\\Database\\Migrations\\FixAuthTables', 'default', 'App', 1756254798, 3),
(33, '2025-08-27-000003', 'App\\Database\\Migrations\\AddUsernameToUsers', 'default', 'App', 1756255468, 4),
(34, '2025-08-27-000004', 'App\\Database\\Migrations\\RemoveRoleFromUsers', 'default', 'App', 1756280811, 5),
(35, '2025-08-27-080000', 'App\\Database\\Migrations\\CreateMissingAuthTables', 'default', 'App', 1756280961, 6),
(36, '2025-08-27-080001', 'App\\Database\\Migrations\\CreateAuthLoginsTable', 'default', 'App', 1756281627, 7),
(37, '2025-08-27-090000', 'App\\Database\\Migrations\\AddLastActiveToUsers', 'default', 'App', 1756343993, 8),
(38, '2025-08-28-000000', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1756344056, 9),
(41, '2025-08-28-010000', 'App\\Database\\Migrations\\RemoveShieldAndCreateUsersTable', 'default', 'App', 1756344449, 10),
(42, '2025-08-28-020000', 'App\\Database\\Migrations\\CreateUsersTableForCustomAuth', 'default', 'App', 1756345468, 11),
(45, '2025-08-28-030000', 'App\\Database\\Migrations\\RemoveShieldTablesAndCreateUsers', 'default', 'App', 1756346538, 12),
(46, '2025-08-28-040000', 'App\\Database\\Migrations\\AddDeletedAtToUsers', 'default', 'App', 1756349778, 13);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `relation` enum('ayah','ibu','wali') COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `education` enum('SD','SMP','SMA','D1','D2','D3','S1','S2','S3','Lainnya') COLLATE utf8mb4_general_ci NOT NULL,
  `occupation` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `monthly_income` decimal(12,2) DEFAULT NULL COMMENT 'Dalam rupiah full nominal',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prior_schools`
--

CREATE TABLE `prior_schools` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `school_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `school_level` enum('TK','RA','SD','Lainnya') COLLATE utf8mb4_general_ci NOT NULL,
  `school_type` enum('negeri','swasta') COLLATE utf8mb4_general_ci NOT NULL,
  `accreditation_status` enum('terakreditasi','tidak_terakreditasi','unknown') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unknown',
  `city` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sequences`
--

CREATE TABLE `sequences` (
  `period` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `counter` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(31) COLLATE utf8mb4_general_ci DEFAULT 'string',
  `context` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `special_needs`
--

CREATE TABLE `special_needs` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_needs`
--

INSERT INTO `special_needs` (`id`, `code`, `label`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'tuna_rungu', 'Tuna Rungu', NULL, NULL, NULL),
(2, 'tuna_netra', 'Tuna Netra', NULL, NULL, NULL),
(3, 'tuna_daksa', 'Tuna Daksa', NULL, NULL, NULL),
(4, 'tuna_grahita', 'Tuna Grahita', NULL, NULL, NULL),
(5, 'tuna_laras', 'Tuna Laras', NULL, NULL, NULL),
(6, 'lamban_belajar', 'Lamban Belajar', NULL, NULL, NULL),
(7, 'sulit_belajar', 'Sulit Belajar', NULL, NULL, NULL),
(8, 'gangguan_komunikasi', 'Gangguan Komunikasi', NULL, NULL, NULL),
(9, 'bakat_luar_biasa', 'Bakat Luar Biasa', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL COMMENT 'nullable jika dibuat panitia untuk siswa offline',
  `nis_local` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nisn` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `birth_place` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL,
  `class_level` int NOT NULL COMMENT '1..6',
  `parallel_class` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `attendance_no` int DEFAULT NULL,
  `class_rank` int DEFAULT NULL,
  `student_status` enum('baru','pindahan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'baru',
  `hobby` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aspiration` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `siblings_count` int NOT NULL DEFAULT '0',
  `submission_state` enum('draft','submitted') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `submitted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_special_needs`
--

CREATE TABLE `student_special_needs` (
  `student_id` int UNSIGNED NOT NULL,
  `special_need_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `registration_no` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('menunggu_verifikasi','terverifikasi','diterima','cadangan','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu_verifikasi',
  `rejection_reason` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `verified_by` int UNSIGNED DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','siswa','panitia','kepala_sekolah') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'siswa',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$9DmDeiq0WJMjj/kgx1rzXe6Yjha0TXj5IG5EuFvzHiiBJIa9etgMq', 'admin', '2025-08-28 02:03:49', '2025-08-28 02:03:49', NULL),
(2, 'minduatanggamuss', 'min2tanggamus@gmail.com', '$2y$10$cSz4sM6gm3ngijGis.2QTuVdkvESs2pV1pjq02uspMv1nYOufuYLC', 'panitia', '2025-08-28 16:28:22', '2025-08-28 16:28:22', NULL),
(4, 'panitia', 'panitia@example.com', '$2y$10$cpkjVwDVFzeSRaYP0NhZ0.gIZY9o9tZTOppZa6Yx3QnCWJV62aoyG', 'panitia', '2025-08-31 03:26:35', '2025-08-31 03:26:35', NULL),
(5, 'panitia1', 'panitia1@example.com', '$2y$10$3tyebtEjmV0RGNZnYHAWD.P4zLuNy6.2tXWu/cXmqeo.5udRzYZ0u', 'panitia', '2025-08-31 03:18:49', '2025-08-31 03:18:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor_user_id` (`actor_user_id`),
  ADD KEY `entity_type_entity_id` (`entity_type`,`entity_id`);

--
-- Indexes for table `cms_posts`
--
ALTER TABLE `cms_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `cms_posts_author_id_foreign` (`author_id`),
  ADD KEY `type` (`type`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `documents_verified_by_foreign` (`verified_by`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `family_cards`
--
ALTER TABLE `family_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kk_number` (`kk_number`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `prior_schools`
--
ALTER TABLE `prior_schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `sequences`
--
ALTER TABLE `sequences`
  ADD UNIQUE KEY `period` (`period`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `special_needs`
--
ALTER TABLE `special_needs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `full_name` (`full_name`),
  ADD KEY `birth_date` (`birth_date`);

--
-- Indexes for table `student_special_needs`
--
ALTER TABLE `student_special_needs`
  ADD PRIMARY KEY (`student_id`,`special_need_id`),
  ADD KEY `student_special_needs_special_need_id_foreign` (`special_need_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registration_no` (`registration_no`),
  ADD KEY `submissions_verified_by_foreign` (`verified_by`),
  ADD KEY `status` (`status`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_posts`
--
ALTER TABLE `cms_posts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_cards`
--
ALTER TABLE `family_cards`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prior_schools`
--
ALTER TABLE `prior_schools`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `special_needs`
--
ALTER TABLE `special_needs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_actor_user_id_foreign` FOREIGN KEY (`actor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `cms_posts`
--
ALTER TABLE `cms_posts`
  ADD CONSTRAINT `cms_posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `documents_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `documents_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `family_cards`
--
ALTER TABLE `family_cards`
  ADD CONSTRAINT `family_cards_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `prior_schools`
--
ALTER TABLE `prior_schools`
  ADD CONSTRAINT `prior_schools_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `student_special_needs`
--
ALTER TABLE `student_special_needs`
  ADD CONSTRAINT `student_special_needs_special_need_id_foreign` FOREIGN KEY (`special_need_id`) REFERENCES `special_needs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_special_needs_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `submissions_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
