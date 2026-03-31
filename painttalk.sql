-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 02 ديسمبر 2025 الساعة 08:01
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `painttalk`
--

-- --------------------------------------------------------

--
-- بنية الجدول `artworks`
--

CREATE TABLE `artworks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `artworks`
--

INSERT INTO `artworks` (`id`, `user_id`, `title`, `description`, `image_path`, `created_at`) VALUES
(8, 1, 'F1', 'فورملا1', 'uploads/1764595514_4672.jpeg', '2025-12-01 13:25:14'),
(15, 1, 'محمد عبده', 'ياكمال الجمال', 'uploads/1764595687_7852.jpeg', '2025-12-01 13:28:07'),
(19, 3, 'Formula 1', '', 'uploads/1764656182_7574.jpeg', '2025-12-02 06:16:22'),
(21, 4, 'الرياض', 'ضضضض', 'uploads/1764658149_6541.jpeg', '2025-12-02 06:49:09');

-- --------------------------------------------------------

--
-- بنية الجدول `art_comments`
--

CREATE TABLE `art_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `art_comments`
--

INSERT INTO `art_comments` (`id`, `user_id`, `artwork_id`, `content`, `created_at`) VALUES
(2, 1, 8, 'واوووو', '2025-12-01 13:25:27'),
(3, 1, 15, 'woww', '2025-12-01 13:28:19'),
(4, 2, 8, 'wowww', '2025-12-01 13:45:37'),
(5, 2, 15, 'حبيت', '2025-12-01 13:45:59'),
(7, 3, 8, 'جميله', '2025-12-02 03:54:10'),
(8, 3, 19, 'واوو حلوه مره', '2025-12-02 06:17:19');

-- --------------------------------------------------------

--
-- بنية الجدول `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `artwork_id`, `created_at`) VALUES
(2, 1, 8, '2025-12-01 13:25:18'),
(3, 1, 15, '2025-12-01 13:28:11'),
(4, 2, 8, '2025-12-01 13:45:39'),
(5, 2, 15, '2025-12-01 13:45:49'),
(7, 3, 15, '2025-12-02 03:53:38'),
(8, 3, 8, '2025-12-02 03:53:54'),
(9, 3, 19, '2025-12-02 06:16:29'),
(11, 4, 15, '2025-12-02 06:49:48');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'layan', 'lyan2006m@gmail.com', '$2y$10$50y3jo2p8MahvNxoErcc6.dYexQFq1QvKtNHJMN8zFYUaf93K33MC', '2025-12-01 10:14:04'),
(2, 'm1', 'may-world@hotmail.com', '$2y$10$JCsQyYo5G6bJh238bo7QgeIeBqROXNXD3Oi7Yx903x9ZwmyBvLpIm', '2025-12-01 13:45:23'),
(3, 'nuha', 'nuha@gmail.com', '$2y$10$lNy9raCTpHKqZTM/GfZhv.eHmY4FEgAevUNdf8JkJ8B6ZN2exIu62', '2025-12-02 03:53:15'),
(4, 'a', 'rahaf@gmail.com', '$2y$10$jqZSYD8fYnJUI.ZfY6HGTubT4XkZ1SbE6In0xxUgK.02Z9P6rsAKC', '2025-12-02 06:27:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artworks_user` (`user_id`);

--
-- Indexes for table `art_comments`
--
ALTER TABLE `art_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_user` (`user_id`),
  ADD KEY `fk_comments_artwork` (`artwork_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_like` (`user_id`,`artwork_id`),
  ADD KEY `fk_likes_artwork` (`artwork_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `art_comments`
--
ALTER TABLE `art_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `artworks`
--
ALTER TABLE `artworks`
  ADD CONSTRAINT `fk_artworks_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `art_comments`
--
ALTER TABLE `art_comments`
  ADD CONSTRAINT `fk_comments_artwork` FOREIGN KEY (`artwork_id`) REFERENCES `artworks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_artwork` FOREIGN KEY (`artwork_id`) REFERENCES `artworks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_likes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
