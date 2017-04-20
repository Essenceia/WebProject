-- MySQL dump 10.16  Distrib 10.1.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: webapp
-- ------------------------------------------------------
-- Server version	10.1.22-MariaDB-

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `user` varchar(20) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `album_id_uindex` (`id`),
  KEY `user_proprietaire_album` (`user`),
  CONSTRAINT `user_proprietaire_album` FOREIGN KEY (`user`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` VALUES ('desmazes',1,'testalbum','this is test'),('m.champalier',2,'test2','another test');
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `amis`
--

DROP TABLE IF EXISTS `amis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amis` (
  `user1` varchar(20) NOT NULL,
  `user2` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `refuser1` (`user1`),
  KEY `refuser2` (`user2`),
  CONSTRAINT `refuser1` FOREIGN KEY (`user1`) REFERENCES `user` (`email`),
  CONSTRAINT `refuser2` FOREIGN KEY (`user2`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amis`
--

LOCK TABLES `amis` WRITE;
/*!40000 ALTER TABLE `amis` DISABLE KEYS */;
INSERT INTO `amis` VALUES ('desmazes','m.champalier',1,'2017-04-15 08:59:25'),('tiercelin','desmazes',0,'2016-04-16 08:59:50');
/*!40000 ALTER TABLE `amis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `idpost` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `type` int(2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `legende` text,
  `idalbum` int(11) DEFAULT NULL,
  `lieu` text,
  `emotion` int(3) DEFAULT NULL,
  `activiter` text,
  `contenu` text,
  `privacy` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idpost`),
  UNIQUE KEY `post_idpost_uindex` (`idpost`),
  KEY `user_qui_post` (`user`),
  KEY `id_album` (`idalbum`),
  CONSTRAINT `id_album` FOREIGN KEY (`idalbum`) REFERENCES `album` (`id`),
  CONSTRAINT `user_qui_post` FOREIGN KEY (`user`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (3,'m.champalier',0,'2017-04-19 11:50:39','Ceci est un post ecrit',NULL,'ece',1,'en cours',NULL,1),(6,'desmazes',1,'2017-04-20 13:51:43','Test',1,'ece',NULL,'rien','6',1),(7,'desmazes',1,'2017-05-20 14:50:46','test2',1,NULL,NULL,NULL,'7',1),(8,'desmazes',1,'2017-04-20 14:50:59','test 3 ',1,'arg',NULL,'I have cookies','8',1),(9,'desmazes',0,'2017-04-20 15:23:31','Hello ',NULL,' ',0,'activite truc ',NULL,0),(10,'desmazes',0,'2017-04-20 15:26:56','ggg ',NULL,' ',1,'activite joggong ',NULL,1),(11,'desmazes',0,'2017-04-20 16:02:18','',NULL,'',0,'',NULL,0),(12,'desmazes',0,'2017-04-20 16:03:53','',NULL,'',0,'',NULL,0),(13,'desmazes',0,'2017-04-20 16:30:35','legende',NULL,'lieu',2,'activite none',NULL,0),(14,'desmazes',0,'2017-04-20 16:31:37','legende',NULL,'lieu',2,'activite none',NULL,0),(15,'desmazes',0,'2017-04-20 16:32:51','legende',NULL,'lieu',2,'activite none',NULL,0),(17,'desmazes',1,'2017-04-20 16:36:53','legende',1,'lieu',2,'activite none','',0);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaction`
--

DROP TABLE IF EXISTS `reaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reaction` (
  `idpost` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reactiontxt` text,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reaction_id_uindex` (`id`),
  KEY `user_qui_reagit` (`user`),
  KEY `post_sur_lequel_on_reagit` (`idpost`),
  CONSTRAINT `post_sur_lequel_on_reagit` FOREIGN KEY (`idpost`) REFERENCES `post` (`idpost`),
  CONSTRAINT `user_qui_reagit` FOREIGN KEY (`user`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reaction`
--

LOCK TABLES `reaction` WRITE;
/*!40000 ALTER TABLE `reaction` DISABLE KEYS */;
INSERT INTO `reaction` VALUES (3,'desmazes',3,'2017-04-19 12:50:08','LOL MDR , oui je suis constructif',1);
/*!40000 ALTER TABLE `reaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `email` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `photoprofil` varchar(20) NOT NULL DEFAULT 'icon',
  `photofond` varchar(20) NOT NULL DEFAULT 'fond',
  PRIMARY KEY (`email`),
  UNIQUE KEY `user_email_uindex` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('desmazes','Desmazes','kkk','sn','icon','fond'),('m.champalier','Champalier','ooo','Cat','icon','fond'),('tiercelin','Tiercelim','pp','MusicGod','icon','fond');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-21  0:17:42
