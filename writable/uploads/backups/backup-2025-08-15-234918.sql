-- Database Backup
-- Generated on: 2025-08-15 23:49:18
-- Database: donasi

SET foreign_key_checks = 0;

-- Table structure for table `donasi`
DROP TABLE IF EXISTS `donasi`;
CREATE TABLE `donasi` (
  `donasi_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(100) DEFAULT NULL,
  `program_id` int(11) unsigned NOT NULL,
  `user_id` int(30) unsigned NOT NULL DEFAULT 0,
  `donatur_id` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `anonim` varchar(10) NOT NULL DEFAULT 'tidak',
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `amount` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `referral` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`donasi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `donasi`
INSERT INTO `donasi` (`donasi_id`, `order_id`, `program_id`, `user_id`, `donatur_id`, `name`, `anonim`, `status`, `amount`, `phone`, `email`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', NULL, '1', '0', '1', 'John Doe', 'tidak', 'pending', '500000', '08123456789', 'jhon@donasi.com', 'jhon', '2025-08-14 16:02:18', '2025-08-14 16:02:18', NULL);
INSERT INTO `donasi` (`donasi_id`, `order_id`, `program_id`, `user_id`, `donatur_id`, `name`, `anonim`, `status`, `amount`, `phone`, `email`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', NULL, '2', '0', '2', 'Jane Smith', 'tidak', 'pending', '1000000', '08123456789', 'jane@donasi.com', 'jane', '2025-08-14 16:02:18', '2025-08-14 16:02:18', NULL);
INSERT INTO `donasi` (`donasi_id`, `order_id`, `program_id`, `user_id`, `donatur_id`, `name`, `anonim`, `status`, `amount`, `phone`, `email`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', NULL, '3', '2', '0', 'Jane Smith', 'tidak', 'pending', '1000000', '08123456779', 'jane2@donasi.com', 'jane2', '2025-08-14 16:02:18', '2025-08-14 16:02:18', NULL);
INSERT INTO `donasi` (`donasi_id`, `order_id`, `program_id`, `user_id`, `donatur_id`, `name`, `anonim`, `status`, `amount`, `phone`, `email`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('4', NULL, '1', '3', '0', 'Imam Safii', 'tidak', 'pending', '500000', NULL, '', NULL, '2025-08-15 04:03:51', '2025-08-15 04:03:51', '2025-08-15 04:04:46');
INSERT INTO `donasi` (`donasi_id`, `order_id`, `program_id`, `user_id`, `donatur_id`, `name`, `anonim`, `status`, `amount`, `phone`, `email`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('5', '2048191741', '2', '0', '0', 'Imam Safii', 'tidak', 'pending', '500000', NULL, 'imamsafii2222022@gmail.com', NULL, NULL, NULL, NULL);
INSERT INTO `donasi` (`donasi_id`, `order_id`, `program_id`, `user_id`, `donatur_id`, `name`, `anonim`, `status`, `amount`, `phone`, `email`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('6', '1185043059', '2', '0', '0', 'Imam Safii', 'tidak', 'pending', '500000', NULL, 'imamsafii2222022@gmail.com', NULL, NULL, NULL, NULL);
INSERT INTO `donasi` (`donasi_id`, `order_id`, `program_id`, `user_id`, `donatur_id`, `name`, `anonim`, `status`, `amount`, `phone`, `email`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('7', '1187303760', '2', '0', '0', 'Imam Safii', 'tidak', 'pending', '500000', NULL, 'imamsafii2222022@gmail.com', 'imam', NULL, NULL, NULL);

-- Table structure for table `donatur`
DROP TABLE IF EXISTS `donatur`;
CREATE TABLE `donatur` (
  `donatur_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(25) NOT NULL DEFAULT 'donatur',
  `status` varchar(20) NOT NULL DEFAULT 'Aktif',
  `address` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`donatur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `donatur`
INSERT INTO `donatur` (`donatur_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `status`, `address`, `photo`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', 'Donatur', 'Sistem', 'donatur@donasi.com', 'donatur', '$2y$10$w6oNDV2Pq7Kb9X21DQzlLeExM6esdoFqu/1MGdFxQ/B4BkMKd0jRa', 'donatur', 'Aktif', 'Jl. Contoh No. 111', 'default.png', '08123456789', '2025-08-14 16:02:19', '2025-08-15 23:21:29', NULL);
INSERT INTO `donatur` (`donatur_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `status`, `address`, `photo`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', 'Donatur', 'Sistem 2', 'donatur2@donasi.com', 'donatur2', '$2y$10$vBiSb8Au0Nz/Yi/mWvwdmehfd5h67wGFvJeoDSt5HOZYoXQkdMTO6', 'donatur', 'Aktif', 'Jl. Contoh No. 121', 'default.png', '08123456789', '2025-08-14 16:02:19', '2025-08-14 16:02:19', NULL);

-- Table structure for table `fundraiser`
DROP TABLE IF EXISTS `fundraiser`;
CREATE TABLE `fundraiser` (
  `fundraiser_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(25) NOT NULL DEFAULT 'fundraiser',
  `address` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `referral` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`fundraiser_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `fundraiser`
INSERT INTO `fundraiser` (`fundraiser_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `address`, `photo`, `phone`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', 'Fundraiser', 'Sistem', 'fundraiser@donsi.com', 'fundraiser', '$2y$10$vlidLbeqiL5IgQgGUxK4hOS/xmAGr2L0jZF0OgAIrjNZKL/Sd2i9S', 'fundraiser', 'Jl. Contoh No. 789', '1755300010_f7d4225af141b8ee988b.png', '08123456789', 'referral_code', '2025-08-14 16:02:19', '2025-08-15 23:20:10', NULL);
INSERT INTO `fundraiser` (`fundraiser_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `address`, `photo`, `phone`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', 'Fundraiser', 'Sistem 2', 'fundraiser2@donasi.com', 'fundraiser2', '$2y$10$0nWiaDv1AlVCUqU/kMP3HuQHgSrQ1IpZ8aZRp9ARNkB/aZO0mA6zG', 'fundraiser', 'Jl. Contoh No. 101', 'default.png', '08123456789', 'referral_code_2', '2025-08-14 16:02:19', '2025-08-14 16:02:19', NULL);
INSERT INTO `fundraiser` (`fundraiser_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `address`, `photo`, `phone`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', 'fyguhj\'', 'hbhjn', 'imamsafii222222@gmail.com', 'ghvhbml', '$2y$10$CdB4fE5m2czQJ3LI/sd21uX5umUueD5oQZtmP/q5//j3Rrj02YnzG', 'fundraiser', 'Jalan Taman Makam Pahlawan No. 19', '1755300915_7d410c68c8470e332060.jpg', '081548811047', 'FUNDW0MSAM', '2025-08-15 23:35:15', '2025-08-15 23:36:04', NULL);
INSERT INTO `fundraiser` (`fundraiser_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `address`, `photo`, `phone`, `referral`, `created_at`, `updated_at`, `deleted_at`) VALUES ('4', 'vhbjnkm', ' vhbjnkm', 'imamsafii22022@gmail.com', 'admintrfytguyhgiujo', '$2y$10$ZUnOGnYqfA14qgbKgBNAKehzOrR7rjPPib2zgdNK4XfqejJ7qyoxi', 'fundraiser', 'Jalan Taman Makam Pahlawan No. 19', '1755301092_a7aef1f974b8869ee910.jpg', '081548811047', 'FUNDG2AYFM', '2025-08-15 23:38:12', '2025-08-15 23:38:12', NULL);

-- Table structure for table `instansi`
DROP TABLE IF EXISTS `instansi`;
CREATE TABLE `instansi` (
  `instansi_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`instansi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `instansi`
INSERT INTO `instansi` (`instansi_id`, `name`, `description`, `address`, `logo`, `phone`, `email`, `facebook`, `instagram`, `website`, `created_at`, `updated_at`) VALUES ('1', 'Bina Insani Grobogan', 'Yayasan Bina Insani Grobogan adalah lembaga pendidikan dan sosial yang beralamat di Jl. Taman Makam Pahlawan No. 19, Purwodadi, Grobogan, didirikan pada tahun 2006 dan telah memperoleh pengesahan badan hukum dari Kemenkumham pada 26 Februari 2020. Dipimpin oleh Sukamto, S.Pd., MM dengan operator Suwati, yayasan ini menaungi berbagai unit pendidikan seperti KB, SD, dan SMP Islam Terpadu Al Firdaus. Berfokus pada pengembangan potensi individu melalui pendidikan dan pemberdayaan masyarakat, Yayasan Bina Insani aktif menciptakan perubahan positif dan berkelanjutan, serta turut berjejaring dengan lembaga sosial seperti Rumah Zakat untuk memperluas dampak kegiatannya.', 'Jalan Taman Makam Pahlawan No. 19, Purwodadi, Kecamatan Purwodadi', 'logo.png', '081548811047', 'binainsanigrobogan@gmail.com', 'https://facebook.com/donasi', 'https://instagram.com/donasi', 'https://donasi.com', '2025-08-14 16:02:18', '2025-08-14 16:02:18');

-- Table structure for table `migrations`
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES ('16', '2025-08-09-180736', 'App\\Database\\Migrations\\AppMigration', 'default', 'App', '1755187339', '1');

-- Table structure for table `program`
DROP TABLE IF EXISTS `program`;
CREATE TABLE `program` (
  `program_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `target_donate` varchar(100) NOT NULL DEFAULT '0',
  `total_donate` varchar(100) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`program_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `program`
INSERT INTO `program` (`program_id`, `title`, `slug`, `photo`, `description`, `target_donate`, `total_donate`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', 'Sedekah Al Quran dan Hadist', 'Sedekah-Al-Quran-dan-Hadist', '1755299880_823f10db824a2cd66aaa.png', 'Sedekahkan Al-Quran, sebarkan cahaya ilmu dan hidayah untuk generasi penerus Islam.', '1000000', '0', '2025-08-14 16:02:18', '2025-08-15 23:18:08', NULL);
INSERT INTO `program` (`program_id`, `title`, `slug`, `photo`, `description`, `target_donate`, `total_donate`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', 'Donasi Palestina', 'Donasi-Palestina', 'program2.png', 'Bantu saudara kita di Palestina, setiap donasi adalah tanda kepedulian dan persaudaraan seiman.', '200000', '0', '2025-08-14 16:02:18', '2025-08-15 23:14:33', NULL);
INSERT INTO `program` (`program_id`, `title`, `slug`, `photo`, `description`, `target_donate`, `total_donate`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', 'Beasiswa Hafidz Al Quran', 'beasiswa-hafidz-al-quran', 'program3.png', 'Investasi akhirat dengan mencetak generasi penghafal Al-Quran yang unggul dan berakhlak mulia.', '15000000', '0', '2025-08-14 16:02:18', '2025-08-14 16:02:18', NULL);
INSERT INTO `program` (`program_id`, `title`, `slug`, `photo`, `description`, `target_donate`, `total_donate`, `created_at`, `updated_at`, `deleted_at`) VALUES ('4', 'Rdskfsd', 'Rdskfsd', '1755300734_4a9841f868a40b619f48.jpg', 'yuhj', '1000000', '0', '2025-08-15 23:32:14', '2025-08-15 23:32:14', NULL);

-- Table structure for table `setting`
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `set_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `server_key` varchar(200) NOT NULL,
  `client_key` varchar(200) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `setting`
INSERT INTO `setting` (`set_id`, `server_key`, `client_key`, `created_at`, `updated_at`) VALUES ('1', 'SB-Mid-server-4VIz2bklbBYFv_gvPpA33Qw_', 'SB-Mid-client-o6_E3CUErSGC06il', '2025-08-14 16:02:18', '2025-08-14 16:02:18');

-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(25) NOT NULL,
  `status` varchar(25) NOT NULL,
  `address` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `status`, `address`, `photo`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES ('1', 'admin', 'sistem', 'admin@donasi.com', 'admin', '$2y$10$lKCe77cJ6aXnB5Hv/ssLk.EMhS4bWtE89/kUdHHcxxQEAa1fTw3De', 'admin', 'Aktif', 'Jl. Contoh No. 123', '1755299123_82aec2075d574524fb7a.jpg', '081234567810', '2025-08-14 16:02:18', '2025-08-15 23:05:23', NULL);
INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `status`, `address`, `photo`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES ('2', 'ketua', 'sistem', 'ketua@donasi.com', 'ketua', '$2y$10$9VlwCYTpw6r6sZL8MeEGWumdLUtpOHvsYm9L0n1uJX.2.L7V8XEBO', 'ketua', 'Aktif', 'Jl. Contoh No. 456', 'default.png', '08123456789', '2025-08-14 16:02:18', '2025-08-14 16:02:18', NULL);
INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `username`, `password`, `level`, `status`, `address`, `photo`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES ('3', 'bendahara', 'sistem', 'bendahara@donasi.com', 'bendahara', '$2y$10$/SSgvVN6VteLfa1HmMXLWuH6fqWnDTBDsqu7fCv648414gYH/rJCW', 'bendahara', 'Aktif', 'Jl. Contoh No. 456', '1755300307_9ee18927162ee9111723.png', '08123456789', '2025-08-14 16:02:18', '2025-08-15 23:25:07', NULL);

SET foreign_key_checks = 1;
