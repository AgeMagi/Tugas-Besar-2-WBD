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
  `category` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES ('2bCdaZ7KvDsC',17967,'Flower language'),('2en3CwAAQBAJ',58300,'Literary Criticism'),('3eAkPwAACAAJ',96274,'Juvenile Nonfiction'),('7FfZCNAi3k0C',0,'Flower arrangement'),('8CSFs_Usw8MC',36162,'Nature'),('8lIdBAAAQBAJ',12532,'Juvenile Fiction'),('dvQVAAAAYAAJ',0,''),('Ff72AAAAQBAJ',74100,'Art'),('fiBbdJ1sdA8C',273405,'Literary Criticism'),('H4m6P7k5XqYC',0,'Literary Collections'),('IfhH9rmvts8C',53136,'Science'),('itTPYQ75V34C',97147,'Social Science'),('ksrbqonI-TAC',0,'Fiction'),('Lc9XAAAAYAAJ',80787,'History'),('LOZhAAAAcAAJ',60914,'Botany'),('MpeE1mAl5FwC',0,'Spirit art'),('MsJluAAACAAJ',52519,'Horror'),('NxR98ogUaAUC',213025,'Health & Fitness'),('oAmUFf_d62EC',0,'Juvenile Fiction'),('P2GS1m876L4C',189846,'Nature'),('PLq0q53zBk4C',12734,'Psychology'),('qhIFAAAAQAAJ',0,''),('RGa2VeA8HiMC',28577,'Floriculture'),('vPS65zz97EAC',87226,'Social Science'),('w1cDAAAAQAAJ',85018,'Flower gardening'),('x5nPG6nwyOQC',43520,'Juvenile Fiction'),('xyh5ss9sKMoC',0,'History'),('Z7uwAAAAIAAJ',16432,'Fiction'),('zy8ADAAAQBAJ',25000,'Juvenile Fiction'),('_ojXNuzgHRcC',36855,'Juvenile Nonfiction');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordered_book`
--

LOCK TABLES `ordered_book` WRITE;
/*!40000 ALTER TABLE `ordered_book` DISABLE KEYS */;
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

-- Dump completed on 2018-11-29 11:43:55
