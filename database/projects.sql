-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 11:38 AM
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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `image_path`, `description`, `title`, `category`, `start_date`, `end_date`, `is_deleted`) VALUES
(1, 7, '../images/project_images/d28fae66aa7684395cb8dd7760b90891.jpg', 'Hadi sijui hii ni gani', 'hadi ', 'ArtificialIntelligence', '2023-11-30', '2023-12-09', 1),
(4, 7, '../images/project_images/F90tXWJakAA1UqE.jpeg', 'please work', 'Let me cook', 'IOT', '2023-11-13', '2023-12-09', 0),
(5, 7, '../images/project_images/F9204pTXgAAW-A9.jpeg', 'anime 4 life', 'Jogo is weak', 'IOT', '2023-11-13', '2023-12-09', 0),
(6, 7, '../images/project_images/premio.jpg', 'Toyota premio \r\nstanced', 'Premio', 'ArtificialIntelligence', '2023-11-13', '2023-12-01', 0),
(7, 7, '../images/project_images/4q1MFt.jpg', 'Mitsubishi Evo x', 'Evo ix', 'ArtificialIntelligence', '2023-12-09', '2023-12-09', 0),
(8, 7, '../images/project_images/HTML-Basics.webp', 'The HyperText Markup Language or HTML is the standard markup language for documents designed to be displayed in a web browser. It defines the meaning and structure of web content. It is often assisted by technologies such as Cascading Style Sheets (CSS) and scripting languages such as JavaScript.\r\n\r\n', 'HTML and CSS', 'Front End', '2023-11-14', '2023-12-09', 0),
(9, 7, '../images/project_images/program.webp', 'The HyperText Markup Language or HTML is the standard markup language for documents designed to be displayed in a web browser. It defines the meaning and structure of web content. It is often assisted by technologies such as Cascading Style Sheets (CSS) and scripting languages such as JavaScript.\r\n\r\nWeb browsers receive HTML documents from a web server or from local storage and render the documents into multimedia web pages. HTML describes the structure of a web page semantically and originally included cues for its appearance.\r\n\r\nHTML can embed programs written in a scripting language such as JavaScript, which affects the behavior and content of web pages. The inclusion of CSS defines the look and layout of content. The World Wide Web Consortium (W3C), former maintainer of the HTML and current maintainer of the CSS standards, has encouraged the use of CSS over explicit presentational HTML since 1997. A form of HTML, known as HTML5, is used to display video and audio, primarily using the  element, together with JavaScript.\r\n\r\nThe first publicly available description of HTML was a document called &#34;HTML Tags&#34;,\r\n\r\nAfter the HTML and HTML+ drafts expired in early 1994, the IETF created an HTML Working Group. In 1995, this working group completed &#34;HTML 2.0&#34;, the first HTML specification intended to be treated as a standard against which future implementations should be based.', 'trial 2', 'Artificial Intelligence', '2023-12-09', '2023-12-09', 0),
(10, 7, '../images/project_images/download.jpeg', 'The HyperText Markup Language or HTML is the standard markup language for documents designed to be displayed in a web browser. It defines the meaning and structure of web content. It is often assisted by technologies such as Cascading Style Sheets (CSS) and scripting languages such as JavaScript.\r\n\r\nWeb browsers receive HTML documents from a web server or from local storage and render the documents into multimedia web pages. HTML describes the structure of a web page semantically and originally included cues for its appearance.\r\n\r\nHTML can embed programs written in a scripting language such as JavaScript, which affects the behavior and content of web pages. The inclusion of CSS defines the look and layout of content. The World Wide Web Consortium (W3C), former maintainer of the HTML and current maintainer of the CSS standards, has encouraged the use of CSS over explicit presentational HTML since 1997. A form of HTML, known as HTML5, is used to display video and audio, primarily using the  element, together with JavaScript.\r\n\r\nThe first publicly available description of HTML was a document called &#34;HTML Tags&#34;,\r\n\r\nAfter the HTML and HTML+ drafts expired in early 1994, the IETF created an HTML Working Group. In 1995, this working group completed &#34;HTML 2.0&#34;, the first HTML specification intended to be treated as a standard against which future implementations should be based.', 'CSS', 'Front End', '2023-11-14', '2023-12-09', 0),
(11, 7, '../images/project_images/house.png', 'hehehe', 'Operation build', 'IOT', '2023-11-14', '2023-12-09', 0),
(12, 7, '../images/project_images/riggy g.jpeg', 'Operation destroy kenya\r\nwakadinali 4 life\r\nNairobi baddies', 'Riggy G', 'Cyber Security', '2023-11-14', '2023-12-09', 0),
(13, 7, '../images/project_images/riggy g.jpeg', 'riggy g', 'Loans', 'Artificial Intelligence', '2023-11-14', '2023-12-09', 0),
(14, 7, '../images/project_images/meme.jpg', 'meme', 'meme', 'Artificial Intelligence', '2023-11-16', '2023-12-09', 0),
(15, 7, '../images/project_images/creepy squidward.jpg', 'bleh', 'Squidward', 'Back End', '2023-11-21', '2023-12-09', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_is_deleted` (`is_deleted`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
