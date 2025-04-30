CREATE DATABASE  IF NOT EXISTS `discoteca` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `discoteca`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: discoteca
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Table structure for table `categorias_posts`
--

DROP TABLE IF EXISTS `categorias_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `id_utilizador` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `categorias_posts_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_posts`
--

LOCK TABLES `categorias_posts` WRITE;
/*!40000 ALTER TABLE `categorias_posts` DISABLE KEYS */;
INSERT INTO `categorias_posts` VALUES (1,'Eventos Noturnos',1);
/*!40000 ALTER TABLE `categorias_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conteudo` text NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `data_criacao` datetime NOT NULL,
  `id_utilizador` int NOT NULL,
  `id_post` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`),
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (1,'Essa festa foi demais!','Comentário sobre a festa','2025-04-30 11:05:09',1,1);
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `mensagem` text NOT NULL,
  `assunto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,'Maria Santos','maria@email.com','Gostaria de saber mais sobre o evento.','Informações sobre o evento');
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `djs`
--

DROP TABLE IF EXISTS `djs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `djs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `tipo_musica` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `morada` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `djs`
--

LOCK TABLES `djs` WRITE;
/*!40000 ALTER TABLE `djs` DISABLE KEYS */;
INSERT INTO `djs` VALUES (1,'DJ Beat','Techno','djbeat@email.com','Av. da Música, 45');
/*!40000 ALTER TABLE `djs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) NOT NULL,
  `Data_Hora_Inicio` datetime NOT NULL,
  `Data_Hora_Fim` datetime NOT NULL,
  `id_utilizador` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Festival de Verão','2025-08-01 18:00:00','2025-08-02 02:00:00',1);
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `tipo_arquivo` varchar(5) NOT NULL,
  `data_upload` datetime NOT NULL,
  `confirmacao` enum('S','N','PV') NOT NULL DEFAULT 'PV',
  `id_utilizador` int NOT NULL,
  `id_utilizador_aprovar` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  KEY `id_utilizador_aprovar` (`id_utilizador_aprovar`),
  CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`),
  CONSTRAINT `fotos_ibfk_2` FOREIGN KEY (`id_utilizador_aprovar`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
INSERT INTO `fotos` VALUES (1,'Festa de Aniversário','Foto tirada durante o evento de comemoração.','jpg','2025-04-30 11:05:09','PV',1,NULL);
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `lista_categorias_posts`
--

DROP TABLE IF EXISTS `lista_categorias_posts`;
/*!50001 DROP VIEW IF EXISTS `lista_categorias_posts`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_categorias_posts` AS SELECT 
 1 AS `id`,
 1 AS `nome`,
 1 AS `id_utilizador`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_comentarios_recentes`
--

DROP TABLE IF EXISTS `lista_comentarios_recentes`;
/*!50001 DROP VIEW IF EXISTS `lista_comentarios_recentes`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_comentarios_recentes` AS SELECT 
 1 AS `id`,
 1 AS `conteudo`,
 1 AS `titulo`,
 1 AS `data_criacao`,
 1 AS `id_utilizador`,
 1 AS `id_post`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_contactos`
--

DROP TABLE IF EXISTS `lista_contactos`;
/*!50001 DROP VIEW IF EXISTS `lista_contactos`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_contactos` AS SELECT 
 1 AS `id`,
 1 AS `nome`,
 1 AS `email`,
 1 AS `mensagem`,
 1 AS `assunto`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_posts_publicados`
--

DROP TABLE IF EXISTS `lista_posts_publicados`;
/*!50001 DROP VIEW IF EXISTS `lista_posts_publicados`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_posts_publicados` AS SELECT 
 1 AS `id`,
 1 AS `titulo`,
 1 AS `imagem`,
 1 AS `descricao`,
 1 AS `data_publicacao`,
 1 AS `id_utilizador`,
 1 AS `id_categoria`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `lista_utilizadores_ativos`
--

