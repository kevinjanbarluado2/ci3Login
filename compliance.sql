-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table onlinei1_test.ta_materials
CREATE TABLE IF NOT EXISTS `ta_materials` (
  `id_material` int(11) NOT NULL AUTO_INCREMENT,
  `material_title` longtext COLLATE utf8mb4_unicode_ci,
  `file_uploaded` longtext COLLATE utf8mb4_unicode_ci,
  `file_name` longtext COLLATE utf8mb4_unicode_ci,
  KEY `Index 1` (`id_material`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table onlinei1_test.ta_materials: ~5 rows (approximately)
/*!40000 ALTER TABLE `ta_materials` DISABLE KEYS */;
INSERT INTO `ta_materials` (`id_material`, `material_title`, `file_uploaded`, `file_name`) VALUES
	(1, 'Teal and Yellow Illustrated Suitcase Going Away Pa', '1', ''),
	(2, 'png demo', 'C:/laragon/www/staging-training/training_materials/adviser profile.png', 'adviser profile.png'),
	(3, 'mp4 demo', 'C:/laragon/www/staging-training/training_materials/cat.mp4', 'cat.mp4'),
	(4, 'pdf demo', 'C:/laragon/www/staging-training/training_materials/Pdf test.pdf', 'Pdf test.pdf'),
	(5, 'mp3 demo', 'C:/laragon/www/staging-training/training_materials/meow.mp3', 'meow.mp3');
/*!40000 ALTER TABLE `ta_materials` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
