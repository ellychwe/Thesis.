-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 11:43 AM
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
-- Database: `scholarship`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_dashboard_documents`
--

CREATE TABLE `admin_dashboard_documents` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `doc_type` enum('Pending','Expired','Liquidation') DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_dashboard_documents`
--

INSERT INTO `admin_dashboard_documents` (`id`, `student_id`, `doc_type`, `status`) VALUES
(1, 1, 'Pending', 'Active'),
(2, 1, 'Expired', 'Active'),
(3, 1, 'Liquidation', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `admin_dashboard_students`
--

CREATE TABLE `admin_dashboard_students` (
  `id` int(11) NOT NULL,
  `school_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `scholarship` varchar(50) DEFAULT NULL,
  `program` varchar(50) DEFAULT NULL,
  `year_level` varchar(10) DEFAULT NULL,
  `enrollment_status` enum('Enrolled','Not Enrolled') DEFAULT 'Not Enrolled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_dashboard_students`
--

INSERT INTO `admin_dashboard_students` (`id`, `school_id`, `name`, `scholarship`, `program`, `year_level`, `enrollment_status`) VALUES
(1, '226039', 'Choi Seungcheol', 'TES', 'BSCS', 'IV', 'Enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `application_id`, `doc_type`, `file_path`) VALUES
(2, 6, 'tdp_form', 'uploads/tdp_form_68a6dfe523d4d.pdf'),
(3, 6, 'reg_form', 'uploads/reg_form_68a6dfe526d22.pdf'),
(4, 6, 'grades_form', 'uploads/grades_form_68a6dfe52a96a.pdf'),
(5, 7, 'tdp_form', 'uploads/tdp_form_68a6e01d50715.pdf'),
(6, 7, 'reg_form', 'uploads/reg_form_68a6e01d63226.pdf'),
(7, 7, 'grades_form', 'uploads/grades_form_68a6e01d65214.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_applications`
--

CREATE TABLE `student_applications` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `year_level` varchar(10) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `scholarship_type` varchar(100) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `date_submitted` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `tdp_form` varchar(255) DEFAULT NULL,
  `reg_form` varchar(255) DEFAULT NULL,
  `grades_form` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_applications`
--

INSERT INTO `student_applications` (`id`, `student_id`, `first_name`, `middle_name`, `last_name`, `program`, `year_level`, `section`, `email`, `phone`, `dob`, `gender`, `address`, `zipcode`, `scholarship_type`, `semester`, `academic_year`, `date_submitted`, `status`, `tdp_form`, `reg_form`, `grades_form`) VALUES
(1, '2025001', 'Test', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Full Scholarship', '1st', '2025-2026', '2025-08-20 22:53:11', 'Pending', NULL, NULL, NULL),
(2, '226039', 'Karylle', 'Bautista', 'Bautista', 'bscs', 'III', 'B', '226039@asu.edu.ph', '09319492161', '2004-03-27', 'Female', 'Nauring, Pandan, Antique', '5712', 'tdp-suc', '1st', '2025-2026', '2025-08-20 17:58:04', 'Pending', 'tdp_68a5f08c21be4.pdf', 'reg_68a5f08c21e1f.pdf', 'grades_68a5f08c22895.pdf'),
(3, '220515', 'Seung', 'cheol', 'Choi', 'bscs', 'IV', 'A', 'choiseungcheol@asu.edu.ph', '09319492161', '2004-03-27', 'Male', 'South Korea', '5712', 'TDP-SUC', '2nd', '2025-2026', '2025-08-21 10:35:13', 'Pending', 'tdp_68a6da410c025.pdf', 'reg_68a6da410c56e.pdf', 'grades_68a6da410ca76.pdf'),
(4, '220515', 'Seung', 'cheol', 'Choi', 'bscs', 'IV', 'A', 'choiseungcheol@asu.edu.ph', '09319492161', '2004-03-27', 'Male', 'South Korea', '5712', 'TDP-SUC', '2nd', '2025-2026', '2025-08-21 10:47:31', 'Pending', 'uploads/tdp_68a6dd2355854.pdf', 'uploads/reg_68a6dd2355bef.pdf', 'uploads/grades_68a6dd2355ef4.pdf'),
(5, '220515', 'Seung', 'cheol', 'Choi', 'bscs', 'IV', 'A', 'choiseungcheol@asu.edu.ph', '09319492161', '2004-03-27', 'Male', 'South Korea', '5712', 'TDP-SUC', '2nd', '2025-2026', '2025-08-21 10:52:38', 'Pending', 'uploads/tdp_68a6de569fe05.pdf', 'uploads/reg_68a6de56a0da3.pdf', 'uploads/grades_68a6de56a142a.pdf'),
(6, '220515', 'Seung', 'cheol', 'Choi', 'bscs', 'IV', 'A', 'choiseungcheol@asu.edu.ph', '09319492161', '2004-03-27', 'Male', 'South Korea', '5712', 'TDP-SUC', '2nd', '2025-2026', '2025-08-21 10:59:17', 'Pending', NULL, NULL, NULL),
(7, '220515', 'Seung', 'cheol', 'Choi', 'bscs', 'IV', 'A', 'choiseungcheol@asu.edu.ph', '09319492161', '2004-03-27', 'Male', 'South Korea', '5712', 'TDP-SUC', '2nd', '2025-2026', '2025-08-21 11:00:13', 'Pending', NULL, NULL, NULL),
(8, '220515', 'Seung', 'cheol', 'Choi', 'bscs', 'IV', 'A', 'choiseungcheol@asu.edu.ph', '09319492161', '2004-03-27', 'Male', 'South Korea', '5712', 'TDP-SUC', '2nd', '2025-2026', '2025-08-21 11:02:17', 'Pending', 'tdp_68a6e0990153b.pdf', 'reg_68a6e09901916.pdf', 'grades_68a6e09901cde.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','osa','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin1', '$2y$10$zRbV37d.ZVuRCmI115SAouZFJJxCkjUFelHDl6zr1VCD.7p/JkQVa', 'admin'),
(2, 'admin2', '$2y$10$PdM35c7Q8RQiKDcp9CPb.O5sFJAkNBnD2YotrZ.tQLC0tO0gtqbya', 'admin'),
(3, 'osasuser', '$2y$10$oCYqgK5awoETJxDU.2hxwO94UtkVfFX6p36Q/8W8e9TuW0H/CMjIK', 'osa'),
(4, 'student1', '$2y$10$3TdT5NkjyZ6EN/Ea7BqaKew1WfDpP3HSR87fcxKpsPAvk7uHRh/mC', 'student'),
(5, 'student2', '$2y$10$E4yHWj.jK0YX7ad3ugZPEOrL9MBaCPTkMd9dnVZftrG/HswvNpdO.', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_dashboard_documents`
--
ALTER TABLE `admin_dashboard_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `admin_dashboard_students`
--
ALTER TABLE `admin_dashboard_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_applications`
--
ALTER TABLE `student_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_dashboard_documents`
--
ALTER TABLE `admin_dashboard_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_dashboard_students`
--
ALTER TABLE `admin_dashboard_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_applications`
--
ALTER TABLE `student_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_dashboard_documents`
--
ALTER TABLE `admin_dashboard_documents`
  ADD CONSTRAINT `admin_dashboard_documents_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `admin_dashboard_students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `student_applications` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
