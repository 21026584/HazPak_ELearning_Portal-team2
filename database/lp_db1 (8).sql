-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2023 at 08:52 AM
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
-- Database: `lp_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `assessment_id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `assessment_name` varchar(255) NOT NULL,
  `instructions` text NOT NULL,
  `release_datetime` datetime NOT NULL,
  `end_time` time(6) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`assessment_id`, `course_id`, `assessment_name`, `instructions`, `release_datetime`, `end_time`, `user_id`, `questions`) VALUES
(1, 'C01', 'Assessment 1', 'Testing features, should have 3 questions', '2023-07-26 14:00:00', '99:00:00.000000', 'HA02', '[\"1\"]'),
(2, 'C01', 'Assessment 2', 'Testing 2, display', '2023-07-27 14:03:00', '00:00:00.000000', 'HA02', '[\"1\",\"2\"]'),
(3, 'C01', 'Assessment 3', 'Yeet', '2023-07-28 14:04:00', '00:05:00.000000', 'HA02', '[\"1\",\"2\",\"4\",\"5\",\"9\",\"10\"]'),
(6, 'C01', 'Assessment 5', 'Take by today', '2023-08-07 10:19:00', '11:20:00.000000', 'A01', '[\"2\",\"5\",\"9\",\"10\"]'),
(7, 'C01', 'Assessment 6', 'tgas', '2023-08-07 10:51:00', '11:51:00.000000', 'A01', '[\"1\",\"2\"]');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_grade`
--

CREATE TABLE `assessment_grade` (
  `assessment_grade_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `time_taken` time(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessment_grade`
--

INSERT INTO `assessment_grade` (`assessment_grade_id`, `assessment_id`, `course_id`, `user_id`, `score`, `time_taken`) VALUES
(39, 1, 'C01', 'T01', 1, '03:00:00.000000'),
(40, 1, 'C01', 'T01', 1, '03:00:00.000000'),
(42, 1, 'C01', 'T01', 1, '03:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `user_id`, `description`) VALUES
('C01', '', 'Course 1');

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `exercise_id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `exercise_name` varchar(255) NOT NULL,
  `instructions` text NOT NULL,
  `release_datetime` datetime NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`exercise_id`, `course_id`, `exercise_name`, `instructions`, `release_datetime`, `user_id`, `questions`) VALUES
(1, 'C01', 'Exercise 1', 'Testing Exercise features, should have 3 questions', '2023-07-26 19:14:00', 'HA02', '[\"1\",\"2\",\"3\"]');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_grade`
--

CREATE TABLE `exercise_grade` (
  `exercise_grade_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercise_grade`
--

INSERT INTO `exercise_grade` (`exercise_grade_id`, `exercise_id`, `course_id`, `user_id`, `score`) VALUES
(1, 1, 'C01', 'T01', 0),
(5, 1, 'C01', 'T01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `user_id`, `course_id`, `description`, `grade`) VALUES
('G01', 'T01', 'C01', 'Course 1', 'Pass');

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE `question_bank` (
  `question_id` int(11) NOT NULL,
  `question_type_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`question_answer`)),
  `answer_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`answer_options`)),
  `question_image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_bank`
--

INSERT INTO `question_bank` (`question_id`, `question_type_id`, `question_text`, `question_answer`, `answer_options`, `question_image`) VALUES
(1, 0, 'What\'s 9 + 10', '[3]', '[\"1\",\"19\",\"21\",\"31\"]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question_type`
--

CREATE TABLE `question_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_type`
--

INSERT INTO `question_type` (`type_id`, `type_name`) VALUES
(0, 'Multiple Choice'),
(1, 'Fill-in-the-blank'),
(2, 'Dropdown List');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(3) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(0, 'Head Admin'),
(1, 'Admin'),
(2, 'Trainee');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `intake` varchar(255) NOT NULL,
  `firstLogin` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `username`, `password`, `intake`, `firstLogin`) VALUES
('A01', 1, 'AdminA', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', '', 1),
('A02', 1, 'Admin B', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', '', 1),
('HA01', 0, 'Head Admin A', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', '', 0),
('HA02', 0, 'Head Admin B', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', '', 1),
('T01', 2, 'TraineeA', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', '', 0),
('T02', 2, 'Trainee B', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', '', 1),
('T05', 2, 'Loouis', '8be3c943b1609fffbfc51aad666d0a04adf83c9d', '2', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `assessment_grade`
--
ALTER TABLE `assessment_grade`
  ADD PRIMARY KEY (`assessment_grade_id`),
  ADD KEY `assessment_id` (`assessment_id`),
  ADD KEY `assessment_course_id` (`course_id`),
  ADD KEY `assesment_user_id` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`exercise_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `exercise_grade`
--
ALTER TABLE `exercise_grade`
  ADD PRIMARY KEY (`exercise_grade_id`),
  ADD KEY `exg_exercise_id` (`exercise_id`),
  ADD KEY `exg_course_id` (`course_id`),
  ADD KEY `exg_user_id` (`user_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `question_type_id` (`question_type_id`);

--
-- Indexes for table `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `assessment_grade`
--
ALTER TABLE `assessment_grade`
  MODIFY `assessment_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exercise_grade`
--
ALTER TABLE `exercise_grade`
  MODIFY `exercise_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `assessments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `assessment_grade`
--
ALTER TABLE `assessment_grade`
  ADD CONSTRAINT `assesment_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `assessment_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `assessment_id` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`assessment_id`);

--
-- Constraints for table `exercises`
--
ALTER TABLE `exercises`
  ADD CONSTRAINT `exercises_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `exercises_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `exercise_grade`
--
ALTER TABLE `exercise_grade`
  ADD CONSTRAINT `exg_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `exg_exercise_id` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`exercise_id`),
  ADD CONSTRAINT `exg_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD CONSTRAINT `question_bank_ibfk_1` FOREIGN KEY (`question_type_id`) REFERENCES `question_type` (`type_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
