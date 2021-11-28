-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.20-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_lab03
CREATE DATABASE IF NOT EXISTS `db_lab03` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `db_lab03`;

-- Dumping structure for table db_lab03.cthd
CREATE TABLE IF NOT EXISTS `cthd` (
  `SOHD` int(11) NOT NULL,
  `MASP` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SL` int(11) NOT NULL,
  KEY `FK_cthd_hoadon` (`SOHD`),
  KEY `FK_cthd_sanpham` (`MASP`),
  CONSTRAINT `FK_cthd_hoadon` FOREIGN KEY (`SOHD`) REFERENCES `hoadon` (`SOHD`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_cthd_sanpham` FOREIGN KEY (`MASP`) REFERENCES `sanpham` (`MASP`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_lab03.cthd: ~48 rows (approximately)
/*!40000 ALTER TABLE `cthd` DISABLE KEYS */;
INSERT INTO `cthd` (`SOHD`, `MASP`, `SL`) VALUES
	(1001, 'TV02', 10),
	(1001, 'ST01', 5),
	(1001, 'BC01', 5),
	(1001, 'BC02', 10),
	(1001, 'ST08', 10),
	(1002, 'BC04', 20),
	(1002, 'BB01', 20),
	(1002, 'BB02', 20),
	(1003, 'BB03', 10),
	(1004, 'TV01', 20),
	(1004, 'TV02', 10),
	(1004, 'TV03', 10),
	(1004, 'TV04', 10),
	(1005, 'TV05', 50),
	(1005, 'TV06', 50),
	(1006, 'TV07', 20),
	(1006, 'ST01', 30),
	(1006, 'ST02', 10),
	(1007, 'ST03', 10),
	(1008, 'ST04', 8),
	(1009, 'ST05', 10),
	(1010, 'TV07', 50),
	(1010, 'ST07', 50),
	(1010, 'ST08', 100),
	(1010, 'ST04', 50),
	(1010, 'TV03', 100),
	(1011, 'ST06', 50),
	(1012, 'ST07', 3),
	(1013, 'ST08', 5),
	(1014, 'BC02', 80),
	(1014, 'BC02', 100),
	(1014, 'BC04', 60),
	(1014, 'BB01', 50),
	(1015, 'BB02', 30),
	(1015, 'BB03', 7),
	(1016, 'TV01', 5),
	(1017, 'TV02', 1),
	(1017, 'TV03', 1),
	(1017, 'TV04', 5),
	(1018, 'ST04', 6),
	(1019, 'ST05', 1),
	(1019, 'ST06', 2),
	(1020, 'ST07', 10),
	(1021, 'ST08', 5),
	(1021, 'TV01', 7),
	(1022, 'ST07', 1),
	(1023, 'ST04', 6),
	(1021, 'TV02', 10);
/*!40000 ALTER TABLE `cthd` ENABLE KEYS */;

-- Dumping structure for table db_lab03.hoadon
CREATE TABLE IF NOT EXISTS `hoadon` (
  `SOHD` int(11) NOT NULL,
  `NGHD` date NOT NULL,
  `MAKH` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MANV` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TRIGIA` float NOT NULL,
  PRIMARY KEY (`SOHD`),
  KEY `FK_hoadon_khachhang` (`MAKH`),
  KEY `FK_hoadon_nhanvien` (`MANV`),
  CONSTRAINT `FK_hoadon_khachhang` FOREIGN KEY (`MAKH`) REFERENCES `khachhang` (`MAKH`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_hoadon_nhanvien` FOREIGN KEY (`MANV`) REFERENCES `nhanvien` (`MANV`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_lab03.hoadon: ~23 rows (approximately)
/*!40000 ALTER TABLE `hoadon` DISABLE KEYS */;
INSERT INTO `hoadon` (`SOHD`, `NGHD`, `MAKH`, `MANV`, `TRIGIA`) VALUES
	(1001, '2006-07-23', 'KH01', 'NV01', 320000),
	(1002, '2006-08-12', 'KH01', 'NV02', 840000),
	(1003, '2006-08-23', 'KH02', 'NV01', 100000),
	(1004, '2006-09-01', 'KH02', 'NV01', 180000),
	(1005, '2006-10-20', 'KH01', 'NV02', 3800000),
	(1006, '2006-10-16', 'KH01', 'NV03', 2430000),
	(1007, '2006-10-28', 'KH03', 'NV03', 510000),
	(1008, '2006-10-28', 'KH01', 'NV03', 440000),
	(1009, '2006-10-28', 'KH03', 'NV04', 200000),
	(1010, '2006-11-01', 'KH01', 'NV01', 5200000),
	(1011, '2006-11-04', 'KH04', 'NV03', 250000),
	(1012, '2006-11-30', 'KH05', 'NV03', 21000),
	(1013, '2006-12-12', 'KH06', 'NV01', 5000),
	(1014, '2006-12-31', 'KH03', 'NV02', 3150000),
	(1015, '2007-01-01', 'KH06', 'NV01', 910000),
	(1016, '2007-01-01', 'KH07', 'NV02', 12500),
	(1017, '2007-01-01', 'KH08', 'NV03', 35000),
	(1018, '2007-01-13', 'KH08', 'NV03', 330000),
	(1019, '2007-01-13', 'KH01', 'NV03', 30000),
	(1020, '2007-01-14', 'KH09', 'NV04', 70000),
	(1021, '2007-01-16', 'KH10', 'NV03', 67500),
	(1022, '2007-01-16', NULL, 'NV03', 7000),
	(1023, '2007-01-17', NULL, 'NV01', 330000);
/*!40000 ALTER TABLE `hoadon` ENABLE KEYS */;

-- Dumping structure for table db_lab03.khachhang
CREATE TABLE IF NOT EXISTS `khachhang` (
  `MAKH` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HOTEN` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DCHI` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `SODT` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NGSINH` date NOT NULL,
  `DOANHSO` float NOT NULL,
  `NGGN` date NOT NULL,
  PRIMARY KEY (`MAKH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_lab03.khachhang: ~10 rows (approximately)
/*!40000 ALTER TABLE `khachhang` DISABLE KEYS */;
INSERT INTO `khachhang` (`MAKH`, `HOTEN`, `DCHI`, `SODT`, `NGSINH`, `DOANHSO`, `NGGN`) VALUES
	('KH01', 'Nguyen Van A', '73 Tran Hung Dao, Q5, TpHCM', '08823451', '1996-10-22', 13060000, '2006-07-22'),
	('KH02', 'Tran Ngoc Han', '23/5 Nguyen Trai, Q5, TpHCM', '0908256478', '1974-04-03', 280000, '2006-07-30'),
	('KH03', 'Tran Ngoc Linh', '45 Nguyen Canh Chan, Q1, TpHCM', '0938776266', '1980-06-12', 3860000, '2006-08-05'),
	('KH04', 'Tran Minh Long', '50/34 Le Dai Hanh, Q10,TpHCM', '0917325476', '1965-03-09', 250000, '2006-10-02'),
	('KH05', 'Le Nhat Minh', '34 Truong Dinh, Q3, TpHCM', '08256108', '1950-03-10', 21000, '2006-10-28'),
	('KH06', 'Le Hoai Thuong', '227 Nguyen Van Cu, Q5, TpHCM', '08631738', '1981-12-31', 915000, '2006-11-24'),
	('KH07', 'Nguyen Van Tam', '23/3 Tran Binh Trong, Q5, TpHCM', '0916783565', '1971-04-06', 12500, '2006-12-01'),
	('KH08', 'Phan Thi Thanh', '45/2 An Duong Vuong, Q5, TpHCM', '0938435756', '1971-01-10', 365000, '2006-12-13'),
	('KH09', 'Le Ha Vinh', '873 Le Hong Phong, Q5, TpHCM', '08654763', '1979-09-03', 70000, '2007-01-14'),
	('KH10', 'Ha Duy Lap', '34/34B Nguyen Trai, Q1, TpHCM', '08768904', '1983-05-02', 67500, '2007-01-16');
/*!40000 ALTER TABLE `khachhang` ENABLE KEYS */;

-- Dumping structure for table db_lab03.nhanvien
CREATE TABLE IF NOT EXISTS `nhanvien` (
  `MANV` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HOTEN` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DTHOAI` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NGVL` date NOT NULL,
  PRIMARY KEY (`MANV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_lab03.nhanvien: ~5 rows (approximately)
/*!40000 ALTER TABLE `nhanvien` DISABLE KEYS */;
INSERT INTO `nhanvien` (`MANV`, `HOTEN`, `DTHOAI`, `NGVL`) VALUES
	('NV01', 'Nguyen Nhu Nhut', '0927345678', '2006-04-13'),
	('NV02', 'Le Thi Phi Yen', '0987567390', '2006-04-21'),
	('NV03', 'Nguyen Van B', '0997047380', '2006-04-27'),
	('NV04', 'Ngo Thanh Tuan', '0913758498', '2006-06-24'),
	('NV05', 'Nguyen Thi Truc Thanh', '0918590387', '2006-07-20');
/*!40000 ALTER TABLE `nhanvien` ENABLE KEYS */;

-- Dumping structure for table db_lab03.sanpham
CREATE TABLE IF NOT EXISTS `sanpham` (
  `MASP` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TENSP` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DVT` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NUOCSX` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GIA` float NOT NULL,
  PRIMARY KEY (`MASP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_lab03.sanpham: ~24 rows (approximately)
/*!40000 ALTER TABLE `sanpham` DISABLE KEYS */;
INSERT INTO `sanpham` (`MASP`, `TENSP`, `DVT`, `NUOCSX`, `GIA`) VALUES
	('BB01', 'But bi', 'cay', 'Viet Nam', 5000),
	('BB02', 'But bi', 'cay', 'Trung Quoc', 7000),
	('BB03', 'But bi', 'hop', 'Thai Lan', 100000),
	('BC01', 'But Chi', 'cay', 'Trung Quoc', 3000),
	('BC02', 'But Chi', 'cay', 'Thai Lan', 5000),
	('BC03', 'But Chi', 'cay', 'Viet Nam', 3500),
	('BC04', 'But chi', 'hop', 'Viet Nam', 30000),
	('ST01', 'So tay 500 trang', 'quyen', 'Trung Quoc', 40000),
	('ST02', 'So tay loai 1', 'quyen', 'Viet Nam', 55000),
	('ST03', 'So tay loai 2', 'quyen', 'Viet Nam', 51000),
	('ST04', 'So tay', 'quyen', 'Thai Lan', 55000),
	('ST05', 'So tay mong', 'quyen', 'Thai Lan', 20000),
	('ST06', 'Phan viet bang', 'hop', 'Viet Nam', 5000),
	('ST07', 'Phan khong bui', 'hop', 'Viet Nam', 7000),
	('ST08', 'Bong bang', 'cai', 'Viet Nam', 1000),
	('ST09', 'But long', 'cay', 'Viet Nam', 5000),
	('ST10', 'But long', 'cay', 'Trung Quoc', 7000),
	('TV01', 'Tap 100 giay mong', 'quyen', 'Trung Quoc', 2500),
	('TV02', 'Tap 200 giay mong', 'quyen', 'Trung Quoc', 4500),
	('TV03', 'Tap 100 giay tot', 'quyen', 'Viet Nam', 3000),
	('TV04', 'Tap 200 giay tot', 'quyen', 'Viet Nam', 5500),
	('TV05', 'Tap 100 trang', 'chuc', 'Viet Nam', 23000),
	('TV06', 'Tap 200 trang', 'chuc', 'Viet Nam', 53000),
	('TV07', 'Tap 100 trang', 'chuc', 'Trung Quoc', 34000);
/*!40000 ALTER TABLE `sanpham` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
