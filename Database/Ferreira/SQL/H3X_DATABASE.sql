CREATE DATABASE  IF NOT EXISTS `h3x` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `h3x`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: h3x
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `categoria_evento`
--

DROP TABLE IF EXISTS `categoria_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria_evento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomecat` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_evento`
--

LOCK TABLES `categoria_evento` WRITE;
/*!40000 ALTER TABLE `categoria_evento` DISABLE KEYS */;
INSERT INTO `categoria_evento` VALUES (1,'Festa'),(2,'Concerto'),(3,'Afterwork');
/*!40000 ALTER TABLE `categoria_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias_post`
--

DROP TABLE IF EXISTS `categorias_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomecat` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_post`
--

LOCK TABLES `categorias_post` WRITE;
/*!40000 ALTER TABLE `categorias_post` DISABLE KEYS */;
INSERT INTO `categorias_post` VALUES (1,'Notícias'),(2,'Eventos'),(3,'Promoções');
/*!40000 ALTER TABLE `categorias_post` ENABLE KEYS */;
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
  `data` datetime DEFAULT NULL,
  `id_post` int DEFAULT NULL,
  `id_utilizador` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`),
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (62,'O espaço VIP está mesmo incrível! Recomendo a todos!','2025-05-02 15:20:09',10,1),(63,'DJ SNTS nunca desaponta, mal posso esperar!','2025-05-02 15:20:09',11,2),(64,'Promoções assim deviam ser todos os dias!','2025-05-02 15:20:09',12,3);
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
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `id_utilizador` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,'Pedro Santos','pedro.santos@email.com','915678901',1),(2,'Ana Ferreira','ana.ferreira@email.com','916789012',2);
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dj`
--

