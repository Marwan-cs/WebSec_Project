-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 10:15 PM
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
-- Database: `websec_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'i:1;', 1748023310),
('laravel_cache_0ade7c2cf97f75d009975f4d720d1fa6c19f4897:timer', 'i:1748023310;', 1748023310),
('laravel_cache_12c6fc06c99a462375eeb3f43dfd832b08ca9e17', 'i:2;', 1748029655),
('laravel_cache_12c6fc06c99a462375eeb3f43dfd832b08ca9e17:timer', 'i:1748029655;', 1748029655),
('laravel_cache_1574bddb75c78a6fd2251d61e2993b5146201319', 'i:1;', 1748026853),
('laravel_cache_1574bddb75c78a6fd2251d61e2993b5146201319:timer', 'i:1748026853;', 1748026853),
('laravel_cache_17ba0791499db908433b80f37c5fbc89b870084b', 'i:2;', 1748024866),
('laravel_cache_17ba0791499db908433b80f37c5fbc89b870084b:timer', 'i:1748024866;', 1748024866),
('laravel_cache_472b07b9fcf2c2451e8781e944bf5f77cd8457c8', 'i:1;', 1748028982),
('laravel_cache_472b07b9fcf2c2451e8781e944bf5f77cd8457c8:timer', 'i:1748028982;', 1748028982),
('laravel_cache_4d134bc072212ace2df385dae143139da74ec0ef', 'i:2;', 1748030228),
('laravel_cache_4d134bc072212ace2df385dae143139da74ec0ef:timer', 'i:1748030228;', 1748030228),
('laravel_cache_887309d048beef83ad3eabf2a79a64a389ab1c9f', 'i:1;', 1748031056),
('laravel_cache_887309d048beef83ad3eabf2a79a64a389ab1c9f:timer', 'i:1748031056;', 1748031056),
('laravel_cache_91032ad7bbcb6cf72875e8e8207dcfba80173f7c', 'i:2;', 1748028387),
('laravel_cache_91032ad7bbcb6cf72875e8e8207dcfba80173f7c:timer', 'i:1748028387;', 1748028387),
('laravel_cache_b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'i:1;', 1748024629),
('laravel_cache_b1d5781111d84f7b3fe45a0852e59758cd7a87e5:timer', 'i:1748024629;', 1748024629),
('laravel_cache_bd307a3ec329e10a2cff8fb87480823da114f8f4', 'i:2;', 1748026269),
('laravel_cache_bd307a3ec329e10a2cff8fb87480823da114f8f4:timer', 'i:1748026269;', 1748026269),
('laravel_cache_d435a6cdd786300dff204ee7c2ef942d3e9034e2', 'i:2;', 1748029957),
('laravel_cache_d435a6cdd786300dff204ee7c2ef942d3e9034e2:timer', 'i:1748029957;', 1748029957),
('laravel_cache_f6e1126cedebf23e1463aee73f9df08783640400', 'i:1;', 1748030560),
('laravel_cache_f6e1126cedebf23e1463aee73f9df08783640400:timer', 'i:1748030560;', 1748030560);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `attempts` tinyint(3) UNSIGNED NOT NULL,
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
(4, '2024_03_18_000000_create_roles_table', 1),
(5, '2024_03_18_000001_create_role_user_table', 1),
(6, '2024_03_19_000001_create_products_table', 1),
(7, '2024_03_19_000002_create_orders_table', 1),
(8, '2024_03_19_000003_create_order_items_table', 1),
(9, '2025_04_30_000000_add_social_fields_to_users_table', 1),
(10, '2024_03_21_000000_update_orders_table', 2),
(11, '2024_03_21_000001_create_order_items_table', 3),
(12, '2024_03_21_add_featured_to_products_table', 4),
(13, '2024_03_21_add_image_url_to_products_table', 5),
(14, '2024_03_21_create_carts_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `tracking_number` varchar(255) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_state` varchar(255) NOT NULL,
  `shipping_zipcode` varchar(255) NOT NULL,
  `shipping_country` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `tracking_number`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_zipcode`, `shipping_country`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 4, 99.99, 'completed', NULL, 'wsdfrvgtujh', 'Cairo', 'qswdavfbgvn', '555', 'CA', 'credit_card', '2025-05-15 11:53:46', '2025-05-15 19:20:03'),
(2, 4, 2000.00, 'completed', NULL, 'Al Mehwar', 'Cairo', 'qswdavfbgvn', '555', 'CA', 'credit_card', '2025-05-16 12:26:16', '2025-05-16 12:30:38'),
(3, 4, 45050.00, 'pending', NULL, 'cierp', 'nnnn', 'nnnnn', 'vvvv', 'GB', 'credit_card', '2025-05-16 18:42:39', '2025-05-16 18:42:39'),
(4, 4, 57500.00, 'pending', NULL, 'a', 'aa', 'a', 'a', 'BR', 'credit_card', '2025-05-16 18:47:14', '2025-05-16 18:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 16, 1, 2000.00, '2025-05-16 12:26:16', '2025-05-16 12:26:16'),
(3, 3, 19, 18, 2500.00, '2025-05-16 18:42:39', '2025-05-16 18:42:39'),
(4, 3, 18, 1, 50.00, '2025-05-16 18:42:39', '2025-05-16 18:42:39'),
(5, 4, 19, 23, 2500.00, '2025-05-16 18:47:14', '2025-05-16 18:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_sale` tinyint(1) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`, `is_featured`, `is_sale`, `image_url`) VALUES
(16, 'Laptop Prooooo', 'sdsvfbgnjm,k', 2000.00, 1, 'products/r6Fwn7D0e37d5LeykTZhnXWihK9wG9991U2y2hH1.jpg', '2025-05-15 18:01:54', '2025-05-21 19:40:45', 0, 0, NULL),
(18, 'Address', 'SWDEFRGTHYUJKILO;P\'[', 50.00, 33, 'products/m8rvdSBmF5244g6aQnVDJW9EEkuBFmUTen5IfAX5.jpg', '2025-05-15 18:16:07', '2025-05-15 18:16:07', 0, 0, NULL),
(19, 'iphone 17 air pro', 'the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you the best phone for you', 2500.00, 50, 'products/1Nvauex5u2KeIezIYRxLnhLCfV6IEFvfZJ55W5wz.jpg', '2025-05-16 16:43:08', '2025-05-16 16:43:08', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'Full access to all features and settings', '2025-05-13 17:45:30', '2025-05-15 05:41:48'),
(2, 'manager', 'manager', 'Access to manage products, orders, and staff', '2025-05-13 17:45:30', '2025-05-15 05:41:48'),
(3, 'staff', 'staff', 'Access to basic store operations and customer service', '2025-05-13 17:45:30', '2025-05-15 05:41:48'),
(4, 'customer', 'customer', 'Access to customer features and shopping', '2025-05-13 17:45:30', '2025-05-15 05:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(4, 4, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0kCnDiYwwth3WsNob8DhretV0diYxISWUDNrp0qA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2ZyczdqbEsxUnA0TUtmcU5TRXo2WEl4NWR3d1JnemJDOWp5Z1hSTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748026434),
('5aubDZ6OY7OqA5fyI1ysErTLqOunP3oNr4VuWFEA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWxlSHEzNHpCRXU5dVJHVzlpYlkxTDZFSnpmSnp0NVFHbllTQ1RsRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027040),
('6SQYTiMNLB8FAPiTFlLu4NliInIEAqyIIVSNZujs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia2dVSXhWYmtaOVR1REJ4NENSbXJnM1B3RXEwbDFDbDF1b0tLR2tqaCI7czo1OiJlcnJvciI7czo0MDoiU29tZXRoaW5nIHdlbnQgd3Jvbmcgd2l0aCBnb29nbGUgbG9naW46ICI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1NzoiaHR0cDovL2Nsb3RoaW5nc3RvcmUubG9jYWxob3N0LmNvbS9hdXRoL2dvb2dsZS9jYWxsYmFjaz9hdXRodXNlcj0wJmNvZGU9NCUyRjBBVUpSLXg2VVA5eElReHFmZmdyWVBkSGVxTHBsTmdvVVhObUFaR05fcmRjTk00UmdjMjZVdWFqamkyU3k2U1FoeEdlWHl3JnByb21wdD1ub25lJnNjb3BlPWVtYWlsJTIwcHJvZmlsZSUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLmVtYWlsJTIwaHR0cHMlM0ElMkYlMkZ3d3cuZ29vZ2xlYXBpcy5jb20lMkZhdXRoJTJGdXNlcmluZm8ucHJvZmlsZSUyMG9wZW5pZCZzdGF0ZT1tbmZaWHN2d3N5cGgyZVh0ZndpYjZRakRhbHVucldpaTJndTdNdXh6Ijt9fQ==', 1748026509),
('6V2OyviMtIME4naaQZyWR0dNNxSI8d6vMA2OSlbA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNEVVUENHUG1IV1N6cVRtc2VXRE9leTVzcjlRVWVmbVJpZ1ZBVnQ4SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027910),
('81OuuegyNL5G9BlM3alCAyqrLtAR5SRdLYLKF0hp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDhDaXRwZ0dpOHppUThoVjJqNmRrVDJWV1ZUNFZKRTFlUnFwdkRaVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027074),
('AbLIknpZ8VBnq8dac4a5XKbKoGqHsxkry5vaJ2Al', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmZIQnhTTkJNVGhiOWhPNlN3OEc1Z3JTOHZMTHc2MlBWemtzdFlneSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027058),
('KDoupAu1XyQhcWL0A4zq0WJyLM21ZkcLzxis2iDP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid052UEx1dmVpWUZ1bndRRTk3MjZVTE5yOW5BSHdyR1JUSW9VNTM0VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748026438),
('knmegcnstWo6hPHSZ0JBxhIynaYsPqOFXxFTQ5Hi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidEFTbjgzYmRRN1dzQncxSmlvb29IVTZCUld2bFpnZFk4bHVoQlZ4dSI7czo1OiJlcnJvciI7czo0MDoiU29tZXRoaW5nIHdlbnQgd3Jvbmcgd2l0aCBnb29nbGUgbG9naW46ICI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1NzoiaHR0cDovL2Nsb3RoaW5nc3RvcmUubG9jYWxob3N0LmNvbS9hdXRoL2dvb2dsZS9jYWxsYmFjaz9hdXRodXNlcj0wJmNvZGU9NCUyRjBBVUpSLXg2YndzdVlXZ0o3QkJ3WnZfVUl6T1hGWThmaENkWmFFOWR2LTl1UGM0WXlURHpwSUdDdmU5M09jczJPT2s0OTF3JnByb21wdD1ub25lJnNjb3BlPWVtYWlsJTIwcHJvZmlsZSUyMG9wZW5pZCUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLmVtYWlsJTIwaHR0cHMlM0ElMkYlMkZ3d3cuZ29vZ2xlYXBpcy5jb20lMkZhdXRoJTJGdXNlcmluZm8ucHJvZmlsZSZzdGF0ZT1uM2ZIWVQ5M203WlRWT0pJaUZ2TlhSeGxwcHB4N29oT25GM2ZtdU45Ijt9fQ==', 1748026426),
('KvcKhaTkAVLBpOeBpzIeQWTE5Ry76v5JAknGiwhm', 26, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOHF0NHdvZVN2TnptRUoxV3ZFNmZ1NmV0RXU4eFU0ZHVIN3dOc0hjWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vY2xvdGhpbmdzdG9yZS5sb2NhbGhvc3QuY29tL3ZlcmlmeS1lbWFpbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI2O3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6NDA6Imh0dHBzOi8vY2xvdGhpbmdzdG9yZS5sb2NhbGhvc3QuY29tL2hvbWUiO319', 1748031045),
('nfuFrspz2IDQK2GYxck80Cjzj6syMEzAg3GSkukK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieE1WRUg5R0pHb2d4MXc0b2ZjNGNvTUlaMHNYdG5TM3JUb2hRNlJ0MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748026426),
('QHqXbhL859lUKc4g2Rg5Xngh1rfWF4LwaKo2nON1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidXhwNnZsMzlhZExieVloUm5PMHo5aXU5dUFPT2JGM094UXo0UUxVMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027059),
('T5rFSS71tkTU4z6yUcBkiAAlPJ9z7icnbDnrLBIj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSmxYcjFVTkR0ejBORnV5OTkyaEJwa1ExS1c5MjVqOWdzN1dvNWNpMyI7czo1OiJzdGF0ZSI7czo0MDoiTW1MVjlKeG9PT0diTnpQakkzUWY1a3NOVDBPSW9DM2gxT1FQMFpIdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vYXV0aC9nb29nbGUvcmVkaXJlY3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748026437),
('T7vc6IE42kKQdibCpYTOPqCPHPmx9fKKCbeuhrq3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV1BoMmEwaGZMRTRzT3FuZ3FCZXFpTFVQb2psN21rZzZtVURzbmVJTyI7czo1OiJzdGF0ZSI7czo0MDoiUDluQjEzSGwxODNuVW5EUmhaNnRMTktuTnZWZjBGcDJUVDc1Tk1JRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vYXV0aC9nb29nbGUvcmVkaXJlY3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027076),
('tAMf8X7qU83AQVn1oaXP1ShTiQBt11cypcznluUm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFc0TU16WmhBTVJVRGM4Vjd1MndQSUxOZDdiRXNGY1dFV1hhZ1JSNCI7czo1OiJlcnJvciI7czo0MDoiU29tZXRoaW5nIHdlbnQgd3Jvbmcgd2l0aCBnb29nbGUgbG9naW46ICI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1NzoiaHR0cDovL2Nsb3RoaW5nc3RvcmUubG9jYWxob3N0LmNvbS9hdXRoL2dvb2dsZS9jYWxsYmFjaz9hdXRodXNlcj0wJmNvZGU9NCUyRjBBVUpSLXg1blRXb1gzQmhacGRZaVNlTmk3Nk9pWjNnM05hRHc5U3NGSkFUWkhXdVpmUjBtSEhpOWlwVTBRYndRR2RBU0hBJnByb21wdD1ub25lJnNjb3BlPWVtYWlsJTIwcHJvZmlsZSUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLnByb2ZpbGUlMjBodHRwcyUzQSUyRiUyRnd3dy5nb29nbGVhcGlzLmNvbSUyRmF1dGglMkZ1c2VyaW5mby5lbWFpbCUyMG9wZW5pZCZzdGF0ZT1NbUxWOUp4b09PR2JOelBqSTNRZjVrc05UME9Jb0MzaDFPUVAwWkh1Ijt9fQ==', 1748026437),
('tOtZTxRpe8jb9W92arrbfXssd20FVjtZnKrqNHRq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMjNyV1EwYXUxUlk1Z2FnMWQ2UU1CVVo1Q1dhcjM5eUQ5RExzeGFucCI7czo1OiJlcnJvciI7czo0MDoiU29tZXRoaW5nIHdlbnQgd3Jvbmcgd2l0aCBnb29nbGUgbG9naW46ICI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1NzoiaHR0cDovL2Nsb3RoaW5nc3RvcmUubG9jYWxob3N0LmNvbS9hdXRoL2dvb2dsZS9jYWxsYmFjaz9hdXRodXNlcj0wJmNvZGU9NCUyRjBBVUpSLXg3eFJsdEhQc0x1NkZHSzR2Q09MOXdVRmtENk0tU25nYnd6U1ZUM1NoMG9BU2JlbFZPSzd1REZkakZmcWZLZjlRJnByb21wdD1ub25lJnNjb3BlPWVtYWlsJTIwcHJvZmlsZSUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLmVtYWlsJTIwaHR0cHMlM0ElMkYlMkZ3d3cuZ29vZ2xlYXBpcy5jb20lMkZhdXRoJTJGdXNlcmluZm8ucHJvZmlsZSUyMG9wZW5pZCZzdGF0ZT1ockJ0NzRKQnBEZDlJUHVzM202VjFyR3RIVGxvSWdCVVhXSUFvTzRsIjt9fQ==', 1748027909),
('uaBor0tr1UM7FQUd8Jxyc8GCUzmwbHVL9hPiKN5N', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2VoSGs2a29ycHEyVlYwWWswYmNJMGlZT2JNZ05QYTFCdDJ5VlZTVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748026510),
('uOWLUBFdLtqQKGA8d0xtA5nw2tioQUJecOrwM3Q2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibmxvTVRBVkFmY0gzRkRwTDhzNmFqc2FSWWdtbFlhc1M0R1o2ZHNFZCI7czo1OiJlcnJvciI7czo0MDoiU29tZXRoaW5nIHdlbnQgd3Jvbmcgd2l0aCBnb29nbGUgbG9naW46ICI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1NzoiaHR0cDovL2Nsb3RoaW5nc3RvcmUubG9jYWxob3N0LmNvbS9hdXRoL2dvb2dsZS9jYWxsYmFjaz9hdXRodXNlcj0wJmNvZGU9NCUyRjBBVUpSLXg0Qm1SNWlwM0o4cmxlNDY5bmVaSVNGc1hhTFdzeDVMd3pkSnphdmZRQWJSRENxMGd1S2VLZzRfNUhFYldZdFBBJnByb21wdD1ub25lJnNjb3BlPWVtYWlsJTIwcHJvZmlsZSUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLmVtYWlsJTIwaHR0cHMlM0ElMkYlMkZ3d3cuZ29vZ2xlYXBpcy5jb20lMkZhdXRoJTJGdXNlcmluZm8ucHJvZmlsZSUyMG9wZW5pZCZzdGF0ZT1nczRJandEckk1RGJMVHdFemZ6aWtCRGRxQnlkVVFTT3lzUUQyeVBiIjt9fQ==', 1748027040),
('y5zBryCPPLcbpJH1xLz7ZkpIseBJbLHAbCJp2uyY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieVBVOUVFQ0xtM2d0MVBxaWJnSTlDVXVZODdMV09yUkYxd1ROUWc2TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027054),
('ZR8HZRHbGrGaX5YcQ3YTeiohkVgWULbx0a1XuIMc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzVVWFhkeWRRc1pIUmpTQ3JsM2VxVHZFYnE5bDV6a2ZkR3MzZlF3MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9jbG90aGluZ3N0b3JlLmxvY2FsaG9zdC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1748027086);

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
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `provider`, `provider_id`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2025-05-13 17:45:30', '$2y$12$wJLMR6mKL42KgL/8mi0k1.4wecUMTBg/CCRo2bHvLJIRhMjDUy00e', NULL, NULL, NULL, NULL, '2025-05-13 17:45:30', '2025-05-15 13:36:19'),
(2, 'Manager User', 'manager@example.com', '2025-05-13 17:45:30', '$2y$12$ZKZLKfUhwSiRuOvboI46n.aEbFErPH0/QoHpNlLkRR5HHCEzU3oaG', NULL, NULL, NULL, NULL, '2025-05-13 17:45:30', '2025-05-15 13:36:19'),
(3, 'Staff User', 'staff@example.com', '2025-05-13 17:45:30', '$2y$12$Z8BhJjJfPJlZyEZnmp13GOxsbVOldy28bTboVMMtz9DvmrK1FGWWS', NULL, NULL, NULL, NULL, '2025-05-13 17:45:30', '2025-05-15 13:36:19'),
(4, 'Customer User', 'customer@example.com', '2025-05-13 17:45:30', '$2y$12$803eQunmHDPrpMJWqGnQ/OI18NFFs0WsYCpz5AXvHpArdzw8gWpJi', NULL, NULL, NULL, NULL, '2025-05-13 17:45:30', '2025-05-15 13:36:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

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
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_user_role_id_user_id_unique` (`role_id`,`user_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
