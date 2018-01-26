-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: smallwork
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `football`
--

DROP TABLE IF EXISTS `football`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `football` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `games` int(11) DEFAULT NULL,
  `won` int(11) DEFAULT NULL,
  `tie` int(11) DEFAULT NULL,
  `lost` int(11) DEFAULT NULL,
  `goals_scored` int(11) DEFAULT NULL,
  `goals_missed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `football_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `football`
--

LOCK TABLES `football` WRITE;
/*!40000 ALTER TABLE `football` DISABLE KEYS */;
INSERT INTO `football` (`id`, `country`, `games`, `won`, `tie`, `lost`, `goals_scored`, `goals_missed`) VALUES (2,'Бразилия',104,70,17,17,221,102),(3,'Германия / ФРГ',106,66,20,20,224,121),(4,'Италия',83,45,21,17,128,77),(5,'Аргентина',77,42,14,21,131,84),(6,'Англия',62,26,20,16,79,56),(7,'Испания',59,29,12,18,92,66),(8,'Франция',59,28,12,19,106,71),(9,'Голландия',50,27,12,11,86,48),(10,'Уругвай',51,20,12,19,80,71),(11,'Швеция',46,16,13,17,74,69),(12,'Россия / СССР',40,17,8,15,66,47),(13,'Сербия / Югославия    ',43,17,8,18,64,59),(14,'Мексика',53,14,14,25,57,92),(15,'Бельгия',41,14,9,18,52,66),(16,'Польша',31,15,5,11,44,40),(17,'Венгрия',32,15,3,14,87,57),(18,'Португалия',26,13,4,9,43,29),(19,'Чехия / Чехословакия',33,12,5,16,47,49),(20,'Чили',33,11,7,15,40,49),(21,'Австрия',29,12,4,13,43,47),(22,'Швейцария',33,11,6,16,45,59),(23,'Парагвай',27,7,10,10,30,38),(24,'США',33,8,6,19,37,62),(25,'Румыния',21,8,5,8,30,32),(26,'Южная Корея',31,5,9,17,31,67),(27,'Дания',16,8,2,6,27,24),(28,'Хорватия',16,7,2,7,21,17),(29,'Колумбия',18,7,2,9,26,27),(30,'Шотландия',23,4,7,12,25,41),(31,'Камерун',23,4,7,12,18,43),(32,'Коста-Рика',15,5,4,6,17,23),(33,'Болгария',26,3,8,15,22,53);
/*!40000 ALTER TABLE `football` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-16 23:07:52
