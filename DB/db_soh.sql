-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2017 at 08:54 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_soh`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_AddSched` (IN `txtGrpKey` INT, IN `txtTeacherKey` INT, IN `txtTimeKey` INT, IN `txtSbjKey` INT, IN `txtAdviserKey` INT)  NO SQL
insert into school_schedule values (null,txtGrpKey,txtTeacherKey,txtTimeKey,txtSbjKey,
         concat(@r:=year(curdate())," - ",@r+1),txtAdviserKey)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_AdviserUtils` (IN `txt1` INT, IN `txt2` INT, IN `txt3` INT, IN `txt4` INT)  NO SQL
SELECT * FROM (SELECT TeacherKey FROM stg_teacher WHERE YearLevelKey = 1 ORDER BY RAND()
LIMIT txt1)as forFirstYear
UNION
SELECT * FROM (SELECT TeacherKey FROM stg_teacher WHERE YearLevelKey = 2 ORDER BY RAND()
LIMIT txt2)as forSecYear
UNION
SELECT * FROM (SELECT TeacherKey FROM stg_teacher WHERE YearLevelKey = 3 ORDER BY RAND()
LIMIT txt3)as forThirdYear
UNION
SELECT * FROM (SELECT TeacherKey FROM stg_teacher WHERE YearLevelKey = 4 ORDER BY RAND()
LIMIT txt4)as forFourthYear$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_FinanceUtils` (IN `txtStudKey` INT)  NO SQL
SELECT A.FinanceKey,
(A.TuitionFee - (case when (SUM(B.Amount) = NULL) THEN 0 ELSE SUM(B.Amount) END)) as Balance
FROM school_finance A
LEFT JOIN school_finance_details B
ON A.FinanceKey = B.FinanceKey
LEFT JOIN stud_student C
ON c.StudentKey = A.StudentKey
WHERE A.StudentKey = txtStudKey$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getSchedForEnrollment` (IN `grpKey` INT, IN `schoolYear` INT)  NO SQL
select `stg`.`StudentGroupKey`,`stg`.`StudentGroupName`,`sch`.`ScheduleKey` AS `ScheduleKey`,concat(`sbj`.`SubjectCode`,' ',`grp`.`YearLevelKey`) AS `SubjectCode`,`sbj`.`SubjectDescription` AS `SubjectDescription`,`tm`.`Details` AS `Details`,`tc`.`LastName` AS `LastName` 
from ((((`db_soh`.`school_schedule` `sch` 
join `db_soh`.`stg_subject` `sbj` on((`sbj`.`SubjectKey` = `sch`.`SubjectKey`))) join `db_soh`.`stg_time` `tm` on((`tm`.`TimeKey` = `sch`.`TimeKey`))) join `db_soh`.`stg_teacher` `tc` on((`tc`.`TeacherKey` = `sch`.`TeacherKey`))) join `db_soh`.`stud_studentgroup` `grp` on((`grp`.`StudentGroupKey` = `sch`.`StudentGroupKey`))) 
left join stud_StudentGroup stg
on stg.StudentGroupKey = sch.StudentGroupKey
where `sch`.StudentGroupKey = grpKey AND `sch`.SchoolYear = schoolYear 
order by `sch`.`ScheduleKey`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getSchedule` (IN `grpKey` INT(1))  NO SQL
select `stg`.`StudentGroupKey`,`stg`.`StudentGroupName`,`sch`.`ScheduleKey` AS `ScheduleKey`,concat(`sbj`.`SubjectCode`,' ',`grp`.`YearLevelKey`) AS `SubjectCode`,`sbj`.`SubjectDescription` AS `SubjectDescription`,`tm`.`Details` AS `Details`,`tc`.`LastName` AS `LastName` 
from ((((`db_soh`.`school_schedule` `sch` 
join `db_soh`.`stg_subject` `sbj` on((`sbj`.`SubjectKey` = `sch`.`SubjectKey`))) join `db_soh`.`stg_time` `tm` on((`tm`.`TimeKey` = `sch`.`TimeKey`))) join `db_soh`.`stg_teacher` `tc` on((`tc`.`TeacherKey` = `sch`.`TeacherKey`))) join `db_soh`.`stud_studentgroup` `grp` on((`grp`.`StudentGroupKey` = `sch`.`StudentGroupKey`))) 
left join stud_StudentGroup stg
on stg.StudentGroupKey = sch.StudentGroupKey
where `sch`.StudentGroupKey = grpKey
order by `sch`.`ScheduleKey`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getScheduleV2` (IN `txtGrpKey` INT)  NO SQL
SELECT b.StudentGroupKey,b.StudentGroupName,a.ScheduleKey,IFNULL(c.SubjectCode,'BREAK') as SubjectCode,
IFNULL(c.SubjectDescription,'BREAK') as SubjectDescription,d.Details,
e.LastName
FROM school_schedule a
LEFT JOIN stud_studentgroup b
ON a.StudentGroupKey = b.StudentGroupKey
LEFT JOIN stg_subject c
ON c.SubjectKey = a.SubjectKey
LEFT JOIN stg_time d
ON d.TimeKey = a.TimeKey
LEFT JOIN stg_teacher e
ON e.TeacherKey = a.TeacherKey
WHERE b.StudentGroupKey = txtGrpKey$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getStudent` (IN `StudentKey` INT(10))  NO SQL
select * from stud_student where stud_student.StudentKey = StudentKey$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getTeacherKey` (IN `txtYR` INT(1), IN `SbjKey` INT(1))  NO SQL
select `TeacherKey` from stg_teacher
WHERE
YearLevelKey = (select YearLevelKey from stud_studentgroup where StudentGroupKey = txtYR)
AND SubjectKey = SbjKey$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_StudentAdd` (IN `txtStudNo` VARCHAR(8), IN `txtLName` VARCHAR(100), IN `txtFName` VARCHAR(100), IN `txtMName` VARCHAR(100), IN `txtAddress` VARCHAR(255), IN `txtContNo` VARCHAR(13), IN `txtDOB` DATE, IN `txtGName` VARCHAR(100), IN `txtGender` VARCHAR(100), IN `txtOnChild` INT)  NO SQL
insert into stud_student values (null,txtStudNo,txtLName,txtFName,txtMName,txtOnChild,txtAddress,txtContNo,txtDOB,txtGName,txtGender,txtLName,password(txtLName),0)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_StudentLogin` (IN `txtUName` VARCHAR(100), IN `txtUPass` VARCHAR(100))  NO SQL
select * from stud_student where username = txtUName and stud_student.password = PASSWORD(txtUPass)
LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_StudentUpdate` (IN `txtStudNo` VARCHAR(8), IN `txtLName` VARCHAR(100), IN `txtFName` VARCHAR(100), IN `txtMName` VARCHAR(100), IN `txtAddress` VARCHAR(255), IN `txtContNo` VARCHAR(13), IN `txtDOB` DATE, IN `txtGName` VARCHAR(100), IN `txtGender` VARCHAR(100), IN `txtOnChild` INT)  NO SQL
update stud_student SET
stud_student.LastName = txtLName,
stud_student.FirstName = txtFName,
stud_student.MiddleName = txtMName,
stud_student.Address = txtAddress,
stud_student.ContactNo = txtContNo,
stud_student.DOB = txtDOB,
stud_student.GuardianName = txtGName,
stud_student.Gender = txtGender,
stud_student.isOnlyChild = txtOnChild

