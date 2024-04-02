-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 02, 2024 at 04:02 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_la_park_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `cash_flows`
--

CREATE TABLE `cash_flows` (
  `id` bigint UNSIGNED NOT NULL,
  `sales_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in` int NOT NULL,
  `out` int NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_flows`
--

INSERT INTO `cash_flows` (`id`, `sales_no`, `date`, `description`, `in`, `out`, `amount`, `created_at`, `updated_at`, `category`) VALUES
(3, NULL, '2024-03-26', 'Saldo awal', 20000000, 0, 20000000, '2024-03-26 05:28:20', '2024-03-26 05:28:20', NULL),
(5, 'ORD-20240330-0011', '2024-03-30', 'Pendapatan dari penjualan Saya', 38500, 0, 20077000, '2024-03-30 00:07:04', '2024-03-30 00:07:04', 'Pendapatan'),
(6, 'ORD-20240330-0011', '2024-03-30', 'Biaya produksi untuk penjualan Saya', 0, 33000, 20077000, '2024-03-30 00:07:04', '2024-03-30 00:07:04', 'Biaya Produksi'),
(7, 'ORD-20240330-0012', '2024-03-30', 'Pendapatan dari penjualan Wisnu', 7000, 0, 20084000, '2024-03-30 07:15:46', '2024-03-30 07:15:46', 'Pendapatan'),
(8, 'ORD-20240330-0012', '2024-03-30', 'Biaya produksi untuk penjualan Wisnu', 0, 6000, 20078000, '2024-03-30 07:15:46', '2024-03-30 07:15:46', 'Biaya Produksi');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('makanan','minuman') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `category`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Tempe Goreng', 'makanan', 3500, '0lu0867PnwaNUZAqfrB0Q8g5odUJedgv5e41Pi1F.jpg', '2024-03-26 08:59:21', '2024-04-02 08:52:21'),
(2, 'Teh Gelas', 'minuman', 2500, 'Is7vvEHGD3DVlxYNaoGQCnJox2JyKZFOnzHi0e0a.png', '2024-04-02 09:00:51', '2024-04-02 09:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(19, '2024_03_26_042939_create_menus_table', 2),
(20, '2024_03_26_043039_create_raw_materials_table', 2),
(21, '2024_03_26_043142_create_requirement_raw_materials_table', 2),
(22, '2024_03_26_043208_create_raw_material_histories_table', 2),
(23, '2024_03_26_043235_create_sales_table', 2),
(24, '2024_03_26_043300_create_sales_details_table', 2),
(25, '2024_03_26_043350_create_cash_flows_table', 2),
(26, '2024_03_26_105948_create_notifications_table', 2),
(27, '2024_03_30_052835_add_column_sales_no_to_sales_table', 3),
(28, '2024_03_30_052915_add_column_sales_no_to_sales_table', 3),
(29, '2024_03_30_054638_add_column_price_to_raw_materials', 3),
(32, '2024_03_30_055456_add_column_price_to_', 4),
(33, '2024_03_30_055857_add_column_category', 4),
(34, '2024_03_30_073618_add_relation_', 5),
(35, '2024_03_30_103656_create_predictions_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `content`, `type`, `user_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'Informasi login', 'Anda login pada 26 March 2024 16:26:25', 'user', 1, 1, '2024-03-26 09:26:25', '2024-04-02 08:35:47'),
(2, 'Update Profil', 'Data Profil berhasil diperbarui', 'user', 1, 1, '2024-03-26 09:28:39', '2024-04-02 08:35:47'),
(3, 'Update Profil', 'Data Profil berhasil diperbarui', 'user', 1, 1, '2024-03-26 09:29:20', '2024-04-02 08:35:47'),
(4, 'Informasi login', 'Anda login pada 26 March 2024 16:34:48', 'user', 3, 1, '2024-03-26 09:34:48', '2024-04-02 08:51:19'),
(5, 'Update Profil', 'Data Profil berhasil diperbarui', 'user', 3, 1, '2024-03-26 11:32:29', '2024-04-02 08:51:19'),
(6, 'Informasi login', 'Anda login pada 26 March 2024 18:32:46', 'user', 1, 1, '2024-03-26 11:32:46', '2024-04-02 08:35:47'),
(7, 'Informasi login', 'Anda login pada 26 March 2024 18:38:10', 'user', 3, 1, '2024-03-26 11:38:10', '2024-04-02 08:51:19'),
(8, 'Informasi login', 'Anda login pada 30 March 2024 04:39:04', 'user', 1, 1, '2024-03-29 21:39:04', '2024-04-02 08:35:47'),
(9, 'Informasi login', 'Anda login pada 30 March 2024 05:26:56', 'user', 3, 1, '2024-03-29 22:26:56', '2024-04-02 08:51:19'),
(10, 'Informasi login', 'Anda login pada 30 March 2024 05:44:33', 'user', 1, 1, '2024-03-29 22:44:33', '2024-04-02 08:35:47'),
(11, 'Informasi login', 'Anda login pada 30 March 2024 06:09:53', 'user', 3, 1, '2024-03-29 23:09:53', '2024-04-02 08:51:19'),
(12, 'Informasi login', 'Anda login pada 30 March 2024 07:08:45', 'user', 1, 1, '2024-03-30 00:08:45', '2024-04-02 08:35:47'),
(13, 'Informasi login', 'Anda login pada 30 March 2024 11:53:23', 'user', 1, 1, '2024-03-30 04:53:23', '2024-04-02 08:35:47'),
(14, 'Informasi login', 'Anda login pada 30 March 2024 14:08:55', 'user', 1, 1, '2024-03-30 07:08:55', '2024-04-02 08:35:47'),
(15, 'Informasi login', 'Anda login pada 30 March 2024 14:14:04', 'user', 3, 1, '2024-03-30 07:14:04', '2024-04-02 08:51:19'),
(16, 'Informasi login', 'Anda login pada 30 March 2024 14:16:54', 'user', 1, 1, '2024-03-30 07:16:54', '2024-04-02 08:35:47'),
(17, 'Informasi login', 'Anda login pada 02 April 2024 15:35:44', 'user', 1, 1, '2024-04-02 08:35:44', '2024-04-02 08:35:47'),
(18, 'Informasi login', 'Anda login pada 02 April 2024 15:51:15', 'user', 3, 1, '2024-04-02 08:51:15', '2024-04-02 08:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `predictions`
--

CREATE TABLE `predictions` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` int NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `predictions`
--

INSERT INTO `predictions` (`id`, `date`, `input`, `result`, `category`, `created_at`, `updated_at`) VALUES
(1, '2024-03-30', '35', 250180, 'Kas Masuk', '2024-03-30 04:25:10', '2024-03-30 04:25:10'),
(2, '2024-03-30', '35', 249995, 'Kas Masuk', '2024-03-30 04:26:10', '2024-03-30 04:26:10'),
(3, '2024-03-30', '35', 250019, 'Kas Masuk', '2024-03-30 04:28:07', '2024-03-30 04:28:07'),
(4, '2024-03-30', '35', 400000, 'Kas Masuk', '2024-03-30 04:39:09', '2024-03-30 04:39:09'),
(7, '2024-03-30', '60', 160000, 'Kas Masuk', '2024-03-30 05:04:47', '2024-03-30 05:04:47'),
(15, '2024-03-30', '11', 160000, 'Kas Masuk', '2024-03-30 05:56:26', '2024-03-30 05:56:26'),
(16, '2024-03-30', '11', 38500, 'Kas Masuk', '2024-03-30 05:57:23', '2024-03-30 05:57:23'),
(17, '2024-03-30', '11', 62000, 'Kas Keluar', '2024-03-30 07:02:30', '2024-03-30 07:02:30'),
(18, '2024-03-30', '11', 33000, 'Kas Keluar', '2024-03-30 07:03:16', '2024-03-30 07:03:16'),
(19, '2024-03-30', '19', 57000, 'Kas Keluar', '2024-03-30 07:03:24', '2024-03-30 07:03:24'),
(27, '2024-03-30', '[\"1\",\"2024\"]', 1894, 'Profit', '2024-03-30 07:26:25', '2024-03-30 07:26:25'),
(28, '2024-03-30', '[\"1\",\"3900\"]', 13, 'Penjualan', '2024-03-30 07:29:00', '2024-03-30 07:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `raw_materials`
--

CREATE TABLE `raw_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `limit` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_materials`
--

INSERT INTO `raw_materials` (`id`, `name`, `qty`, `limit`, `unit`, `created_at`, `updated_at`, `price`) VALUES
(5, 'Tempe', 810, 100, 'gram', '2024-03-26 08:21:18', '2024-03-30 07:15:46', 300),
(6, 'Micin', 1000, 100, 'gram', '2024-04-02 08:57:27', '2024-04-02 08:57:27', 100);

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_histories`
--

CREATE TABLE `raw_material_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `raw_material_id` bigint UNSIGNED NOT NULL,
  `in` int NOT NULL,
  `out` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_material_histories`
--

INSERT INTO `raw_material_histories` (`id`, `date`, `raw_material_id`, `in`, `out`, `description`, `balance`, `created_at`, `updated_at`, `price`) VALUES
(1, '2024-03-26', 5, 1000, 0, 'Tambah stok awal', 1000, '2024-03-26 08:21:18', '2024-03-26 08:21:18', 300),
(2, '2024-03-26', 5, 50, 0, 'Penambahan stok', 1050, '2024-03-26 08:34:50', '2024-03-26 08:34:50', 300),
(3, '2024-03-30', 5, 0, 110, 'Pengurangan stock bahan baku untuk penjualan Saya', 940, '2024-03-30 00:07:04', '2024-03-30 00:07:04', 300),
(4, '2024-03-30', 5, 0, 20, 'Pengurangan stock bahan baku untuk penjualan Wisnu', 920, '2024-03-30 07:15:46', '2024-03-30 07:15:46', 300),
(5, '2024-04-02', 6, 1000, 0, 'Tambah stok awal', 1000, '2024-04-02 08:57:27', '2024-04-02 08:57:27', 100);

-- --------------------------------------------------------

--
-- Table structure for table `requirement_raw_materials`
--

CREATE TABLE `requirement_raw_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `raw_material_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requirement_raw_materials`
--

INSERT INTO `requirement_raw_materials` (`id`, `menu_id`, `raw_material_id`, `qty`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 10, '2024-03-26 09:06:34', '2024-03-26 09:06:34'),
(2, 1, 6, 2, '2024-04-02 08:57:48', '2024-04-02 08:57:48'),
(3, 2, 6, 1, '2024-04-02 09:01:07', '2024-04-02 09:01:07');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `sales_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `sales_no`, `date`, `customer`, `total`, `user_id`, `created_at`, `updated_at`) VALUES
(11, 'ORD-20240330-0011', '2024-03-30', 'Saya', 38500, 3, '2024-03-30 00:07:04', '2024-03-30 00:07:04'),
(13, 'ORD-20240330-0012', '2024-03-30', 'Wisnu', 7000, 3, '2024-03-30 07:15:46', '2024-03-30 07:15:46');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `id` bigint UNSIGNED NOT NULL,
  `sales_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`id`, `sales_id`, `menu_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(14, 11, 1, 11, 3500, '2024-03-30 00:07:04', '2024-03-30 00:07:04'),