DROP TABLE IF EXISTS `lista_utilizadores_ativos`;
/*!50001 DROP VIEW IF EXISTS `lista_utilizadores_ativos`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `lista_utilizadores_ativos` AS SELECT 
 1 AS `id`,
 1 AS `nome`,
 1 AS `email`,
 1 AS `tipo`,
 1 AS `password`,
 1 AS `estado`,
 1 AS `ultima_atividade`,
 1 AS `nif`,
 1 AS `telefone`,
 1 AS `morada`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `participacoes`
--

DROP TABLE IF EXISTS `participacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Data_Hora` datetime NOT NULL,
  `id_dj` int NOT NULL,
  `id_eventos` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dj` (`id_dj`),
  KEY `id_eventos` (`id_eventos`),
  CONSTRAINT `participacoes_ibfk_1` FOREIGN KEY (`id_dj`) REFERENCES `djs` (`id`),
  CONSTRAINT `participacoes_ibfk_2` FOREIGN KEY (`id_eventos`) REFERENCES `eventos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participacoes`
--

LOCK TABLES `participacoes` WRITE;
/*!40000 ALTER TABLE `participacoes` DISABLE KEYS */;
INSERT INTO `participacoes` VALUES (1,'2025-08-01 21:00:00',1,1);
/*!40000 ALTER TABLE `participacoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `imagem` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `data_publicacao` datetime NOT NULL,
  `id_utilizador` int NOT NULL,
  `id_categoria` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Melhor noite do ano!','noite.jpg','Imagens da festa eletrônica','2025-04-30 11:05:09',1,1);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `reservas_utilizador_1`
--

DROP TABLE IF EXISTS `reservas_utilizador_1`;
/*!50001 DROP VIEW IF EXISTS `reservas_utilizador_1`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `reservas_utilizador_1` AS SELECT 
 1 AS `id`,
 1 AS `descricao`,
 1 AS `data_reserva`,
 1 AS `id_utilizador`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `reservas_vips`
--

DROP TABLE IF EXISTS `reservas_vips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservas_vips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `data_reserva` datetime NOT NULL,
  `id_utilizador` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `reservas_vips_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas_vips`
--

LOCK TABLES `reservas_vips` WRITE;
/*!40000 ALTER TABLE `reservas_vips` DISABLE KEYS */;
INSERT INTO `reservas_vips` VALUES (1,'Reserva para Bruno Marques','2025-04-30 11:05:09',1);
/*!40000 ALTER TABLE `reservas_vips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tipo` enum('N','F','A') NOT NULL DEFAULT 'N',
  `password` varchar(255) NOT NULL,
  `estado` enum('A','I') NOT NULL DEFAULT 'A',
  `ultima_atividade` timestamp NOT NULL,
  `nif` char(9) DEFAULT NULL,
  `telefone` char(9) DEFAULT NULL,
  `morada` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizadores`
--

LOCK TABLES `utilizadores` WRITE;
/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` VALUES (1,'João Silva','joao@email.com','N','senha123','A','2025-04-30 10:05:09','123456789','912345678','Rua das Flores, 123');
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `lista_categorias_posts`
--

/*!50001 DROP VIEW IF EXISTS `lista_categorias_posts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_categorias_posts` AS select `categorias_posts`.`id` AS `id`,`categorias_posts`.`nome` AS `nome`,`categorias_posts`.`id_utilizador` AS `id_utilizador` from `categorias_posts` order by `categorias_posts`.`nome` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_comentarios_recentes`
--

/*!50001 DROP VIEW IF EXISTS `lista_comentarios_recentes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_comentarios_recentes` AS select `comentarios`.`id` AS `id`,`comentarios`.`conteudo` AS `conteudo`,`comentarios`.`titulo` AS `titulo`,`comentarios`.`data_criacao` AS `data_criacao`,`comentarios`.`id_utilizador` AS `id_utilizador`,`comentarios`.`id_post` AS `id_post` from `comentarios` where (`comentarios`.`data_criacao` is not null) order by `comentarios`.`data_criacao` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_contactos`
--

/*!50001 DROP VIEW IF EXISTS `lista_contactos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_contactos` AS select `contactos`.`id` AS `id`,`contactos`.`nome` AS `nome`,`contactos`.`email` AS `email`,`contactos`.`mensagem` AS `mensagem`,`contactos`.`assunto` AS `assunto` from `contactos` where (`contactos`.`email` is not null) order by `contactos`.`nome` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_posts_publicados`
--

/*!50001 DROP VIEW IF EXISTS `lista_posts_publicados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_posts_publicados` AS select `posts`.`id` AS `id`,`posts`.`titulo` AS `titulo`,`posts`.`imagem` AS `imagem`,`posts`.`descricao` AS `descricao`,`posts`.`data_publicacao` AS `data_publicacao`,`posts`.`id_utilizador` AS `id_utilizador`,`posts`.`id_categoria` AS `id_categoria` from `posts` where (`posts`.`data_publicacao` is not null) order by `posts`.`data_publicacao` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lista_utilizadores_ativos`
--

/*!50001 DROP VIEW IF EXISTS `lista_utilizadores_ativos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lista_utilizadores_ativos` AS select `utilizadores`.`id` AS `id`,`utilizadores`.`nome` AS `nome`,`utilizadores`.`email` AS `email`,`utilizadores`.`tipo` AS `tipo`,`utilizadores`.`password` AS `password`,`utilizadores`.`estado` AS `estado`,`utilizadores`.`ultima_atividade` AS `ultima_atividade`,`utilizadores`.`nif` AS `nif`,`utilizadores`.`telefone` AS `telefone`,`utilizadores`.`morada` AS `morada` from `utilizadores` where (`utilizadores`.`estado` = 'A') order by `utilizadores`.`nome` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `reservas_utilizador_1`
--

/*!50001 DROP VIEW IF EXISTS `reservas_utilizador_1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `reservas_utilizador_1` AS select `reservas_vips`.`id` AS `id`,`reservas_vips`.`descricao` AS `descricao`,`reservas_vips`.`data_reserva` AS `data_reserva`,`reservas_vips`.`id_utilizador` AS `id_utilizador` from `reservas_vips` where (`reservas_vips`.`id_utilizador` = 1) order by `reservas_vips`.`data_reserva` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-30 13:00:39
