-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2025 at 07:32 PM
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
-- Database: `lms_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `ai_description` text DEFAULT NULL,
  `duration_hours` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `trainer_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `video_url`, `pdf_file`, `ai_description`, `duration_hours`, `status`, `created_at`, `updated_at`, `trainer_id`) VALUES
(1, 'Python', 'Python is a versatile, high-level programming language known for its simplicity and readability. It\'s great for beginners but powerful enough for advanced projects. Python is used in web development, data analysis, machine learning, automation, and more. With its easy-to-understand syntax and large community support, it\'s one of the most popular programming languages in the world today. Whether you\'re building apps or analyzing data, Python is a great choice!', 'https://youtu.be/K5KVEU3aaeQ?si=5SmQfAL2A0E_AXNP', 'course_pdfs/l2CHfL3S4rN4F4ergxrYGVH2n8pokm8Ts3x8AZGN.pdf', NULL, 12, 1, '2025-12-22 10:08:44', '2025-12-25 07:51:09', 4),
(2, 'Javascript', 'JavaScript is a dynamic, high-level programming language that’s mainly used for creating interactive and dynamic websites. It runs in the browser, allowing developers to build things like animations, games, interactive forms, and even full web apps. It works alongside HTML and CSS to create modern web pages. JavaScript is also widely used on the server-side (with frameworks like Node.js). It\'s super versatile and can be used for both front-end (what the user sees) and back-end (server-side) development, making it one of the core technologies of web development.', NULL, NULL, NULL, 10, 1, '2025-12-22 10:09:18', '2025-12-25 13:52:23', 4),
(3, 'Html & CSS', 'HTML (HyperText Markup Language) is the foundation of web pages. It defines the structure of a webpage by using \"tags\" to create elements like headings, paragraphs, images, links, and more. HTML is like the skeleton of a webpage, telling the browser how to display content.\r\n\r\nCSS (Cascading Style Sheets) is used to control the appearance and layout of those HTML elements. With CSS, you can change things like colors, fonts, spacing, and positioning. While HTML defines the structure, CSS makes it look good and ensures it’s responsive across different screen sizes. Together, HTML and CSS are the building blocks for creating attractive, functional websites.', NULL, NULL, NULL, 6, 1, '2025-12-22 10:10:04', '2025-12-25 13:58:18', 4),
(4, 'PHP with MySQL', 'Learn the fundamentals of PHP to build dynamic websites and web applications. This course covers PHP syntax, control structures, forms handling, database integration with MySQL, and basic object-oriented programming. By the end, you\'ll be able to create interactive web applications using PHP and MySQL.', 'https://youtu.be/zZ6vybT1HQs?si=1tTYBs9Z56okDj5o', NULL, NULL, 18, 0, '2025-12-23 05:52:03', '2025-12-25 08:54:14', 5);

-- --------------------------------------------------------

--
-- Table structure for table `course_students`
--

CREATE TABLE `course_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_students`
--

