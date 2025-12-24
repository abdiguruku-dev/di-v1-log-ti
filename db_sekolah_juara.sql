-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.4.3 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Membuang data untuk tabel db_sekolah_juara.app_settings: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.cache: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.card_templates: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.failed_jobs: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.jam_kbm: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.jobs: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.jurusans: ~1 rows (lebih kurang)
INSERT INTO `jurusans` (`id`, `kode_jurusan`, `nama_jurusan`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 'UMUM', 'Reguler / Umum', 'Jurusan standar untuk jenjang SD/SMP', '2025-12-12 02:17:41', NULL);

-- Membuang data untuk tabel db_sekolah_juara.kategori_jadwal: ~2 rows (lebih kurang)
INSERT INTO `kategori_jadwal` (`id`, `nama_jadwal`, `is_aktif`, `created_at`, `updated_at`) VALUES
	(1, 'Jadwal Normal (Senin-Jumat)', 1, '2025-12-15 01:25:45', NULL),
	(2, 'Jadwal Ramadhan', 0, '2025-12-14 18:51:46', NULL);

-- Membuang data untuk tabel db_sekolah_juara.kelas: ~1 rows (lebih kurang)
INSERT INTO `kelas` (`id`, `tahun_ajaran_id`, `nama_kelas`, `tingkat`, `jurusan_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '7A', 7, 1, '2025-12-12 22:26:13', NULL);

-- Membuang data untuk tabel db_sekolah_juara.kurikulums: ~5 rows (lebih kurang)
INSERT INTO `kurikulums` (`id`, `nama_kurikulum`, `tahun_mulai`, `label_periode`, `jumlah_periode`, `skala_nilai`, `batas_kkM`, `is_active`, `dokumen_pendukung`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 'Kurikulum 1975', '1975', 'Semester', 2, '0-10', 75, 1, NULL, NULL, '2025-12-13 02:42:51', NULL),
	(2, 'Kurikulum 1994', '1994', 'Caturwulan', 3, '0-10', 75, 1, NULL, NULL, '2025-12-13 02:42:51', NULL),
	(3, 'Kurikulum 2004 (KBK)', '2004', 'Semester', 2, '0-100', 75, 1, NULL, NULL, '2025-12-13 02:42:51', NULL),
	(4, 'Kurikulum 2013 (K-13)', '2013', 'Semester', 2, '0-100', 75, 1, NULL, NULL, '2025-12-13 02:42:51', NULL),
	(5, 'Kurikulum Merdeka', '2022', 'Semester', 2, '0-100', 75, 1, NULL, NULL, '2025-12-13 02:42:51', NULL);

-- Membuang data untuk tabel db_sekolah_juara.mata_pelajarans: ~1 rows (lebih kurang)
INSERT INTO `mata_pelajarans` (`id`, `kode_mapel`, `nama_mapel`, `nama_ringkas`, `kelompok`, `nomor_urut`, `jenjang`, `jurusan_id`, `is_active`, `created_at`, `updated_at`) VALUES
	(4, 'MTK', 'Matematika', 'MTK', 'A', 1, 'SMP', 1, 1, '2025-12-14 08:24:11', '2025-12-14 08:24:16');

-- Membuang data untuk tabel db_sekolah_juara.murids: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.parents: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.password_reset_tokens: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.pegawais: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.sekolah_configs: ~1 rows (lebih kurang)
INSERT INTO `sekolah_configs` (`id`, `nama_sekolah`, `mode_aplikasi`, `npsn`, `nss`, `jenjang`, `status_sekolah`, `akreditasi`, `alamat_jalan`, `desa_kelurahan`, `kecamatan`, `kabupaten_kota`, `provinsi`, `kode_pos`, `no_telp`, `email`, `website`, `kepala_sekolah`, `nip_kepala_sekolah`, `bendahara_sekolah`, `logo`, `kop_surat`, `stempel`, `created_at`, `updated_at`, `facebook`, `instagram`, `tiktok`, `youtube`, `twitter`, `alamat`, `telepon`, `nip_kepsek`) VALUES
	(1, 'YAYASAN INI ITU SAMA SAJA KAN', 'TUNGGAL', '-', 'KAMANKUM', 'SMP', NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin@YAYASAB.sch.id', 'yayasan.com', NULL, NULL, NULL, 'logo_utama_1765725434.png', NULL, NULL, '2025-12-12 02:43:53', '2025-12-14 08:17:33', 'fb unit', 'ig unit', 'tiktok unit', 'yt unit', NULL, 'NUSANTAEA', '111111', NULL);

-- Membuang data untuk tabel db_sekolah_juara.sekolah_units: ~1 rows (lebih kurang)
INSERT INTO `sekolah_units` (`id`, `sekolah_config_id`, `nama_unit`, `alamat_unit`, `jenjang`, `npsn`, `custom_domain`, `kepala_sekolah`, `nip_kepala_sekolah`, `email`, `no_telp`, `website`, `logo_unit`, `kop_surat_unit`, `created_at`, `updated_at`, `facebook`, `instagram`, `tiktok`, `youtube`, `twitter`) VALUES
	(1, 1, 'SMK Taman Karya Madya', 'Alamat Unit', 'SMK', NULL, 'smktamankarya.sch.id', 'Joko', '232112', 'admin@sekolah.sch.id', '124141', 'Sekolah.com', 'uploads/logo_unit/5h9PIdwCz36adRUunZi2JQu4C8lMZbMXrfT4XC8h.png', NULL, '2025-12-12 17:27:41', '2025-12-12 18:51:44', 'fb unit', 'ig unit', 'tiktok unit', 'yt unit', NULL);

-- Membuang data untuk tabel db_sekolah_juara.sessions: ~3 rows (lebih kurang)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('QRGh51DAuIrhu36u1spa9c4gFR2fhAtfiG2Cwr1C', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMmZMZXQ0azhhYnlkTUI2akxSem1ERkgwQTNOeEZTWGZqUVpOY3pBeiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vc2Vrb2xhaC1qdWFyYS50ZXN0L2FkbWluL211cmlkIjtzOjU6InJvdXRlIjtzOjE3OiJhZG1pbi5tdXJpZC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMzoibW9kZV9hcGxpa2FzaSI7czo3OiJUVU5HR0FMIjt9', 1765899985),
	('vl0VJH6aCZBKWyJeiI34siiOowTFx42ZHsyPTe9N', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHRyWmxmQnJmOXl1R1Q1aG1SU1Jtbk5qbXYzSVNLSGNhdGxndFlQeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9zZWtvbGFoLWp1YXJhLnRlc3QvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765888726),
	('w7IqgFh9Os9qs43Oy0XFRk6vOj1zoCLzDIEKbgKm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiY01qeDBXeG9KeExWeWNWNXZKSzluTGhhNWZUYUZsQkJWM2VxZ0FJbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9zZWtvbGFoLWp1YXJhLnRlc3QvYWRtaW4vbWFzdGVyL2p1cnVzYW4iO3M6NToicm91dGUiO3M6MTk6ImFkbWluLmp1cnVzYW4uaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTM6Im1vZGVfYXBsaWthc2kiO3M6NzoiVFVOR0dBTCI7fQ==', 1765880662);

-- Membuang data untuk tabel db_sekolah_juara.student_documents: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.student_photos: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.sys_sessions: ~0 rows (lebih kurang)

-- Membuang data untuk tabel db_sekolah_juara.tahun_ajarans: ~2 rows (lebih kurang)
INSERT INTO `tahun_ajarans` (`id`, `tahun_ajaran`, `semester`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, '2024/2025', 'Ganjil', 1, '2025-12-11 18:21:21', NULL),
	(4, '2024/2025', 'Genap', 0, '2025-12-14 08:07:12', NULL);

-- Membuang data untuk tabel db_sekolah_juara.unit_sekolah: ~2 rows (lebih kurang)
INSERT INTO `unit_sekolah` (`id`, `jenjang`, `nama_unit`, `alamat_unit`, `kepala_sekolah`, `nip_kepala_sekolah`, `email`, `no_telp`, `website`, `facebook`, `instagram`, `tiktok`, `youtube`, `custom_domain`, `logo`, `created_at`, `updated_at`) VALUES
	(1, 'SMK', 'SMK Taman Karya Madya', 'Jalan cinta', 'Joko', 'wd', 'akhyar@gmail.com', '124141', 'Sekolah.com', 'fb unit', 'ig unit', 'tiktok unit', 'yt unit', 'smktamankarya.sch.id', 'logo_unit_1765873838.png', '2025-12-16 00:28:53', '2025-12-16 01:31:14'),
	(2, 'SMA', 'SMK Taman Madya', 'dsf', 'fs', 'dsf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-16 01:32:21', NULL);

-- Membuang data untuk tabel db_sekolah_juara.users: ~1 rows (lebih kurang)
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `status_aktif`, `created_at`, `updated_at`, `unit_id`) VALUES
	(1, 'Super Administrator', 'admin', 'admin@sekolah.sch.id', '$2y$12$j/bnBDaNllOFdbuN8ejq8uvKIwmwTKyYlZ3PR.xZmvdhhtHiwzgdW', 'admin', 1, '2025-12-11 10:16:15', '2025-12-11 03:43:08', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
