-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Apr 2026 pada 11.09
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengaduan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `nama`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Andre.id', '$2y$12$7FVnykQzyK8p/ThG3/Ee1O/7w/sYg/mVDIpIGUTJnKKCe2swbGC0y', '2026-04-08 19:04:45', '2026-04-09 01:25:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` bigint(20) UNSIGNED NOT NULL,
  `id_pelaporan` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Menunggu','Proses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `siswa_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `id_pelaporan`, `status`, `id_kategori`, `feedback`, `siswa_feedback`, `created_at`, `updated_at`) VALUES
(8, 9, 'Proses', 1, 'waw makasih', 'camacama', '2026-04-09 00:14:13', '2026-04-09 00:18:22'),
(9, 10, 'Selesai', 1, 'waw makasih', NULL, '2026-04-09 00:15:24', '2026-04-09 00:15:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `id_pelaporan` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `foto`, `tanggal`, `created_at`, `updated_at`) VALUES
(9, '12345678', 1, 'perpustakaan', 'tempanya sangat nyaman', '1775717682.jpg', '2026-03-09', '2026-04-08 23:54:42', '2026-04-08 23:54:42'),
(10, '12345678', 1, 'ruang kelas', 'sangat bersih', '1775717891.jpg', '2026-02-23', '2026-04-08 23:58:11', '2026-04-08 23:58:11'),
(11, '12345678', 4, 'Kelas A16', 'presentasi', '1775718671.jpg', '2026-04-03', '2026-04-09 00:11:11', '2026-04-09 00:11:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `ket_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Kebersihan', '2026-04-08 19:04:45', '2026-04-08 19:04:45'),
(2, 'Keselamatan', '2026-04-08 19:04:45', '2026-04-08 19:04:45'),
(3, 'Fasilitas', '2026-04-08 19:04:45', '2026-04-08 19:04:45'),
(4, 'Pembelajaran', '2026-04-08 19:04:45', '2026-04-08 19:04:45'),
(5, 'Administrasi', '2026-04-08 19:04:45', '2026-04-08 19:04:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(14, '2026_04_09_000002_change_feedback_to_text_in_aspirasi', 2),
(16, '0001_01_01_000000_create_users_table', 3),
(17, '0001_01_01_000001_create_cache_table', 3),
(18, '0001_01_01_000002_create_jobs_table', 3),
(19, '2026_04_07_022752_create_siswa_table', 3),
(20, '2026_04_07_022823_create_admin_table', 3),
(21, '2026_04_07_022846_create_kategori_table', 3),
(22, '2026_04_07_022919_create_input_aspirasi_table', 3),
(23, '2026_04_07_022940_create_aspirasi_table', 3),
(24, '2026_04_07_083605_add_nis_to_aspirasi_table', 3),
(25, '2026_04_07_083754_update_aspirasi_table', 3),
(26, '2026_04_07_090350_add_foto_tanggal_to_aspirasi_table', 3),
(27, '2026_04_09_000001_add_username_to_users_table', 3),
(28, '2026_04_09_000002_fix_aspirasi_schema', 3),
(29, '2026_04_09_000004_add_siswa_feedback_to_aspirasi', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nis`, `kelas`, `password`, `created_at`, `updated_at`) VALUES
('111111', 'xll rpl 1', '$2y$12$L/BHgBrNrW/P2p9Ex6Wuh.IHlW8m3mjLpf6deLdU73eokK2De6FRW', '2026-04-08 21:43:33', '2026-04-08 21:43:33'),
('1111111', 'xll rpl 11', '$2y$12$jjJ.GRFMnEGnNl4.N.xY5uOVjTZcTHepu7U7rdRaWq/Q9C6eNDmFe', '2026-04-08 21:46:33', '2026-04-08 21:46:33'),
('12345678', 'xll rpl 2', '$2y$12$iSCXA1Dh/W3Gceb.i10fs.ho5HAxAksWbDEBe7ez0.Qs4iOTVNa9q', '2026-04-08 22:31:24', '2026-04-08 22:31:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `aspirasi_id_pelaporan_foreign` (`id_pelaporan`),
  ADD KEY `aspirasi_id_kategori_foreign` (`id_kategori`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD KEY `input_aspirasi_nis_foreign` (`nis`),
  ADD KEY `input_aspirasi_id_kategori_foreign` (`id_kategori`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `id_pelaporan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE,
  ADD CONSTRAINT `aspirasi_id_pelaporan_foreign` FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD CONSTRAINT `input_aspirasi_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE,
  ADD CONSTRAINT `input_aspirasi_nis_foreign` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
