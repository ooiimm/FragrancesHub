-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2026 at 10:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fragranceshub`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Parfum Pria', 'parfum-pria', 'Koleksi parfum eksklusif untuk pria modern', '2026-05-11 23:56:53', '2026-05-11 23:56:53'),
(2, 'Parfum Wanita', 'parfum-wanita', 'Koleksi parfum elegan untuk wanita', '2026-05-11 23:56:53', '2026-05-11 23:56:53'),
(3, 'Parfum Unisex', 'parfum-unisex', 'Parfum yang cocok untuk semua gender', '2026-05-11 23:56:53', '2026-05-11 23:56:53'),
(4, 'Parfum Mewah', 'parfum-mewah', 'Koleksi parfum premium dan eksklusif', '2026-05-11 23:56:53', '2026-05-11 23:56:53'),
(5, 'Parfum Lokal', 'parfum-lokal', 'Parfum berkualitas dari brand lokal Indonesia', '2026-05-11 23:56:53', '2026-05-11 23:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_09_162043_create_categories_table', 1),
(5, '2026_05_09_162101_create_products_table', 1),
(6, '2026_05_09_162336_create_carts_table', 1),
(7, '2026_05_09_162345_create_orders_table', 1),
(8, '2026_05_09_162354_create_order_items_table', 1),
(9, '2026_05_10_052442_create_payments_table', 1),
(10, '2026_01_01_000009_add_discount_to_product_table', 2),
(11, '2026_01_01_000009_add_discount_to_products_table', 3),
(12, '2026_07_04_000001_create_product_variants_table', 3),
(13, '2026_07_04_000002_add_featured_to_products_table', 3),
(14, '2026_07_04_000003_create_promos_table', 3),
(15, '2026_07_04_000004_update_payments_table_for_methods', 3),
(16, '2026_07_04_000005_update_orders_table_add_payment_method', 3),
(17, '2026_07_04_000006_add_variant_to_carts_table', 3),
(18, '2026_07_04_000007_add_variant_to_order_items_table', 3),
(19, '2026_07_05_000001_drop_old_cart_product_unique_index', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','waiting_payment','payment_uploaded','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL DEFAULT 'bank_transfer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `total_amount`, `shipping_address`, `phone`, `notes`, `status`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 3, 'ORD-6A03489E35AAE', 2122000.00, 'Lampung', '087541254888', NULL, 'processing', 'bank_transfer', '2026-05-12 08:34:54', '2026-05-12 08:39:34'),
(2, 4, 'ORD-6A046CF843F80', 680000.00, 'jombang', '087781944482', NULL, 'delivered', 'bank_transfer', '2026-05-13 05:22:16', '2026-05-13 05:23:47'),
(3, 3, 'ORD-6A0559EFB3249', 256500.00, 'Lampung', '087541254888', NULL, 'payment_uploaded', 'bank_transfer', '2026-05-13 22:13:19', '2026-05-13 22:15:35'),
(4, 3, 'ORD-6A056F6879CEF', 706500.00, 'Lampung', '087541254888', NULL, 'delivered', 'bank_transfer', '2026-05-13 23:44:56', '2026-05-13 23:47:14'),
(5, 3, 'ORD-6A05B887E491D', 297000.00, 'Lampung', '087541254888', NULL, 'delivered', 'bank_transfer', '2026-05-14 04:56:55', '2026-05-14 04:59:35'),
(6, 3, 'ORD-6A05BB684B9D2', 1465500.00, 'Lampung', '087541254888', NULL, 'delivered', 'bank_transfer', '2026-05-14 05:09:12', '2026-05-14 05:11:33'),
(7, 2, 'ORD-6A43EA2234432', 3798000.00, 'Jl. SURYA KENCANA NO 2984', '08123456789', NULL, 'delivered', 'bank_transfer', '2026-06-30 09:09:06', '2026-06-30 09:13:38'),
(8, 2, 'ORD-6A492B3F30FA9', 780000.00, 'Jl. SURYA KENCANA NO 2984', '08123456789', NULL, 'payment_uploaded', 'ovo', '2026-07-04 08:48:15', '2026-07-04 08:49:34'),
(9, 2, 'ORD-6A492CE3BABAB', 920000.00, 'Jl. SURYA KENCANA NO 2984', '08123456789', NULL, 'payment_uploaded', 'gopay', '2026-07-04 08:55:15', '2026-07-04 08:55:41'),
(10, 2, 'ORD-6A4943038B542', 442000.00, 'Jl. SURYA KENCANA NO 2984', '08123456789', NULL, 'payment_uploaded', 'ovo', '2026-07-04 10:29:39', '2026-07-04 10:32:53'),
(11, 3, 'ORD-6A4946BC2B8A4', 442000.00, 'Lampung Selatan', '087541254888', NULL, 'payment_uploaded', 'gopay', '2026-07-04 10:45:32', '2026-07-04 10:55:12'),
(12, 3, 'ORD-6A4949935E82F', 680000.00, 'Lampung', '087541254888', NULL, 'processing', 'bank_transfer', '2026-07-04 10:57:39', '2026-07-05 20:43:26'),
(13, 2, 'ORD-6A4B52731EF89', 442000.00, 'Jl. SURYA KENCANA NO 2984', '08123456789', NULL, 'cancelled', 'ovo', '2026-07-06 00:00:03', '2026-07-06 00:03:04'),
(14, 2, 'ORD-6A4B5624C7E3B', 442000.00, 'Jl. SURYA KENCANA NO 2984', '08123456789', NULL, 'cancelled', 'dana', '2026-07-06 00:15:48', '2026-07-06 00:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`, `product_variant_id`, `variant_size`) VALUES
(1, 1, 11, 'Arumanis', 265500.00, 1, 265500.00, '2026-05-12 08:34:54', '2026-05-12 08:34:54', NULL, NULL),
(2, 1, 10, 'Bamboe Roencing', 256500.00, 1, 256500.00, '2026-05-12 08:34:54', '2026-05-12 08:34:54', NULL, NULL),
(3, 1, 1, 'Sauvage Dior', 680000.00, 1, 680000.00, '2026-05-12 08:34:54', '2026-05-12 08:34:54', NULL, NULL),
(4, 1, 2, 'Bleu de Chanel', 920000.00, 1, 920000.00, '2026-05-12 08:34:54', '2026-05-12 08:34:54', NULL, NULL),
(5, 2, 1, 'Sauvage Dior', 680000.00, 1, 680000.00, '2026-05-13 05:22:16', '2026-05-13 05:22:16', NULL, NULL),
(6, 3, 10, 'Bamboe Roencing', 256500.00, 1, 256500.00, '2026-05-13 22:13:19', '2026-05-13 22:13:19', NULL, NULL),
(7, 4, 10, 'Bamboe Roencing', 256500.00, 1, 256500.00, '2026-05-13 23:44:56', '2026-05-13 23:44:56', NULL, NULL),
(8, 4, 5, 'CK One Calvin Klein', 450000.00, 1, 450000.00, '2026-05-13 23:44:56', '2026-05-13 23:44:56', NULL, NULL),
(9, 5, 9, 'Samosir', 297000.00, 1, 297000.00, '2026-05-14 04:56:55', '2026-05-14 04:56:55', NULL, NULL),
(10, 6, 11, 'Arumanis', 265500.00, 1, 265500.00, '2026-05-14 05:09:12', '2026-05-14 05:09:12', NULL, NULL),
(11, 6, 3, 'Chanel No. 5', 1200000.00, 1, 1200000.00, '2026-05-14 05:09:12', '2026-05-14 05:09:12', NULL, NULL),
(12, 7, 8, 'Le Labo \'Santal 33\'', 3798000.00, 1, 3798000.00, '2026-06-30 09:09:06', '2026-06-30 09:09:06', NULL, NULL),
(13, 8, 4, 'Miss Dior Blooming Bouquet', 780000.00, 1, 780000.00, '2026-07-04 08:48:15', '2026-07-04 08:48:15', NULL, NULL),
(14, 9, 2, 'Bleu de Chanel', 920000.00, 1, 920000.00, '2026-07-04 08:55:15', '2026-07-04 08:55:15', NULL, NULL),
(15, 10, 9, 'Samosir', 442000.00, 1, 442000.00, '2026-07-04 10:29:39', '2026-07-04 10:29:39', 1, '200ml'),
(16, 11, 9, 'Samosir', 442000.00, 1, 442000.00, '2026-07-04 10:45:32', '2026-07-04 10:45:32', 1, '200ml'),
(17, 12, 1, 'Sauvage Dior', 680000.00, 1, 680000.00, '2026-07-04 10:57:39', '2026-07-04 10:57:39', NULL, NULL),
(18, 13, 9, 'Samosir', 442000.00, 1, 442000.00, '2026-07-06 00:00:03', '2026-07-06 00:00:03', 1, '200ml'),
(19, 14, 9, 'Samosir', 442000.00, 1, 442000.00, '2026-07-06 00:15:48', '2026-07-06 00:15:48', 1, '200ml');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'bank_transfer',
  `phone_number` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `recipient_account` varchar(255) DEFAULT NULL,
  `payment_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `phone_number`, `amount`, `proof_image`, `status`, `notes`, `created_at`, `updated_at`, `recipient_name`, `recipient_account`, `payment_notes`) VALUES
(1, 1, 'bank_transfer', NULL, 2122000.00, 'payments/Nbp6PhU5EmQYkpcTNZfW00TNn2Lzp5qCWrMqnAXa.jpg', 'verified', NULL, '2026-05-12 08:34:54', '2026-05-12 22:25:47', NULL, NULL, NULL),
(2, 2, 'bank_transfer', NULL, 680000.00, 'payments/QbcGHYAWBiuTC3rV0lxRzLHwqbxNAo80pNBVQsxD.png', 'verified', NULL, '2026-05-13 05:22:16', '2026-05-13 05:23:23', NULL, NULL, NULL),
(3, 3, 'bank_transfer', NULL, 256500.00, 'payments/whUZRDbXWu6ZOpgsx1Gj6f7UPNvt0UKSXOoBc3Jr.png', 'pending', NULL, '2026-05-13 22:13:19', '2026-05-13 22:15:35', NULL, NULL, NULL),
(4, 4, 'bank_transfer', NULL, 706500.00, 'payments/lJ5ZAbQFzxU4NrC4bMhHCj4FCxTYW0WIa5OtTpb5.png', 'pending', NULL, '2026-05-13 23:44:56', '2026-05-13 23:45:15', NULL, NULL, NULL),
(5, 5, 'bank_transfer', NULL, 297000.00, 'payments/oBVjaCF8G9sAfsfuu1d7Emi5WI89JTrtQsfeI1Z0.jpg', 'verified', NULL, '2026-05-14 04:56:56', '2026-05-14 04:59:13', NULL, NULL, NULL),
(6, 6, 'bank_transfer', NULL, 1465500.00, 'payments/Ly3Y6pGdOtSxSNwsULtyh5JVEvMidx3Rs8bONUhn.jpg', 'pending', NULL, '2026-05-14 05:09:12', '2026-05-14 05:09:30', NULL, NULL, NULL),
(7, 7, 'bank_transfer', NULL, 3798000.00, 'payments/a28n1MQt0hnkzwZiNabah86e73a9RzQYQwJAHFTw.png', 'verified', NULL, '2026-06-30 09:09:06', '2026-06-30 09:13:31', NULL, NULL, NULL),
(8, 8, 'ovo', NULL, 780000.00, 'payments/CVTtD1PijVRIqJxVWVGb554XmXNS8WtOWaIRKAdP.jpg', 'pending', NULL, '2026-07-04 08:48:15', '2026-07-04 08:49:34', NULL, NULL, NULL),
(9, 9, 'gopay', NULL, 920000.00, 'payments/3lhkqMxZC2J1CVNJYHF70X6S8whIO2TSnEH9tx2s.jpg', 'pending', NULL, '2026-07-04 08:55:15', '2026-07-04 08:55:41', NULL, NULL, NULL),
(10, 10, 'ovo', '081908634683', 442000.00, 'payments/JXbViFtyGNu7XKOGaiK2hMf49dfmk6LQc0A2YCro.jpg', 'pending', NULL, '2026-07-04 10:29:39', '2026-07-04 10:32:53', NULL, NULL, '📱 INSTRUKSI PEMBAYARAN OVO:\n\n1. Buka aplikasi OVO Anda\n2. Pilih Menu Pembayaran/Transfer\n3. Cari merchant \'FragrancesHub Store\'\n4. Masukkan Nominal: Rp 442.000\n5. Masukkan PIN/Password Anda\n6. Selesaikan pembayaran\n7. Simpan bukti pembayaran\n8. Upload bukti di halaman pesanan Anda'),
(11, 11, 'gopay', '087775554664', 442000.00, 'payments/iJCeOwU1e4EyP6vdCwFFl89ITLHxIyYjzbRRRmVe.jpg', 'pending', NULL, '2026-07-04 10:45:32', '2026-07-04 10:55:12', NULL, NULL, '📱 INSTRUKSI PEMBAYARAN GOPAY:\n\n1. Buka aplikasi GOPAY Anda\n2. Pilih Menu Pembayaran/Transfer\n3. Cari merchant \'FragrancesHub Store\'\n4. Masukkan Nominal: Rp 442.000\n5. Masukkan PIN/Password Anda\n6. Selesaikan pembayaran\n7. Simpan bukti pembayaran\n8. Upload bukti di halaman pesanan Anda'),
(12, 12, 'bank_transfer', NULL, 680000.00, 'payments/rlarWn2VPZNdmIdZEIthhgGgMSS90sm13w7cmwIC.jpg', 'verified', NULL, '2026-07-04 10:57:39', '2026-07-05 20:43:26', 'FragrancesHub Store', '6801397384 (BCA)', '📋 INSTRUKSI TRANSFER BANK:\n\n1. Buka aplikasi perbankan Anda (BCA, Mandiri, BNI, etc)\n2. Pilih Transfer/Kirim Uang\n3. Pilih Transfer Antar Bank\n4. Masukkan Data:\n   - Nomor Rekening: 6801397384\n   - Atas Nama: FragrancesHub Store\n   - Nominal: Rp 680.000\n5. Konfirmasi dan selesaikan transfer\n6. Simpan bukti transfer\n7. Upload bukti di halaman pesanan Anda'),
(13, 13, 'ovo', '08123456789', 442000.00, 'payments/C5Uox38dGJwmhvdhSiodMyUBSvGqNUhkUBEQdbg0.jpg', 'verified', NULL, '2026-07-06 00:00:03', '2026-07-06 00:02:28', NULL, NULL, '📱 INSTRUKSI PEMBAYARAN OVO:\n\n1. Buka aplikasi OVO Anda\n2. Pilih Menu Pembayaran/Transfer\n3. Cari merchant \'FragrancesHub Store\'\n4. Masukkan Nominal: Rp 442.000\n5. Masukkan PIN/Password Anda\n6. Selesaikan pembayaran\n7. Simpan bukti pembayaran\n8. Upload bukti di halaman pesanan Anda'),
(14, 14, 'dana', '08123456789', 442000.00, 'payments/ehmtvBeMNlyRfQOuCXGdOHggSRDAsvfPA73QuPwo.jpg', 'verified', NULL, '2026-07-06 00:15:48', '2026-07-06 00:17:15', NULL, NULL, '📱 INSTRUKSI PEMBAYARAN DANA:\n\n1. Buka aplikasi DANA Anda\n2. Pilih Menu Pembayaran/Transfer\n3. Cari merchant \'FragrancesHub Store\'\n4. Masukkan Nominal: Rp 442.000\n5. Masukkan PIN/Password Anda\n6. Selesaikan pembayaran\n7. Simpan bukti pembayaran\n8. Upload bukti di halaman pesanan Anda');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_percent` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `discount_percent`, `stock`, `image`, `is_active`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sauvage Dior', 'sauvage-dior-1', 'Aroma maskulin dengan nuansa kayu cedar dan bergamot yang menyegarkan. Cocok untuk pria modern yang penuh percaya diri.', 850000.00, 20, 23, 'products/vV5KOtyKwvnWHsI75aM0s4OWIvCRMWdTBtf8hmvA.jpg', 1, 0, '2026-05-11 23:56:53', '2026-07-04 10:57:39'),
(2, 1, 'Bleu de Chanel', 'bleu-de-chanel-2', 'Parfum woody aromatic yang memancarkan karakter pria kuat dan elegan. Perpaduan citrus dengan vetiver yang memukau.', 920000.00, 0, 16, 'products/D4RMf4Pb0jifZmrFxGDyo2Rpo2ZUaBcyY3ZqZ9vM.jpg', 1, 0, '2026-05-11 23:56:53', '2026-07-04 08:55:15'),
(3, 2, 'Chanel No. 5', 'chanel-no-5-3', 'Ikon parfum wanita sepanjang masa dengan aroma floral yang timeless dan mewah. Perpaduan ylang-ylang dan rose yang sempurna.', 1200000.00, 0, 14, 'products/EUiaNMgwlojOyPOfpL0BFwMCXBHoNp5KBxXx7cXT.jpg', 1, 0, '2026-05-11 23:56:53', '2026-05-14 05:09:12'),
(4, 2, 'Miss Dior Blooming Bouquet', 'miss-dior-blooming-bouquet-4', 'Aroma floral segar yang feminin dan romantis. Kombinasi peony, rose, dan white musks yang indah.', 780000.00, 0, 21, 'products/t1PGnrvq8llmEls9LEbPhYStqxE6dZCiUBvG8MRb.jpg', 1, 0, '2026-05-11 23:56:53', '2026-07-04 08:48:15'),
(5, 3, 'CK One Calvin Klein', 'ck-one-calvin-klein-5', 'Parfum unisex ikonik dengan aroma citrus segar yang cocok untuk semua gender. Ringan dan menyegarkan.', 450000.00, 0, 30, 'products/HuskKGydL2DRonydFZkQFp2wPom7turTlscN8d9a.jpg', 1, 0, '2026-05-11 23:56:53', '2026-05-13 23:46:25'),
(6, 4, 'Tom Ford Black Orchid', 'tom-ford-black-orchid-6', 'Parfum mewah dengan aroma oriental yang gelap dan sensual. Kombinasi black truffle, ylang-ylang, dan bergamot.', 2500000.00, 0, 15, 'products/P5uxEXv5kQnhHsOvj9ppv0sxTOF4A6oarmWC7JhL.jpg', 1, 0, '2026-05-11 23:56:53', '2026-05-12 09:01:56'),
(7, 3, 'ONIX-FWB', 'onix-fwb-7', 'Untuk fwb, fresh citrus gitu karna ada aroma lemonnya tapi nanti dia ada manisnya juga karna campuran aroma vanilla dan caramelnya. Pokoknya ini aromanya unik parah, fresh tapi ada manis-manisnya gitu', 189000.00, 0, 1, 'products/CH4ix6GhOK31COH3P9blwFT2CQkB7ZgsGvI9ZaQb.jpg', 1, 0, '2026-05-11 23:56:53', '2026-06-30 09:08:04'),
(8, 4, 'Le Labo \'Santal 33\'', 'le-labo-santal-33-8', 'Discover the most talked-about scent in the world. Le Labo Santal 33 is a cult classic, blending smoky cardamom and violet with the crackle of Australian sandalwood. This luxury perfume sample is the perfect way to experience the intoxicating, woody aroma before committing to a full bottle', 3798000.00, 0, 0, 'products/s1I6BQjFlkWfCseJhFUUiNFbXgoa6JcK8KJNbBWJ.jpg', 1, 0, '2026-05-11 23:56:53', '2026-06-30 09:09:06'),
(9, 5, 'Samosir', 'samosir-9', 'Bamboe Roencing adalah cerminan tekad hati, persatuan, dan semangat pantang menyerah.\r\n\r\nTerinspirasi dari bambu runcing - simbol perjuangan rakyat Indonesia - serta filosofi motif Pucuk Rebung dan anyaman bambu yang melambangkan keteguhan dan kekuatan. Bamboe Roencing hadir bukan hanya sebagai aroma, tapi sebagai pengingat akan semangat kita.\r\n\r\nPerpaduan aroma Bergamot, Osmanthus, dan Musk menciptakan karakter wangi yang menyegarkan dan membangkitkan harapan serta keberanian dalam menghadapi hari yang penuh tantangan.', 297000.00, 0, 98, 'products/VU3zTFPBQvmE37CUyb8T90D5CuMFYNf7HtyOU6ks.jpg', 1, 0, '2026-05-11 23:58:30', '2026-06-30 08:48:11'),
(10, 5, 'Bamboe Roencing', 'bamboe-roencing-10', 'SAMOSIR, sebuah aroma yang terinspirasi dari kemegahan dan ketenangan Danau Toba. \r\n\r\n\r\n\r\nHoneysuckle yang manis membawa nuansa kebahagian dan excitement, dilanjut oleh Bergamot yang menawarkan kesegaran dan semangat berpetualangan. \r\nDitutup oleh Musk yang lembut menambahkan nuansa kedamaian dan kenyamanan, mengingatkan kita untuk terus menikmati setiap momen dari perjalanan hidup.', 270000.00, 5, 19, 'products/4p8bLmmL0B3cyQFlRqmMzm4QJg1gCEZz4FXeqsyS.jpg', 1, 0, '2026-05-12 00:09:03', '2026-06-30 08:47:38'),
(11, 5, 'Arumanis', 'arumanis-11', 'Pulang Tanpa Harus Kembali, Inilah Sebotol Nostalgia Dalam Pelukan Waktu.\r\n\r\nLayaknya mesin waktu pribadi, Arumanis mengajak kamu bernostalgia dan merasakan kembali hangatnya pelukan kenangan masa kecil. Arumanis merangkum memori dalam harmoni yang tenang : Vanilla yang lembut, cokelat yang hangat dan musk yang bersih. Bukan sekadar manis--ini adalah cara lain mengatakan \"pulang\".\r\n\r\n\r\n\r\nSeakan melangkah masuk ke rumah nenek dimana keharumannya menghadirkan alunan cerita nostalgia yang lembut dan hangat, menghubungkan indra penciuman dengan kenangan manis yang tak lekang oleh waktu.', 295000.00, 10, 48, 'products/CDoE8AHKJ9Ud1JAqQeIVdQwGdsVHpEaTgVA2qIJI.jpg', 1, 0, '2026-05-12 00:09:52', '2026-06-30 08:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size`, `price`, `stock`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 9, '200ml', 442000.00, 13, 1, '2026-07-04 09:23:02', '2026-07-06 00:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin FragrancesHub', 'admin@fragranceshub.com', NULL, '$2y$12$IJjt3fClhBbqe.VCIK/IvuxCKg/JAKEQAwGyJ6i2rDSaaswu06He6', 'admin', NULL, NULL, NULL, '2026-05-11 23:56:53', '2026-05-11 23:56:53'),
(2, 'user sebagai testing', 'user@fragranceshub.com', NULL, '$2y$12$XyNyjHATecM1bp.mg9PtreWQXNAFcJYVjl.U7lJWMUaKwS8yzuG2i', 'user', '08123456789', 'Jl. SURYA KENCANA NO 2984', NULL, '2026-05-11 23:56:53', '2026-07-05 23:44:17'),
(3, 'Nazwa kanaya putri', 'kanaya@fragranceshub.com', NULL, '$2y$12$25X3oc6qJDwkEiWoYNozI.Jo9KtloDxrJ/YdRotozAU54XGvXqm1i', 'user', '087541254888', 'Lampung', 'DgRYxbIwp0gAUt8cbQFaMV3I9OwNHFepfAuo8ZaZ0wyDIQy7Q0fUvvVhc5dN', '2026-05-12 02:01:02', '2026-05-12 02:01:02'),
(4, 'muhamad audi radittia prasetyo', 'radityaradit177@gmai.com', NULL, '$2y$12$8xTEov8BaLnj0NQowkkegeaUnpt3GipjNRNIsRFsdC5ZuNBBEg0aC', 'user', '087781944482', 'jombang', NULL, '2026-05-13 05:21:27', '2026-05-13 05:21:27'),
(5, 'firmansyah', 'firmansyah980@gmail.com', NULL, '$2y$12$YmSQpuAXLUZFggHQQrZ7C.1BznsyyKsAzHjPF/jMi02EmSqlz9NiG', 'user', '08475648331894', 'Serpong Tangerang', NULL, '2026-07-05 20:54:43', '2026-07-05 20:54:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_product_variant_id_foreign` (`product_variant_id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_user_product_variant_index` (`user_id`,`product_id`,`product_variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_product_variant_id_foreign` (`product_variant_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_product_id_size_unique` (`product_id`,`size`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
