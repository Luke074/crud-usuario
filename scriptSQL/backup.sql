-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: dbcontatos20202t
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblcontatos`
--

DROP TABLE IF EXISTS `tblcontatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblcontatos` (
  `idContato` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `idEstado` int(8) NOT NULL,
  `dataNascimento` date NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `obs` text,
  `statusContato` tinyint(1) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  PRIMARY KEY (`idContato`),
  KEY `FK_Estados_Contato` (`idEstado`),
  CONSTRAINT `FK_Estados_Contato` FOREIGN KEY (`idEstado`) REFERENCES `tblestados` (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcontatos`
--

LOCK TABLES `tblcontatos` WRITE;
/*!40000 ALTER TABLE `tblcontatos` DISABLE KEYS */;
INSERT INTO `tblcontatos` VALUES (22,'André da silva','(11)99874-5555','teste@algumsite.com',1,'2000-04-01','M','sdfsdfdsf',0,'d226bbdadbc857cb73b8da28c0596bc9.jpg'),(23,'Maria da Silva','(11)98747-4422','fdgdgdfg@teste.com',1,'2000-10-10','F','gfhfg fhg f',0,'a9f7a3542bc8d5f0c57520649d39735c.jpg'),(24,'Luiz da Silva','(11)98747-4422','fdgdgdfg@teste.com',1,'2000-10-10','M','f hfg hfh',0,'e6b4005cbeaa9610d5bab151b06a2d79.jpg'),(25,'Marcel','(11)98747-4422','fdgdgdfg@teste.com',1,'2000-10-10','M','sdsadad',0,'51459d1839232f4e8909fd06007d489d.jpg'),(26,'dfgdfg','(11)98747-4422','fdgdgdfg@teste.com',1,'2000-10-10','M','dfgdfgd df g',0,'semFoto.png');
/*!40000 ALTER TABLE `tblcontatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblestados`
--

DROP TABLE IF EXISTS `tblestados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblestados` (
  `idEstado` int(8) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `sigla` varchar(2) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblestados`
--

LOCK TABLES `tblestados` WRITE;
/*!40000 ALTER TABLE `tblestados` DISABLE KEYS */;
INSERT INTO `tblestados` VALUES (1,'São Paulo','SP'),(2,'Rio de Janeiro','RJ'),(3,'Acre','AC');
/*!40000 ALTER TABLE `tblestados` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-05 15:09:40
