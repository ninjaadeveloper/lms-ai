-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 03:10 PM
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
(4, 'PHP with MySQL', 'Learn the fundamentals of PHP to build dynamic websites and web applications. This course covers PHP syntax, control structures, forms handling, database integration with MySQL, and basic object-oriented programming. By the end, you\'ll be able to create interactive web applications using PHP and MySQL.', 'https://youtu.be/zZ6vybT1HQs?si=1tTYBs9Z56okDj5o', NULL, NULL, 18, 1, '2025-12-23 05:52:03', '2025-12-27 02:08:23', 5);

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
(9, '2025_12_26_154433_create_quiz_questions_table', 5),
(10, '2025_12_27_071725_create_quiz_attempts_table', 6),
(11, '2025_12_27_071802_create_quiz_attempt_answers_table', 6);

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
(3, 1, 1, 'admin', 'Python', 10, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(4, 3, 1, 'admin', 'Basics of HTML', 10, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(5, 2, 4, 'trainer', 'Basics of Javascript', 10, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(6, 4, 5, 'trainer', 'Basics of PHP', 10, '2025-12-27 02:11:18', '2025-12-27 02:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `total_questions` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `correct` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `wrong` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `score_percent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `quiz_id`, `student_id`, `total_questions`, `correct`, `wrong`, `score_percent`, `submitted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 10, 10, 0, 100, '2025-12-27 05:17:30', '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(2, 3, 2, 10, 2, 8, 20, '2025-12-27 06:07:14', '2025-12-27 06:07:13', '2025-12-27 06:07:14'),
(3, 3, 3, 10, 2, 8, 20, '2026-01-05 10:50:38', '2026-01-05 10:50:38', '2026-01-05 10:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempt_answers`
--

CREATE TABLE `quiz_attempt_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attempt_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `selected_option` varchar(1) DEFAULT NULL,
  `correct_option` varchar(1) DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempt_answers`
--

INSERT INTO `quiz_attempt_answers` (`id`, `attempt_id`, `question_id`, `selected_option`, `correct_option`, `is_correct`, `created_at`, `updated_at`) VALUES
(1, 1, 31, 'A', 'A', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(2, 1, 32, 'B', 'B', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(3, 1, 33, 'A', 'A', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(4, 1, 34, 'C', 'C', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(5, 1, 35, 'B', 'B', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(6, 1, 36, 'D', 'D', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(7, 1, 37, 'B', 'B', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(8, 1, 38, 'A', 'A', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(9, 1, 39, 'C', 'C', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(10, 1, 40, 'C', 'C', 1, '2025-12-27 05:17:30', '2025-12-27 05:17:30'),
(11, 2, 21, 'A', 'B', 0, '2025-12-27 06:07:13', '2025-12-27 06:07:13'),
(12, 2, 22, 'D', 'B', 0, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(13, 2, 23, 'C', 'B', 0, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(14, 2, 24, NULL, 'C', 0, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(15, 2, 25, 'B', 'C', 0, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(16, 2, 26, 'A', 'D', 0, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(17, 2, 27, 'B', 'B', 1, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(18, 2, 28, 'A', 'B', 0, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(19, 2, 29, 'B', 'C', 0, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(20, 2, 30, 'C', 'C', 1, '2025-12-27 06:07:14', '2025-12-27 06:07:14'),
(21, 3, 21, 'B', 'B', 1, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(22, 3, 22, 'C', 'B', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(23, 3, 23, 'B', 'B', 1, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(24, 3, 24, 'A', 'C', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(25, 3, 25, 'B', 'C', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(26, 3, 26, 'C', 'D', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(27, 3, 27, 'D', 'B', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(28, 3, 28, NULL, 'B', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(29, 3, 29, 'A', 'C', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38'),
(30, 3, 30, 'D', 'C', 0, '2026-01-05 10:50:38', '2026-01-05 10:50:38');

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
(21, 3, 'Python is primarily known for its:', 'Complex syntax', 'Simplicity and readability', 'Low-level memory management', 'Strict type declarations', 'B', 1, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(22, 3, 'Which of the following is NOT a common application area for Python?', 'Web development', 'Operating system kernel development', 'Data analysis', 'Machine learning', 'B', 2, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(23, 3, 'Python is often recommended for:', 'Only advanced programmers', 'Beginners due to its ease of learning', 'Hardware programming', 'Real-time embedded systems', 'B', 3, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(24, 3, 'What type of programming language is Python?', 'Assembly language', 'Low-level language', 'High-level language', 'Machine language', 'C', 4, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(25, 3, 'A key characteristic of Python\'s syntax is its:', 'Use of semicolons to end statements', 'Reliance on curly braces for code blocks', 'Easy-to-understand and clean structure', 'Mandatory variable type declarations', 'C', 5, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(26, 3, 'What kind of community support does Python benefit from?', 'Very limited', 'Only for paid users', 'A small, specialized group', 'A large and active community', 'D', 6, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(27, 3, 'Regarding its capabilities, Python is described as:', 'Only suitable for small scripts', 'Powerful enough for advanced projects', 'Exclusively for academic research', 'Limited to simple automation tasks', 'B', 7, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(28, 3, 'How is Python\'s popularity generally described?', 'Niche and declining', 'One of the most popular programming languages', 'Primarily used in specific regions', 'Rarely used outside of data science', 'B', 8, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(29, 3, 'Python is widely used in which of these fields?', 'Game engine development', 'Operating system design', 'Automation', 'Microcontroller programming', 'C', 9, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(30, 3, 'What makes Python a good choice for various applications, including building apps and analyzing data?', 'Its strict performance limitations', 'Its lack of external libraries', 'Its versatility and ease of use', 'Its proprietary nature', 'C', 10, '2025-12-26 13:30:03', '2025-12-26 13:30:03'),
(31, 4, 'What does HTML stand for?', 'HyperText Markup Language', 'High-level Text Management Language', 'Hyperlink and Text Markup', 'Home Tool Markup Language', 'A', 1, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(32, 4, 'What is the primary purpose of HTML?', 'To style the appearance of a webpage', 'To define the structure and content of a webpage', 'To add interactivity to a webpage', 'To manage server-side logic', 'B', 2, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(33, 4, 'Which of the following is the correct declaration for an HTML5 document?', '`<!DOCTYPE html>`', '`<DOCTYPE html>`', '`<html DOCTYPE>`', '`<declare html>`', 'A', 3, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(34, 4, 'Which HTML tag is used to define the root of an HTML document?', '`<head>`', '`<body>`', '`<html>`', '`<root>`', 'C', 4, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(35, 4, 'Which HTML tag is used to create a paragraph?', '`<para>`', '`<p>`', '`<text>`', '`<paragraph>`', 'B', 5, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(36, 4, 'Which HTML tag is used for the largest heading?', '`<h6>`', '`<head>`', '`<heading>`', '`<h1>`', 'D', 6, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(37, 4, 'What does the `<head>` section of an HTML document typically contain?', 'The visible content of the webpage', 'Metadata about the HTML document', 'Scripts for interactivity', 'Styles for the webpage', 'B', 7, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(38, 4, 'Which HTML tag is used to insert an image?', '`<img>`', '`<picture>`', '`<image>`', '`<src>`', 'A', 8, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(39, 4, 'How do you create a comment in HTML?', '`// This is a comment`', '`/* This is a comment */`', '`<!-- This is a comment -->`', '`# This is a comment`', 'C', 9, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(40, 4, 'What is an HTML attribute used for?', 'To define the styling of an element', 'To add interactivity to an element', 'To provide additional information about an element', 'To create new HTML elements', 'C', 10, '2025-12-27 02:02:59', '2025-12-27 02:02:59'),
(41, 5, 'What is JavaScript primarily used for?', 'Styling web pages', 'Structuring web content', 'Adding interactivity to web pages', 'Managing server databases', 'C', 1, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(42, 5, 'Where does JavaScript typically execute?', 'On the server', 'In the browser', 'Within the operating system kernel', 'On a dedicated hardware device', 'B', 2, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(43, 5, 'Which keyword is used to declare a variable whose value can be reassigned in modern JavaScript?', 'const', 'var', 'let', 'static', 'C', 3, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(44, 5, 'How do you define a function in JavaScript?', 'function myFunction()', 'def myFunction()', 'myFunction = function()', 'func myFunction()', 'A', 4, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(45, 5, 'What is the correct way to link an external JavaScript file named \'script.js\'?', '<script name=\'script.js\'>', '<link rel=\'javascript\' href=\'script.js\'>', '<script src=\'script.js\'></script>', '<js src=\'script.js\'>', 'C', 5, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(46, 5, 'Which operator performs a strict equality comparison (value and type)?', '==', '!=', '===', '=', 'C', 6, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(47, 5, 'What data type represents true or false values in JavaScript?', 'String', 'Number', 'Boolean', 'Array', 'C', 7, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(48, 5, 'How do you write a single-line comment in JavaScript?', '<!-- comment -->', '/* comment */', '// comment', '# comment', 'C', 8, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(49, 5, 'Which of the following is NOT a primitive data type in JavaScript?', 'String', 'Number', 'Object', 'Boolean', 'C', 9, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(50, 5, 'What method is used to display a message box with an \'OK\' button to the user?', 'console.log()', 'document.write()', 'alert()', 'prompt()', 'C', 10, '2025-12-27 02:05:23', '2025-12-27 02:05:23'),
(51, 6, 'What is the standard file extension for PHP files?', '.html', '.php', '.js', '.css', 'B', 1, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(52, 6, 'How do you begin a PHP script block in an HTML file?', '<php>', '<?php', '{{php}}', '[php]', 'B', 2, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(53, 6, 'Which character is used to terminate a PHP statement?', '.', ';', ':', ',', 'B', 3, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(54, 6, 'Which function is commonly used to output text in PHP?', 'print()', 'echo()', 'display()', 'output()', 'B', 4, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(55, 6, 'How do you declare and assign a value to a variable in PHP?', 'var $name;', '$name;', 'name = \"value\";', '$name = \"value\";', 'D', 5, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(56, 6, 'Which symbol is used for single-line comments in PHP?', '//', '/*', '<!--', '#', 'A', 6, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(57, 6, 'What is the primary purpose of `include` or `require` statements in PHP?', 'To define functions', 'To connect to a database', 'To embed content from another PHP file', 'To declare variables', 'C', 7, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(58, 6, 'Which of the following is a PHP superglobal variable used to collect form data submitted with the POST method?', '$_GET', '$_SESSION', '$_POST', '$_SERVER', 'C', 8, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(59, 6, 'How do you define a global constant in PHP?', 'const MY_CONSTANT = \"value\";', 'define(\"MY_CONSTANT\", \"value\");', '$MY_CONSTANT = \"value\";', 'constant MY_CONSTANT = \"value\";', 'B', 9, '2025-12-27 02:11:18', '2025-12-27 02:11:18'),
(60, 6, 'Which operator is used to concatenate two strings in PHP?', '+', '&', '.', '*', 'C', 10, '2025-12-27 02:11:18', '2025-12-27 02:11:18');

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
('2AwoaTYEYfTFDrFKzUQoTac2Ix46KX1s315k0gLC', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUjJ5SGYwZXo3WWExUnBud1B2OWdJSnZjNnFjQURmaEtRNFF1ZDNVNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1767698987),
('8jP74Qe2EWFzQvRSae7x9NkrHnqDoPBMC19JIam4', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicDN3aXlOSzd6YXRKeUw1d0RlR2duYU1oazRLSzFIVnpKNjRuSjh5ZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC90cmFpbmVyL3F1aXotYXR0ZW1wdHMvNC8xIjtzOjU6InJvdXRlIjtzOjM2OiJ0cmFpbmVyLnF1aXouYXR0ZW1wdHMuc3R1ZGVudC5kZXRhaWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1767701060),
('LFIVHLNkgKDiopMfLGX0dVo5LWdBDnj93MuM56rq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic1I2U25hNWptUnhvMG9QN1JmcFU2NDMwQVFOY3ZHS2ZPOG1uSEJBSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9xdWl6LWF0dGVtcHRzLzMvMiI7czo1OiJyb3V0ZSI7czozNDoiYWRtaW4ucXVpei5hdHRlbXB0cy5zdHVkZW50LmRldGFpbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1767700959),
('xMPztAwoLwi4iKLqPrO75t9SZ65iqjxGyxafLa2P', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY3VrUThMN3pMenF3TUlkVFlSOG9RZXF3UVJ1ZHdtTFA1b1RIZWVERyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1767708599);

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
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quiz_attempts_quiz_id_student_id_unique` (`quiz_id`,`student_id`),
  ADD KEY `quiz_attempts_student_id_foreign` (`student_id`);

--
-- Indexes for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quiz_attempt_answers_attempt_id_question_id_unique` (`attempt_id`,`question_id`),
  ADD KEY `quiz_attempt_answers_question_id_foreign` (`question_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempts_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempt_answers`
--
ALTER TABLE `quiz_attempt_answers`
  ADD CONSTRAINT `quiz_attempt_answers_attempt_id_foreign` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempt_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
