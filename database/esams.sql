-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2023 at 05:27 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esams`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist_list`
--

CREATE TABLE `artist_list` (
  `id` int(30) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `stage_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `sex` varchar(20) NOT NULL,
  `DOB` date DEFAULT NULL,
  `about_artist` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artist_list`
--

INSERT INTO `artist_list` (`id`, `firstname`, `lastname`, `stage_name`, `email`, `password`, `sex`, `DOB`, `about_artist`, `type`, `avatar`, `date_created`) VALUES
(5, 'David', 'Mwelwa', 'The Priest', 'davidgarciajr955@gmail.com', '55fc5b709962876903785fd64a6961e5', '', '1996-08-05', '', 1, NULL, '2023-08-28 17:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` bigint(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `description`, `status`, `delete_flag`, `created_at`, `updated_at`) VALUES
(1, 'Rock', ' It typically features electric guitars, bass, drums, and vocals, and often has a loud, energetic sound.', 1, 0, '2023-01-26 10:50:48', '2023-05-07 02:36:55'),
(2, 'EDM', 'Associated with electronic devices and instruments, such as synthesizers, drum machines, and samplers.', 1, 0, '2023-01-27 10:19:47', '2023-05-07 02:38:45'),
(3, 'POP', ' Catchy melodies, upbeat rhythms, and simple lyrics that are easy to sing along to.', 1, 0, '2023-01-27 10:20:04', '2023-05-07 02:35:34'),
(4, 'Reggae', 'Typically features a strong bassline, drums, and lyrics that often deal with social and political issues.', 1, 0, '2023-01-27 10:20:26', '2023-05-07 02:42:20'),
(5, 'R&amp;B', 'Typically feature soulful vocals, groovy rhythms, and lyrics about love and heartbreak.', 1, 0, '2023-01-27 10:20:46', '2023-05-07 02:40:37'),
(6, 'Hip-Hop/Rap', 'It typically features rapping (spoken or chanted lyrics), beats, and samples from other songs.', 1, 0, '2023-05-07 02:43:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `music_list`
--

CREATE TABLE `music_list` (
  `id` bigint(30) NOT NULL,
  `title` text NOT NULL,
  `artist` text NOT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `description` text NOT NULL,
  `banner_path` text NOT NULL,
  `audio_path` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Pending, 1=Active, 2=Inactive',
  `streams` int(50) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `music_list`
--

INSERT INTO `music_list` (`id`, `title`, `artist`, `category_id`, `description`, `banner_path`, `audio_path`, `status`, `streams`, `delete_flag`, `created_at`, `updated_at`) VALUES
(4, 'My Way', 'Emmy The Priest feat. Tama', 6, 'Inspirational Rap music written by Emmy The Priest and Produced by a gifted beats smith Skills of the PhatJam Records. The track was released on 16 October 2021', 'uploads/music_banners/banner4_1.jpeg', 'uploads/audio/The Priest - My Way-1_1.mp3', 1, 0, 0, '2023-05-07 03:02:55', '2023-05-07 03:02:56'),
(5, 'Zigolo', 'Jivan &amp; Zack 1\'3', 6, 'Hip-Hop banger by Jivan and Zack 1\'3 called Zogolo wonderfully produced by Skills of the PhatJam Records', 'uploads/music_banners/banner5_2.jpg', 'uploads/audio/Jivan & Zaq-Zigolo-Prod.-By-Skillz_1.mp3', 1, 0, 0, '2023-05-07 03:28:55', '2023-05-07 03:28:57'),
(6, 'Rap Revolution', 'The Priest, Jivan &amp; Laguna BK', 6, 'A Hip-Hop Track done by The Echo Sound Arts Crew in the quest to devise the Rap game and was written by Emmy The Priest. The banger was produced by Vent and Nino', 'uploads/music_banners/banner4_1_1.jpg', 'uploads/audio/Rap Revolution_1.mp3', 1, 0, 0, '2023-05-07 03:33:04', '2023-05-07 03:33:05'),
(7, 'Black Oceans', 'Emmy The Priest', 6, 'A track Done by The Priest to reveal the untold mysteries of the Rap Game. Written and produced by The Priest', 'uploads/music_banners/banner5_1_1.jpg', 'uploads/audio/BLACK OCEANS_1.mp3', 1, 0, 0, '2023-05-07 03:36:37', '2023-05-07 03:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `stream_counter`
--

CREATE TABLE `stream_counter` (
  `id` int(50) NOT NULL,
  `artist_id` int(50) NOT NULL,
  `num_streams` int(50) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Echo Sound Arts Music Storage Gallery'),
(6, 'short_name', 'ESAMS'),
(11, 'logo', 'uploads/logo1.jpg?v=1674703192'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover3.jpg?v=1674699976'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '0972862797'),
(19, 'email', 'info@echosoundartsmusic.com'),
(20, 'address', 'Chilenje, Lusaka Zambia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(30) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'David', '', 'Mwelwa', 'priest', '80298f4f83ade66920bc8521cb63ff80', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2023-02-24 15:45:39'),
(5, 'Angela', '', 'Zulu', 'azulu', 'f495b400db54e6dec5bf2a7f6d40fd56', NULL, NULL, 2, '2023-09-15 10:40:02', '2023-09-15 10:40:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist_list`
--
ALTER TABLE `artist_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music_list`
--
ALTER TABLE `music_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist_list`
--
ALTER TABLE `artist_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `music_list`
--
ALTER TABLE `music_list`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