where stud_student.StudentKey = txtStudNo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TeacherLogin` (IN `txtUName` VARCHAR(50), IN `txtUPass` VARCHAR(50))  NO SQL
select *,concat(LastName,', ',FirstName) as Name from stg_teacher where stg_teacher.username = txtUName and stg_teacher.password = PASSWORD(txtUPass)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tempStudent` (IN `txtLName` VARCHAR(100), IN `txtFName` VARCHAR(100), IN `txtOnChild` INT, IN `txtAddress` VARCHAR(250), IN `txtContNo` VARCHAR(15), IN `txtDOB` DATE, IN `txtGName` VARCHAR(100), IN `txtGender` VARCHAR(5), IN `txtMName` VARCHAR(100))  NO SQL
insert into tempstudtable values (null,txtLName,txtFName,txtMName,txtOnChild,txtAddress,txtContNo,txtDOB,txtGName,txtGender,txtFname,txtLName)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `InformationKey` int(11) NOT NULL,
  `SchoolName` varchar(255) NOT NULL,
  `SchoolLogo` varchar(250) NOT NULL,
  `SchoolMission` varchar(500) NOT NULL,
  `SchoolVision` varchar(500) NOT NULL,
  `SchoolHymn` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`InformationKey`, `SchoolName`, `SchoolLogo`, `SchoolMission`, `SchoolVision`, `SchoolHymn`) VALUES
(1, 'Pamantasan ng Lungsod ng Pasig', '../img/11351139_807228679384854_4022725134921322494_n.jpg', 'Mission Eto', 'WALA KAMING VISION', 'Sariwain ang nagdaan');

-- --------------------------------------------------------

--
-- Table structure for table `istg_civilstatus`
--

