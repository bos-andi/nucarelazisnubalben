-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2025 pada 17.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lazisnubalongbendo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `excerpt` text NOT NULL,
  `body` longtext NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `article_tag`
--

CREATE TABLE `article_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_highlighted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `color`, `description`, `is_highlighted`, `created_at`, `updated_at`) VALUES
(2, 'Program Sosial', 'program-sosial', '#16a34a', 'Gerakan sosial Lazisnu untuk pemberdayaan umat.', 1, '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(3, 'Kesehatan', 'kesehatan', '#0ea5e9', 'Layanan kesehatan dan rumah sehat NU.', 1, '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(4, 'Pendidikan', 'pendidikan', '#a855f7', 'Beasiswa dan penguatan madrasah/ponpes.', 1, '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(5, 'Ekonomi', 'ekonomi', '#f97316', 'Program kemandirian ekonomi warga.', 1, '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(6, 'Respon Bencana', 'respon-bencana', '#ef4444', 'Kesiapsiagaan dan tanggap darurat banjir, longsor, dll.', 0, '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(7, 'Lingkungan', 'lingkungan', '#65a30d', 'Ekonomi hijau dan gerakan hijau NU.', 1, '2025-11-25 10:02:16', '2025-11-25 10:02:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact_settings`
--

CREATE TABLE `contact_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `header_subtitle` varchar(255) NOT NULL DEFAULT 'Hubungi Kami',
  `header_title` varchar(255) NOT NULL DEFAULT 'Sapa Tim Lazisnu Balongbendo',
  `header_description` text NOT NULL DEFAULT 'Kami siap membantu kolaborasi program kebaikan, penyaluran zakat, hingga publikasi berita komunitas Nahdliyin.',
  `office_title` varchar(255) NOT NULL DEFAULT 'Sekretariat & Layanan',
  `office_address` text NOT NULL DEFAULT 'Jl. KH. Hasyim Asyari No. 12, Balongbendo, Sidoarjo',
  `office_hours` varchar(255) NOT NULL DEFAULT 'Senin - Sabtu, 08.00 - 16.00 WIB',
  `phone` varchar(255) NOT NULL DEFAULT '0813-1234-5678',
  `email` varchar(255) NOT NULL DEFAULT 'media@lazisnubalongbendo.or.id',
  `instagram` varchar(255) NOT NULL DEFAULT '@lazisnu.balongbendo',
  `facebook` varchar(255) NOT NULL DEFAULT 'Lazisnu Balongbendo',
  `whatsapp_number` varchar(255) NOT NULL DEFAULT '6281312345678',
  `whatsapp_text` varchar(255) NOT NULL DEFAULT 'Chat WhatsApp',
  `map_embed_url` text DEFAULT NULL,
  `show_map` tinyint(1) NOT NULL DEFAULT 1,
  `form_subtitle` varchar(255) NOT NULL DEFAULT 'Formulir Singkat',
  `form_title` varchar(255) NOT NULL DEFAULT 'Kirim kebutuhan programmu',
  `form_description` text NOT NULL DEFAULT 'Isi data berikut, tim kami akan menghubungi maksimal 1x24 jam kerja.',
  `form_action_url` varchar(255) DEFAULT NULL,
  `form_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contact_settings`
--

INSERT INTO `contact_settings` (`id`, `header_subtitle`, `header_title`, `header_description`, `office_title`, `office_address`, `office_hours`, `phone`, `email`, `instagram`, `facebook`, `whatsapp_number`, `whatsapp_text`, `map_embed_url`, `show_map`, `form_subtitle`, `form_title`, `form_description`, `form_action_url`, `form_enabled`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hubungi Kami', 'Sapa Tim Lazisnu Balongbendo', 'Kami siap membantu kolaborasi program kebaikan, penyaluran zakat, hingga publikasi berita komunitas Nahdliyin.', 'Sekretariat & Layanan', 'Jln. Mayjen Bambang Yuwono Desa Suwaluh Kec. Balongbendo Kab. Sidoarjo Kode Pos 61263', '-', '0895339840307', 'media@lazisnubalongbendo.or.id', '@lazisnu.balongbendo', 'Lazisnu Balongbendo', '6281312345678', 'Chat WhatsApp', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.27933698717007!2d112.5393400451143!3d-7.41318745088172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78093bd20f5619%3A0x384f560b560a9a5c!2sJl.%20Raya%20Balongbendo%20No.140%2C%20Suwaluh%20Utara%2C%20Suwaluh%2C%20Kec.%20BalongBendo%2C%20Kabupaten%20Sidoarjo%2C%20Jawa%20Timur%2061263!5e0!3m2!1sen!2sid!4v1764129306123!5m2!1sen!2sid', 1, 'Formulir Singkat', 'Kirim kebutuhan programmu', 'Isi data berikut, tim kami akan menghubungi maksimal 1x24 jam kerja.', 'https://formspree.io/f/xknlqqre', 1, 1, '2025-11-25 20:41:38', '2025-11-27 03:32:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_items`
--

