-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2025 at 06:56 AM
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
-- Database: `cmrit_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_register`
--

CREATE TABLE `student_register` (
  `id` int(14) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `guardian_mobile_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `class` varchar(10) NOT NULL,
  `program_interest` varchar(100) NOT NULL,
  `institution_type` enum('Aided','Unaided') NOT NULL,
  `caste` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `school_udise_number` varchar(50) DEFAULT NULL,
  `aadhaar_number` varchar(12) DEFAULT NULL,
  `tenth_marks` int(11) DEFAULT NULL,
  `tenth_percentage` decimal(5,2) DEFAULT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT 1,
  `current_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `tenth_marksheet` mediumblob DEFAULT NULL,
  `school_leaving_certificate` mediumblob DEFAULT NULL,
  `aadhaar_card` mediumblob DEFAULT NULL,
  `passport_photo` mediumblob DEFAULT NULL,
  `caste_certificate` mediumblob DEFAULT NULL,
  `non_creamy_layer_certificate` mediumblob DEFAULT NULL,
  `ews_eligibility_certificate` mediumblob DEFAULT NULL,
  `domicile_certificate` mediumblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_register`
--
ALTER TABLE `student_register`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_register`
--
ALTER TABLE `student_register`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