CREATE TABLE `istg_civilstatus` (
  `CivilStatusKey` int(11) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `istg_gender`
--

CREATE TABLE `istg_gender` (
  `GenderKey` int(11) NOT NULL,
  `GenderCode` varchar(1) NOT NULL,
  `GenderName` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `istg_gender`
--

INSERT INTO `istg_gender` (`GenderKey`, `GenderCode`, `GenderName`) VALUES
(1, 'M', 'Male'),
(2, 'F', 'Femal');

-- --------------------------------------------------------

--
-- Table structure for table `main_admin`
--

CREATE TABLE `main_admin` (
  `key` int(11) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) NOT NULL,
  `Details` varchar(100) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_admin`
--

INSERT INTO `main_admin` (`key`, `LastName`, `FirstName`, `MiddleName`, `Details`, `UserName`, `Password`) VALUES
(1, 'School', 'Administrator', '', 'Admin', 'admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441');

-- --------------------------------------------------------

--
-- Table structure for table `school_enrollee`
--

CREATE TABLE `school_enrollee` (
  `EnrolleeKey` int(11) NOT NULL,
  `StudentKey` int(11) NOT NULL,
  `StudentGroupKey` int(11) NOT NULL,
  `YearLevelKey` int(11) NOT NULL,
  `SchoolYear` varchar(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Status::';

--
-- Dumping data for table `school_enrollee`
--

INSERT INTO `school_enrollee` (`EnrolleeKey`, `StudentKey`, `StudentGroupKey`, `YearLevelKey`, `SchoolYear`, `Status`) VALUES
(4, 43, 1, 1, '2017-2018', 0),
(7, 49, 4, 1, '2017-2018', 0),
(8, 48, 4, 1, '2017-2018', 0),
(9, 47, 4, 1, '2017-2018', 0),
(10, 46, 4, 1, '2017-2018', 1),
(11, 41, 4, 1, '2017-2018', 0),
(13, 55, 4, 1, '2017-2018', 0),
(14, 1, 4, 1, '2017-2018', 0),
(15, 56, 4, 1, '2017-2018', 0),
(16, 57, 4, 1, '2017-2018', 0),
(17, 55, 0, 0, '2017-2018', 0),
(18, 41, 4, 1, '2017-2018', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_enrollment_period`
--

CREATE TABLE `school_enrollment_period` (
  `id` int(11) NOT NULL,
  `isEnrollemt` tinyint(1) NOT NULL,
  `dateCreated` date NOT NULL,
  `untilDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_enrollment_period`
--

INSERT INTO `school_enrollment_period` (`id`, `isEnrollemt`, `dateCreated`, `untilDate`) VALUES
(1, 0, '2017-08-21', '2017-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `school_finance`
--

CREATE TABLE `school_finance` (
  `FinanceKey` int(11) NOT NULL,
  `StudentKey` int(11) NOT NULL,
  `EnrolleeKey` int(11) NOT NULL,
  `SchoolYear` varchar(11) NOT NULL,
  `TuitionFee` double NOT NULL,
  `UniformFee` double NOT NULL,
  `BookFee` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_finance`
--

INSERT INTO `school_finance` (`FinanceKey`, `StudentKey`, `EnrolleeKey`, `SchoolYear`, `TuitionFee`, `UniformFee`, `BookFee`) VALUES
(9, 2, 0, '2017-2018', 7125, 0, 0),
(14, 42, 5, '2017-2018', 7625, 0, 0),
(16, 0, 6, '', 0, 0, 0),
(17, 0, 8, '', 0, 0, 0),
(18, 0, 9, '', 0, 0, 0),
(19, 46, 10, '2017-2018', 9500, 0, 0),
(20, 41, 11, '2017-2018', 9500, 0, 0),
(21, 43, 12, '2017-2018', 9500, 0, 0),
(22, 55, 13, '2017-2018', 9500, 0, 0),
(23, 1, 14, '2017-2018', 9500, 0, 0),
(24, 56, 15, '2017-2018', 9500, 0, 0),
(25, 57, 16, '2017-2018', 9500, 0, 0),
(26, 55, 17, '2017-2018', 9500, 0, 0),
(27, 41, 18, '2017-2018', 9500, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_finance_details`
--

CREATE TABLE `school_finance_details` (
  `FinanceDetKey` int(11) NOT NULL,
  `FinanceKey` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_finance_details`
--

INSERT INTO `school_finance_details` (`FinanceDetKey`, `FinanceKey`, `Date`, `Amount`) VALUES
(1, 9, '2017-08-06', 7125),
(2, 14, '2017-08-13', 500),
(3, 46, '2017-08-14', 500),
(4, 46, '2017-08-14', 500),
(5, 19, '2017-08-14', 500);

-- --------------------------------------------------------

--
-- Table structure for table `school_schedule`
--

CREATE TABLE `school_schedule` (
  `ScheduleKey` int(11) NOT NULL,
  `StudentGroupKey` int(11) NOT NULL,
  `TeacherKey` varchar(11) NOT NULL,
  `TimeKey` int(11) NOT NULL,
  `SubjectKey` int(11) NOT NULL,
  `SchoolYear` varchar(11) NOT NULL,
  `AdviserKey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_schedule`
--

INSERT INTO `school_schedule` (`ScheduleKey`, `StudentGroupKey`, `TeacherKey`, `TimeKey`, `SubjectKey`, `SchoolYear`, `AdviserKey`) VALUES
(1, 1, '4', 1, 4, '2017 - 2018', 5),
(2, 1, '6', 2, 6, '2017 - 2018', 5),
(3, 1, '1', 3, 1, '2017 - 2018', 5),
(4, 1, '7', 4, 8, '2017 - 2018', 5),
(5, 1, '7', 5, 7, '2017 - 2018', 5),
(6, 1, '2', 6, 2, '2017 - 2018', 5),
(7, 1, '5', 7, 5, '2017 - 2018', 5),
(8, 1, '3', 8, 3, '2017 - 2018', 5),
(9, 2, '7', 1, 7, '2017 - 2018', 1),
(10, 2, '1', 2, 1, '2017 - 2018', 1),
(11, 2, '5', 3, 5, '2017 - 2018', 1),
(12, 2, '2', 4, 8, '2017 - 2018', 1),
(13, 2, '2', 5, 2, '2017 - 2018', 1),
(14, 2, '6', 6, 6, '2017 - 2018', 1),
(15, 2, '3', 7, 3, '2017 - 2018', 1),
(16, 2, '4', 8, 4, '2017 - 2018', 1),
(17, 3, '2', 1, 2, '2017 - 2018', 6),
(18, 3, '7', 2, 7, '2017 - 2018', 6),
(19, 3, '4', 3, 4, '2017 - 2018', 6),
(20, 3, '3', 4, 8, '2017 - 2018', 6),
(21, 3, '3', 5, 3, '2017 - 2018', 6),
(22, 3, '1', 6, 1, '2017 - 2018', 6),
(23, 3, '6', 7, 6, '2017 - 2018', 6),
(24, 3, '5', 8, 5, '2017 - 2018', 6),
(25, 4, '1', 1, 1, '2017 - 2018', 2),
(26, 4, '2', 2, 2, '2017 - 2018', 2),
(27, 4, '6', 3, 6, '2017 - 2018', 2),
(28, 4, '5', 4, 8, '2017 - 2018', 2),
(29, 4, '5', 5, 5, '2017 - 2018', 2),
(30, 4, '3', 6, 3, '2017 - 2018', 2),
(31, 4, '4', 7, 4, '2017 - 2018', 2),
(32, 4, '7', 8, 7, '2017 - 2018', 2),
(33, 5, '6', 1, 6, '2017 - 2018', 8),
(34, 5, '4', 2, 4, '2017 - 2018', 8),
(35, 5, '3', 3, 3, '2017 - 2018', 8),
(36, 5, '1', 4, 8, '2017 - 2018', 8),
(37, 5, '1', 5, 1, '2017 - 2018', 8),
(38, 5, '5', 6, 5, '2017 - 2018', 8),
(39, 5, '7', 7, 7, '2017 - 2018', 8),
(40, 5, '2', 8, 2, '2017 - 2018', 8),
(41, 6, '0', 1, 5, '2017 - 2018', 13),
(42, 6, '0', 2, 2, '2017 - 2018', 13),
(43, 6, '0', 3, 7, '2017 - 2018', 13),
(44, 6, '0', 4, 8, '2017 - 2018', 13),
(45, 6, '0', 5, 3, '2017 - 2018', 13),
(46, 6, '0', 6, 4, '2017 - 2018', 13),
(47, 6, '0', 7, 6, '2017 - 2018', 13),
(48, 6, '0', 8, 1, '2017 - 2018', 13),
(49, 7, '0', 1, 4, '2017 - 2018', 12),
(50, 7, '0', 2, 1, '2017 - 2018', 12),
(51, 7, '0', 3, 6, '2017 - 2018', 12),
(52, 7, '0', 4, 8, '2017 - 2018', 12),
(53, 7, '0', 5, 7, '2017 - 2018', 12),
(54, 7, '0', 6, 3, '2017 - 2018', 12),
(55, 7, '0', 7, 2, '2017 - 2018', 12),
(56, 7, '0', 8, 5, '2017 - 2018', 12),
(57, 8, '0', 1, 2, '2017 - 2018', 14),
(58, 8, '0', 2, 3, '2017 - 2018', 14),
(59, 8, '0', 3, 4, '2017 - 2018', 14),
(60, 8, '0', 4, 8, '2017 - 2018', 14),
(61, 8, '0', 5, 5, '2017 - 2018', 14),
(62, 8, '0', 6, 7, '2017 - 2018', 14),
(63, 8, '0', 7, 1, '2017 - 2018', 14),
(64, 8, '0', 8, 6, '2017 - 2018', 14),
(65, 9, '0', 1, 3, '2017 - 2018', 11),
(66, 9, '0', 2, 6, '2017 - 2018', 11),
(67, 9, '0', 3, 1, '2017 - 2018', 11),
(68, 9, '0', 4, 8, '2017 - 2018', 11),
(69, 9, '0', 5, 4, '2017 - 2018', 11),
(70, 9, '0', 6, 5, '2017 - 2018', 11),
(71, 9, '0', 7, 7, '2017 - 2018', 11),
(72, 9, '0', 8, 2, '2017 - 2018', 11),
(73, 10, '0', 1, 7, '2017 - 2018', 10),
(74, 10, '0', 2, 5, '2017 - 2018', 10),
(75, 10, '0', 3, 2, '2017 - 2018', 10),
(76, 10, '0', 4, 8, '2017 - 2018', 10),
(77, 10, '0', 5, 6, '2017 - 2018', 10),
(78, 10, '0', 6, 1, '2017 - 2018', 10),
(79, 10, '0', 7, 3, '2017 - 2018', 10),
(80, 10, '0', 8, 4, '2017 - 2018', 10);

-- --------------------------------------------------------

--
-- Table structure for table `stg_books`
--

CREATE TABLE `stg_books` (
  `BookKey` int(11) NOT NULL,
  `BookCode` varchar(50) NOT NULL,
  `BookName` varchar(100) NOT NULL,
  `BookPrice` double NOT NULL,
  `YearLevelKey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_books`
--

INSERT INTO `stg_books` (`BookKey`, `BookCode`, `BookName`, `BookPrice`, `YearLevelKey`) VALUES
(1, 'ma', 'Mathematics', 100, 1),
(4, 'pao', 'paobook', 1000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `stg_subject`
--

CREATE TABLE `stg_subject` (
  `SubjectKey` int(11) NOT NULL,
  `SubjectCode` varchar(50) NOT NULL,
  `SubjectDescription` varchar(50) NOT NULL,
  `Comments` varchar(50) DEFAULT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_subject`
--

INSERT INTO `stg_subject` (`SubjectKey`, `SubjectCode`, `SubjectDescription`, `Comments`, `Status`) VALUES
(29, 'Fil', 'Filipino', '1', 1),
(30, 'Eng', 'English', '2', 1),
(31, 'Sci', 'Sciene', '3', 1),
(32, 'Ma', 'Mathematics', '4', 1),
(33, 'EpXAP', 'Edukasyong sa Pagpapakatao and Araling Panlipunan', '5,8', 1),
(34, 'TleXComp', 'TLE and Computer Education', '6,9', 1),
(35, 'Map', 'MAPEH', '7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stg_subjectdesc`
--

CREATE TABLE `stg_subjectdesc` (
  `SubjectDescKey` int(11) NOT NULL,
  `SubjectCode` varchar(50) NOT NULL,
  `SubjectDescription` varchar(50) NOT NULL,
  `SubjectKey` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_subjectdesc`
--

INSERT INTO `stg_subjectdesc` (`SubjectDescKey`, `SubjectCode`, `SubjectDescription`, `SubjectKey`) VALUES
(1, 'Fil', 'Filipino', ''),
(2, 'Eng', 'English', ''),
(3, 'Sci', 'Sciene', ''),
(4, 'Ma', 'Mathematics', ''),
(5, 'Ep', 'Edukasyong sa Pagpapakatao', ''),
(6, 'Tle', 'TLE', ''),
(7, 'Map', 'MAPEH', ''),
(8, 'AP', 'Araling Panlipunan', ''),
(9, 'Comp', 'Computer Education', '');

-- --------------------------------------------------------

--
-- Table structure for table `stg_teacher`
--

CREATE TABLE `stg_teacher` (
  `TeacherKey` int(11) NOT NULL,
  `TeacherNo` varchar(8) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) NOT NULL DEFAULT '',
  `Address` varchar(255) NOT NULL,
  `ContactNo` varchar(13) DEFAULT NULL,
  `DOB` date NOT NULL,
  `YearLevelKey` int(11) NOT NULL,
  `SubjectKey` int(5) NOT NULL,
  `SubjectDescKey` int(11) NOT NULL,
  `CivilStatusKey` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_teacher`
--

INSERT INTO `stg_teacher` (`TeacherKey`, `TeacherNo`, `LastName`, `FirstName`, `MiddleName`, `Address`, `ContactNo`, `DOB`, `YearLevelKey`, `SubjectKey`, `SubjectDescKey`, `CivilStatusKey`, `username`, `password`) VALUES
(1, '10001', 'paothegreat', '', '', '', '', '0000-00-00', 1, 1, 1, 0, '1', '*E6CC90B878B948C35E92B003C792C46C58C4AF40'),
(2, '10002', 'the great pao', '', '', '', '', '0000-00-00', 1, 2, 2, 0, '', ''),
(3, '10003', 'paothegreat2', '', '', '', NULL, '0000-00-00', 1, 3, 3, 0, '', ''),
(4, '10004', 'paothegreat3', '', '', '', NULL, '0000-00-00', 1, 4, 4, 0, '', ''),
(5, '10005', 'paothegreat4', '', '', '', NULL, '0000-00-00', 1, 5, 5, 0, '', ''),
(6, '10006', 'jared', '', '', '', '', '2011-01-01', 1, 6, 6, 0, '', ''),
(7, '10007', 'paothegreat6', '', '', '', NULL, '0000-00-00', 1, 7, 7, 0, '', ''),
(8, '10008', 'paoAP', '', '', '', NULL, '0000-00-00', 1, 5, 8, 0, '', ''),
(9, '10009', 'paoComp', '', '', '', NULL, '0000-00-00', 1, 6, 9, 0, '', ''),
(10, '', '', '', '', '', NULL, '0000-00-00', 2, 0, 0, 0, '', ''),
(11, '', '', '', '', '', NULL, '0000-00-00', 2, 0, 0, 0, '', ''),
(12, '', '', '', '', '', NULL, '0000-00-00', 2, 0, 0, 0, '', ''),
(13, '', '', '', '', '', NULL, '0000-00-00', 2, 0, 0, 0, '', ''),
(14, '', '', '', '', '', NULL, '0000-00-00', 2, 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `stg_time`
--

CREATE TABLE `stg_time` (
  `TimeKey` int(11) NOT NULL,
  `Details` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_time`
--

INSERT INTO `stg_time` (`TimeKey`, `Details`, `Status`) VALUES
(1, '7:00 AM - 7:50 AM', 1),
(2, '8: 00 AM - 9:00 AM', 1),
(3, '9:00 AM - 10:00 AM', 1),
(4, 'test', 0),
(5, '11:00 AM - 12::00 NN', 1),
(6, '12:00 NN - 1:00 PM', 1),
(7, '1:00 pm - 2:00 pm', 1),
(8, '10:00 - 11:00 AM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stg_tuitionfee`
--

CREATE TABLE `stg_tuitionfee` (
  `Keyy` int(11) NOT NULL,
  `TuitionAmount` double NOT NULL,
  `MiscelenousFee` double NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_tuitionfee`
--

INSERT INTO `stg_tuitionfee` (`Keyy`, `TuitionAmount`, `MiscelenousFee`, `Date`) VALUES
(1, 9500, 500, '2017-06-25 17:26:29');

-- --------------------------------------------------------

--
-- Table structure for table `stg_uniform`
--

CREATE TABLE `stg_uniform` (
  `UniformKey` int(11) NOT NULL,
  `UniformName` varchar(50) NOT NULL,
  `UniformSize` varchar(5) NOT NULL,
  `UniformPrice` double NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `Part` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_uniform`
--

INSERT INTO `stg_uniform` (`UniformKey`, `UniformName`, `UniformSize`, `UniformPrice`, `Gender`, `Part`) VALUES
(1, 'Blouse w/ ribbon', 'S', 250, 'F', 'Upper'),
(2, 'Blouse w/ ribbon', 'M', 285, 'F', 'Upper'),
(3, 'Blouse w/ ribbon', 'L', 335, 'F', 'Upper'),
(4, 'Blouse w/ ribbon', 'XL', 375, 'F', 'Upper'),
(5, 'Skirt with Belt', 'S', 240, 'F', 'Lower'),
(6, 'Skirt with Belt', 'M', 265, 'F', 'Lower'),
(7, 'Skirt with Belt', 'L', 315, 'F', 'Lower'),
(8, 'Skirt with Belt', 'XL', 345, 'F', 'Lower'),
(9, 'WHITE POLO  ', 'S', 235, 'M', 'Upper'),
(10, 'WHITE POLO', 'M', 265, 'M', 'Upper'),
(11, 'WHITE POLO  ', 'L', 320, 'M', 'Upper'),
(12, 'WHITE POLO', 'XL', 365, 'M', 'Upper'),
(13, 'Blue Navy Slacks ', 'S', 220, 'M', 'Lower'),
(14, 'Blue Navy Slacks ', 'M', 245, 'M', 'Lower');

-- --------------------------------------------------------

--
-- Table structure for table `stg_yearlevel`
--

CREATE TABLE `stg_yearlevel` (
  `YearLevelKey` int(11) NOT NULL,
  `YearLevel` varchar(5) NOT NULL,
  `Comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stg_yearlevel`
--

INSERT INTO `stg_yearlevel` (`YearLevelKey`, `YearLevel`, `Comment`) VALUES
(1, '1', 'First Year/Grade Seven');

-- --------------------------------------------------------

--
-- Table structure for table `stud_clearance`
--

CREATE TABLE `stud_clearance` (
  `ClearanceKey` int(11) NOT NULL,
  `StudentKey` int(11) NOT NULL,
  `EnrolleeKey` int(11) NOT NULL,
  `Library` int(11) NOT NULL,
  `Guidance` int(11) NOT NULL,
  `Finance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_clearance`
--

INSERT INTO `stud_clearance` (`ClearanceKey`, `StudentKey`, `EnrolleeKey`, `Library`, `Guidance`, `Finance`) VALUES
(1, 2, 0, 1, 1, 0),
(2, 43, 0, 0, 0, 0),
(3, 43, 0, 0, 0, 0),
(4, 43, 0, 0, 0, 0),
(5, 43, 0, 0, 0, 0),
(6, 42, 0, 0, 0, 0),
(7, 0, 5, 0, 0, 0),
(8, 0, 6, 0, 0, 0),
(9, 0, 8, 0, 0, 0),
(10, 0, 9, 0, 0, 0),
(11, 41, 11, 0, 0, 0),
(12, 43, 12, 0, 0, 0),
(13, 55, 13, 0, 0, 0),
(14, 1, 14, 0, 0, 0),
(15, 56, 15, 0, 0, 0),
(16, 57, 16, 0, 0, 0),
(17, 55, 17, 0, 0, 0),
(18, 41, 18, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stud_clearance1`
--

CREATE TABLE `stud_clearance1` (
  `ClearanceKey` int(11) NOT NULL,
  `StudentKey` int(11) NOT NULL,
  `Library` tinyint(1) NOT NULL DEFAULT '1',
  `Finance` tinyint(1) NOT NULL DEFAULT '1',
  `Guidance` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_clearance1`
--

INSERT INTO `stud_clearance1` (`ClearanceKey`, `StudentKey`, `Library`, `Finance`, `Guidance`) VALUES
(1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stud_grade`
--

CREATE TABLE `stud_grade` (
  `GradeKey` int(11) NOT NULL,
  `StudentKey` varchar(8) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `SchoolFrom` varchar(100) NOT NULL,
  `StudentGroupKey` int(4) NOT NULL,
  `YearLevel` int(11) NOT NULL,
  `Grade` double NOT NULL,
  `SchoolYear` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_grade`
--

INSERT INTO `stud_grade` (`GradeKey`, `StudentKey`, `Status`, `SchoolFrom`, `StudentGroupKey`, `YearLevel`, `Grade`, `SchoolYear`) VALUES
(10, '43', 'Incoming First Year', 'pp', 0, 0, 90, ''),
(11, '55', '', '', 0, 0, 0, ''),
(12, '56', '', '', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `stud_individualgrade`
--

CREATE TABLE `stud_individualgrade` (
  `IndividualGradeKey` int(11) NOT NULL,
  `StudentKey` int(11) NOT NULL,
  `English` double NOT NULL,
  `Math` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stud_notification`
--

CREATE TABLE `stud_notification` (
  `NotificationKey` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Message` varchar(250) NOT NULL,
  `DatePosted` date NOT NULL,
  `PostUntil` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_notification`
--

INSERT INTO `stud_notification` (`NotificationKey`, `Title`, `Message`, `DatePosted`, `PostUntil`) VALUES
(1, '2', 'Test', '0000-00-00', '2017-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `stud_notification_v2`
--

CREATE TABLE `stud_notification_v2` (
  `NotificationKey` int(11) NOT NULL,
  `StudentKey` int(11) NOT NULL,
  `NotificationTitle` varchar(100) NOT NULL,
  `NotificationMessage` varchar(100) NOT NULL,
  `DatePosted` date NOT NULL,
  `PostUntil` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_notification_v2`
--

INSERT INTO `stud_notification_v2` (`NotificationKey`, `StudentKey`, `NotificationTitle`, `NotificationMessage`, `DatePosted`, `PostUntil`) VALUES
(1, 42, 'Finance Update', 'You have a pending account to school finance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(2, 46, 'Finance Update', 'You have a pending account to school finance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(3, 41, 'Finance Update', 'You have a pending account to school finance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(4, 43, 'Finance Update', 'You have a pending account to school finance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(5, 55, 'Finance Update', 'You have a pending account to school finance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(8, 43, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(9, 43, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(10, 43, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(11, 43, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(12, 42, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(13, 41, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(14, 43, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16'),
(15, 55, 'Clearnace Update', 'You have a pending uncleared clearance, please settle your account as soon as possible', '2017-08-15', '2017-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `stud_student`
--

CREATE TABLE `stud_student` (
  `StudentKey` int(11) NOT NULL,
  `StudentNo` varchar(10) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) NOT NULL,
  `isOnlyChild` tinyint(4) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `ContactNo` varchar(13) NOT NULL,
  `DOB` date NOT NULL,
  `GuardianName` varchar(100) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_student`
--

INSERT INTO `stud_student` (`StudentKey`, `StudentNo`, `LastName`, `FirstName`, `MiddleName`, `isOnlyChild`, `Address`, `ContactNo`, `DOB`, `GuardianName`, `Gender`, `username`, `password`, `isActive`) VALUES
(1, '', 'Revillosa', 'Kristian Paolo', 'Galicia', 0, 'Taga Pasig', '09497145955', '1994-12-04', 'Wala', 'M', '17-0014', '*C4E74DDDC9CC9E2FDCDB7F63B127FB638831262E', 0),
(41, '17-0002', 'txtLName', 'txtFName', 'txtMName', 0, 'txtAddress', 'txtContNo', '0000-00-00', 'txtGName', 't', '17-0002', '*3E9C47314CD4849A840994EAD26B619BC2DDA816', 1),
(43, '', '', '', '', 0, '0', '', '0000-00-00', '', 'F', '', '*226F24D88B3D51C9AF604FF7D1A4140D233411C4', 0),
(46, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(47, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(48, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(49, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(50, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(51, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(52, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(53, '', '', '', '', 0, '', '', '0000-00-00', '', '', '', '', 0),
(55, '17-0001', 'revillosa', '', '', 0, '0', '', '0000-00-00', '', '', '17-0001', '*427A4CFF90A03A89765537EBAD4258F975C86D44', 1),
(56, '', 'people', '', '', 0, '0', '', '0000-00-00', '', '', '17-0015', 'password(17-0015)', 0),
(57, '', 'tets', '', '', 0, '0', '', '0000-00-00', '', '', '17-0016', '*E6CC90B878B948C35E92B003C792C46C58C4AF40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stud_studentgroup`
--

CREATE TABLE `stud_studentgroup` (
  `StudentGroupKey` int(11) NOT NULL,
  `StudentGroupName` varchar(40) NOT NULL,
  `Size` int(11) NOT NULL DEFAULT '0',
  `YearLevelKey` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `Comments` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='this serves as school sectioning';

--
-- Dumping data for table `stud_studentgroup`
--

INSERT INTO `stud_studentgroup` (`StudentGroupKey`, `StudentGroupName`, `Size`, `YearLevelKey`, `Comments`) VALUES
(1, 'section1', 10, 1, ''),
(2, 'sec2', 10, 1, ''),
(3, 'sec3', 10, 1, ''),
(4, 'sec4', 10, 1, ''),
(5, 'sec1', 10, 1, 'test'),
(6, 'sec2:2', 40, 2, ''),
(7, 'sec3:2', 0, 2, ''),
(8, 'sec4:2', 0, 2, ''),
(9, 'sec1:3', 0, 2, ''),
(10, 'sec2:3', 40, 2, ''),
(11, 'sec3:3', 0, 3, ''),
(12, 'sec4:3', 0, 3, ''),
(13, 'sec1:4', 0, 3, ''),
(14, 'sec2:4', 0, 3, ''),
(15, 'sec3:4', 0, 3, ''),
(16, 'sec4:4', 0, 4, ''),
(17, 'test1', 0, 4, ''),
(18, 'test2', 0, 4, ''),
(19, 'test3', 0, 4, ''),
(20, 'test4', 0, 4, ''),
(21, 'test5', 0, 5, ''),
(22, 'test6', 0, 5, ''),
(23, 'test7', 0, 5, ''),
(24, 'test8', 0, 5, ''),
(25, 'test9', 0, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `tempstudtable`
--

CREATE TABLE `tempstudtable` (
  `tempStudKey` int(11) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) NOT NULL,
  `isOnlyChild` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `ContactNo` varchar(13) NOT NULL,
  `DOB` date NOT NULL,
  `GuardianName` varchar(100) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_enrolled`
--
CREATE TABLE `vw_enrolled` (
`YearLevelKey` int(11)
,`StudentKey` int(11)
,`StudentNo` varchar(10)
,`FullName` varchar(204)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_financeutils`
--
CREATE TABLE `vw_financeutils` (
`FinanceKey` int(11)
,`Balance` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_preenrolled`
--
CREATE TABLE `vw_preenrolled` (
`YearLevelKey` int(11)
,`StudentKey` int(11)
,`StudentNo` varchar(10)
,`FullName` varchar(204)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_scheduleinfo`
--
CREATE TABLE `vw_scheduleinfo` (
`ScheduleKey` int(11)
,`SubjectCode` varchar(61)
,`SubjectDescription` varchar(50)
,`Details` varchar(20)
,`LastName` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_studinfo`
--
CREATE TABLE `vw_studinfo` (
`StudentKey` int(11)
,`StudentNo` varchar(10)
,`LastName` varchar(100)
,`FirstName` varchar(100)
,`MiddleName` varchar(100)
,`Address` varchar(255)
,`ContactNo` varchar(13)
,`DOB` date
,`GuardianName` varchar(100)
,`Gender` varchar(1)
,`username` varchar(100)
,`password` varchar(100)
,`FullName` varchar(204)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_totalsubject`
--
CREATE TABLE `vw_totalsubject` (
`TotalSubject` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_enrolled`
--
DROP TABLE IF EXISTS `vw_enrolled`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_enrolled`  AS  select `a`.`YearLevelKey` AS `YearLevelKey`,`b`.`StudentKey` AS `StudentKey`,`b`.`StudentNo` AS `StudentNo`,concat(`b`.`LastName`,', ',`b`.`FirstName`,' ',left(`b`.`MiddleName`,1)) AS `FullName` from (`school_enrollee` `a` left join `stud_student` `b` on((`b`.`StudentKey` = `a`.`StudentKey`))) where ((`b`.`isActive` = 1) and (`a`.`Status` = 1)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_financeutils`
--
DROP TABLE IF EXISTS `vw_financeutils`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_financeutils`  AS  select `a`.`FinanceKey` AS `FinanceKey`,(`a`.`TuitionFee` - (case when (sum(`b`.`Amount`) = NULL) then 1 else 0 end)) AS `Balance` from ((`school_finance` `a` left join `school_finance_details` `b` on((`a`.`FinanceKey` = `b`.`FinanceKey`))) left join `stud_student` `c` on((`c`.`StudentKey` = `a`.`StudentKey`))) where (`a`.`StudentKey` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_preenrolled`
--
DROP TABLE IF EXISTS `vw_preenrolled`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_preenrolled`  AS  select `a`.`YearLevelKey` AS `YearLevelKey`,`b`.`StudentKey` AS `StudentKey`,`b`.`StudentNo` AS `StudentNo`,concat(`b`.`LastName`,', ',`b`.`FirstName`,' ',left(`b`.`MiddleName`,1)) AS `FullName` from (`school_enrollee` `a` left join `stud_student` `b` on((`b`.`StudentKey` = `a`.`StudentKey`))) where ((`b`.`isActive` = 1) and (`a`.`Status` = 0)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_scheduleinfo`
--
DROP TABLE IF EXISTS `vw_scheduleinfo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_scheduleinfo`  AS  select `sch`.`ScheduleKey` AS `ScheduleKey`,concat(`sbj`.`SubjectCode`,' ',`grp`.`YearLevelKey`) AS `SubjectCode`,`sbj`.`SubjectDescription` AS `SubjectDescription`,`tm`.`Details` AS `Details`,`tc`.`LastName` AS `LastName` from ((((`school_schedule` `sch` join `stg_subject` `sbj` on((`sbj`.`SubjectKey` = `sch`.`SubjectKey`))) join `stg_time` `tm` on((`tm`.`TimeKey` = `sch`.`TimeKey`))) join `stg_teacher` `tc` on((`tc`.`TeacherKey` = `sch`.`TeacherKey`))) join `stud_studentgroup` `grp` on((`grp`.`StudentGroupKey` = `sch`.`StudentGroupKey`))) order by `sch`.`ScheduleKey` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_studinfo`
--
DROP TABLE IF EXISTS `vw_studinfo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_studinfo`  AS  select `stud_student`.`StudentKey` AS `StudentKey`,`stud_student`.`StudentNo` AS `StudentNo`,`stud_student`.`LastName` AS `LastName`,`stud_student`.`FirstName` AS `FirstName`,`stud_student`.`MiddleName` AS `MiddleName`,`stud_student`.`Address` AS `Address`,`stud_student`.`ContactNo` AS `ContactNo`,`stud_student`.`DOB` AS `DOB`,`stud_student`.`GuardianName` AS `GuardianName`,`stud_student`.`Gender` AS `Gender`,`stud_student`.`username` AS `username`,`stud_student`.`password` AS `password`,concat(`stud_student`.`LastName`,', ',`stud_student`.`FirstName`,' ',left(`stud_student`.`MiddleName`,1)) AS `FullName` from `stud_student` order by `stud_student`.`StudentKey`,`stud_student`.`StudentNo` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_totalsubject`
--
DROP TABLE IF EXISTS `vw_totalsubject`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_totalsubject`  AS  select count(0) AS `TotalSubject` from `stg_subject` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`InformationKey`);

--
-- Indexes for table `istg_civilstatus`
--
ALTER TABLE `istg_civilstatus`
  ADD PRIMARY KEY (`CivilStatusKey`);

--
-- Indexes for table `istg_gender`
--
ALTER TABLE `istg_gender`
  ADD PRIMARY KEY (`GenderKey`);

--
-- Indexes for table `school_enrollee`
--
ALTER TABLE `school_enrollee`
  ADD PRIMARY KEY (`EnrolleeKey`);

--
-- Indexes for table `school_enrollment_period`
--
ALTER TABLE `school_enrollment_period`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_finance`
--
ALTER TABLE `school_finance`
  ADD PRIMARY KEY (`FinanceKey`);

--
-- Indexes for table `school_finance_details`
--
ALTER TABLE `school_finance_details`
  ADD PRIMARY KEY (`FinanceDetKey`);

--
-- Indexes for table `school_schedule`
--
ALTER TABLE `school_schedule`
  ADD PRIMARY KEY (`ScheduleKey`);

--
-- Indexes for table `stg_books`
--
ALTER TABLE `stg_books`
  ADD PRIMARY KEY (`BookKey`);

--
-- Indexes for table `stg_subject`
--
ALTER TABLE `stg_subject`
  ADD PRIMARY KEY (`SubjectKey`);

--
-- Indexes for table `stg_subjectdesc`
--
ALTER TABLE `stg_subjectdesc`
  ADD PRIMARY KEY (`SubjectDescKey`);

--
-- Indexes for table `stg_teacher`
--
ALTER TABLE `stg_teacher`
  ADD PRIMARY KEY (`TeacherKey`);

--
-- Indexes for table `stg_time`
--
ALTER TABLE `stg_time`
  ADD PRIMARY KEY (`TimeKey`);

--
-- Indexes for table `stg_tuitionfee`
--
ALTER TABLE `stg_tuitionfee`
  ADD PRIMARY KEY (`Keyy`);

--
-- Indexes for table `stg_uniform`
--
ALTER TABLE `stg_uniform`
  ADD PRIMARY KEY (`UniformKey`);

--
-- Indexes for table `stg_yearlevel`
--
ALTER TABLE `stg_yearlevel`
  ADD PRIMARY KEY (`YearLevelKey`);

--
-- Indexes for table `stud_clearance`
--
ALTER TABLE `stud_clearance`
  ADD PRIMARY KEY (`ClearanceKey`);

--
-- Indexes for table `stud_clearance1`
--
ALTER TABLE `stud_clearance1`
  ADD PRIMARY KEY (`ClearanceKey`);

--
-- Indexes for table `stud_grade`
--
ALTER TABLE `stud_grade`
  ADD PRIMARY KEY (`GradeKey`);

--
-- Indexes for table `stud_notification`
--
ALTER TABLE `stud_notification`
  ADD PRIMARY KEY (`NotificationKey`);

--
-- Indexes for table `stud_notification_v2`
--
ALTER TABLE `stud_notification_v2`
  ADD PRIMARY KEY (`NotificationKey`);

--
-- Indexes for table `stud_student`
--
ALTER TABLE `stud_student`
  ADD PRIMARY KEY (`StudentKey`);

--
-- Indexes for table `stud_studentgroup`
--
ALTER TABLE `stud_studentgroup`
  ADD PRIMARY KEY (`StudentGroupKey`);

--
-- Indexes for table `tempstudtable`
--
ALTER TABLE `tempstudtable`
  ADD PRIMARY KEY (`tempStudKey`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `InformationKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `istg_civilstatus`
--
ALTER TABLE `istg_civilstatus`
  MODIFY `CivilStatusKey` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `istg_gender`
--
ALTER TABLE `istg_gender`
  MODIFY `GenderKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `school_enrollee`
--
ALTER TABLE `school_enrollee`
  MODIFY `EnrolleeKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `school_enrollment_period`
--
ALTER TABLE `school_enrollment_period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `school_finance`
--
ALTER TABLE `school_finance`
  MODIFY `FinanceKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `school_finance_details`
--
ALTER TABLE `school_finance_details`
  MODIFY `FinanceDetKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `school_schedule`
--
ALTER TABLE `school_schedule`
  MODIFY `ScheduleKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `stg_books`
--
ALTER TABLE `stg_books`
  MODIFY `BookKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `stg_subject`
--
ALTER TABLE `stg_subject`
  MODIFY `SubjectKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `stg_subjectdesc`
--
ALTER TABLE `stg_subjectdesc`
  MODIFY `SubjectDescKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `stg_teacher`
--
ALTER TABLE `stg_teacher`
  MODIFY `TeacherKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `stg_time`
--
ALTER TABLE `stg_time`
  MODIFY `TimeKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `stg_tuitionfee`
--
ALTER TABLE `stg_tuitionfee`
  MODIFY `Keyy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stg_uniform`
--
ALTER TABLE `stg_uniform`
  MODIFY `UniformKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `stg_yearlevel`
--
ALTER TABLE `stg_yearlevel`
  MODIFY `YearLevelKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stud_clearance`
--
ALTER TABLE `stud_clearance`
  MODIFY `ClearanceKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `stud_clearance1`
--
ALTER TABLE `stud_clearance1`
  MODIFY `ClearanceKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stud_grade`
--
ALTER TABLE `stud_grade`
  MODIFY `GradeKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `stud_notification`
--
ALTER TABLE `stud_notification`
  MODIFY `NotificationKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stud_notification_v2`
--
ALTER TABLE `stud_notification_v2`
  MODIFY `NotificationKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `stud_student`
--
ALTER TABLE `stud_student`
  MODIFY `StudentKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `stud_studentgroup`
--
ALTER TABLE `stud_studentgroup`
  MODIFY `StudentGroupKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tempstudtable`
--
ALTER TABLE `tempstudtable`
  MODIFY `tempStudKey` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