CREATE TABLE `gallery_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('photo','video') NOT NULL,
  `media_url` varchar(255) NOT NULL,
  `photos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`photos`)),
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `khutbah_jumats`
--

CREATE TABLE `khutbah_jumats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `khutbah_date` date NOT NULL,
  `khatib` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_01_000000_create_categories_table', 1),
(6, '2025_11_25_111419_create_articles_table', 1),
(7, '2025_11_25_113906_create_tags_table', 1),
(8, '2025_11_25_113916_create_article_tag_table', 1),
(9, '2025_11_25_114004_create_gallery_items_table', 1),
(10, '2025_11_25_173958_add_views_to_articles_table', 2),
(11, '2025_11_25_174344_add_avatar_to_users_table', 3),
(12, '2025_11_25_183610_create_site_settings_table', 4),
(13, '2025_11_25_192703_add_approval_fields_to_users_table', 5),
(14, '2025_11_25_193253_create_programs_table', 6),
(15, '2025_11_26_024004_create_organization_settings_table', 7),
(16, '2025_11_26_033529_create_contact_settings_table', 8),
(17, '2025_11_26_044145_create_vision_mission_settings_table', 9),
(18, '2025_11_26_055006_create_visitor_statistics_table', 10),
(19, '2025_11_26_060450_create_system_updates_table', 11),
(20, '2025_11_26_103529_add_ktp_fields_to_users_table', 12),
(21, '2025_11_26_105049_add_thumbnail_to_articles_table', 13),
(22, '2025_11_26_165354_add_photos_to_gallery_items_table', 14),
(23, '2025_11_27_060000_create_khutbah_jumats_table', 15),
(24, '2025_11_26_233312_merge_arabic_and_indonesian_content_in_khutbah_jumats_table', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `organization_settings`
--

CREATE TABLE `organization_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `image` varchar(255) DEFAULT NULL,
  `chairman_photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `organization_settings`
--

INSERT INTO `organization_settings` (`id`, `key`, `title`, `content`, `data`, `image`, `chairman_photo`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'welcome_message', 'Sambutan Ketua', 'Assalamualaikum warahmatullahi wabarakatuh.\r\n\r\nAlhamdulillah, atas ridha Allah SWT dan dukungan keluarga besar Nahdliyin, Lazisnu Balongbendo terus meluaskan jangkauan program: dari sedekah pagi, respon kebencanaan, hingga beasiswa santri produktif.\r\n\r\nSemua bergerak karena jejaring ranting, banom, dan para dermawan yang istiqamah menebar manfaat. Di tengah tantangan iklim dan ekonomi, kami percaya gerakan hijau ala NU adalah ikhtiar menjaga bumi sekaligus memuliakan manusia.\r\n\r\nMari kuatkan kolaborasi, pastikan setiap rupiah zakat/infak sampai ke mustahik yang tepat, transparan, dan berdampak.\r\n\r\nWassalamualaikum warahmatullahi wabarakatuh.', NULL, NULL, NULL, 1, 1, '2025-11-25 19:49:01', '2025-11-25 19:49:01'),
(2, 'organization_structure', 'Struktur Organisasi', NULL, '{\"positions\":[{\"name\":\"bos andi\",\"title\":\"Pengembang Website\",\"description\":\"\",\"order\":20,\"is_chairman\":false,\"photo\":\"\\/storage\\/uploads\\/organization\\/position_0_1764125618_466zZnMAku.png\"}]}', NULL, NULL, 1, 2, '2025-11-25 19:49:08', '2025-11-25 19:53:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `programs`
--

INSERT INTO `programs` (`id`, `title`, `icon`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Sedekah Produktif', '🌱', 'Pemberdayaan UMKM hijau dengan modal bergulir dan pendampingan branding.', 1, 1, '2025-11-25 12:35:52', '2025-11-25 12:35:52'),
(2, 'Respon Cepat Bencana', '🤝', 'Gerak cepat relawan NU Peduli membawa logistik dan layanan kesehatan.', 1, 2, '2025-11-25 12:35:52', '2025-11-25 12:35:52'),
(3, 'Beasiswa Santri', '📚', 'Investasi pendidikan dengan pelatihan wirausaha digital bagi santri kreatif.', 1, 3, '2025-11-25 12:35:52', '2025-11-25 12:35:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `group`, `created_at`, `updated_at`) VALUES
(1, 'site_logo', '/storage/uploads/settings/logo_1764236216.png', 'image', 'general', '2025-11-25 11:37:58', '2025-11-27 02:36:59'),
(2, 'site_title', 'NU Care Lazisnu Balongbendo', 'text', 'general', '2025-11-25 11:37:58', '2025-11-25 12:07:01'),
(3, 'site_subtitle', 'Lazisnu MWC NU', 'text', 'general', '2025-11-25 11:37:58', '2025-11-25 11:37:58'),
(4, 'hero_title', 'Website Official NU Care Lazisnu Balongbendo', 'text', 'homepage', '2025-11-25 11:37:58', '2025-11-25 16:50:47'),
(5, 'hero_description', 'Menguatkan gerakan zakat, infak, sedekah, dan program sosial untuk menghadirkan kemandirian ekonomi umat.', 'textarea', 'homepage', '2025-11-25 11:37:58', '2025-11-25 11:37:58'),
(6, 'site_favicon', '/storage/uploads/settings/favicon_1764236219.png', 'image', 'general', '2025-11-25 11:50:13', '2025-11-27 02:36:59'),
(7, 'adsense_client_id', 'ca-pub-2382201505784677', 'text', 'adsense', '2025-11-25 12:11:01', '2025-11-25 12:11:01'),
(8, 'adsense_header_ad', NULL, 'textarea', 'adsense', '2025-11-25 12:11:01', '2025-11-25 12:11:01'),
(9, 'adsense_sidebar_ad', NULL, 'textarea', 'adsense', '2025-11-25 12:11:01', '2025-11-25 12:11:01'),
(10, 'adsense_article_ad', NULL, 'textarea', 'adsense', '2025-11-25 12:11:01', '2025-11-25 12:11:01'),
(11, 'adsense_footer_ad', NULL, 'textarea', 'adsense', '2025-11-25 12:11:01', '2025-11-25 12:11:01'),
(12, 'adsense_enabled', '1', 'text', 'adsense', '2025-11-25 12:11:01', '2025-11-25 12:11:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `system_updates`
--

CREATE TABLE `system_updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) DEFAULT NULL,
  `commit_hash` varchar(255) DEFAULT NULL,
  `branch` varchar(255) NOT NULL DEFAULT 'main',
  `description` text DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `status` enum('pending','in_progress','completed','failed','rolled_back') NOT NULL DEFAULT 'pending',
  `log` text DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `system_updates`
