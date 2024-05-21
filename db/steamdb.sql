-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 03:44 PM
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
-- Database: `steamdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `genre`) VALUES
(1, 'Action'),
(2, 'Horror'),
(3, 'Comedy'),
(4, 'Drama'),
(5, 'Thriller'),
(6, 'Sci-Fi'),
(7, 'Anime'),
(8, 'Pixar'),
(9, 'Crime'),
(10, 'Advernture'),
(11, 'Documentary'),
(12, 'Cartoon'),
(13, 'Fantasy');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `erscheinungsJahr` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `dauer` int(11) NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `erscheinungsJahr`, `genre`, `dauer`, `link`) VALUES
(1, 'The Fast and the Furious', 2001, 1, 120, 'https://www.imdb.com/title/tt0232500/'),
(2, 'Saw', 2004, 2, 120, 'https://www.imdb.com/title/tt0387564/'),
(3, 'Saw', 2004, 2, 120, 'https://www.imdb.com/title/tt0387564/'),
(4, 'American Gangster', 2007, 1, 180, 'https://www.imdb.com/title/tt0765429/?ref_=nv_sr_srsg_0_tt_7_nm_1_q_american%2520gangster'),
(7, 'Training Day', 2001, 1, 120, 'https://www.imdb.com/title/tt0139654/?ref_=nv_sr_srsg_0_tt_8_nm_0_q_Training%2520d'),
(8, 'Malcolm X', 1992, 1, 202, 'https://www.imdb.com/title/tt0104797/'),
(9, 'Good Will Hunting', 1998, 4, 120, ''),
(10, '\'', 1, 1, 1, ''),
(12, 'A Beautiful Mind', 2001, 4, 135, 'https://www.imdb.com/title/tt0268978/'),
(13, 'Batman The Dark Knight', 2008, 1, 152, 'https://www.imdb.com/title/tt0468569/'),
(14, 'Blood in Blood out', 1993, 9, 180, 'https://www.imdb.com/title/tt0106469/?ref_=nv_sr_srsg_0_tt_8_nm_0_q_blood%2520in%2520bloo');

-- --------------------------------------------------------

--
-- Table structure for table `serien`
--

CREATE TABLE `serien` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `erscheinungsjahr` int(11) NOT NULL,
  `staffeln` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `serien`
--

INSERT INTO `serien` (`id`, `title`, `erscheinungsjahr`, `staffeln`, `genre`, `link`) VALUES
(2, 'Breaking Bad', 2008, 5, 9, 'https://www.imdb.com/title/tt0903747/?ref_=nv_sr_srsg_0_tt_8_nm_0_q_Breakin'),
(3, 'Game Of Thrones', 2011, 8, 13, 'https://www.imdb.com/title/tt0944947/?ref_=nv_sr_srsg_0_tt_8_nm_0_q_Game%2520of');

-- --------------------------------------------------------

--
-- Table structure for table `user_movies`
--

CREATE TABLE `user_movies` (
  `email` varchar(100) NOT NULL,
  `movie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_movies`
--

INSERT INTO `user_movies` (`email`, `movie`) VALUES
('mokastrom@gmail.com', 8),
('dilo@uni.com', 9),
('dilo@uni.com', 10),
('mokastrom@gmail.com', 12),
('mokastrom@gmail.com', 13),
('mokastrom@gmail.com', 14);

-- --------------------------------------------------------

--
-- Table structure for table `user_serien`
--

CREATE TABLE `user_serien` (
  `email` varchar(100) NOT NULL,
  `serie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_serien`
--

INSERT INTO `user_serien` (`email`, `serie`) VALUES
('mokastrom@gmail.com', 2),
('mokastrom@gmail.com', 3);

-- --------------------------------------------------------

--
-- Table structure for table `usrs`
--

CREATE TABLE `usrs` (
  `email` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `benutzername` varchar(100) NOT NULL,
  `passwort` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usrs`
--

INSERT INTO `usrs` (`email`, `nachname`, `vorname`, `benutzername`, `passwort`) VALUES
('aghiadfreej@gmail.com', 'Freej', 'aghiad', 'aj360', 'mesqueunclub'),
('ahmadking@gmail.com', 'freej', 'ahmad', 'ahmadking', 'ahonor8ad'),
('alanbacho@uni.de', 'Bacho', 'Alan', 'Alanbacho', 'winf2025'),
('dilo@uni.com', 'bacho', 'dilo', 'dillo', 'tiblernen'),
('jules@gmail.com', 'Julian', 'Wirtz', 'JW10', 'Leverkusen10'),
('mobahserjalal@yahoo.com', 'Mobahser', 'Jalal', 'mjalal13', 'mobasher'),
('mokastrom@gmail.com', 'Freej', 'Mohammad', 'moka', '22332123'),
('Niko@uni.de', 'Kastanos', 'Niko', 'nikometeora', 'winf2024'),
('striker@knockout.com', 'theOrcane', 'Kate', '0xKate', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie-genre` (`genre`);

--
-- Indexes for table `serien`
--
ALTER TABLE `serien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serien-genre` (`genre`);

--
-- Indexes for table `user_movies`
--
ALTER TABLE `user_movies`
  ADD KEY `user_movie_movie` (`movie`),
  ADD KEY `email_user` (`email`);

--
-- Indexes for table `user_serien`
--
ALTER TABLE `user_serien`
  ADD KEY `user_serien_email` (`email`),
  ADD KEY `user_serien_serie` (`serie`);

--
-- Indexes for table `usrs`
--
ALTER TABLE `usrs`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `serien`
--
ALTER TABLE `serien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movie-genre` FOREIGN KEY (`genre`) REFERENCES `genres` (`id`);

--
-- Constraints for table `serien`
--
ALTER TABLE `serien`
  ADD CONSTRAINT `serien-genre` FOREIGN KEY (`genre`) REFERENCES `genres` (`id`);

--
-- Constraints for table `user_movies`
--
ALTER TABLE `user_movies`
  ADD CONSTRAINT `email_user` FOREIGN KEY (`email`) REFERENCES `usrs` (`email`),
  ADD CONSTRAINT `user_movie_movie` FOREIGN KEY (`movie`) REFERENCES `movies` (`id`);

--
-- Constraints for table `user_serien`
--
ALTER TABLE `user_serien`
  ADD CONSTRAINT `user_serien_email` FOREIGN KEY (`email`) REFERENCES `usrs` (`email`),
  ADD CONSTRAINT `user_serien_serie` FOREIGN KEY (`serie`) REFERENCES `serien` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
