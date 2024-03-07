-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 04:13 AM
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
-- Database: `db_ct06`
--
CREATE DATABASE IF NOT EXISTS `db_ct06` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_ct06`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `author` varchar(256) NOT NULL,
  `imagefile` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `description`, `author`, `imagefile`) VALUES
(1, 'PHP and MySQL', 'PHP Language for Web Developer. Incididunt excepteur culpa exercitation pariatur labore ipsum ea non eiusmod deserunt amet. Veniam voluptate ea adipisicing qui anim veniam laboris occaecat sint minim ipsum. Eu esse cupidatat deserunt ut ex aliquip id ut ut excepteur incididunt veniam ut laborum. Minim proident dolor sit nostrud aute consectetur velit irure duis. Mollit cupidatat eu deserunt tempor fugiat deserunt reprehenderit est labore adipisicing qui. Anim incididunt ut labore occaecat do occaecat tempor aliqua velit Lorem ut excepteur.', 'Kevin', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `actived` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `actived`) VALUES
(1, 'root', '$2y$10$k7bkuy2tx2uII9PLqy.Tee6dLNh1gunNR2rPazoz4q7FAc9gwQqtO', 1),
(2, 'daclam', '$2y$10$k7bkuy2tx2uII9PLqy.Tee6dLNh1gunNR2rPazoz4q7FAc9gwQqtO', 1),
(4, 'admin', '$2y$10$k7bkuy2tx2uII9PLqy.Tee6dLNh1gunNR2rPazoz4q7FAc9gwQqtO', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