--

INSERT INTO `system_updates` (`id`, `version`, `commit_hash`, `branch`, `description`, `changes`, `status`, `log`, `error_message`, `updated_by`, `started_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'master', 'Manual update package generated', NULL, 'completed', 'Package generated: update-package-2025-11-26-170035.zip\nFiles: 1\nMigrations: 0', NULL, 2, NULL, '2025-11-26 10:00:35', '2025-11-26 10:00:35', '2025-11-26 10:00:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Zakat', 'zakat', '#0ea5e9', '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(2, 'Sedekah', 'sedekah', '#facc15', '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(3, 'Khutbah', 'khutbah', '#0ea5e9', '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(4, 'Santri', 'santri', '#facc15', '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(5, 'Ekonomi Hijau', 'ekonomi-hijau', '#10b981', '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(6, 'Respon Cepat', 'respon-cepat', '#10b981', '2025-11-25 10:02:16', '2025-11-25 10:02:16'),
(7, 'Digitalisasi', 'digitalisasi', '#facc15', '2025-11-25 10:02:16', '2025-11-25 10:02:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `ktp_file` varchar(255) DEFAULT NULL,
  `is_ktp_verified` tinyint(1) NOT NULL DEFAULT 0,
  `ktp_verified_at` timestamp NULL DEFAULT NULL,
  `ktp_verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'contributor',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `ktp_file`, `is_ktp_verified`, `ktp_verified_at`, `ktp_verified_by`, `email_verified_at`, `password`, `role`, `is_approved`, `approved_by`, `approved_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin Lazisnu', 'superadmin@lazisnubalongbendo.test', NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$l1ohXd2gimH3vSfscKJuN.OXRzQpuHujYaPd1oMCULOLF8Iyyv3Eq', 'superadmin', 1, NULL, '2025-11-25 12:30:33', NULL, '2025-11-25 10:02:16', '2025-11-25 12:30:33'),
(2, 'bos andi', 'ndiandie@gmail.com', '/storage/uploads/avatars/avatar_2_1764114276.jpg', NULL, 0, NULL, NULL, NULL, '$2y$12$cI1MNnAga1JT3aIbpZHJgufgpc33iThk1g2ptm.yjnnqoAUSH1vrS', 'superadmin', 1, NULL, '2025-11-25 12:30:33', NULL, '2025-11-25 10:02:16', '2025-11-26 03:31:53'),
(5, 'MISBAKHUL MUNIR', 'misbakhulm27@gmail.com', NULL, NULL, 0, NULL, NULL, NULL, '$2y$12$vmg3DkSxy1SPLWYSQrQT0uDjwo5Ybmxvk2EQ9f1AmjypQ0VS0XQPe', 'contributor', 1, 2, '2025-11-26 06:22:48', NULL, '2025-11-26 06:22:30', '2025-11-26 06:22:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vision_mission_settings`
--

CREATE TABLE `vision_mission_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vision` text NOT NULL DEFAULT 'Menjadi lembaga amil zakat terpercaya yang menghadirkan kemandirian ekonomi umat melalui pemberdayaan berkelanjutan dan transparansi pengelolaan dana sosial.',
  `mission` text NOT NULL DEFAULT '1. Menghimpun, mengelola, dan menyalurkan zakat, infak, sedekah secara amanah dan profesional.\n2. Memberdayakan mustahik melalui program ekonomi produktif dan pendampingan usaha.\n3. Mengembangkan program sosial yang berdampak langsung pada peningkatan kesejahteraan masyarakat.\n4. Membangun jaringan kemitraan strategis untuk memperluas jangkauan program kemanusiaan.\n5. Menerapkan tata kelola organisasi yang transparan dan akuntabel.',
  `background_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vision_mission_settings`
--

INSERT INTO `vision_mission_settings` (`id`, `vision`, `mission`, `background_image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Menjadi lembaga amil zakat terpercaya yang menghadirkan kemandirian ekonomi umat melalui pemberdayaan berkelanjutan dan transparansi pengelolaan dana sosial.', '1. Menghimpun, mengelola, dan menyalurkan zakat, infak, sedekah secara amanah dan profesional.\n2. Memberdayakan mustahik melalui program ekonomi produktif dan pendampingan usaha.\n3. Mengembangkan program sosial yang berdampak langsung pada peningkatan kesejahteraan masyarakat.\n4. Membangun jaringan kemitraan strategis untuk memperluas jangkauan program kemanusiaan.\n5. Menerapkan tata kelola organisasi yang transparan dan akuntabel.', NULL, 1, '2025-11-25 21:58:58', '2025-11-25 21:58:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visitor_statistics`
--

CREATE TABLE `visitor_statistics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `session_duration` int(11) NOT NULL DEFAULT 0,
  `is_unique_visitor` tinyint(1) NOT NULL DEFAULT 0,
  `visit_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visitor_statistics`
--

INSERT INTO `visitor_statistics` (`id`, `ip_address`, `user_agent`, `page_url`, `page_title`, `referrer`, `country`, `city`, `device_type`, `browser`, `os`, `session_duration`, `is_unique_visitor`, `visit_date`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 1, '2025-11-26', '2025-11-25 22:57:38', '2025-11-25 22:57:38'),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/berita', 'Berita', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-25 22:57:46', '2025-11-25 22:57:46'),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri', 'Galeri', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-25 22:57:52', '2025-11-25 22:57:52'),
(4, '182.8.98.171', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.6 Mobile/15E148 Safari/604.1', 'http://eeabb865db65.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Safari', 'macOS', 0, 1, '2025-11-26', '2025-11-25 22:59:09', '2025-11-25 22:59:09'),
(5, '182.8.98.171', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.6 Mobile/15E148 Safari/604.1', 'http://eeabb865db65.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'mobile', 'Safari', 'macOS', 0, 0, '2025-11-26', '2025-11-25 22:59:46', '2025-11-25 22:59:46'),
(6, '182.8.98.171', 'WhatsApp/2.23.20.0', 'http://eeabb865db65.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Unknown', 'Unknown', 0, 0, '2025-11-26', '2025-11-25 23:00:10', '2025-11-25 23:00:10'),
(7, '182.8.98.171', 'WhatsApp/2.23.20.0', 'http://eeabb865db65.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Unknown', 'Unknown', 0, 0, '2025-11-26', '2025-11-25 23:00:21', '2025-11-25 23:00:21'),
(8, '182.8.98.171', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://eeabb865db65.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-25 23:46:37', '2025-11-25 23:46:37'),
(9, '182.8.98.171', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://eeabb865db65.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-25 23:46:42', '2025-11-25 23:46:42'),
(10, '182.8.98.171', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://eeabb865db65.ngrok-free.app/berita', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-25 23:46:46', '2025-11-25 23:46:46'),
(11, '182.8.98.171', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://eeabb865db65.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-25 23:46:49', '2025-11-25 23:46:49'),
(12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 02:25:54', '2025-11-26 02:25:54'),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 02:26:12', '2025-11-26 02:26:12'),
(14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 02:43:27', '2025-11-26 02:43:27'),
(15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/login', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 02:43:37', '2025-11-26 02:43:37'),
(16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:32:32', '2025-11-26 03:32:32'),
(17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:32:47', '2025-11-26 03:32:47'),
(18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/dashboard/contributors', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:41:09', '2025-11-26 03:41:09'),
(19, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:41:15', '2025-11-26 03:41:15'),
(20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:48:58', '2025-11-26 03:48:58'),
(21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/author/2', 'Profil Penulis', 'http://127.0.0.1:8000/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:49:04', '2025-11-26 03:49:04'),
(22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/author/2', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:49:14', '2025-11-26 03:49:14'),
(23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/test-artikel-dengan-author-profile', 'Detail Artikel', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 03:49:21', '2025-11-26 03:49:21'),
(24, '182.8.98.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 05:54:11', '2025-11-26 05:54:11'),
(25, '182.8.98.171', 'WhatsApp/2.2546.3 W', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Unknown', 'Unknown', 0, 0, '2025-11-26', '2025-11-26 05:54:26', '2025-11-26 05:54:26'),
(26, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 05:55:22', '2025-11-26 05:55:22'),
(27, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 05:55:27', '2025-11-26 05:55:27'),
(28, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 05:55:44', '2025-11-26 05:55:44'),
(29, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/login', 'Halaman Website', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 05:56:19', '2025-11-26 05:56:19'),
(30, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 05:56:53', '2025-11-26 05:56:53'),
(31, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 05:57:20', '2025-11-26 05:57:20'),
(32, '64.233.173.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 05:57:25', '2025-11-26 05:57:25'),
(33, '64.233.172.226', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 05:57:26', '2025-11-26 05:57:26'),
(34, '64.233.172.225', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 05:57:27', '2025-11-26 05:57:27'),
(35, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 06:00:23', '2025-11-26 06:00:23'),
(36, '114.5.244.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 06:01:27', '2025-11-26 06:01:27'),
(37, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/visi-misi', 'Visi Misi', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:02:20', '2025-11-26 06:02:20'),
(38, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:02:35', '2025-11-26 06:02:35'),
(39, '114.8.225.77', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:03:02', '2025-11-26 06:03:02'),
(40, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:03:05', '2025-11-26 06:03:05'),
(41, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/kontak', 'Kontak', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:03:06', '2025-11-26 06:03:06'),
(42, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/struktur', 'Struktur Organisasi', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:03:32', '2025-11-26 06:03:32'),
(43, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/sambutan', 'Sambutan', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:03:48', '2025-11-26 06:03:48'),
(44, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/struktur', 'Struktur Organisasi', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:04:35', '2025-11-26 06:04:35'),
(45, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:11:08', '2025-11-26 06:11:08'),
(46, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/program', 'Program', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:11:39', '2025-11-26 06:11:39'),
(47, '182.8.98.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/login', 'Halaman Website', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:16:27', '2025-11-26 06:16:27'),
(48, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:18:19', '2025-11-26 06:18:19'),
(49, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/program', 'Program', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:18:23', '2025-11-26 06:18:23'),
(50, '117.103.171.4', 'Mozilla/5.0 (Linux; Android 14; Pixel 6 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.6261.119 Mobile Safari/537.36 OPR/81.2.4292.78581', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', 'https://www.google.com/', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 1, '2025-11-26', '2025-11-26 06:18:24', '2025-11-26 06:18:24'),
(51, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/kontak', 'Kontak', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:19:25', '2025-11-26 06:19:25'),
(52, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/sambutan', 'Sambutan', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:19:33', '2025-11-26 06:19:33'),
(53, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/register', 'Halaman Website', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:21:31', '2025-11-26 06:21:31'),
(54, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/register', 'Halaman Website', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:22:29', '2025-11-26 06:22:29'),
(55, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/login', 'Halaman Website', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:24:10', '2025-11-26 06:24:10'),
(56, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:25:16', '2025-11-26 06:25:16'),
(57, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/test-artikel-dengan-author-profile', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:25:25', '2025-11-26 06:25:25'),
(58, '114.8.225.77', 'WhatsApp/2.23.20.0', 'http://e5be5cabfb5c.ngrok-free.app/test-artikel-dengan-author-profile', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Unknown', 'Unknown', 0, 0, '2025-11-26', '2025-11-26 06:25:36', '2025-11-26 06:25:36'),
(59, '114.8.225.77', 'WhatsApp/2.23.20.0', 'http://e5be5cabfb5c.ngrok-free.app/test-artikel-dengan-author-profile', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Unknown', 'Unknown', 0, 0, '2025-11-26', '2025-11-26 06:25:36', '2025-11-26 06:25:36'),
(60, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:26:04', '2025-11-26 06:26:04'),
(61, '114.8.225.77', 'WhatsApp/2.23.20.0', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Unknown', 'Unknown', 0, 0, '2025-11-26', '2025-11-26 06:26:14', '2025-11-26 06:26:14'),
(62, '114.8.225.77', 'WhatsApp/2.23.20.0', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Unknown', 'Unknown', 0, 0, '2025-11-26', '2025-11-26 06:26:14', '2025-11-26 06:26:14'),
(63, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:27:47', '2025-11-26 06:27:47'),
(64, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:30:20', '2025-11-26 06:30:20'),
(65, '114.8.225.77', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:31:34', '2025-11-26 06:31:34'),
(66, '114.8.222.136', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/program', 'Program', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:31:44', '2025-11-26 06:31:44'),
(67, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 1, '2025-11-26', '2025-11-26 06:44:18', '2025-11-26 06:44:18'),
(68, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/struktur', 'Struktur Organisasi', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:44:29', '2025-11-26 06:44:29'),
(69, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:45:53', '2025-11-26 06:45:53'),
(70, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:46:35', '2025-11-26 06:46:35'),
(71, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita', 'Berita', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:46:52', '2025-11-26 06:46:52'),
(72, '114.5.244.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:49:24', '2025-11-26 06:49:24'),
(73, '114.5.244.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/visi-misi', 'Visi Misi', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:49:27', '2025-11-26 06:49:27'),
(74, '114.5.244.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/sambutan', 'Sambutan', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 06:49:29', '2025-11-26 06:49:29'),
(75, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:52:09', '2025-11-26 06:52:09'),
(76, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/sambutan', 'Sambutan', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:55:29', '2025-11-26 06:55:29'),
(77, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita?category=program-sosial', 'Berita', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:55:57', '2025-11-26 06:55:57'),
(78, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 06:56:14', '2025-11-26 06:56:14'),
(79, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:09:29', '2025-11-26 07:09:29'),
(80, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:09:35', '2025-11-26 07:09:35'),
(81, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/program', 'Program', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:18:08', '2025-11-26 07:18:08'),
(82, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/galeri', 'Galeri', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:18:47', '2025-11-26 07:18:47'),
(83, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/galeri/6', 'Detail Galeri', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:18:53', '2025-11-26 07:18:53'),
(84, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:19:20', '2025-11-26 07:19:20'),
(85, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:19:40', '2025-11-26 07:19:40'),
(86, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/author/2', 'Profil Penulis', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:19:47', '2025-11-26 07:19:47'),
(87, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:20:02', '2025-11-26 07:20:02'),
(88, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:20:26', '2025-11-26 07:20:26'),
(89, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:20:46', '2025-11-26 07:20:46'),
(90, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/visi-misi', 'Visi Misi', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:20:52', '2025-11-26 07:20:52'),
(91, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:20:57', '2025-11-26 07:20:57'),
(92, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/visi-misi', 'Visi Misi', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:10', '2025-11-26 07:23:10'),
(93, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:27', '2025-11-26 07:23:27'),
(94, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/galeri', 'Galeri', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:33', '2025-11-26 07:23:33'),
(95, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/sambutan', 'Sambutan', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:45', '2025-11-26 07:23:45'),
(96, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita?category=ekonomi', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:47', '2025-11-26 07:23:47'),
(97, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:49', '2025-11-26 07:23:49'),
(98, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/sambutan', 'Sambutan', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:52', '2025-11-26 07:23:52'),
(99, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita?category=ekonomi', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:53', '2025-11-26 07:23:53'),
(100, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/struktur', 'Struktur Organisasi', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:23:55', '2025-11-26 07:23:55'),
(101, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/kontak', 'Kontak', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:24:04', '2025-11-26 07:24:04'),
(102, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita?category=ekonomi', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:24:08', '2025-11-26 07:24:08'),
(103, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita', 'Berita', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:24:10', '2025-11-26 07:24:10'),
(104, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/visi-misi', 'Visi Misi', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:24:13', '2025-11-26 07:24:13'),
(105, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/kontak', 'Kontak', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:24:30', '2025-11-26 07:24:30'),
(106, '114.5.223.11', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/kontak', 'Kontak', NULL, NULL, NULL, 'desktop', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:24:37', '2025-11-26 07:24:37'),
(107, '114.5.223.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/kontak', 'Kontak', NULL, NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 07:25:01', '2025-11-26 07:25:01'),
(108, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:51:25', '2025-11-26 07:51:25'),
(109, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/berita', 'Berita', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:56:11', '2025-11-26 07:56:11'),
(110, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app/struktur', 'Struktur Organisasi', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:56:25', '2025-11-26 07:56:25'),
(111, '180.251.126.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://e5be5cabfb5c.ngrok-free.app', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 07:56:42', '2025-11-26 07:56:42'),
(112, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:51:20', '2025-11-26 09:51:20'),
(113, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:51:34', '2025-11-26 09:51:34'),
(114, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri', 'Galeri', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:51:55', '2025-11-26 09:51:55'),
(115, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri/6', 'Detail Galeri', 'http://127.0.0.1:8000/galeri', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:52:02', '2025-11-26 09:52:02'),
(116, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri/6', 'Detail Galeri', 'http://127.0.0.1:8000/galeri', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:56:00', '2025-11-26 09:56:00'),
(117, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:56:15', '2025-11-26 09:56:15'),
(118, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/dashboard/gallery', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:57:47', '2025-11-26 09:57:47'),
(119, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri', 'Galeri', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:57:51', '2025-11-26 09:57:51'),
(120, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri/8', 'Detail Galeri', 'http://127.0.0.1:8000/galeri', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:57:54', '2025-11-26 09:57:54'),
(121, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/galeri/8', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 09:58:32', '2025-11-26 09:58:32'),
(122, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/berita', 'Berita', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:02:28', '2025-11-26 10:02:28'),
(123, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/berita', 'Berita', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:05:11', '2025-11-26 10:05:11'),
(124, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', 'http://127.0.0.1:8000/berita', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:05:19', '2025-11-26 10:05:19'),
(125, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:05:27', '2025-11-26 10:05:27'),
(126, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:10:42', '2025-11-26 10:10:42'),
(127, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/berita?q=hari', 'Berita', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:10:52', '2025-11-26 10:10:52'),
(128, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/berita?q=hari', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:10:55', '2025-11-26 10:10:55'),
(129, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/berita?category=ekonomi', 'Berita', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:11:11', '2025-11-26 10:11:11'),
(130, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/visi-misi', 'Visi Misi', 'http://127.0.0.1:8000/berita?category=ekonomi', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:11:15', '2025-11-26 10:11:15'),
(131, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/visi-misi', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:11:20', '2025-11-26 10:11:20'),
(132, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/di-tangan-guru-masa-depan-dibangun-lazisnu-balongbendo-sampaikan-salam-apresiasi', 'Detail Artikel', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:11:33', '2025-11-26 10:11:33'),
(133, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/visi-misi', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:15:08', '2025-11-26 10:15:08'),
(134, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 10:15:13', '2025-11-26 10:15:13'),
(135, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 15:42:47', '2025-11-26 15:42:47'),
(136, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/berita?category=kesehatan', 'Berita', 'http://127.0.0.1:8000/', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 15:45:06', '2025-11-26 15:45:06'),
(137, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000/berita?category=kesehatan', 'Berita', 'http://127.0.0.1:8000/', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 15:45:07', '2025-11-26 15:45:07'),
(138, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/berita?category=kesehatan', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 15:45:11', '2025-11-26 15:45:11'),
(139, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 15:45:22', '2025-11-26 15:45:22'),
(140, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 15:45:22', '2025-11-26 15:45:22'),
(141, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 15:55:16', '2025-11-26 15:55:16'),
(142, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 15:55:26', '2025-11-26 15:55:26'),
(143, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 15:58:21', '2025-11-26 15:58:21'),
(144, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:01:05', '2025-11-26 16:01:05'),
(145, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:08:16', '2025-11-26 16:08:16'),
(146, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:09:48', '2025-11-26 16:09:48'),
(147, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 16:12:07', '2025-11-26 16:12:07'),
(148, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:12:17', '2025-11-26 16:12:17'),
(149, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:15:20', '2025-11-26 16:15:20'),
(150, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/berita?category=kesehatan', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 16:15:30', '2025-11-26 16:15:30'),
(151, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:19:53', '2025-11-26 16:19:53'),
(152, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/berita?category=kesehatan', NULL, NULL, 'mobile', 'Chrome', 'Linux', 0, 0, '2025-11-26', '2025-11-26 16:20:29', '2025-11-26 16:20:29'),
(153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/khutbah', 'Halaman Website', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:20:33', '2025-11-26 16:20:33'),
(154, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:20:56', '2025-11-26 16:20:56'),
(155, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:29:56', '2025-11-26 16:29:56'),
(156, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/login', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:30:04', '2025-11-26 16:30:04');
INSERT INTO `visitor_statistics` (`id`, `ip_address`, `user_agent`, `page_url`, `page_title`, `referrer`, `country`, `city`, `device_type`, `browser`, `os`, `session_duration`, `is_unique_visitor`, `visit_date`, `created_at`, `updated_at`) VALUES
(157, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/dashboard/khutbah', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:53:10', '2025-11-26 16:53:10'),
(158, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/login', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-26', '2025-11-26 16:53:18', '2025-11-26 16:53:18'),
(159, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/dashboard/system-updates', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 1, '2025-11-27', '2025-11-26 17:11:22', '2025-11-26 17:11:22'),
(160, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/program', 'Program', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 17:12:31', '2025-11-26 17:12:31'),
(161, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/dashboard/system-updates', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 17:13:00', '2025-11-26 17:13:00'),
(162, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/program', 'Program', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 17:13:08', '2025-11-26 17:13:08'),
(163, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/program', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 17:24:00', '2025-11-26 17:24:00'),
(164, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/login', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 17:58:46', '2025-11-26 17:58:46'),
(165, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/login', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 17:58:50', '2025-11-26 17:58:50'),
(166, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 19:25:49', '2025-11-26 19:25:49'),
(167, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/login', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 19:34:09', '2025-11-26 19:34:09'),
(168, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 19:34:12', '2025-11-26 19:34:12'),
(169, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-26 19:36:59', '2025-11-26 19:36:59'),
(170, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', NULL, NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 02:06:39', '2025-11-27 02:06:39'),
(171, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/login', 'Halaman Website', 'http://127.0.0.1:8000/adminlur', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 02:07:37', '2025-11-27 02:07:37'),
(172, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/dashboard/settings', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 02:37:05', '2025-11-27 02:37:05'),
(173, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 02:37:12', '2025-11-27 02:37:12'),
(174, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/program', 'Program', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 02:37:24', '2025-11-27 02:37:24'),
(175, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri', 'Galeri', 'http://127.0.0.1:8000/program', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 02:37:32', '2025-11-27 02:37:32'),
(176, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri/8', 'Detail Galeri', 'http://127.0.0.1:8000/galeri', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 02:37:37', '2025-11-27 02:37:37'),
(177, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/galeri/8', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 03:24:00', '2025-11-27 03:24:00'),
(178, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/galeri/8', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-11-27', '2025-11-27 03:32:07', '2025-11-27 03:32:07'),
(179, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/gallery/13', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 1, '2025-12-01', '2025-12-01 09:18:11', '2025-12-01 09:18:11'),
(180, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/program', 'Program', 'http://127.0.0.1:8000/', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-12-01', '2025-12-01 09:18:22', '2025-12-01 09:18:22'),
(181, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/galeri', 'Galeri', 'http://127.0.0.1:8000/program', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-12-01', '2025-12-01 09:18:24', '2025-12-01 09:18:24'),
(182, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/khutbah', 'Halaman Website', 'http://127.0.0.1:8000/galeri', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-12-01', '2025-12-01 09:18:26', '2025-12-01 09:18:26'),
(183, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'http://127.0.0.1:8000', 'Beranda', 'http://127.0.0.1:8000/khutbah', NULL, NULL, 'desktop', 'Chrome', 'Windows', 0, 0, '2025-12-01', '2025-12-01 09:18:28', '2025-12-01 09:18:28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_user_id_foreign` (`user_id`),
  ADD KEY `articles_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `article_tag`
--
ALTER TABLE `article_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_tag_article_id_tag_id_unique` (`article_id`,`tag_id`),
  ADD KEY `article_tag_tag_id_foreign` (`tag_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `contact_settings`
--
ALTER TABLE `contact_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_items_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `khutbah_jumats`
--
ALTER TABLE `khutbah_jumats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `khutbah_jumats_slug_unique` (`slug`),
  ADD KEY `khutbah_jumats_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `organization_settings`
--
ALTER TABLE `organization_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organization_settings_key_unique` (`key`),
  ADD KEY `organization_settings_key_is_active_index` (`key`,`is_active`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indeks untuk tabel `system_updates`
--
ALTER TABLE `system_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_updates_updated_by_foreign` (`updated_by`),
  ADD KEY `system_updates_status_created_at_index` (`status`,`created_at`);

--
-- Indeks untuk tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_approved_by_foreign` (`approved_by`),
  ADD KEY `users_ktp_verified_by_foreign` (`ktp_verified_by`);

--
-- Indeks untuk tabel `vision_mission_settings`
--
ALTER TABLE `vision_mission_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `visitor_statistics`
--
ALTER TABLE `visitor_statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_statistics_visit_date_ip_address_index` (`visit_date`,`ip_address`),
  ADD KEY `visitor_statistics_page_url_index` (`page_url`),
  ADD KEY `visitor_statistics_is_unique_visitor_index` (`is_unique_visitor`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `article_tag`
--
ALTER TABLE `article_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `contact_settings`
--
ALTER TABLE `contact_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gallery_items`
--
ALTER TABLE `gallery_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `khutbah_jumats`
--
ALTER TABLE `khutbah_jumats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `organization_settings`
--
ALTER TABLE `organization_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `system_updates`
--
ALTER TABLE `system_updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `vision_mission_settings`
--
ALTER TABLE `vision_mission_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `visitor_statistics`
--
ALTER TABLE `visitor_statistics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `article_tag_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD CONSTRAINT `gallery_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `khutbah_jumats`
--
ALTER TABLE `khutbah_jumats`
  ADD CONSTRAINT `khutbah_jumats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `system_updates`
--
ALTER TABLE `system_updates`
  ADD CONSTRAINT `system_updates_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ktp_verified_by_foreign` FOREIGN KEY (`ktp_verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