(15, 13, 1, 2, 3500, '2024-03-30 07:15:46', '2024-03-30 07:15:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kasir',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Syaiq', 'manager@gmail.com', NULL, '$2y$10$5mDpi6z9Md1yBp/IuaReH.JZKC9K955j4Bdw1k6TPxwqlL.J.h8X.', 'manager', NULL, NULL, '2024-03-26 09:28:39'),
(2, 'owner', 'owner@gmail.com', NULL, '$2y$10$DNydbBgDafkj58uTvQ/Qrut7aYSPY8Ay4WuAi62ZneZfJdV1qIyfm', 'owner', NULL, NULL, NULL),
(3, 'Mas Kasir', 'kasir@gmail.com', NULL, '$2y$10$jFfgv0VTYKMwWSD8UtII4Olf5EdDZjOQuHea3qh/fsBUiR/6k.m/2', 'kasir', NULL, NULL, '2024-03-26 11:32:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_no` (`sales_no`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `predictions`
--
ALTER TABLE `predictions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raw_material_histories`
--
ALTER TABLE `raw_material_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_material_histories_raw_material_id_foreign` (`raw_material_id`);

--
-- Indexes for table `requirement_raw_materials`
--
ALTER TABLE `requirement_raw_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requirement_raw_materials_menu_id_foreign` (`menu_id`),
  ADD KEY `requirement_raw_materials_raw_material_id_foreign` (`raw_material_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_user_id_foreign` (`user_id`),
  ADD KEY `sales_no` (`sales_no`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_details_sales_id_foreign` (`sales_id`),
  ADD KEY `sales_details_menu_id_foreign` (`menu_id`);

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
-- AUTO_INCREMENT for table `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `predictions`
--
ALTER TABLE `predictions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `raw_materials`
--
ALTER TABLE `raw_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `raw_material_histories`
--
ALTER TABLE `raw_material_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `requirement_raw_materials`
--
ALTER TABLE `requirement_raw_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD CONSTRAINT `cash_flows_sales_no_foreign` FOREIGN KEY (`sales_no`) REFERENCES `sales` (`sales_no`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raw_material_histories`
--
ALTER TABLE `raw_material_histories`
  ADD CONSTRAINT `raw_material_histories_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`);

--
-- Constraints for table `requirement_raw_materials`
--
ALTER TABLE `requirement_raw_materials`
  ADD CONSTRAINT `requirement_raw_materials_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `requirement_raw_materials_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD CONSTRAINT `sales_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `sales_details_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
