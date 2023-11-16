-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 12:12 PM
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
-- Database: `apprentice`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `experience` enum('beginner','mentor') NOT NULL,
  `profession` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastlogin` text DEFAULT NULL,
  `code` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `experience`, `profession`, `password`, `registration_date`, `lastlogin`, `code`) VALUES
(3, 'King', 'Asgard', 'asgard@gmail.com', 'mentor', 'Artificial Intelligence', '$2y$10$jti1bB/P5r0GMA7YWL3/jO82WwA6dw32D/LgtyHFGZEmC/QQtUkCa', '2023-10-10 11:49:54', NULL, NULL),
(4, 'Bosco121', 'Mlulwa', 'wmuchiri@strathmore.edu', 'beginner', 'Front end', '$2y$10$Cj5NBHbWPy.1yaZS/d9G2OD2kqGDnHNnFjfy4MEEAZ3DwAcBkelqe', '2023-10-11 07:41:40', '2023-10-11 10:07:32', 83970),
(5, 'Aicha', 'Zindamoyen', 'zindamoyen2@gmail.com', 'beginner', 'Back end', '$2y$10$qKDEuYkVZAEFEeaeLzDI.eO8ip/jiHYFXHRK5lNg6kLg6XdiEByPa', '2023-10-12 12:12:07', '2023-10-12 14:12:18', 94707),
(6, 'Kamondia', 'Walter', 'kamondia101@gmail.com', 'beginner', 'Artificial Intelligence', '$2y$10$Kn5Z6ArDtKIBUXBeyQDmmOBy6lFj9NxM/ZTQgxoaeYfD3XRB3NtUm', '2023-10-16 15:28:24', '2023-10-16 17:30:27', 87726),
(7, 'Moses', 'Mbugua', 'mbuguam323@gmail.com', 'mentor', 'Cyber Security', '$2y$10$nHGchvL215aBcRX5K/nnU.tjTSLQlQVCOvouoS1rWBqo7nbconVWK', '2023-10-17 11:22:03', '2023-11-16 11:53:27', 46889),
(11, 'Aicha', 'Zindamoyen', 'zindamuoyen2@gmail.com', 'beginner', 'Back end', '$2y$10$qKDEuYkVZAEFEeaeLzDI.eO8ip/jiHYFXHRK5lNg6kLg6XdiEByPa', '2023-10-12 12:12:07', '2023-10-12 14:12:18', 94707);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
