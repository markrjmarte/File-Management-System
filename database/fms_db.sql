-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2023 at 11:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent_id` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notary`
--

CREATE TABLE `notary` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent_id` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notary`
--

INSERT INTO `notary` (`id`, `user_id`, `name`, `parent_id`) VALUES
(2, 1, '1', 1),
(3, 1, '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notary_files`
--

CREATE TABLE `notary_files` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `parent_id` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `user_id`, `name`, `parent_id`) VALUES
(3, 1, '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `template_files`
--

CREATE TABLE `template_files` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1+admin , 2 = users',
  `adress` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `about` varchar(200) NOT NULL,
  `profile_image` varchar(60) NOT NULL,
  `job` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`, `adress`, `phone`, `email`, `about`, `profile_image`, `job`) VALUES
(1, 'Administrator', 'admin', 'admin123', 1, '', '', '', '', 'profile.jpg', ''),
(5, '1', '21', '21', 2, '1', '1', '1@gmail.com', '112121', 'profile.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_logs`
--

CREATE TABLE `users_logs` (
  `status` varchar(200) NOT NULL,
  `users` varchar(200) NOT NULL,
  `dates` varchar(200) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_logs`
--

INSERT INTO `users_logs` (`status`, `users`, `dates`, `id`) VALUES
('Created the folder 2', 'admin', '2023-08-23 04:33:04', 1),
('Created the folder 2', 'admin', '2023-08-23 04:33:17', 2),
('Created the folder 2', 'admin', '2023-08-23 04:33:23', 3),
('Deleted a folder', 'admin', '2023-08-23 04:34:56', 4),
('Deleted a folder', 'admin', '2023-08-23 04:35:02', 5),
('Deleted a folder', 'admin', '2023-08-23 04:35:07', 6),
('Added a file called setenv (1)', 'admin', '2023-08-23 04:48:03', 7),
('Added a file called setenv (1)', 'admin', '2023-08-23 04:48:23', 8),
('Added a file called setenv (1)', 'admin', '2023-08-23 04:48:30', 9),
('Renamed a file into setenv.sh', 'admin', '2023-08-23 04:48:45', 10),
('Renamed a file into setenv.sh', 'admin', '2023-08-23 04:48:59', 11),
('Renamed a file into setenv.sh', 'admin', '2023-08-23 04:49:05', 12),
('Deleted a file ', 'admin', '2023-08-23 04:49:15', 13),
('Deleted a folder ', 'admin', '2023-08-23 04:53:49', 14),
('Deleted a folder ', 'admin', '2023-08-23 04:54:00', 15),
('Deleted a folder ', 'admin', '2023-08-23 04:54:05', 16),
('Add users 2', 'admin', '2023-08-23 05:00:33', 17),
('Update users 1', 'admin', '2023-08-23 05:00:47', 18),
('Update users Administrator', 'admin', '2023-08-23 05:00:59', 19),
('Add users dddd', 'admin', '2023-08-23 05:02:09', 20),
('Deleted a user', 'admin', '2023-08-23 05:10:52', 21),
('Deleted a user', 'admin', '2023-08-23 05:10:55', 22),
('Deleted a user', 'admin', '2023-08-23 05:10:59', 23),
('Created the folder 1', 'admin', '2023-08-23 05:17:08', 24),
('Created the folder 2', 'admin', '2023-08-23 05:17:13', 25),
('Created the folder 2', 'admin', '2023-08-23 05:17:18', 26),
('Created the folder 2', 'admin', '2023-08-23 05:17:23', 27),
('Deleted a folder ', 'admin', '2023-08-23 05:18:55', 28),
('Deleted a folder ', 'admin', '2023-08-23 05:19:47', 29);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notary`
--
ALTER TABLE `notary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notary_files`
--
ALTER TABLE `notary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_files`
--
ALTER TABLE `template_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_logs`
--
ALTER TABLE `users_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notary`
--
ALTER TABLE `notary`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notary_files`
--
ALTER TABLE `notary_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `template_files`
--
ALTER TABLE `template_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_logs`
--
ALTER TABLE `users_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
