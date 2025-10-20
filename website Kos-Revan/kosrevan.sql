-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2025 at 01:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kosrevan`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `ID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Level` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`ID`, `Email`, `Nama`, `Password`, `Level`) VALUES
(1, 'hazamiyazid7@gmail.com', 'yazid', 'hazami9', 'user'),
(2, 'gmail@email.com', 'Rayvanes', 'Ray12345', 'admin'),
(3, 'ailsanaya@gmail.com', 'naya', 'naya12345', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `ID` int(11) NOT NULL,
  `Nama_Kamar` varchar(50) NOT NULL,
  `Harga` varchar(25) NOT NULL,
  `Gambar_Kamar` varchar(250) NOT NULL,
  `Fasilitas` varchar(500) NOT NULL,
  `Status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`ID`, `Nama_Kamar`, `Harga`, `Gambar_Kamar`, `Fasilitas`, `Status`) VALUES
(1, 'Kamar A1', 'RP 1.500.000 / Bulan', 'Kamar A1.jpeg', '-', 'tersedia'),
(2, 'Kamar A2', 'RP 1.000.000 / Bulan', 'Kamar A2.jpeg', '-Kasur \r\n-Kipas\r\n-Kamar Mandi Dalam\r\n-Lemari\r\n-Rak sepatu\r\n-Sapu\r\n-Jemuran\r\n-Tempat Sampah\r\n-Bantal \r\n-Guling', 'Tersedia'),
(3, 'Kamar A3', 'RP 1.500.000 / Bulan', 'Kamar A3.jpeg', '-Kasur \r\n-Kipas\r\n-Kamar Mandi Dalam\r\n-Lemari\r\n-Rak Sepatu\r\n-Sapu\r\n-Bantal\r\n-Guling\r\n-Jemuran\r\n-AC', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `kamar_detail`
--

CREATE TABLE `kamar_detail` (
  `ID` int(11) NOT NULL,
  `ID_Kamar` int(11) DEFAULT NULL,
  `Gambar_Detail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar_detail`
--

INSERT INTO `kamar_detail` (`ID`, `ID_Kamar`, `Gambar_Detail`) VALUES
(1, 1, '1760864587_K A1 Detail 1.jpeg'),
(2, 1, '1760864587_K A1 Detail 2.jpeg'),
(3, 1, '1760864587_K A2 Detail 3.jpeg'),
(4, 2, 'K A2 detail 1.jpeg'),
(5, 2, 'K A2 detail 2.jpeg'),
(6, 2, 'K A2 detail 3.jpeg'),
(7, 3, 'K A3 detail 1.jpeg'),
(8, 3, 'K A3 detail 2.jpeg'),
(9, 3, 'K A3 detail 3.jpeg'),
(10, 3, 'K A3 detail 4.jpeg'),
(11, 3, 'K A3 detail 5.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kamar_detail`
--
ALTER TABLE `kamar_detail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_kamar_detail_kamar` (`ID_Kamar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kamar_detail`
--
ALTER TABLE `kamar_detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kamar_detail`
--
ALTER TABLE `kamar_detail`
  ADD CONSTRAINT `fk_kamar_detail_kamar` FOREIGN KEY (`ID_Kamar`) REFERENCES `kamar` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
