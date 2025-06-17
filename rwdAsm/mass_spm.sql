-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 10:55 AM
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
-- Database: `mass_spm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` varchar(10) NOT NULL,
  `AdminUserName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `AdminPW` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminUserName`, `Email`, `AdminPW`) VALUES
('A01', 'Alexa', 'alexa@gmail.com', 'alexa123'),
('A02', 'Saswin', 'SaswinBM@gmail.com', 'saswinisbatman2');

-- --------------------------------------------------------

--
-- Table structure for table `answer_option`
--

CREATE TABLE `answer_option` (
  `AnswerID` varchar(10) NOT NULL,
  `QuestionID` varchar(10) NOT NULL,
  `AnswerPrompt` text NOT NULL,
  `IsCorrect` tinyint(1) NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `UpdatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer_option`
--

INSERT INTO `answer_option` (`AnswerID`, `QuestionID`, `AnswerPrompt`, `IsCorrect`, `CreatedAt`, `UpdatedAt`) VALUES
('A01', 'QT01', 'a study', 1, '2024-12-09 14:13:53', '2024-12-09 14:13:53'),
('A02', 'QT01', 'a magic', 0, '2024-12-09 14:14:45', '2024-12-09 14:14:45'),
('A03', 'QT01', 'a data', 0, '2024-12-09 14:14:45', '2024-12-09 14:14:45'),
('A04', 'QT01', 'a things', 0, '2024-12-09 14:17:54', '2024-12-09 14:17:54'),
('A05', 'QT02', 'Pembekal', 0, '2024-12-09 14:20:32', '2024-12-09 14:20:32'),
('A06', 'QT02', 'Pihak Bank', 0, '2024-12-09 14:20:32', '2024-12-09 14:20:32'),
('A07', 'QT02', 'Pihak pengurusan', 1, '2024-12-09 14:21:24', '2024-12-09 14:21:24'),
('A08', 'QT03', 'Ambilan', 1, '2024-12-09 14:24:06', '2024-12-09 14:24:06'),
('A09', 'QT03', 'Susut nilai terkumpul', 0, '2024-12-09 14:24:06', '2024-12-09 14:24:06'),
('A10', 'QT03', 'Pulangan masuk', 1, '2024-12-09 14:24:59', '2024-12-09 14:24:59'),
('A11', 'QT04', 'BETUL', 0, '2024-12-09 14:26:52', '2024-12-09 14:26:52'),
('A12', 'QT04', 'SALAH', 1, '2024-12-09 14:26:52', '2024-12-09 14:26:52'),
('A13', 'QT05', 'Yes...', 0, '2024-12-15 09:12:13', '2024-12-15 09:12:13'),
('A14', 'QT05', 'Yesss', 0, '2024-12-15 09:12:44', '2024-12-15 09:12:44'),
('A15', 'QT05', 'YESSSS', 1, '2024-12-15 09:13:07', '2024-12-15 09:13:07'),
('A16', 'QT06', 'Of Course', 1, '2024-12-15 09:14:54', '2024-12-15 09:14:54'),
('A17', 'QT06', 'Yes', 0, '2024-12-15 09:15:18', '2024-12-15 09:15:18'),
('A18', 'QT07', 'Yessss', 1, '2024-12-15 09:17:17', '2024-12-15 09:17:17'),
('A19', 'QT07', 'Yes', 1, '2024-12-15 09:18:00', '2024-12-15 09:18:00'),
('A20', 'QT07', 'NOOO', 0, '2024-12-15 09:18:22', '2024-12-15 09:18:22'),
('A21', 'QT08', 'True', 1, '2024-12-15 09:20:39', '2024-12-15 09:20:39'),
('A22', 'QT08', 'False\r\n', 0, '2024-12-15 09:20:39', '2024-12-15 09:20:39'),
('A23', 'QT09', 'True', 1, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A24', 'QT09', 'False', 0, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A25', 'QT10', 'Mitochondria', 1, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A26', 'QT10', 'Nucleus', 1, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A27', 'QT10', 'Cytoplasm', 1, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A28', 'QT10', 'Chloroplast', 0, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A29', 'QT11', 'Semipermeable', 0, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A30', 'QT11', 'Elastic', 0, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A31', 'QT11', 'Fully Permeable', 1, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A32', 'QT11', 'rigid', 0, '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('A33', 'QT12', 'True', 1, '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('A34', 'QT12', 'False', 0, '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('A35', 'QT13', '4', 0, '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('A36', 'QT13', '5', 0, '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('A37', 'QT13', '6', 1, '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('A38', 'QT13', '7', 0, '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('A39', 'QT14', 'True', 1, '2024-12-15 16:45:53', '2024-12-15 16:45:53'),
('A40', 'QT14', 'False', 0, '2024-12-15 16:45:53', '2024-12-15 16:45:53'),
('A41', 'QT15', 'Yes', 1, '2024-12-15 16:47:16', '2024-12-15 16:47:16'),
('A42', 'QT15', 'Partially', 0, '2024-12-15 16:47:16', '2024-12-15 16:47:16'),
('A43', 'QT15', 'No', 0, '2024-12-15 16:47:16', '2024-12-15 16:47:16'),
('A44', 'QT16', 'Yes', 1, '2024-12-15 16:51:59', '2024-12-15 16:51:59'),
('A45', 'QT16', 'No', 0, '2024-12-15 16:51:59', '2024-12-15 16:51:59'),
('A46', 'QT17', 'True', 1, '2024-12-15 17:00:25', '2024-12-15 17:00:25'),
('A47', 'QT17', 'False', 0, '2024-12-15 17:00:25', '2024-12-15 17:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionID` varchar(10) NOT NULL,
  `QuizID` varchar(10) NOT NULL,
  `QuestionPrompt` text NOT NULL,
  `QuestionType` enum('MCQ','TRUE/FALSE','CHECKBOX') NOT NULL,
  `QuestionMark` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `ExplanationPrompt` text NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `UpdatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`QuestionID`, `QuizID`, `QuestionPrompt`, `QuestionType`, `QuestionMark`, `ExplanationPrompt`, `CreatedAt`, `UpdatedAt`) VALUES
('QT01', 'Q01', 'What is Account?', 'MCQ', 1, 'Account is a study on how to record and interpret financial transactions.', '2024-12-09 14:12:06', '2024-12-09 14:12:06'),
('QT02', 'Q01', 'Siapakah merupakan pengguna dalam Penyata Kewangan?', 'MCQ', 2, 'Penyata Kewangan adalah seorang yang rajin dan bertanggungjawab', '2024-12-09 14:18:24', '2024-12-09 14:18:24'),
('QT03', 'Q01', 'Antara berikut, yang manakah Catatan Kontra bagi Akaun Jualan?', 'CHECKBOX', 1, 'Pulangan keluar merujuk kepada tansaksi di mana barnag yang telah dijual dipulangkan oleh pelanggan', '2024-12-09 14:22:00', '2024-12-09 14:22:00'),
('QT04', 'Q01', 'Catatan Kontra bagi Akaun Jualan ialh ambilan?', 'TRUE/FALSE', 1, 'Catatan Kontra ialah pulangan keluar', '2024-12-09 14:25:25', '2024-12-09 14:25:25'),
('QT05', 'Q03', 'Are you ok?', 'MCQ', 1, 'Yes I am fineeee', '2024-12-15 09:10:00', '2024-12-15 09:10:00'),
('QT06', 'Q03', 'Submit on time?', 'TRUE/FALSE', 1, 'Submission due is near TT', '2024-12-15 09:13:35', '2024-12-15 09:13:35'),
('QT07', 'Q04', 'RWD is fun! :D', 'CHECKBOX', 1, 'Responsive Web Design is fun~', '2024-12-15 09:15:53', '2024-12-15 09:15:53'),
('QT08', 'Q05', 'I dont know what to insert already :(', 'TRUE/FALSE', 1, 'No problem!', '2024-12-15 09:18:49', '2024-12-15 09:18:49'),
('QT09', 'Q06', 'Is human an organism?', 'TRUE/FALSE', 1, 'Every living thing is organism', '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('QT10', 'Q06', 'Animal cell consist of?', 'CHECKBOX', 2, 'Animal cell consists cytoplasm, nucleus and mitochondria. Only plant cell have chloroplast', '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('QT11', 'Q06', 'Which of the following is true about cell wall?', 'MCQ', 1, 'Cell wall is fully permeable which not allows any water and air diffusion happens.', '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('QT12', 'Q07', '1+1 = 2?', 'TRUE/FALSE', 1, '1+1 =2', '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('QT13', 'Q07', '3 * 2 =?', 'MCQ', 1, '3 * 2 = 6!', '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('QT14', 'Q08', 'Throw rubbish into rubbish bin', 'TRUE/FALSE', 10, 'This is a good habit to throw rubbish into bin', '2024-12-15 16:45:53', '2024-12-15 16:45:53'),
('QT15', 'Q09', 'Science is fun', 'MCQ', 1, 'It is fun to observe amazing reaction between living and non living orgranisms', '2024-12-15 16:47:16', '2024-12-15 16:47:16'),
('QT16', 'Q12', 'Account is a main subject in SPM', 'CHECKBOX', 1, 'No', '2024-12-15 16:51:59', '2024-12-15 16:51:59'),
('QT17', 'Q14', 'Physic is amazing', 'TRUE/FALSE', 1, 'It is really amazing!', '2024-12-15 17:00:25', '2024-12-15 17:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `QuizID` varchar(10) NOT NULL,
  `SubjectID` varchar(10) NOT NULL,
  `Duration` time DEFAULT NULL,
  `EditAdminID` varchar(10) NOT NULL,
  `QuizName` varchar(100) NOT NULL,
  `QuizType` enum('CHAPTER','PAST YEAR') NOT NULL,
  `QuizLevel` enum('FORM4','FORM5') DEFAULT NULL,
  `Chapter` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `UpdatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`QuizID`, `SubjectID`, `Duration`, `EditAdminID`, `QuizName`, `QuizType`, `QuizLevel`, `Chapter`, `CreatedAt`, `UpdatedAt`) VALUES
('Q01', 'ACC', NULL, 'A01', 'Account Chapter 1', 'CHAPTER', 'FORM5', '1', '2024-12-09 12:58:03', '2024-12-09 12:58:03'),
('Q03', 'AMTH', NULL, 'A02', 'ADDMATH CHAPTER 4', 'CHAPTER', 'FORM4', '4', '2024-12-09 13:00:20', '2024-12-09 13:00:20'),
('Q04', 'CS', '00:25:00', 'A01', 'Computer Science', 'CHAPTER', 'FORM4', '3', '2024-12-10 13:24:39', '2024-12-10 13:24:39'),
('Q05', 'SCI', '00:25:00', 'A02', 'Science Quiz', 'CHAPTER', 'FORM4', '14', '2024-12-12 01:08:28', '2024-12-12 01:08:28'),
('Q06', 'BIO', '00:30:00', 'A02', 'Biology Chapter 2', 'CHAPTER', 'FORM5', '2', '2024-12-15 16:39:34', '2024-12-15 16:39:34'),
('Q07', 'MTH', '00:40:00', 'A02', 'Math Fun Quiz', 'PAST YEAR', 'FORM5', '', '2024-12-15 16:43:21', '2024-12-15 16:43:21'),
('Q08', 'ACC', '00:30:00', 'A02', 'Moral', 'CHAPTER', 'FORM5', '4', '2024-12-15 16:45:53', '2024-12-15 16:45:53'),
('Q09', 'SCI', '00:20:00', 'A02', 'Science', 'CHAPTER', 'FORM4', '12', '2024-12-15 16:47:16', '2024-12-15 16:47:16'),
('Q12', 'ACC', '01:40:00', 'A02', 'Account Past Year', 'PAST YEAR', 'FORM4', '', '2024-12-15 16:51:59', '2024-12-15 16:51:59'),
('Q14', 'PHY', '02:00:00', 'A01', 'Physic', 'CHAPTER', 'FORM4', '1', '2024-12-15 17:00:25', '2024-12-15 17:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `SubjectID` varchar(10) NOT NULL,
  `CreatedAdminID` varchar(10) NOT NULL,
  `SubjectName` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SubjectID`, `CreatedAdminID`, `SubjectName`, `Description`, `CreatedAt`) VALUES
('ACC', 'A01', 'Account', 'Want to be an accountant? Learn It!', '2024-12-09 12:31:21'),
('AMTH', 'A01', 'Addmath', 'Learn addmath for better future~', '2024-12-09 12:31:21'),
('BIO', 'A01', 'Biology', 'How an organism survive?', '2024-12-09 12:32:44'),
('CHEM', 'A02', 'Chemistry', 'Learn the mysterious of chemicals and combination effect', '2024-12-09 12:33:25'),
('CS', 'A02', 'Computer Science', 'Coding is powerful tools!', '2024-12-09 12:34:45'),
('ECO', 'A01', 'Economy', 'Have a look on economy insight~', '2024-12-09 12:34:45'),
('ENG', 'A01', 'English', 'ENGLISH is international languageee', '2024-12-09 12:28:10'),
('HIS', 'A01', 'History', 'Know our country history in depth!', '2024-12-09 12:29:49'),
('MLY', 'A01', 'Malay', 'Malay is Malaysia first language!', '2024-12-09 12:28:10'),
('MRL', 'A01', 'Moral', 'Moral takes one better~', '2024-12-09 12:30:39'),
('MTH', 'A01', 'Math', 'Math is da best', '2024-12-09 12:31:02'),
('PHY', 'A02', 'Physic', 'Study of matter, energy in a space', '2024-12-09 12:33:25'),
('SCI', 'A01', 'Science', 'Explore the secret of earth', '2024-12-09 12:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(10) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserPW` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ProfilePicURL` varchar(255) DEFAULT NULL,
  `DOB` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserName`, `UserPW`, `Email`, `ProfilePicURL`, `DOB`) VALUES
('U0001', 'abc', 'abc', 'abc@gmail.com', NULL, '2024-12-11'),
('U002', 'okk', 'ok', 'okk@gmail.com', 'uploads/675e8ae0ada4a_view.png.jpg', '2024-12-15'),
('u003', 'asd', 'asd', 'asd@gmail.com', NULL, '2024-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `user_attempt`
--

CREATE TABLE `user_attempt` (
  `AttemptID` varchar(10) NOT NULL,
  `UserID` varchar(10) NOT NULL,
  `QuizID` varchar(10) NOT NULL,
  `AttemptDate` datetime NOT NULL,
  `Timestamp` int(11) NOT NULL,
  `Score` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_attempt`
--

INSERT INTO `user_attempt` (`AttemptID`, `UserID`, `QuizID`, `AttemptDate`, `Timestamp`, `Score`) VALUES
('A01', 'U002', 'Q01', '2024-12-13 22:38:20', 17, 0),
('A02', 'U002', 'Q01', '2024-12-13 22:38:39', 117, 1),
('A08', 'U002', 'Q01', '2024-12-13 22:44:13', 117, 2),
('A09', 'U002', 'Q01', '2024-12-13 22:44:44', 117, 2),
('A10', 'U0001', 'Q01', '2024-12-14 06:40:30', 33, 0),
('A11', 'U0001', 'Q01', '2024-12-14 06:42:20', 167, 3),
('A12', 'U0001', 'Q01', '2024-12-14 06:45:03', 167, 1),
('A13', 'U0001', 'Q01', '2024-12-14 06:45:57', 267, 2),
('A15', 'U0001', 'Q01', '2024-12-14 07:18:37', 150, 2),
('A16', 'U002', 'Q01', '2024-12-14 16:35:43', 17, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `AdminUserName` (`AdminUserName`);

--
-- Indexes for table `answer_option`
--
ALTER TABLE `answer_option`
  ADD PRIMARY KEY (`AnswerID`),
  ADD KEY `answer_option_ibfk_2` (`QuestionID`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `question_ibfk_1` (`QuizID`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`QuizID`),
  ADD KEY `EditAdminID` (`EditAdminID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`SubjectID`),
  ADD UNIQUE KEY `SubjectName` (`SubjectName`),
  ADD KEY `CreatedAdminID` (`CreatedAdminID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `user_attempt`
--
ALTER TABLE `user_attempt`
  ADD PRIMARY KEY (`AttemptID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `user_attempt_ibfk_1` (`QuizID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_option`
--
ALTER TABLE `answer_option`
  ADD CONSTRAINT `answer_option_ibfk_2` FOREIGN KEY (`QuestionID`) REFERENCES `question` (`QuestionID`) ON DELETE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_2` FOREIGN KEY (`EditAdminID`) REFERENCES `admin` (`AdminID`),
  ADD CONSTRAINT `quiz_ibfk_3` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`SubjectID`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`CreatedAdminID`) REFERENCES `admin` (`AdminID`);

--
-- Constraints for table `user_attempt`
--
ALTER TABLE `user_attempt`
  ADD CONSTRAINT `user_attempt_ibfk_1` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_attempt_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
