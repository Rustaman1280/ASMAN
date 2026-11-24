-- MySQL dump 10.13  Distrib 8.4.9, for Linux (x86_64)
--
-- Host: localhost    Database: asman
-- ------------------------------------------------------
-- Server version	8.4.9-0ubuntu0.26.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barang_ruangan`
--

DROP TABLE IF EXISTS `barang_ruangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_ruangan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint unsigned NOT NULL,
  `ruangan_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barang_ruangan_barang_id_ruangan_id_unique` (`barang_id`,`ruangan_id`),
  KEY `barang_ruangan_ruangan_id_foreign` (`ruangan_id`),
  CONSTRAINT `barang_ruangan_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `barang_ruangan_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_ruangan`
--

LOCK TABLES `barang_ruangan` WRITE;
/*!40000 ALTER TABLE `barang_ruangan` DISABLE KEYS */;
/*!40000 ALTER TABLE `barang_ruangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barangs`
--

DROP TABLE IF EXISTS `barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_seri_pabrik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ukuran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggungjawab` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pembuatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_perolehan` decimal(15,2) DEFAULT NULL,
  `masa_manfaat_bulan` int DEFAULT NULL,
  `jumlah_baik` int NOT NULL DEFAULT '0',
  `jumlah_rusak_ringan` int NOT NULL DEFAULT '0',
  `jumlah_rusak_berat` int NOT NULL DEFAULT '0',
  `keterangan_mutasi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_perolehan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulan_perolehan` int DEFAULT NULL,
  `koreksi` decimal(20,2) DEFAULT '0.00',
  `penyusutan_sd_tahun_sebelumnya` decimal(20,2) DEFAULT '0.00',
  `beban_penyusutan_per_bulan` decimal(20,2) DEFAULT '0.00',
  `bulan_manfaat_sd_des_2024` decimal(20,2) DEFAULT '0.00',
  `akum_peny_sd_des_2024` decimal(20,2) DEFAULT '0.00',
  `koreksi_pembulatan` decimal(20,2) DEFAULT '0.00',
  `masa_manfaat_sd_mar_2025` decimal(20,2) DEFAULT '0.00',
  `beban_penyusutan_2025` decimal(20,2) DEFAULT '0.00',
  `akum_peny_sd_2025` decimal(20,2) DEFAULT '0.00',
  `nilai_buku` decimal(20,2) DEFAULT '0.00',
  `nama_opd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_opd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barangs_kode_barang_unique` (`kode_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangs`
--

LOCK TABLES `barangs` WRITE;
/*!40000 ALTER TABLE `barangs` DISABLE KEYS */;
INSERT INTO `barangs` VALUES (1,'1.3.2.06.01.02.999','LAIN - LAIN PERALATAN STUDIO VIDEO DAN FILM','Light Stand Lengkap-Godox SL60W LED','','',NULL,NULL,'LAIN - LAIN PERALATAN STUDIO VIDEO DAN FILM',NULL,'2025',4500000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:24','5.2.02.06.01.0002','SMKN 1 GARUT','BOS REGULER',3,0.00,0.00,46875.00,0.00,0.00,0.00,10.00,468750.00,468750.00,4031250.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(2,'1.3.2.06.01.02.045','Tripod Camera','Manfrotto TRIPOD COMPACT LIGHT','','',NULL,NULL,'Tripod Camera',NULL,'2025',1250000.00,NULL,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:23','5.2.02.06.01.0002','SMKN 1 GARUT','BOS REGULER',2,0.00,0.00,26042.00,0.00,0.00,0.00,11.00,286462.00,286462.00,2213538.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(3,'1.3.2.06.01.02.126','Camera Digital','Kamera DSLR Canon 800D','','',NULL,NULL,'Camera Digital',NULL,'2025',9990000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:24','5.2.02.06.01.0003','SMKN 1 GARUT','BOS REGULER',3,0.00,0.00,104063.00,0.00,0.00,0.00,10.00,1040630.00,1040630.00,8949370.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(4,'1.3.2.06.02.01.004','Telephone Mobile','OPPO A3 NFC 8GB/128GB','','',NULL,NULL,'Telephone Mobile',NULL,'2025',2500000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:23','5.2.02.06.02.0001','SMKN 1 GARUT','BOS REGULER',2,0.00,0.00,26042.00,0.00,0.00,0.00,11.00,286462.00,286462.00,2213538.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(5,'1.3.2.05.01.05.053','Focusing Screen/Layar LCD Projector','LAYAR PROYEKSI MOTORIZED MR-2121 BRITE','','',NULL,NULL,'Focusing Screen/Layar LCD Projector',NULL,'2025',3981570.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:26','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,82950.00,0.00,0.00,0.00,1.00,82950.00,82950.00,3898620.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(6,'1.3.2.08.01.42.999','LAIN - LAIN ALAT LABORATORIUM ELEKTRONIKA DAN DAYA','Battery Lifepo4 48v 20Ah BMS DALY Battery 48v 60ah','','',NULL,NULL,'LAIN - LAIN ALAT LABORATORIUM ELEKTRONIKA DAN DAYA',NULL,'2025',3726000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:23','5.2.02.08.01.0042','SMKN 1 GARUT','BOS REGULER',2,0.00,0.00,38813.00,0.00,0.00,0.00,11.00,426943.00,426943.00,3299057.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(7,'1.3.2.01.01.10.015','Hand Palet Truck','Hand Pallet Manual Pu 68.5x122 Cm 3 Ton','','',NULL,NULL,'Hand Palet Truck',NULL,'2025',6600000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:23','5.2.02.08.03.0014','SMKN 1 GARUT','BOS REGULER',3,0.00,0.00,34375.00,0.00,0.00,0.00,10.00,343750.00,343750.00,6256250.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(8,'1.3.2.10.02.04.026','Acces Point','Ruijie RG-RAP2260 Wi-Fi 6 Dual Band Ceiling Mount Access Point','','',NULL,NULL,'Acces Point',NULL,'2025',1680000.00,NULL,10,0,0,'KABUPATEN GARUT','2026-06-18 20:29:23','2026-06-18 20:29:24','5.2.02.10.02.0004','SMKN 1 GARUT','BOS REGULER',3,0.00,0.00,350000.00,0.00,0.00,0.00,10.00,3500000.00,3500000.00,13300000.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(9,'1.3.2.05.02.06.038','Dispenser','DISPENSER LANTAI BAWAH COSMOS CWD 7601','','',NULL,NULL,'Dispenser',NULL,'2025',2200000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.02.0005','SMKN 1 GARUT','BOS REGULER',3,0.00,0.00,22917.00,0.00,0.00,0.00,10.00,229170.00,229170.00,1970830.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(10,'1.3.2.03.01.06.001','Mesin Gergaji','Mesin Pemotong Kayu merk cleo','','',NULL,NULL,'Mesin Gergaji',NULL,'2025',1500000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',3,0.00,0.00,31250.00,0.00,0.00,0.00,10.00,312500.00,312500.00,1187500.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(11,'1.3.2.05.02.01.033','Kursi Biasa','Kursi Meja Properti Studio Properti informa','','',NULL,NULL,'Kursi Biasa',NULL,'2025',3500000.00,NULL,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',3,0.00,0.00,36459.00,0.00,0.00,0.00,10.00,364590.00,364590.00,3135410.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(12,'1.3.2.08.01.16.006','Mikroskop Binokuler','Mikroskop Binokuler Corona LED','','',NULL,NULL,'Mikroskop Binokuler',NULL,'2025',4600000.00,96,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:25','5.2.02.08.01.0012','SMKN 1 GARUT','BOS REGULER',9,0.00,0.00,95834.00,0.00,0.00,0.00,4.00,383336.00,383336.00,8816664.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(13,'1.3.2.10.02.03.017','External/ Portable Hardisk','Harddisk 8TB CCTV WD Purple','','',NULL,NULL,'External/ Portable Hardisk',NULL,'2025',4900000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:25','5.2.02.10.02.0004','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,102084.00,0.00,0.00,0.00,2.00,204168.00,204168.00,4695832.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(14,'1.3.2.05.01.05.010','Alat Penghancur Kertas','PAPER SHREDDER KOZURE KS-8722C','','',NULL,NULL,'Alat Penghancur Kertas',NULL,'2025',3600000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',5,0.00,0.00,75000.00,0.00,0.00,0.00,8.00,600000.00,600000.00,3000000.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(15,'1.3.2.10.01.02.001','P.C Unit','ACER Veriton X - Core i3 (VX/0041) Acer','','',NULL,NULL,'P.C Unit',NULL,'2025',15401250.00,48,36,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:25','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,11550960.00,0.00,0.00,0.00,1.00,11550960.00,11550960.00,542894040.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(16,'1.3.2.10.01.02.002','Lap Top','ACER TRAVELMATE P214 CORE-I5 (TMP214/0041) ACER','','',NULL,NULL,'Lap Top',NULL,'2025',18212880.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:25','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,758870.00,0.00,0.00,0.00,1.00,758870.00,758870.00,35666890.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(17,'1.3.2.10.02.03.003','Printer (Peralatan Personal Komputer)','HP Printer OfficeJet 200 [CZ993A] HP','','',NULL,NULL,'Printer (Peralatan Personal Komputer)',NULL,'2025',4639800.00,48,4,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:25','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,386652.00,0.00,0.00,0.00,1.00,386652.00,386652.00,18172548.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(18,'1.3.2.05.01.05.043','LCD Projector/Infocus','EPSON EB-FH52 Epson','','',NULL,NULL,'LCD Projector/Infocus',NULL,'2025',14251290.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:25','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,296902.00,0.00,0.00,0.00,1.00,296902.00,296902.00,13954388.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(19,'1.3.2.15.03.01.021','Tandu','Tandu Lipat 2','','',NULL,NULL,'Tandu',NULL,'2025',1310650.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',5,0.00,0.00,27306.00,0.00,0.00,0.00,8.00,218448.00,218448.00,1092202.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(20,'1.3.2.05.01.02.007','Mesin Penghitung Uang','MESIN HITUNG UANG IWARE MC88VII','','',NULL,NULL,'Mesin Penghitung Uang',NULL,'2025',2485000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.01.0002','SMKN 1 GARUT','BOS REGULER',5,0.00,0.00,51771.00,0.00,0.00,0.00,8.00,414168.00,414168.00,2070832.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(21,'1.3.2.05.01.04.001','Lemari Besi/Metal','High Cabinet Winnie Halfslide','','',NULL,NULL,'Lemari Besi/Metal',NULL,'2025',2399000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BLUD',12,0.00,0.00,49980.00,0.00,0.00,0.00,1.00,49980.00,49980.00,2349020.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(22,'1.3.2.06.01.02.163','Camera Conference','WEBCAM LOGITECH C922 PR','','',NULL,NULL,'Camera Conference',NULL,'2025',1750000.00,96,8,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,145840.00,0.00,0.00,0.00,7.00,1020880.00,1020880.00,12979120.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(23,'1.3.2.05.02.06.014','Microphone','BoyaLink All in One Wireless Microphone BANDUN','','',NULL,NULL,'Microphone',NULL,'2025',1750000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.06.01.0002','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,18230.00,0.00,0.00,0.00,7.00,127610.00,127610.00,1622390.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(24,'1.3.2.08.04.05.002','Uninterupted Power Supply (UPS)','UPS APC Easy UPS BVX 1200VA 650W BVX1200LI-MS APC','','',NULL,NULL,'Uninterupted Power Supply (UPS)',NULL,'2025',1965000.00,96,7,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.10.02.0005','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,143283.00,0.00,0.00,0.00,7.00,1002981.00,1002981.00,12752019.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(25,'1.3.2.05.02.04.006','Kipas Angin','MASPION Kipas Angin Dinding 20 Inch Remote / Power Fan PW 2002RC','','',NULL,NULL,'Kipas Angin',NULL,'2025',1100000.00,96,6,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.02.0006','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,68754.00,0.00,0.00,0.00,7.00,481278.00,481278.00,6118722.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(26,'1.3.2.03.02.11.999','LAIN - LAIN PERALATAN UKUR, GIP DAN FEETING','Krisbow Meteran Laser Digital Compact 100 Mtr B','','',NULL,NULL,'LAIN - LAIN PERALATAN UKUR, GIP DAN FEETING',NULL,'2025',2175000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,45313.00,0.00,0.00,0.00,7.00,317191.00,317191.00,1857809.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(27,'1.3.2.05.01.05.005','White Board','Glassboard Standing Putih 100x150 cm magnetik','','',NULL,NULL,'White Board',NULL,'2025',2135000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,88960.00,0.00,0.00,0.00,7.00,622720.00,622720.00,3647280.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(28,'1.3.2.08.01.01.009','Timbangan Elektronik','Timbangan Meja Digita','','',NULL,NULL,'Timbangan Elektronik',NULL,'2025',1285000.00,96,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.03.03.0010','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,26772.00,0.00,0.00,0.00,7.00,187404.00,187404.00,2382596.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(29,'1.3.2.06.03.23.015','Switcher/Patch Panel','PATCH PANEL 24PORT CAT 6 COMMSCOPE','','',NULL,NULL,'Switcher/Patch Panel',NULL,'2025',2100000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.10.02.0004','SMKN 1 GARUT','BOS REGULER',6,0.00,0.00,21875.00,0.00,0.00,0.00,7.00,153125.00,153125.00,1946875.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(30,'1.3.2.05.02.01.999','LAIN - LAIN MEUBELAIR','MEJA KURSI SISWA','','',NULL,NULL,'LAIN - LAIN MEUBELAIR',NULL,'2025',1350000.00,96,120,0,0,'KABUPATEN GARUT','2026-06-18 20:29:24','2026-06-18 20:29:24','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',8,0.00,0.00,1687560.00,0.00,0.00,0.00,5.00,8437800.00,8437800.00,153562200.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(31,'1.3.2.05.01.04.003','Rak Besi','RAK 4 SUSUN SERBAGUNA BAJA STAINLESS','','',NULL,NULL,'Rak Besi',NULL,'2025',1255000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,52292.00,0.00,0.00,0.00,3.00,156876.00,156876.00,2353124.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(32,'1.3.2.10.02.04.024','Switch','Switch FO Ruijie Reyee RG-ES210GS-P10','','',NULL,NULL,'Switch',NULL,'2025',2496580.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.02.0004','SMKN 1 GARUT','BLUD',10,0.00,0.00,52013.00,0.00,0.00,0.00,3.00,156039.00,156039.00,2340541.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(33,'1.3.2.15.04.01.012','Voice Recorder','NVR IP CAMERA Hikvision DS-7362NXI-K2','','',NULL,NULL,'Voice Recorder',NULL,'2025',4960000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.02.0004','SMKN 1 GARUT','BOS REGULER',8,0.00,0.00,51667.00,0.00,0.00,0.00,5.00,258335.00,258335.00,4701665.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(34,'1.3.2.05.01.04.027','Lemari Kaca','LEMARI IMPORTA SC-A8 MS','','',NULL,NULL,'Lemari Kaca',NULL,'2025',3700000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',8,0.00,0.00,154168.00,0.00,0.00,0.00,5.00,770840.00,770840.00,6629160.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(35,'1.3.2.05.02.04.005','Portable Air Conditioner (Alat Pendingin)','MIDEA AC PORTABLE MPHA-09CRN7 1PK MULTIPLE FUNCTION','','',NULL,NULL,'Portable Air Conditioner (Alat Pendingin)',NULL,'2025',4350000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0006','SMKN 1 GARUT','BOS REGULER',8,0.00,0.00,45313.00,0.00,0.00,0.00,5.00,226565.00,226565.00,4123435.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(36,'1.3.2.05.01.05.002','CCTV - Camera Control Television System','DS-2CD1047G2H-LIU Hikvision Audio IP Came PoE CCTV 4MP','','',NULL,NULL,'CCTV - Camera Control Television System',NULL,'2025',1750000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,72918.00,0.00,0.00,0.00,2.00,145836.00,145836.00,3354164.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(37,'1.3.2.01.03.06.999','LAIN - LAIN MESIN BOR','BOR CORDLESS IMPACT WRENCH RYU RWC20V','','',NULL,NULL,'LAIN - LAIN MESIN BOR',NULL,'2025',1999000.00,192,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.08.01.0042','SMKN 1 GARUT','BOS REGULER',9,0.00,0.00,20824.00,0.00,0.00,0.00,4.00,83296.00,83296.00,3914704.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(38,'1.3.2.10.02.04.999','LAIN - LAIN PERALATAN JARINGAN','Ruijie RG-RAP2260(G) Reyee Wi-Fi 6','','',NULL,NULL,'LAIN - LAIN PERALATAN JARINGAN',NULL,'2025',2900000.00,48,10,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.02.0004','SMKN 1 GARUT','BLUD',10,0.00,0.00,604170.00,0.00,0.00,0.00,3.00,1812510.00,1812510.00,27187490.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(39,'1.3.2.05.02.06.002','Televisi','TV Samsung 55 55DU7000','','',NULL,NULL,'Televisi',NULL,'2025',11950000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.05.01.02.0001','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,124480.00,0.00,0.00,0.00,2.00,248960.00,248960.00,11701040.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(40,'1.3.2.05.02.06.074','Bracket Standing Peralatan','Bracket Standing Tv 55 - 80','','',NULL,NULL,'Bracket Standing Peralatan',NULL,'2025',1780000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.05.01.02.0001','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,18542.00,0.00,0.00,0.00,2.00,37084.00,37084.00,1742916.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(41,'1.3.2.10.02.03.999','LAIN - LAIN PERALATAN PERSONAL KOMPUTER','3D PRINTER','','',NULL,NULL,'LAIN - LAIN PERALATAN PERSONAL KOMPUTER',NULL,'2025',4093000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.06.01.0004','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,85271.00,0.00,0.00,0.00,3.00,255813.00,255813.00,3837187.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(42,'1.3.2.10.02.04.001','Server','SERVER HPE ML30 G11 XEON E - 2434 16GB 1TB HDD P65095 - 371','','',NULL,NULL,'Server',NULL,'2025',36500000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.01.0002','SMKN 1 GARUT','BOS REGULER',9,0.00,0.00,760417.00,0.00,0.00,0.00,4.00,3041668.00,3041668.00,33458332.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(43,'1.3.2.05.01.04.005','Filing Cabinet Besi','DRY BOX DRY CABINET ANDBON AD- 80C','','',NULL,NULL,'Filing Cabinet Besi',NULL,'2025',2670000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,55625.00,0.00,0.00,0.00,3.00,166875.00,166875.00,2503125.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(44,'1.3.2.10.02.01.009','Serial Printer','PRINTER EPSON L3250 ALL IN ONE BANDUNG 1','','',NULL,NULL,'Serial Printer',NULL,'2025',3125000.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.02.0005','SMKN 1 GARUT','BOS REGULER',9,0.00,0.00,65105.00,0.00,0.00,0.00,4.00,260420.00,260420.00,2864580.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(45,'1.3.2.05.02.06.057','Karpet','KARPET MESJID','','',NULL,NULL,'Karpet',NULL,'2025',3500000.00,96,3,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,109377.00,0.00,0.00,0.00,3.00,328131.00,328131.00,10171869.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(46,'1.3.2.05.01.05.063','Board Stan','GLASSBOARD STANDING PUTIH 100X150 CM','','',NULL,NULL,'Board Stan',NULL,'2025',2345000.00,48,3,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,146565.00,0.00,0.00,0.00,3.00,439695.00,439695.00,6595305.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(47,'1.3.2.05.02.04.007','Exhause Fan','KIPAS EKSOS CKE 20 INCH ESN 220V EXHAUST ESN-D20/1-YL','','',NULL,NULL,'Exhause Fan',NULL,'2025',1790000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0006','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,18646.00,0.00,0.00,0.00,3.00,55938.00,55938.00,1734062.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(48,'1.3.2.05.01.02.003','Mesin Hitung Elektronik/Calculator','KALKULATOR  CASIO FR-2650RC','','',NULL,NULL,'Mesin Hitung Elektronik/Calculator',NULL,'2025',1350000.00,48,3,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.01.0002','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,84375.00,0.00,0.00,0.00,3.00,253125.00,253125.00,3796875.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(49,'1.3.2.07.01.11.003','Bed Pan For Adult 310 mm Complete','BED PASIEN 2 CRANK ABS','','',NULL,NULL,'Bed Pan For Adult 310 mm Complete',NULL,'2025',6250000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.01.0005','SMKN 1 GARUT','BOS REGULER',10,0.00,0.00,65105.00,0.00,0.00,0.00,3.00,195315.00,195315.00,6054685.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(50,'1.3.2.10.02.03.001','CPU (Peralatan Personal Komputer)','PC RAKITAN AMD RYZEN 7 8700F RAM 16 GB VGA RX9060SSD 512 GB','','',NULL,NULL,'CPU (Peralatan Personal Komputer)',NULL,'2025',17800000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.02.0005','SMKN 1 GARUT','BOS REGULER',9,0.00,0.00,741668.00,0.00,0.00,0.00,4.00,2966672.00,2966672.00,32633328.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(51,'1.3.2.10.02.03.002','Monitor','MONITOR SAMSUNG LS24F320GAEXXD ESSENTIAL S32GF BANDUNG','','',NULL,NULL,'Monitor',NULL,'2025',1500000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.02.0005','SMKN 1 GARUT','BOS REGULER',9,0.00,0.00,62500.00,0.00,0.00,0.00,4.00,250000.00,250000.00,2750000.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(52,'1.3.2.10.02.04.002','Router','SWITCH HUB RUIJE REYEE EG-ES118GS-PL 16 PORT','','',NULL,NULL,'Router',NULL,'2025',2700000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.10.02.0004','SMKN 1 GARUT','BOS REGULER',9,0.00,0.00,112500.00,0.00,0.00,0.00,4.00,450000.00,450000.00,4950000.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(53,'1.3.2.05.01.05.078','Papan Tulis','Glassboard Standing Putih 100x150 cm','','',NULL,NULL,'Papan Tulis',NULL,'2025',2345000.00,48,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,97710.00,0.00,0.00,0.00,2.00,195420.00,195420.00,4494580.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(54,'1.3.2.08.03.16.999','LAIN - LAIN ALAT PERAGA PRAKTEK SEKOLAH LAINNYA','Bench / Kursi Group Studio Poto','','',NULL,NULL,'LAIN - LAIN ALAT PERAGA PRAKTEK SEKOLAH LAINNYA',NULL,'2025',8500000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,88542.00,0.00,0.00,0.00,2.00,177084.00,177084.00,8322916.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(55,'1.3.2.06.01.01.036','Microphone/Wireless MIC','Wireless Mic Ashley','','',NULL,NULL,'Microphone/Wireless MIC',NULL,'2025',3500000.00,96,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.06.01.0001','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,36459.00,0.00,0.00,0.00,2.00,72918.00,72918.00,3427082.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(56,'1.3.2.05.02.01.032','Kursi Putar','LEXUS','','',NULL,NULL,'Kursi Putar',NULL,'2025',1750000.00,96,5,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.05.02.0001','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,91150.00,0.00,0.00,0.00,2.00,182300.00,182300.00,8567700.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(57,'1.3.2.08.03.05.999','LAIN - LAIN ALAT PERAGA PRAKTEK SEKOLAH BIDANG STUDI : IPA MENENGAH','Timbangan Obat/Timbangan Gram/Timbangan Farmasi','','',NULL,NULL,'LAIN - LAIN ALAT PERAGA PRAKTEK SEKOLAH BIDANG STUDI : IPA MENENGAH',NULL,'2025',2400000.00,96,5,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.03.03.0010','SMKN 1 GARUT','BOS REGULER',11,0.00,0.00,125000.00,0.00,0.00,0.00,2.00,250000.00,250000.00,11750000.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(58,'1.3.2.05.02.01.048','Sofa','Sofa Podcast-Dimensi: 69 cm x 71 cm x 75 cm','','',NULL,NULL,'Sofa',NULL,'2025',4750800.00,96,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,98976.00,0.00,0.00,0.00,1.00,98976.00,98976.00,9402624.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(59,'1.3.2.06.01.02.157','Clipp On','Clip On-Jangkauan Wireless Hingga 100m','','',NULL,NULL,'Clipp On',NULL,'2025',4195800.00,96,2,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,87414.00,0.00,0.00,0.00,1.00,87414.00,87414.00,8304186.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(60,'1.3.2.09.02.01.011','Target Drone (Simulasi Pesawat Sasaran Tembak Udara)','dji Drone Mavic 3 Enterprise DJI','','',NULL,NULL,'Target Drone (Simulasi Pesawat Sasaran Tembak Udara)',NULL,'2025',54061440.00,48,1,0,0,'KABUPATEN GARUT','2026-06-18 20:29:25','2026-06-18 20:29:25','5.2.02.08.03.0014','SMKN 1 GARUT','DAK',12,0.00,0.00,1126280.00,0.00,0.00,0.00,1.00,1126280.00,1126280.00,52935160.00,'DINAS PENDIDIKAN','SMKN 1 GARUT'),(61,'1.3.2.05.02.01.023','Meja Sekolah','Vivente','','',NULL,NULL,'Meja Sekolah',NULL,'2025',1100010.00,96,72,0,0,'KABUPATEN GARUT','2026-06-18 20:29:26','2026-06-18 20:29:26','5.2.02.05.02.0001','SMKN 1 GARUT','APBD',12,0.00,0.00,825048.00,0.00,0.00,0.00,1.00,825048.00,825048.00,78375672.00,'DINAS PENDIDIKAN','SMKN 1 GARUT');
/*!40000 ALTER TABLE `barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurusans`
--

DROP TABLE IF EXISTS `jurusans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jurusans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jurusans_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurusans`
--

LOCK TABLES `jurusans` WRITE;
/*!40000 ALTER TABLE `jurusans` DISABLE KEYS */;
INSERT INTO `jurusans` VALUES (1,'Rekayasa Perangkat Lunak','RPL','2026-06-18 20:29:23','2026-06-18 20:29:23'),(2,'Teknik Komputer dan Jaringan','TKJ','2026-06-18 20:29:23','2026-06-18 20:29:23');
/*!40000 ALTER TABLE `jurusans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_10_070101_create_jurusans_table',1),(5,'2026_02_10_070102_create_kelas_table',1),(6,'2026_02_10_072103_create_labs_table',1),(7,'2026_02_11_004603_create_suppliers_table',1),(8,'2026_02_11_004608_create_barangs_table',1),(9,'2026_02_11_071738_create_units_table',1),(10,'2026_02_11_073700_restructure_barang_unit',1),(11,'2026_02_13_100000_add_inventory_fields_to_barangs_table',1),(12,'2026_02_13_120000_remove_units_and_update_keadaan_barang',1),(13,'2026_04_02_074958_restructure_ruangans_tables',1),(14,'2026_04_15_002936_change_lokasi_to_ruangan_id_in_barangs_table',1),(15,'2026_04_15_010447_create_unit_barangs_table',1),(16,'2026_04_15_090000_create_barang_ruangan_table',1),(17,'2026_04_15_090100_remove_ruangan_id_from_barangs',1),(18,'2026_04_15_093000_add_ruangan_id_to_unit_barangs_table',1),(19,'2026_04_16_005830_add_jurusan_id_to_users_table',1),(20,'2026_04_28_012552_create_mutasis_table',1),(21,'2026_04_30_005917_create_ruangan_user_table',1),(22,'2026_05_25_015809_add_inventory_columns_to_barangs_and_units_tables',1),(23,'2026_05_25_023624_drop_suppliers_table_and_column',1),(24,'2026_05_25_033435_add_missing_32_columns_to_barangs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutasis`
--

DROP TABLE IF EXISTS `mutasis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mutasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint unsigned DEFAULT NULL,
  `unit_barang_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `jenis_mutasi` enum('penambahan','ubah_status','ubah_lokasi','peminjaman','pengembalian','penghapusan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tanggal_mutasi` date NOT NULL,
  `status_awal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_akhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruangan_awal_id` bigint unsigned DEFAULT NULL,
  `ruangan_akhir_id` bigint unsigned DEFAULT NULL,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mutasis_barang_id_foreign` (`barang_id`),
  KEY `mutasis_unit_barang_id_foreign` (`unit_barang_id`),
  KEY `mutasis_user_id_foreign` (`user_id`),
  KEY `mutasis_ruangan_awal_id_foreign` (`ruangan_awal_id`),
  KEY `mutasis_ruangan_akhir_id_foreign` (`ruangan_akhir_id`),
  CONSTRAINT `mutasis_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mutasis_ruangan_akhir_id_foreign` FOREIGN KEY (`ruangan_akhir_id`) REFERENCES `ruangans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `mutasis_ruangan_awal_id_foreign` FOREIGN KEY (`ruangan_awal_id`) REFERENCES `ruangans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `mutasis_unit_barang_id_foreign` FOREIGN KEY (`unit_barang_id`) REFERENCES `unit_barangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mutasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutasis`
--

LOCK TABLES `mutasis` WRITE;
/*!40000 ALTER TABLE `mutasis` DISABLE KEYS */;
/*!40000 ALTER TABLE `mutasis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruangan_user`
--

DROP TABLE IF EXISTS `ruangan_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ruangan_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ruangan_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ruangan_user_ruangan_id_foreign` (`ruangan_id`),
  KEY `ruangan_user_user_id_foreign` (`user_id`),
  CONSTRAINT `ruangan_user_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ruangan_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruangan_user`
--

LOCK TABLES `ruangan_user` WRITE;
/*!40000 ALTER TABLE `ruangan_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `ruangan_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruangans`
--

DROP TABLE IF EXISTS `ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ruangans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_ruangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ruangans_jurusan_id_foreign` (`jurusan_id`),
  CONSTRAINT `ruangans_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruangans`
--

LOCK TABLES `ruangans` WRITE;
/*!40000 ALTER TABLE `ruangans` DISABLE KEYS */;
INSERT INTO `ruangans` VALUES (1,'Area Pembelajaran & Akademik','Ruang Kelas','Ruang Kelas X RPL 1','10',1,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(2,'Area Pembelajaran & Akademik','Ruang Laboratorium','Lab Komputer 1',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(3,'Area Pembelajaran & Akademik','Ruang Perpustakaan','Perpustakaan Pusat',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(4,'Area Administrasi & Manajemen','Ruang Pimpinan','Ruang Kepala Sekolah',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(5,'Area Administrasi & Manajemen','Ruang Guru','Ruang Guru Utama',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(6,'Area Administrasi & Manajemen','Ruang TU (Tata Usaha)','Ruang Tata Usaha (TU)',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(7,'Area Penunjang Pendidikan & Siswa','Ruang OSIS','Ruang OSIS',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(8,'Area Penunjang Pendidikan & Siswa','Ruang UKS','Ruang UKS',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(9,'Area Fasilitas Umum & Sanitasi','Ruang Toilet','Toilet Siswa Lantai 1',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(10,'Area Fasilitas Umum & Sanitasi','Ruang Gudang','Gudang Pusat',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(11,'Area Fasilitas Umum & Sanitasi','Tempat Bermain / Olahraga','Lapangan Olahraga',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23');
/*!40000 ALTER TABLE `ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_barangs`
--

DROP TABLE IF EXISTS `unit_barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unit_barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint unsigned NOT NULL,
  `kode_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_perolehan` decimal(15,2) DEFAULT NULL,
  `akumulasi_penyusutan` decimal(15,2) DEFAULT NULL,
  `nilai_buku` decimal(15,2) DEFAULT NULL,
  `ruangan_id` bigint unsigned DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `no_mesin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rangka` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unit_barangs_kode_unit_unique` (`kode_unit`),
  KEY `unit_barangs_barang_id_foreign` (`barang_id`),
  KEY `unit_barangs_ruangan_id_foreign` (`ruangan_id`),
  CONSTRAINT `unit_barangs_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `unit_barangs_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=421 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_barangs`
--

LOCK TABLES `unit_barangs` WRITE;
/*!40000 ALTER TABLE `unit_barangs` DISABLE KEYS */;
INSERT INTO `unit_barangs` VALUES (1,1,'1.3.2.06.01.02.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(2,2,'1.3.2.06.01.02.045-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(3,2,'1.3.2.06.01.02.045-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(4,3,'1.3.2.06.01.02.126-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(5,4,'1.3.2.06.02.01.004-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(6,5,'1.3.2.05.01.05.053-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(8,6,'1.3.2.08.01.42.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(9,7,'1.3.2.01.01.10.015-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(10,8,'1.3.2.10.02.04.026-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23'),(20,9,'1.3.2.05.02.06.038-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(21,10,'1.3.2.03.01.06.001-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(22,11,'1.3.2.05.02.01.033-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(23,12,'1.3.2.08.01.16.006-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(25,8,'1.3.2.10.02.04.026-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(26,8,'1.3.2.10.02.04.026-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(27,8,'1.3.2.10.02.04.026-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(28,8,'1.3.2.10.02.04.026-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(29,8,'1.3.2.10.02.04.026-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(30,8,'1.3.2.10.02.04.026-007','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(31,8,'1.3.2.10.02.04.026-008','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(32,8,'1.3.2.10.02.04.026-009','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(33,8,'1.3.2.10.02.04.026-010','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(34,13,'1.3.2.10.02.03.017-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(36,14,'1.3.2.05.01.05.010-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(37,15,'1.3.2.10.01.02.001-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(38,16,'1.3.2.10.01.02.002-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(40,17,'1.3.2.10.02.03.003-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(44,18,'1.3.2.05.01.05.043-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(47,19,'1.3.2.15.03.01.021-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(48,20,'1.3.2.05.01.02.007-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(49,21,'1.3.2.05.01.04.001-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(59,22,'1.3.2.06.01.02.163-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(60,22,'1.3.2.06.01.02.163-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(61,22,'1.3.2.06.01.02.163-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(62,22,'1.3.2.06.01.02.163-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(63,22,'1.3.2.06.01.02.163-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(64,22,'1.3.2.06.01.02.163-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(65,22,'1.3.2.06.01.02.163-007','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(66,22,'1.3.2.06.01.02.163-008','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(67,23,'1.3.2.05.02.06.014-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(68,24,'1.3.2.08.04.05.002-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(69,24,'1.3.2.08.04.05.002-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(70,24,'1.3.2.08.04.05.002-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(71,24,'1.3.2.08.04.05.002-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(72,24,'1.3.2.08.04.05.002-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(73,24,'1.3.2.08.04.05.002-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(74,24,'1.3.2.08.04.05.002-007','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(75,25,'1.3.2.05.02.04.006-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(76,25,'1.3.2.05.02.04.006-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(77,25,'1.3.2.05.02.04.006-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(78,25,'1.3.2.05.02.04.006-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(79,25,'1.3.2.05.02.04.006-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(80,25,'1.3.2.05.02.04.006-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(81,26,'1.3.2.03.02.11.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(82,27,'1.3.2.05.01.05.005-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(83,27,'1.3.2.05.01.05.005-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(84,28,'1.3.2.08.01.01.009-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(85,28,'1.3.2.08.01.01.009-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(86,29,'1.3.2.06.03.23.015-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(87,30,'1.3.2.05.02.01.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(88,30,'1.3.2.05.02.01.999-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(89,30,'1.3.2.05.02.01.999-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(90,30,'1.3.2.05.02.01.999-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(91,30,'1.3.2.05.02.01.999-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(92,30,'1.3.2.05.02.01.999-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(93,30,'1.3.2.05.02.01.999-007','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(94,30,'1.3.2.05.02.01.999-008','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(95,30,'1.3.2.05.02.01.999-009','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(96,30,'1.3.2.05.02.01.999-010','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(97,30,'1.3.2.05.02.01.999-011','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(98,30,'1.3.2.05.02.01.999-012','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(99,30,'1.3.2.05.02.01.999-013','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(100,30,'1.3.2.05.02.01.999-014','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(101,30,'1.3.2.05.02.01.999-015','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(102,30,'1.3.2.05.02.01.999-016','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(103,30,'1.3.2.05.02.01.999-017','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(104,30,'1.3.2.05.02.01.999-018','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(105,30,'1.3.2.05.02.01.999-019','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(106,30,'1.3.2.05.02.01.999-020','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(107,30,'1.3.2.05.02.01.999-021','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(108,30,'1.3.2.05.02.01.999-022','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(109,30,'1.3.2.05.02.01.999-023','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(110,30,'1.3.2.05.02.01.999-024','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(111,30,'1.3.2.05.02.01.999-025','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(112,30,'1.3.2.05.02.01.999-026','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(113,30,'1.3.2.05.02.01.999-027','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(114,30,'1.3.2.05.02.01.999-028','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(115,30,'1.3.2.05.02.01.999-029','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(116,30,'1.3.2.05.02.01.999-030','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(117,30,'1.3.2.05.02.01.999-031','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(118,30,'1.3.2.05.02.01.999-032','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(119,30,'1.3.2.05.02.01.999-033','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(120,30,'1.3.2.05.02.01.999-034','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(121,30,'1.3.2.05.02.01.999-035','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(122,30,'1.3.2.05.02.01.999-036','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(123,30,'1.3.2.05.02.01.999-037','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(124,30,'1.3.2.05.02.01.999-038','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(125,30,'1.3.2.05.02.01.999-039','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(126,30,'1.3.2.05.02.01.999-040','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(127,30,'1.3.2.05.02.01.999-041','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(128,30,'1.3.2.05.02.01.999-042','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(129,30,'1.3.2.05.02.01.999-043','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(130,30,'1.3.2.05.02.01.999-044','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(131,30,'1.3.2.05.02.01.999-045','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(132,30,'1.3.2.05.02.01.999-046','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(133,30,'1.3.2.05.02.01.999-047','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(134,30,'1.3.2.05.02.01.999-048','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(135,30,'1.3.2.05.02.01.999-049','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(136,30,'1.3.2.05.02.01.999-050','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(137,30,'1.3.2.05.02.01.999-051','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(138,30,'1.3.2.05.02.01.999-052','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(139,30,'1.3.2.05.02.01.999-053','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(140,30,'1.3.2.05.02.01.999-054','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(141,30,'1.3.2.05.02.01.999-055','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(142,30,'1.3.2.05.02.01.999-056','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(143,30,'1.3.2.05.02.01.999-057','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(144,30,'1.3.2.05.02.01.999-058','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(145,30,'1.3.2.05.02.01.999-059','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(146,30,'1.3.2.05.02.01.999-060','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(147,30,'1.3.2.05.02.01.999-061','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(148,30,'1.3.2.05.02.01.999-062','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(149,30,'1.3.2.05.02.01.999-063','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(150,30,'1.3.2.05.02.01.999-064','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(151,30,'1.3.2.05.02.01.999-065','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(152,30,'1.3.2.05.02.01.999-066','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(153,30,'1.3.2.05.02.01.999-067','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(154,30,'1.3.2.05.02.01.999-068','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(155,30,'1.3.2.05.02.01.999-069','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(156,30,'1.3.2.05.02.01.999-070','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(157,30,'1.3.2.05.02.01.999-071','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(158,30,'1.3.2.05.02.01.999-072','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(159,30,'1.3.2.05.02.01.999-073','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(160,30,'1.3.2.05.02.01.999-074','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(161,30,'1.3.2.05.02.01.999-075','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(162,30,'1.3.2.05.02.01.999-076','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(163,30,'1.3.2.05.02.01.999-077','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(164,30,'1.3.2.05.02.01.999-078','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(165,30,'1.3.2.05.02.01.999-079','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(166,30,'1.3.2.05.02.01.999-080','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(167,30,'1.3.2.05.02.01.999-081','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(168,30,'1.3.2.05.02.01.999-082','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(169,30,'1.3.2.05.02.01.999-083','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(170,30,'1.3.2.05.02.01.999-084','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(171,30,'1.3.2.05.02.01.999-085','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(172,30,'1.3.2.05.02.01.999-086','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(173,30,'1.3.2.05.02.01.999-087','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(174,30,'1.3.2.05.02.01.999-088','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(175,30,'1.3.2.05.02.01.999-089','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(176,30,'1.3.2.05.02.01.999-090','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(177,30,'1.3.2.05.02.01.999-091','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(178,30,'1.3.2.05.02.01.999-092','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(179,30,'1.3.2.05.02.01.999-093','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(180,30,'1.3.2.05.02.01.999-094','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(181,30,'1.3.2.05.02.01.999-095','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(182,30,'1.3.2.05.02.01.999-096','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(183,30,'1.3.2.05.02.01.999-097','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(184,30,'1.3.2.05.02.01.999-098','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(185,30,'1.3.2.05.02.01.999-099','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(186,30,'1.3.2.05.02.01.999-100','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(187,30,'1.3.2.05.02.01.999-101','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(188,30,'1.3.2.05.02.01.999-102','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(189,30,'1.3.2.05.02.01.999-103','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(190,30,'1.3.2.05.02.01.999-104','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(191,30,'1.3.2.05.02.01.999-105','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(192,30,'1.3.2.05.02.01.999-106','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(193,30,'1.3.2.05.02.01.999-107','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(194,30,'1.3.2.05.02.01.999-108','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(195,30,'1.3.2.05.02.01.999-109','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(196,30,'1.3.2.05.02.01.999-110','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(197,30,'1.3.2.05.02.01.999-111','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(198,30,'1.3.2.05.02.01.999-112','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(199,30,'1.3.2.05.02.01.999-113','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(200,30,'1.3.2.05.02.01.999-114','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(201,30,'1.3.2.05.02.01.999-115','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(202,30,'1.3.2.05.02.01.999-116','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(203,30,'1.3.2.05.02.01.999-117','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(204,30,'1.3.2.05.02.01.999-118','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:24','2026-06-18 20:29:24'),(205,30,'1.3.2.05.02.01.999-119','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(206,30,'1.3.2.05.02.01.999-120','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(207,31,'1.3.2.05.01.04.003-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(208,32,'1.3.2.10.02.04.024-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(210,33,'1.3.2.15.04.01.012-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(211,34,'1.3.2.05.01.04.027-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(212,34,'1.3.2.05.01.04.027-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(213,31,'1.3.2.05.01.04.003-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(214,35,'1.3.2.05.02.04.005-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(215,36,'1.3.2.05.01.05.002-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(244,12,'1.3.2.08.01.16.006-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(245,37,'1.3.2.01.03.06.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(246,37,'1.3.2.01.03.06.999-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(247,38,'1.3.2.10.02.04.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(248,39,'1.3.2.05.02.06.002-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(253,40,'1.3.2.05.02.06.074-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(258,41,'1.3.2.10.02.03.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(259,42,'1.3.2.10.02.04.001-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(260,43,'1.3.2.05.01.04.005-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(261,44,'1.3.2.10.02.01.009-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(264,45,'1.3.2.05.02.06.057-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(265,45,'1.3.2.05.02.06.057-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(266,45,'1.3.2.05.02.06.057-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(267,46,'1.3.2.05.01.05.063-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(268,46,'1.3.2.05.01.05.063-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(269,46,'1.3.2.05.01.05.063-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(270,47,'1.3.2.05.02.04.007-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(271,48,'1.3.2.05.01.02.003-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(272,48,'1.3.2.05.01.02.003-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(273,48,'1.3.2.05.01.02.003-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(274,49,'1.3.2.07.01.11.003-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(275,50,'1.3.2.10.02.03.001-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(276,50,'1.3.2.10.02.03.001-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(277,51,'1.3.2.10.02.03.002-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(278,51,'1.3.2.10.02.03.002-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(279,52,'1.3.2.10.02.04.002-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(280,52,'1.3.2.10.02.04.002-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(281,38,'1.3.2.10.02.04.999-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(282,38,'1.3.2.10.02.04.999-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(283,38,'1.3.2.10.02.04.999-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(284,38,'1.3.2.10.02.04.999-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(285,38,'1.3.2.10.02.04.999-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(286,38,'1.3.2.10.02.04.999-007','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(287,38,'1.3.2.10.02.04.999-008','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(288,38,'1.3.2.10.02.04.999-009','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(289,38,'1.3.2.10.02.04.999-010','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(290,53,'1.3.2.05.01.05.078-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(291,53,'1.3.2.05.01.05.078-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(292,54,'1.3.2.08.03.16.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(293,55,'1.3.2.06.01.01.036-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(294,56,'1.3.2.05.02.01.032-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(295,56,'1.3.2.05.02.01.032-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(296,56,'1.3.2.05.02.01.032-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(297,56,'1.3.2.05.02.01.032-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(298,56,'1.3.2.05.02.01.032-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(299,36,'1.3.2.05.01.05.002-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(300,57,'1.3.2.08.03.05.999-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(301,57,'1.3.2.08.03.05.999-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(302,57,'1.3.2.08.03.05.999-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(303,57,'1.3.2.08.03.05.999-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(304,57,'1.3.2.08.03.05.999-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(305,58,'1.3.2.05.02.01.048-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(306,58,'1.3.2.05.02.01.048-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(307,59,'1.3.2.06.01.02.157-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(308,59,'1.3.2.06.01.02.157-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(309,16,'1.3.2.10.01.02.002-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(310,15,'1.3.2.10.01.02.001-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(311,15,'1.3.2.10.01.02.001-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(312,15,'1.3.2.10.01.02.001-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(313,15,'1.3.2.10.01.02.001-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(314,15,'1.3.2.10.01.02.001-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(315,15,'1.3.2.10.01.02.001-007','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(316,15,'1.3.2.10.01.02.001-008','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(317,15,'1.3.2.10.01.02.001-009','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(318,15,'1.3.2.10.01.02.001-010','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(319,15,'1.3.2.10.01.02.001-011','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(320,15,'1.3.2.10.01.02.001-012','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(321,15,'1.3.2.10.01.02.001-013','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(322,15,'1.3.2.10.01.02.001-014','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(323,15,'1.3.2.10.01.02.001-015','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(324,15,'1.3.2.10.01.02.001-016','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(325,15,'1.3.2.10.01.02.001-017','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(326,15,'1.3.2.10.01.02.001-018','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(327,15,'1.3.2.10.01.02.001-019','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(328,15,'1.3.2.10.01.02.001-020','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(329,15,'1.3.2.10.01.02.001-021','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(330,15,'1.3.2.10.01.02.001-022','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(331,15,'1.3.2.10.01.02.001-023','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(332,15,'1.3.2.10.01.02.001-024','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(333,15,'1.3.2.10.01.02.001-025','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(334,15,'1.3.2.10.01.02.001-026','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(335,15,'1.3.2.10.01.02.001-027','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(336,15,'1.3.2.10.01.02.001-028','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(337,15,'1.3.2.10.01.02.001-029','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(338,15,'1.3.2.10.01.02.001-030','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(339,15,'1.3.2.10.01.02.001-031','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(340,15,'1.3.2.10.01.02.001-032','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(341,15,'1.3.2.10.01.02.001-033','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(342,15,'1.3.2.10.01.02.001-034','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(343,15,'1.3.2.10.01.02.001-035','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(344,15,'1.3.2.10.01.02.001-036','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(345,60,'1.3.2.09.02.01.011-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(346,17,'1.3.2.10.02.03.003-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(347,17,'1.3.2.10.02.03.003-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(348,17,'1.3.2.10.02.03.003-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:25','2026-06-18 20:29:25'),(349,61,'1.3.2.05.02.01.023-001','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(350,61,'1.3.2.05.02.01.023-002','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(351,61,'1.3.2.05.02.01.023-003','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(352,61,'1.3.2.05.02.01.023-004','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(353,61,'1.3.2.05.02.01.023-005','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(354,61,'1.3.2.05.02.01.023-006','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(355,61,'1.3.2.05.02.01.023-007','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(356,61,'1.3.2.05.02.01.023-008','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(357,61,'1.3.2.05.02.01.023-009','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(358,61,'1.3.2.05.02.01.023-010','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(359,61,'1.3.2.05.02.01.023-011','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(360,61,'1.3.2.05.02.01.023-012','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(361,61,'1.3.2.05.02.01.023-013','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(362,61,'1.3.2.05.02.01.023-014','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(363,61,'1.3.2.05.02.01.023-015','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(364,61,'1.3.2.05.02.01.023-016','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(365,61,'1.3.2.05.02.01.023-017','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(366,61,'1.3.2.05.02.01.023-018','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(367,61,'1.3.2.05.02.01.023-019','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(368,61,'1.3.2.05.02.01.023-020','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(369,61,'1.3.2.05.02.01.023-021','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(370,61,'1.3.2.05.02.01.023-022','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(371,61,'1.3.2.05.02.01.023-023','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(372,61,'1.3.2.05.02.01.023-024','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(373,61,'1.3.2.05.02.01.023-025','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(374,61,'1.3.2.05.02.01.023-026','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(375,61,'1.3.2.05.02.01.023-027','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(376,61,'1.3.2.05.02.01.023-028','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(377,61,'1.3.2.05.02.01.023-029','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(378,61,'1.3.2.05.02.01.023-030','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(379,61,'1.3.2.05.02.01.023-031','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(380,61,'1.3.2.05.02.01.023-032','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(381,61,'1.3.2.05.02.01.023-033','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(382,61,'1.3.2.05.02.01.023-034','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(383,61,'1.3.2.05.02.01.023-035','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(384,61,'1.3.2.05.02.01.023-036','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(385,61,'1.3.2.05.02.01.023-037','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(386,61,'1.3.2.05.02.01.023-038','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(387,61,'1.3.2.05.02.01.023-039','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(388,61,'1.3.2.05.02.01.023-040','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(389,61,'1.3.2.05.02.01.023-041','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(390,61,'1.3.2.05.02.01.023-042','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(391,61,'1.3.2.05.02.01.023-043','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(392,61,'1.3.2.05.02.01.023-044','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(393,61,'1.3.2.05.02.01.023-045','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(394,61,'1.3.2.05.02.01.023-046','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(395,61,'1.3.2.05.02.01.023-047','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(396,61,'1.3.2.05.02.01.023-048','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(397,61,'1.3.2.05.02.01.023-049','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(398,61,'1.3.2.05.02.01.023-050','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(399,61,'1.3.2.05.02.01.023-051','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(400,61,'1.3.2.05.02.01.023-052','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(401,61,'1.3.2.05.02.01.023-053','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(402,61,'1.3.2.05.02.01.023-054','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(403,61,'1.3.2.05.02.01.023-055','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(404,61,'1.3.2.05.02.01.023-056','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(405,61,'1.3.2.05.02.01.023-057','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(406,61,'1.3.2.05.02.01.023-058','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(407,61,'1.3.2.05.02.01.023-059','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(408,61,'1.3.2.05.02.01.023-060','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(409,61,'1.3.2.05.02.01.023-061','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(410,61,'1.3.2.05.02.01.023-062','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(411,61,'1.3.2.05.02.01.023-063','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(412,61,'1.3.2.05.02.01.023-064','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(413,61,'1.3.2.05.02.01.023-065','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(414,61,'1.3.2.05.02.01.023-066','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(415,61,'1.3.2.05.02.01.023-067','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(416,61,'1.3.2.05.02.01.023-068','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(417,61,'1.3.2.05.02.01.023-069','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(418,61,'1.3.2.05.02.01.023-070','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(419,61,'1.3.2.05.02.01.023-071','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26'),(420,61,'1.3.2.05.02.01.023-072','baik',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-18 20:29:26','2026-06-18 20:29:26');
/*!40000 ALTER TABLE `unit_barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan_id` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_jurusan_id_foreign` (`jurusan_id`),
  CONSTRAINT `users_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@asman.com',NULL,'$2y$12$YItg8PWG0ocjL2dVtBpZv.2y19m.Z1qhD/tFY//kUTNuZDzxI60J2','admin',NULL,NULL,'2026-06-18 20:29:23','2026-06-18 20:29:23');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-19 10:30:13