INSERT INTO `course_students` (`id`, `course_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-12-25 08:23:05', '2025-12-25 08:23:05'),
(2, 3, 2, '2025-12-25 10:52:04', '2025-12-25 10:52:04'),
(3, 1, 3, '2025-12-25 10:56:33', '2025-12-25 10:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_role` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `user_role`, `subject`, `message`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'trainer', 'Issue', 'Please remove me from Python Course.', 3, 'resolved', '2025-12-25 13:07:12', '2025-12-25 13:20:49'),
(2, 3, 'student', 'Unenroll', 'Please un-enroll me from course.', 5, 'resolved', '2025-12-25 13:22:25', '2025-12-25 13:24:31'),
(3, 2, 'student', 'Issue', 'Yaar ye kia he. ..', 1, 'new', '2025-12-25 14:05:19', '2025-12-25 14:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_20_072503_create_courses_table', 1),
(5, '2025_12_22_152056_add_trainer_video_pdf_to_courses_table', 2),
(6, '2025_12_25_125805_create_course_user_table', 3),
(7, '2025_12_25_175915_create_feedback_table', 4),
(8, '2025_12_26_154348_create_quizzes_table', 5),
(9, '2025_12_26_154433_create_quiz_questions_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `creator_role` varchar(20) NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `total_questions` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `created_by`, `creator_role`, `topic`, `total_questions`, `created_at`, `updated_at`) VALUES
(2, 4, 1, 'admin', 'PHP', 10, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(3, 1, 1, 'admin', 'Python', 10, '2025-12-26 13:30:03', '2025-12-26 13:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` enum('A','B','C','D') NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `sort_order`, `created_at`, `updated_at`) VALUES
(11, 2, 'What is the correct way to start a PHP script?', '<?php', '<script php>', '<?', '<!--php', 'A', 1, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(12, 2, 'How do you declare a variable in PHP?', 'var $name;', '$name = \"value\";', 'name = \"value\";', 'variable $name;', 'B', 2, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(13, 2, 'Which keyword is used to handle multiple conditions in PHP?', 'else if', 'elseif', 'switch', 'All of the above', 'D', 3, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(14, 2, 'Which loop is best suited for iterating over arrays in PHP?', 'for', 'while', 'foreach', 'do-while', 'C', 4, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(15, 2, 'Which superglobal variable is used to collect data from an HTML form submitted with the POST method?', '$_GET', '$_POST', '$_REQUEST', '$_SESSION', 'B', 5, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(16, 2, 'What data type would `true` or `false` represent in PHP?', 'String', 'Integer', 'Boolean', 'Float', 'C', 6, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(17, 2, 'How do you write a single-line comment in PHP?', '/* This is a comment */', '// This is a comment', '# This is a comment', 'Both B and C', 'D', 7, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(18, 2, 'What is the result of `10 % 3` in PHP?', '3', '1', '0', '3.33', 'B', 8, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(19, 2, 'Which symbols are used to enclose PHP code within an HTML file?', '<?php ... ?>', '<% ... %>', '{{ ... }}', '<!-- ... -->', 'A', 9, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(20, 2, 'Which of the following is a valid \'if\' statement in PHP?', 'if ($x == 5) { ... }', 'if $x == 5 then { ... }', 'if ($x equals 5) { ... }', 'if ($x is 5) { ... }', 'A', 10, '2025-12-26 13:28:34', '2025-12-26 13:28:34'),
(21, 3, 'Python is primarily known for its:', 'Complex syntax', 'Simplicity and readability', 'Low-level memory management', 'Strict type declarations', 'B', 1, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(22, 3, 'Which of the following is NOT a common application area for Python?', 'Web development', 'Operating system kernel development', 'Data analysis', 'Machine learning', 'B', 2, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(23, 3, 'Python is often recommended for:', 'Only advanced programmers', 'Beginners due to its ease of learning', 'Hardware programming', 'Real-time embedded systems', 'B', 3, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(24, 3, 'What type of programming language is Python?', 'Assembly language', 'Low-level language', 'High-level language', 'Machine language', 'C', 4, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(25, 3, 'A key characteristic of Python\'s syntax is its:', 'Use of semicolons to end statements', 'Reliance on curly braces for code blocks', 'Easy-to-understand and clean structure', 'Mandatory variable type declarations', 'C', 5, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(26, 3, 'What kind of community support does Python benefit from?', 'Very limited', 'Only for paid users', 'A small, specialized group', 'A large and active community', 'D', 6, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(27, 3, 'Regarding its capabilities, Python is described as:', 'Only suitable for small scripts', 'Powerful enough for advanced projects', 'Exclusively for academic research', 'Limited to simple automation tasks', 'B', 7, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(28, 3, 'How is Python\'s popularity generally described?', 'Niche and declining', 'One of the most popular programming languages', 'Primarily used in specific regions', 'Rarely used outside of data science', 'B', 8, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(29, 3, 'Python is widely used in which of these fields?', 'Game engine development', 'Operating system design', 'Automation', 'Microcontroller programming', 'C', 9, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(30, 3, 'What makes Python a good choice for various applications, including building apps and analyzing data?', 'Its strict performance limitations', 'Its lack of external libraries', 'Its versatility and ease of use', 'Its proprietary nature', 'C', 10, '2025-12-26 13:30:03', '2025-12-26 13:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('PSFLc8GMdw0wIgtfDueLyKB4SkK1hmYDoqbEqiFG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid25HOThBQ2s1ZElFWDdmZXg2aTRpR0VwejVMZGFsMWVXS2lQc2l5TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9xdWl6emVzIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5xdWl6emVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1766773817);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','trainer','student') NOT NULL DEFAULT 'student',
  `phone` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rizwan Tahir', 'admin@gmail.com', '$2y$12$ZeqxRfEDvJtIiLjce5hKv.fV7mIs9RG62O2S3Ddo1Rcwe.cbd4psa', 'admin', '0332-609366', 1, NULL, '2025-12-22 09:56:39', '2025-12-25 06:03:28'),
(2, 'Hamza', 'student@gmail.com', '$2y$12$VtYdrSZ5K6MAa1SN541p5.HegDmHRAVBPdUv1OT7aCTLdKAwmUClC', 'student', '0300-3467983', 1, NULL, '2025-12-22 09:57:39', '2025-12-22 09:59:17'),
(3, 'Shahzaib', 'student1@gmail.com', '$2y$12$WV.suyVZnLSagynL.K11l.3FjJ8sS6LKM6OZ/Fq.03RrOYgMW4SvG', 'student', '0332-7656874', 1, NULL, '2025-12-22 09:58:50', '2025-12-25 13:25:05'),
(4, 'Amjad', 'trainer@gmail.com', '$2y$12$DvgDzvcJcd3PqsGKieC65u9rNMwJe7CixP3Wrbr89eIXgz9gPRac.', 'trainer', '0323-8765459', 1, NULL, '2025-12-22 10:01:48', '2025-12-22 10:06:53'),
(5, 'Asad Ali', 'trainer1@gmail.com', '$2y$12$NRKnTB1ske9BfaOI7LnvGeQzaTbM7EF3LXebxq8/AqvEE0ae13XCm', 'trainer', '0324-6754875', 1, NULL, '2025-12-22 10:06:13', '2025-12-22 10:42:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_trainer_id_foreign` (`trainer_id`);

--
-- Indexes for table `course_students`
--
ALTER TABLE `course_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_students_course_id_foreign` (`course_id`),
  ADD KEY `course_students_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_course_id_index` (`course_id`),
  ADD KEY `quizzes_created_by_index` (`created_by`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_questions_quiz_id_index` (`quiz_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_students`
--
ALTER TABLE `course_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_students`
--
ALTER TABLE `course_students`
  ADD CONSTRAINT `course_students_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
