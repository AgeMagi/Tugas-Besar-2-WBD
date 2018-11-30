-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: webservice_book
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `book_id` varchar(45) NOT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES ('0-1LTfwEeq0C',4041),('1-BMDwAAQBAJ',85000),('1hu06fuemlcC',0),('2PlqewAACAAJ',0),('38ZQOiEpDvQC',75403),('58ZhDwAAQBAJ',59000),('6uNjAAAAMAAJ',99113),('7UtFDwAAQBAJ',55000),('8CSFs_Usw8MC',98255),('90bMUPuBjm4C',0),('9TAzp1Vy7t0C',99900),('a6sLAAAAMAAJ',0),('acQGNYhKkAYC',0),('adbAAAAAQBAJ',88917),('ADhrR99L2lEC',341726),('AwGialii_IkC',0),('b2c8ki3kG-oC',0),('bFVkCgAAQBAJ',14900),('biRHNwP32sUC',66284),('BQLwo39frsgC',0),('BsCCAwAAQBAJ',45000),('cizGbnnvJkgC',93790),('CvWpDQAAQBAJ',29539),('dt2jYcpbNvsC',0),('dURGDwAAQBAJ',39000),('EmlaDwAAQBAJ',75403),('ewPxsaeVzeoC',0),('EwyAOxtUz5MC',0),('Ff72AAAAQBAJ',74100),('fiBbdJ1sdA8C',273405),('FN5wMOZKTYMC',133376),('frzS6cG-khgC',61172),('G8U_MJNgQTwC',53964),('gBrmaR0q4OEC',55471),('geBCMq-Ha5cC',0),('HYZKDwAAQBAJ',22000),('I-ORhT_RY3IC',69035),('Iw_gHtk4ghYC',133376),('JUlirhy2iIQC',0),('JWiNch4JDQUC',86335),('k3547R_FtwQC',92003),('kh5mXds7jzYC',50407),('KIEVgQOcDYAC',64073),('lkhfAAAAcAAJ',64590),('LOZhAAAAcAAJ',0),('Mgs7AQAAMAAJ',0),('mll4BwAAQBAJ',88968),('Mug4uI3ZGo8C',102568),('nciBAAAAQBAJ',8900),('NN_q3RZdrpMC',68270),('NxR98ogUaAUC',213025),('O2iTYcPGG5MC',0),('OuI0rAnxPDUC',41112),('P-E8DwAAQBAJ',47000),('QFpdDwAAQBAJ',0),('QorCAAAACAAJ',54782),('rXWOVGGzHekC',0),('S0ZNe2iqM54C',98507),('SALPZwEACAAJ',0),('SaQdmWiAM-MC',95243),('SB1kDB21lWcC',17873),('ssCuWsY3dskC',64539),('stJ7HHxF-KsC',34985),('SVJFDwAAQBAJ',67000),('svMpjjnnig0C',24402),('SYnxB4-pJRUC',0),('SZ-uScSyKxoC',71020),('taSGbCRIW5cC',0),('TFJfCc8Q9GUC',0),('TMj0RS0QeMgC',0),('tOD9AwAAQBAJ',23085),('uchjAAAAMAAJ',46487),('uF0cOEMgI00C',26284),('VfWI-JB8kjsC',8900),('VHCZKTWSY0YC',0),('vHlTOVTKHeUC',0),('w1cDAAAAQAAJ',78944),('W9Slrak_DfUC',0),('WUtFDwAAQBAJ',50000),('xJbLB8zcXCgC',102797),('xkaB9-xhK_sC',147018),('xoLvbBZCD9wC',77693),('xsIZEhS0DrIC',8900),('xvLwAAAAMAAJ',73893),('Y-dEnc_Sj0cC',86744),('Yz8Fnw0PlEQC',112837),('ZdKYBQAAQBAJ',88993),('_8haYvWoKfYC',8900),('_nLTRryTGDQC',0),('_ojXNuzgHRcC',32071),('_zSzAwAAQBAJ',0);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_book`
--

DROP TABLE IF EXISTS `category_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_book` (
  `category_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` varchar(45) NOT NULL,
  `category` varchar(125) NOT NULL,
  PRIMARY KEY (`category_book_id`),
  KEY `fk_category_book_1_idx` (`book_id`),
  CONSTRAINT `fk_category_book_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_book`
--

LOCK TABLES `category_book` WRITE;
/*!40000 ALTER TABLE `category_book` DISABLE KEYS */;
INSERT INTO `category_book` VALUES (1,'Ff72AAAAQBAJ','Art'),(2,'w1cDAAAAQAAJ','Flower gardening'),(3,'8CSFs_Usw8MC','Nature'),(4,'LOZhAAAAcAAJ','Botany'),(5,'fiBbdJ1sdA8C','Literary Criticism'),(6,'_ojXNuzgHRcC','Juvenile Nonfiction'),(7,'xvLwAAAAMAAJ','Gardening'),(8,'AwGialii_IkC','Juvenile Nonfiction'),(9,'svMpjjnnig0C','Juvenile Nonfiction'),(10,'NxR98ogUaAUC','Health & Fitness'),(11,'gBrmaR0q4OEC','Music'),(12,'a6sLAAAAMAAJ','Indonesian language'),(13,'HYZKDwAAQBAJ','Juvenile Fiction'),(14,'KIEVgQOcDYAC','Indonesian fiction'),(15,'58ZhDwAAQBAJ','Religion'),(16,'S0ZNe2iqM54C','Indonesian fiction'),(17,'90bMUPuBjm4C','Furniture industry and trade'),(18,'_nLTRryTGDQC','Laskar pelangi (Motion picture)'),(19,'rXWOVGGzHekC','Batak (Indonesian people)'),(20,'P-E8DwAAQBAJ','Juvenile Fiction'),(21,'biRHNwP32sUC','Indonesian fiction'),(22,'HYZKDwAAQBAJ','Juvenile Fiction / Legends, Myths, Fables / General'),(23,'QorCAAAACAAJ','Null'),(24,'Ff72AAAAQBAJ','Art / General'),(25,'Ff72AAAAQBAJ','Art / Subjects & Themes / Landscapes & Seascapes'),(26,'Ff72AAAAQBAJ','Art / Subjects & Themes / Plants & Animals'),(27,'Ff72AAAAQBAJ','Art / Techniques / Painting'),(28,'SB1kDB21lWcC','Bakeries'),(29,'QFpdDwAAQBAJ','History'),(30,'O2iTYcPGG5MC','Book industries and trade'),(31,'9TAzp1Vy7t0C','Poetry'),(32,'taSGbCRIW5cC','Poetry'),(33,'ewPxsaeVzeoC','Poetry'),(34,'2PlqewAACAAJ','Literary Criticism'),(35,'adbAAAAAQBAJ','Poetry'),(36,'uchjAAAAMAAJ','Poets, Urdu'),(37,'SYnxB4-pJRUC','Urdu poetry'),(38,'6uNjAAAAMAAJ','Poets, Urdu'),(39,'NN_q3RZdrpMC','Kal?m'),(40,'taSGbCRIW5cC','Poetry / General'),(41,'acQGNYhKkAYC','Biography & Autobiography'),(42,'1-BMDwAAQBAJ','Self-Help'),(43,'ssCuWsY3dskC','Juvenile Fiction'),(44,'EmlaDwAAQBAJ','Juvenile Fiction'),(45,'stJ7HHxF-KsC','Juvenile Fiction'),(46,'xoLvbBZCD9wC','Philosophy'),(47,'1hu06fuemlcC','Games'),(48,'ADhrR99L2lEC','Comics & Graphic Novels'),(49,'frzS6cG-khgC','Fiction'),(50,'b2c8ki3kG-oC','Fiction'),(51,'acQGNYhKkAYC','Biography & Autobiography / Personal Memoirs'),(52,'VHCZKTWSY0YC','Political Science'),(53,'SZ-uScSyKxoC','Language Arts & Disciplines'),(54,'geBCMq-Ha5cC','Fiction'),(55,'mll4BwAAQBAJ','Law'),(56,'SaQdmWiAM-MC','Fiction'),(57,'xkaB9-xhK_sC','Juvenile Fiction'),(58,'xJbLB8zcXCgC','Juvenile Fiction'),(59,'ZdKYBQAAQBAJ','Fiction'),(60,'VHCZKTWSY0YC','Political Science / General'),(61,'SZ-uScSyKxoC','Language Arts & Disciplines / General'),(62,'dt2jYcpbNvsC','Baggins, Frodo (Fictitious character)'),(63,'7UtFDwAAQBAJ','Fiction'),(64,'bFVkCgAAQBAJ','Fiction'),(65,'Y-dEnc_Sj0cC','Self-Help'),(66,'WUtFDwAAQBAJ','Fiction'),(67,'BsCCAwAAQBAJ','Fiction'),(68,'JUlirhy2iIQC','India'),(69,'SALPZwEACAAJ','Teenage girls'),(70,'xsIZEhS0DrIC','Juvenile Fiction'),(71,'_8haYvWoKfYC','Juvenile Fiction'),(72,'VfWI-JB8kjsC','Juvenile Fiction'),(73,'nciBAAAAQBAJ','Juvenile Fiction'),(74,'tOD9AwAAQBAJ','Humorous stories'),(75,'dURGDwAAQBAJ','Family & Relationships'),(76,'BQLwo39frsgC','Comics & Graphic Novels'),(77,'0-1LTfwEeq0C','Fiction'),(78,'38ZQOiEpDvQC','Juvenile Fiction'),(79,'ssCuWsY3dskC','Juvenile Fiction / Action & Adventure / General'),(80,'ssCuWsY3dskC','Juvenile Fiction / Comics & Graphic Novels / Superheroes'),(81,'ssCuWsY3dskC','Juvenile Fiction / Media Tie-In'),(82,'ssCuWsY3dskC','Juvenile Fiction / Readers / Beginner'),(83,'Yz8Fnw0PlEQC','Juvenile Fiction'),(84,'I-ORhT_RY3IC','Cooking'),(85,'FN5wMOZKTYMC','Juvenile Fiction'),(86,'_zSzAwAAQBAJ','Juvenile Fiction'),(87,'SVJFDwAAQBAJ','Fiction'),(88,'Iw_gHtk4ghYC','Juvenile Fiction'),(89,'JWiNch4JDQUC','Young Adult Nonfiction'),(90,'kh5mXds7jzYC','Biography & Autobiography'),(91,'uF0cOEMgI00C','Fiction'),(92,'Mug4uI3ZGo8C','Juvenile Nonfiction'),(93,'Yz8Fnw0PlEQC','Juvenile Fiction / Dystopian'),(94,'vHlTOVTKHeUC','Computers / Software Development & Engineering / General'),(95,'vHlTOVTKHeUC','Computers / Software Development & Engineering / Quality Assurance & Testing'),(96,'xsIZEhS0DrIC','Juvenile Fiction / Action & Adventure / General'),(97,'xsIZEhS0DrIC','Juvenile Fiction / Media Tie-In'),(98,'xsIZEhS0DrIC','Juvenile Fiction / Fantasy & Magic');
/*!40000 ALTER TABLE `category_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordered_book`
--

DROP TABLE IF EXISTS `ordered_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordered_book` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` varchar(45) NOT NULL,
  `sender_card_number` varchar(45) NOT NULL,
  `ordered_count` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_ordered_book_1_idx` (`book_id`),
  CONSTRAINT `fk_ordered_book_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordered_book`
--

LOCK TABLES `ordered_book` WRITE;
/*!40000 ALTER TABLE `ordered_book` DISABLE KEYS */;
INSERT INTO `ordered_book` VALUES (8,'HYZKDwAAQBAJ','9',2),(9,'QorCAAAACAAJ','9',1),(10,'KIEVgQOcDYAC','9',1);
/*!40000 ALTER TABLE `ordered_book` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-30 18:30:41