DROP TABLE IF EXISTS `dj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dj` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dj`
--

LOCK TABLES `dj` WRITE;
/*!40000 ALTER TABLE `dj` DISABLE KEYS */;
INSERT INTO `dj` VALUES (1,' DJ SNTS','dj_snts.jpg','dj_snts_video.mp4'),(2,'DJ DJ I Hate Models','dj_Models.jpg','dj_Models_video.mp4');
/*!40000 ALTER TABLE `dj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `descricao` text,
  `hora_inicio` datetime DEFAULT NULL,
  `hora_fim` datetime DEFAULT NULL,
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `id_dj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_dj` (`id_dj`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_evento` (`id`),
  CONSTRAINT `eventos_ibfk_2` FOREIGN KEY (`id_dj`) REFERENCES `dj` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (7,'Noite de Techno','Uma noite intensa com batidas techno e DJ SNTS no comando!','2025-06-10 22:00:00','2025-06-11 03:00:00','2025-06-10 00:00:00','2025-06-11 00:00:00',1,2),(8,'Techno Night Vibes','Prepare-se para uma noite eletrizante com os melhores sons techno ao vivo com DJ SNTS!','2025-06-14 18:00:00','2025-06-14 22:00:00','2025-06-14 00:00:00','2025-06-14 00:00:00',3,1),(12,'Underground Techno Session','Explore o som profundo do techno underground com DJ SNTS numa noite inesquecível!','2025-06-21 20:00:00','2025-06-21 23:00:00','2025-06-21 00:00:00','2025-06-21 00:00:00',2,2);
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `eventos_com_dj_e_categoria`
--

DROP TABLE IF EXISTS `eventos_com_dj_e_categoria`;
/*!50001 DROP VIEW IF EXISTS `eventos_com_dj_e_categoria`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `eventos_com_dj_e_categoria` AS SELECT 
 1 AS `id`,
 1 AS `titulo`,
 1 AS `descricao`,
 1 AS `hora_inicio`,
 1 AS `hora_fim`,
 1 AS `data_inicio`,
 1 AS `data_fim`,
 1 AS `categoria_evento`,
 1 AS `nome_dj`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `galeria`
--

DROP TABLE IF EXISTS `galeria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galeria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_upload` datetime DEFAULT NULL,
  `id_utilizador` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `galeria_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeria`
--

LOCK TABLES `galeria` WRITE;
/*!40000 ALTER TABLE `galeria` DISABLE KEYS */;
INSERT INTO `galeria` VALUES (1,'Festa de Aniversário','evento_vip_1.jpg','2025-04-30 17:51:36',3),(2,'Festa com o DJ SNTS','evento_dj_SNTS.jpg','2025-04-30 17:51:36',2);
/*!40000 ALTER TABLE `galeria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `galeria_aprovada`
--

DROP TABLE IF EXISTS `galeria_aprovada`;
/*!50001 DROP VIEW IF EXISTS `galeria_aprovada`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `galeria_aprovada` AS SELECT 
 1 AS `id`,
 1 AS `titulo`,
 1 AS `imagem`,
 1 AS `data_upload`,
 1 AS `nome_utilizador`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mesa`
--

DROP TABLE IF EXISTS `mesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(15) NOT NULL,
  `capacidade` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero` (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesa`
--

LOCK TABLES `mesa` WRITE;
/*!40000 ALTER TABLE `mesa` DISABLE KEYS */;
INSERT INTO `mesa` VALUES (1,'A1',4),(2,'B2',6),(3,'C3',2);
/*!40000 ALTER TABLE `mesa` ENABLE KEYS */;
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
  `conteudo` text NOT NULL,
  `data` datetime DEFAULT NULL,
  `aprovadoreprovado` varchar(20) DEFAULT NULL,
  `id_utilizador` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_post` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (10,'Abertura do novo espaço VIP','Venham ver o nosso novo espaço VIP para clientes exclusivos!','2025-05-02 15:06:13','Aprovado',3,1),(11,'Próximo evento com DJ SNTS','Prepare-se para a melhor festa da cidade com o DJ SNTS na próxima sexta-feira!','2025-05-02 15:06:13','Aprovado',2,2),(12,'Promoção de bebidas','50% de desconto em todas as bebidas durante a as 22h e a meia noite!','2025-05-02 15:06:13','Aprovado',1,3);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `posts_aprovados`
--

DROP TABLE IF EXISTS `posts_aprovados`;
/*!50001 DROP VIEW IF EXISTS `posts_aprovados`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `posts_aprovados` AS SELECT 
 1 AS `id`,
 1 AS `titulo`,
 1 AS `conteudo`,
 1 AS `data`,
 1 AS `nome_utilizador`,
 1 AS `categoria`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `reservas_vip`
--

DROP TABLE IF EXISTS `reservas_vip`;
/*!50001 DROP VIEW IF EXISTS `reservas_vip`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `reservas_vip` AS SELECT 
 1 AS `id`,
 1 AS `instagram`,
 1 AS `data_nasc`,
 1 AS `mensagem`,
 1 AS `mesa_preferida`,
 1 AS `nome_utilizador`*/;
SET character_set_client = @saved_cs_client;

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
  `telefone` varchar(15) DEFAULT NULL,
  `tipo` enum('cliente','funcionário','administrador') NOT NULL,
  `estado` enum('online','offline') NOT NULL,
  `ultima_atividade` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizadores`
--

LOCK TABLES `utilizadores` WRITE;
/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` VALUES (1,'João Silva','joao.silva@email.com','912345678','cliente','online','2025-04-30 17:15:33'),(2,'Maria Oliveira','maria.oliveira@email.com','913456789','funcionário','offline','2025-04-30 17:15:33'),(3,'Carlos Costa','carlos.costa@email.com','914567890','administrador','online','2025-04-30 17:15:33');
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `utilizadores_online`
--

DROP TABLE IF EXISTS `utilizadores_online`;
/*!50001 DROP VIEW IF EXISTS `utilizadores_online`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `utilizadores_online` AS SELECT 
 1 AS `id`,
 1 AS `nome`,
 1 AS `email`,
 1 AS `telefone`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `vip`
--

DROP TABLE IF EXISTS `vip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `instagram` varchar(100) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `mensagem` text,
  `mesa_preferida` int DEFAULT NULL,
  `id_utilizador` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mesa_preferida` (`mesa_preferida`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `vip_ibfk_1` FOREIGN KEY (`mesa_preferida`) REFERENCES `mesa` (`id`),
  CONSTRAINT `vip_ibfk_2` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vip`
--

LOCK TABLES `vip` WRITE;
/*!40000 ALTER TABLE `vip` DISABLE KEYS */;
INSERT INTO `vip` VALUES (20,'@joao_vip','1990-05-21','Mesa com vista para o DJ.',1,1),(36,'@maria_vip','1985-12-10','Mesa no canto mais reservado.',2,2),(37,'@carlos_vip','1988-07-15','Mesa próxima do bar.',3,3);
/*!40000 ALTER TABLE `vip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `eventos_com_dj_e_categoria`
--

/*!50001 DROP VIEW IF EXISTS `eventos_com_dj_e_categoria`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `eventos_com_dj_e_categoria` AS select `eventos`.`id` AS `id`,`eventos`.`titulo` AS `titulo`,`eventos`.`descricao` AS `descricao`,`eventos`.`hora_inicio` AS `hora_inicio`,`eventos`.`hora_fim` AS `hora_fim`,`eventos`.`data_inicio` AS `data_inicio`,`eventos`.`data_fim` AS `data_fim`,`categoria_evento`.`nomecat` AS `categoria_evento`,`dj`.`nome` AS `nome_dj` from ((`eventos` join `categoria_evento` on((`eventos`.`id_categoria` = `categoria_evento`.`id`))) join `dj` on((`eventos`.`id_dj` = `dj`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `galeria_aprovada`
--

/*!50001 DROP VIEW IF EXISTS `galeria_aprovada`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `galeria_aprovada` AS select `galeria`.`id` AS `id`,`galeria`.`titulo` AS `titulo`,`galeria`.`imagem` AS `imagem`,`galeria`.`data_upload` AS `data_upload`,`utilizadores`.`nome` AS `nome_utilizador` from (`galeria` join `utilizadores` on((`galeria`.`id_utilizador` = `utilizadores`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `posts_aprovados`
--

/*!50001 DROP VIEW IF EXISTS `posts_aprovados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `posts_aprovados` AS select `posts`.`id` AS `id`,`posts`.`titulo` AS `titulo`,`posts`.`conteudo` AS `conteudo`,`posts`.`data` AS `data`,`utilizadores`.`nome` AS `nome_utilizador`,`categorias_post`.`nomecat` AS `categoria` from ((`posts` join `utilizadores` on((`posts`.`id_utilizador` = `utilizadores`.`id`))) join `categorias_post` on((`posts`.`id_categoria` = `categorias_post`.`id`))) where (`posts`.`aprovadoreprovado` = 'aprovado') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `reservas_vip`
--

/*!50001 DROP VIEW IF EXISTS `reservas_vip`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `reservas_vip` AS select `vip`.`id` AS `id`,`vip`.`instagram` AS `instagram`,`vip`.`data_nasc` AS `data_nasc`,`vip`.`mensagem` AS `mensagem`,`vip`.`mesa_preferida` AS `mesa_preferida`,`utilizadores`.`nome` AS `nome_utilizador` from ((`vip` join `mesa` on((`vip`.`mesa_preferida` = `mesa`.`id`))) join `utilizadores` on((`vip`.`id_utilizador` = `utilizadores`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `utilizadores_online`
--

/*!50001 DROP VIEW IF EXISTS `utilizadores_online`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `utilizadores_online` AS select `utilizadores`.`id` AS `id`,`utilizadores`.`nome` AS `nome`,`utilizadores`.`email` AS `email`,`utilizadores`.`telefone` AS `telefone` from `utilizadores` where (`utilizadores`.`estado` = 'online') */;
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

-- Dump completed on 2025-05-02 16:28:22
