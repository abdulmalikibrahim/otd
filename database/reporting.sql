-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2020 at 09:58 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reporting`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `name_jabatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`name_jabatan`) VALUES
('Admin'),
('Foreman');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_report`
--

CREATE TABLE `jenis_report` (
  `id_jenis_report` int(25) NOT NULL,
  `jenis_report` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_report`
--

INSERT INTO `jenis_report` (`id_jenis_report`, `jenis_report`) VALUES
(10, 'QR'),
(11, 'PR'),
(13, 'FR');

-- --------------------------------------------------------

--
-- Table structure for table `peringkat_report`
--

CREATE TABLE `peringkat_report` (
  `id` int(25) NOT NULL,
  `peringkat` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level` varchar(30) NOT NULL,
  `tanggal_peringkat` date NOT NULL,
  `total_point` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peringkat_report`
--

INSERT INTO `peringkat_report` (`id`, `peringkat`, `username`, `nama`, `level`, `tanggal_peringkat`, `total_point`) VALUES
(4, 1, 'anton.bayu', 'Anton Bayu Nugraha', 'Foreman', '2020-04-16', '36'),
(5, 2, 'Sandi.Sopyan', 'Sandi Sopyan', 'Foreman', '2020-04-16', '30'),
(6, 1, 'malik', 'Abdul Malik Ibrahim', 'Admin', '2020-04-01', '42');

-- --------------------------------------------------------

--
-- Table structure for table `peringkat_report_bu`
--

CREATE TABLE `peringkat_report_bu` (
  `peringkat` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level` varchar(30) NOT NULL,
  `tanggal_peringkat` date NOT NULL,
  `total_point` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `point_report`
--

CREATE TABLE `point_report` (
  `id_point_report` int(25) NOT NULL,
  `jenis_report` varchar(25) NOT NULL,
  `category` text NOT NULL,
  `point` varchar(4) NOT NULL,
  `detail` text NOT NULL,
  `remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `point_report`
--

INSERT INTO `point_report` (`id_point_report`, `jenis_report`, `category`, `point`, `detail`, `remark`) VALUES
(1, 'QR', 'Difficulties', '1', 'Soft', 'Analisa Problem :\r\nAnalisa dengan Konfirmasi problem (cek ulang langsung repair/judgement OK).\r\n\r\nVisit Supplier :\r\nSPTT 1~3 , packing check ekspor part'),
(2, 'QR', 'Difficulties', '2', 'Medium', 'Analisa Problem :\r\nAnalisa dengan cara rubbing part saja/compare dengan limit sample/cek akurasi data dengan int/ext cf.\r\n\r\nVisit Supplier :\r\nHVPT, PCR konfirmasi, join cek, development tahap awal, regular follow up supplier development.'),
(3, 'QR', 'Difficulties', '3', 'Hard', 'Analisa Problem :\r\nAnalisa dengan cara analisa body akurasi, cek akurasi part pada cf supplier, visit/invite supplier, penggantian part major (turun mesin/transmisi, ganti pp member, ganti headlining, etc).\r\n\r\nVisit Supplier :\r\nsafety item (SERA) follow up, cek akurasi part problem, check process terkait garansi quality untuk item problem.'),
(4, 'QR', 'On Time', '0', 'Delay > 1 hari', 'pengumpulan report terlambat lebih dari 1 hari.'),
(5, 'QR', 'On Time', '0.5', 'Delay 1 hari', 'pengumpulan report terlambat 1 hari				\r\n'),
(6, 'QR', 'On Time', '1', 'On Time', 'Pengumpulan report tepat waktu				\r\n'),
(7, 'QR', 'Quality', '0.5', 'No QC story and less data', 'Analisa Problem :\r\nhanya ada fenomena, possibility rootcause --> DO				\r\n\r\nVisit Supplier :\r\nReport hanya berupa attachment mom dan summary	'),
(8, 'QR', 'Quality', '1', 'QC story not in arrange but has some data', 'Analisa Problem :\r\nada fenomena, data akurasi part/henkaten, possibility rootcause, temporary action --> DO, CHECK\r\n\r\nVisit Supplier :\r\nsummary visit dan kesimpulan/next action				\r\n'),
(9, 'QR', 'Quality', '1.5', 'QC story in arrange but has some data', 'Analisa Problem :\r\nada fenomena, data akurasi part/henkaten, sudah tau rootcause, temporary action --> DO, CHECK, ACTION				\r\n\r\nVisit Supplier :\r\nterdapat genba result, summary visit, kesimpulan dan next action'),
(10, 'QR', 'Quality', '2', 'QC story in arrange and full data', 'Analisa Problem :\r\nada fenomena, data akurasi/henkaten, sudah tau rootcause, temporary action dan fix action --> PLAN DO CHECK ACTION				\r\n\r\nVisit Supplier :\r\nterdapat planning activity/schedule, genba result, highlight issue, countermeasure, dan next action'),
(11, 'QR', 'Prevention Action', '0', 'Poor', 'Analisa Problem :\r\nTidak ada temporary action namun ada rencana terkait Fix action\r\n\r\nVisit Supplier :\r\nhanya ada next action	'),
(12, 'QR', 'Prevention Action', '1', 'Fair', 'Analisa Problem :\r\ndilakukan sortir dan penggantian part NG, ada rencana fix action\r\n\r\nVisit Supplier :\r\nsudah ada next action dan fix countermeasure'),
(13, 'QR', 'Prevention Action', '2', 'Excellent', 'Analisa Problem :\r\ndilakukan temporary action untuk part2 NG sampai fix countermeasure selesai. sudah ada fix action/rencana\r\n\r\nVisit Supplier :\r\nmenyertakan temporary action, next action fix c/m dengan due date yang jelas	'),
(14, 'QR', 'Job Type', '1', 'Non Analisa', 'Analisa Problem :\r\ntrial, progress special job.\r\n\r\nVisit Supplier :\r\nSPTT, HVPT, PCR, Packing Check.'),
(15, 'QR', 'Job Type', '2', 'Analisa', 'Analisa Problem :\r\nanalisa DPU, monren project, after market.\r\n\r\nVisit Supplier :\r\nProblem confirmation, join cek, Development.');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `Id` varchar(30) NOT NULL,
  `Tanggal` date NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Level_Prepared` varchar(30) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Sub_Report` varchar(40) NOT NULL,
  `Judul_Report` text NOT NULL,
  `Report` varchar(30) NOT NULL,
  `Jenis_Report` varchar(3) NOT NULL,
  `Point_Detail` text NOT NULL,
  `Point` int(3) NOT NULL,
  `Checked_Foreman` text NOT NULL,
  `Status_Checked_Foreman` varchar(1) NOT NULL,
  `Checked_SPV` text NOT NULL,
  `Status_Checked_SPV` varchar(1) NOT NULL,
  `Approved_Dept_Head` text NOT NULL,
  `Status_Approve_Dept_Head` varchar(1) NOT NULL DEFAULT 'X'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`Id`, `Tanggal`, `Username`, `Level_Prepared`, `Nama`, `Sub_Report`, `Judul_Report`, `Report`, `Jenis_Report`, `Point_Detail`, `Point`, `Checked_Foreman`, `Status_Checked_Foreman`, `Checked_SPV`, `Status_Checked_SPV`, `Approved_Dept_Head`, `Status_Approve_Dept_Head`) VALUES
('20200401102456796', '2020-04-01', 'malik', 'Admin', 'Abdul Malik Ibrahim', 'Instrument Panel', 'Progress Report People System 2', '20200401102456796', 'QR', '#difficulties:2#job_type:2#on_time:0#prevention_action:2#quality:2', 8, 'Sandi Sopyan', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200401102547109', '2020-04-01', 'malik', 'Admin', 'Abdul Malik Ibrahim', 'Instrument Panel', 'Progress Report People System 3', '20200401102547109', 'QR', '#difficulties:3#job_type:2#on_time:1#prevention_action:1#quality:1.5', 9, 'Sandi Sopyan', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200415020011334', '2020-04-15', 'malik', 'Admin', 'Abdul Malik Ibrahim', 'PP Member', 'Interior', '20200415020011334', 'QR', '#difficulties:3#job_type:2#on_time:1#prevention_action:2#quality:1.5', 10, 'Sandi Sopyan', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('2020041512581083', '2020-04-15', 'malik', 'Admin', 'Abdul Malik Ibrahim', 'Kerjaan', 'Headlining Kerut', '2020041512581083', 'QR', '#difficulties:2#job_type:1#on_time:1#prevention_action:1#quality:0.5', 6, 'Sandi Sopyan', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200416033323162', '2020-04-16', 'Sandi.Sopyan', 'Foreman', 'Sandi Sopyan', 'Headlining', 'Headlining Kerut', '20200416033323162', 'QR', '#difficulties:3#job_type:2#on_time:1#prevention_action:2#quality:2', 10, '-', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200416100011282', '2020-04-16', 'anton.bayu', 'Foreman', 'Anton Bayu Nugraha', 'Headlining', 'Headlining Kerut', '20200416100011282', 'QR', '#difficulties:3#job_type:2#on_time:1#prevention_action:2#quality:2', 10, '-', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200417051711402', '2020-04-17', 'anton.bayu', 'Foreman', 'Anton Bayu Nugraha', 'Headlining', 'Interior', '20200417051711402', 'QR', '#difficulties:3#job_type:2#on_time:0.5#prevention_action:2#quality:1.5', 9, '-', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('2020041705173751', '2020-04-17', 'anton.bayu', 'Foreman', 'Anton Bayu Nugraha', 'Kerjaan Lain', 'Progress Report People System 2', '2020041705173751', 'QR', '#difficulties:1#job_type:2#on_time:1#prevention_action:2#quality:1', 7, '-', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200417075728295', '2020-04-17', 'Sandi.Sopyan', 'Foreman', 'Sandi Sopyan', 'Headlining', 'Progress Report People System 3', '20200417075728295', 'QR', '#difficulties:3#job_type:2#on_time:1#prevention_action:2#quality:2', 10, '-', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('2020041707574014', '2020-04-17', 'Sandi.Sopyan', 'Foreman', 'Sandi Sopyan', 'Headlining', 'Progress Report People System 4', '2020041707574014', 'QR', '#difficulties:3#job_type:2#on_time:1#prevention_action:2#quality:2', 10, '-', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200417080916635', '2020-04-17', 'anton.bayu', 'Foreman', 'Anton Bayu Nugraha', 'Headlining', 'Headlining Kerut', '20200417080916635', 'QR', '#difficulties:3#job_type:2#on_time:1#prevention_action:2#quality:2', 10, '-', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O'),
('20200421040738814', '2020-04-21', 'malik', 'Admin', 'Abdul Malik Ibrahim', 'Instrument Panel', 'Headlining Kerut', '20200421040738814', 'QR', '#difficulties:3#job_type:2#on_time:0#prevention_action:2#quality:2', 9, 'Sandi Sopyan', 'O', 'Atifa Sholikha', 'O', 'Syamsudin Basri', 'O');

-- --------------------------------------------------------

--
-- Table structure for table `ss`
--

CREATE TABLE `ss` (
  `Id` varchar(30) NOT NULL,
  `Tanggal` date NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Level_Prepared` varchar(30) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Judul_SS` text NOT NULL,
  `SS` varchar(30) NOT NULL,
  `Checked_SPV` text NOT NULL,
  `Status_Checked_SPV` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`name_jabatan`);

--
-- Indexes for table `jenis_report`
--
ALTER TABLE `jenis_report`
  ADD PRIMARY KEY (`id_jenis_report`);

--
-- Indexes for table `peringkat_report`
--
ALTER TABLE `peringkat_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `point_report`
--
ALTER TABLE `point_report`
  ADD PRIMARY KEY (`id_point_report`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `ss`
--
ALTER TABLE `ss`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_report`
--
ALTER TABLE `jenis_report`
  MODIFY `id_jenis_report` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `peringkat_report`
--
ALTER TABLE `peringkat_report`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `point_report`
--
ALTER TABLE `point_report`
  MODIFY `id_point_report` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
