CREATE DATABASE  IF NOT EXISTS `h3x` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `h3x`;
-- MySQL dump 10.13  Distrib 8.0.41, for macos15 (x86_64)
--
-- Host: localhost    Database: h3x
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `categorias_eventos`
--

DROP TABLE IF EXISTS `categorias_eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_eventos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_eventos`
--

LOCK TABLES `categorias_eventos` WRITE;
/*!40000 ALTER TABLE `categorias_eventos` DISABLE KEYS */;
INSERT INTO `categorias_eventos` VALUES (2,'House Music'),(1,'Techno');
/*!40000 ALTER TABLE `categorias_eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias_posts`
--

DROP TABLE IF EXISTS `categorias_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_posts`
--

LOCK TABLES `categorias_posts` WRITE;
/*!40000 ALTER TABLE `categorias_posts` DISABLE KEYS */;
INSERT INTO `categorias_posts` VALUES (8,'123'),(2,'Eventos Semanais'),(1,'Notícias'),(3,'Outros');
/*!40000 ALTER TABLE `categorias_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `conteudo` text NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_post` int unsigned NOT NULL,
  `id_utilizador` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`),
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (3,'Adorei a nova decoração! O H3X sempre arrasa nos detalhes!','2025-05-21 16:15:22',2,2),(5,'1231','2025-05-22 00:22:47',2,1);
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `comentarios_post`
--

DROP TABLE IF EXISTS `comentarios_post`;
/*!50001 DROP VIEW IF EXISTS `comentarios_post`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `comentarios_post` AS SELECT 
 1 AS `ID`,
 1 AS `Conteúdo`,
 1 AS `Data/Hora`,
 1 AS `ID Post`,
 1 AS `Título Post`,
 1 AS `Nome`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(9) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `id_utilizador` int unsigned DEFAULT NULL,
  `data_contactos` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,NULL,NULL,NULL,'Quero saber mais sobre os eventos.',1,'2025-05-21 17:07:02'),(2,'José Faria','josefaria@gmail.com','912345678','Gostaria de fazer uma reserva para a mesa VIP.',NULL,'2025-05-21 17:07:02');
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `contatos_detalhada`
--

DROP TABLE IF EXISTS `contatos_detalhada`;
/*!50001 DROP VIEW IF EXISTS `contatos_detalhada`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `contatos_detalhada` AS SELECT 
 1 AS `ID`,
 1 AS `Nome`,
 1 AS `Email`,
 1 AS `Telefone`,
 1 AS `Mensagem`,
 1 AS `Nome (Cliente)`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `djs`
--

DROP TABLE IF EXISTS `djs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `djs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `djs`
--

LOCK TABLES `djs` WRITE;
/*!40000 ALTER TABLE `djs` DISABLE KEYS */;
INSERT INTO `djs` VALUES (1,'DJ Tiesto','tiesto.jpg','tiesto_video.mp4'),(2,'Armin van Buuren','armin.jpg','armin_video.mp4');
/*!40000 ALTER TABLE `djs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `id_utilizador` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Festival de Música Eletrônica','2025-05-15','2025-05-16','22:00:00','06:00:00',3),(2,'Noite Escura','2025-06-01','2025-06-01','09:00:00','18:00:00',3);
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos_categorias`
--

DROP TABLE IF EXISTS `eventos_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos_categorias` (
  `id_evento` int unsigned NOT NULL,
  `id_categoria` int unsigned NOT NULL,
  PRIMARY KEY (`id_evento`,`id_categoria`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `eventos_categorias_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`),
  CONSTRAINT `eventos_categorias_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_eventos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos_categorias`
--

LOCK TABLES `eventos_categorias` WRITE;
/*!40000 ALTER TABLE `eventos_categorias` DISABLE KEYS */;
INSERT INTO `eventos_categorias` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `eventos_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos_djs`
--

DROP TABLE IF EXISTS `eventos_djs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos_djs` (
  `id_evento` int unsigned NOT NULL,
  `id_dj` int unsigned NOT NULL,
  PRIMARY KEY (`id_evento`,`id_dj`),
  KEY `id_dj` (`id_dj`),
  CONSTRAINT `eventos_djs_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`),
  CONSTRAINT `eventos_djs_ibfk_2` FOREIGN KEY (`id_dj`) REFERENCES `djs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos_djs`
--

LOCK TABLES `eventos_djs` WRITE;
/*!40000 ALTER TABLE `eventos_djs` DISABLE KEYS */;
INSERT INTO `eventos_djs` VALUES (1,1),(1,2);
/*!40000 ALTER TABLE `eventos_djs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `eventos_futuros`
--

DROP TABLE IF EXISTS `eventos_futuros`;
/*!50001 DROP VIEW IF EXISTS `eventos_futuros`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `eventos_futuros` AS SELECT 
 1 AS `ID`,
 1 AS `Título`,
 1 AS `Data início`,
 1 AS `Data fim`,
 1 AS `Hora início`,
 1 AS `Hora fim`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `imagens_galeria`
--

DROP TABLE IF EXISTS `imagens_galeria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagens_galeria` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  `aprovado` tinyint(1) DEFAULT '0',
  `data_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_utilizador` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `imagens_galeria_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagens_galeria`
--

LOCK TABLES `imagens_galeria` WRITE;
/*!40000 ALTER TABLE `imagens_galeria` DISABLE KEYS */;
INSERT INTO `imagens_galeria` VALUES (1,'Foto do evento 1','evento1_imagem.jpg',1,'2025-05-21 16:15:22',1),(2,'Foto do evento 2','evento2_imagem.jpg',0,'2025-05-21 16:15:22',2),(3,'Foto do DJ no palco','dj_palco.jpg',1,'2025-05-21 16:15:22',3);
/*!40000 ALTER TABLE `imagens_galeria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `imagens_por_aprovar`
--

DROP TABLE IF EXISTS `imagens_por_aprovar`;
/*!50001 DROP VIEW IF EXISTS `imagens_por_aprovar`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `imagens_por_aprovar` AS SELECT 
 1 AS `ID`,
 1 AS `Título`,
 1 AS `Imagem`,
 1 AS `Data/Hora`,
 1 AS `Aprovação`,
 1 AS `Nome`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mesas`
--

DROP TABLE IF EXISTS `mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mesas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(15) NOT NULL,
  `capacidade` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas`
--

LOCK TABLES `mesas` WRITE;
/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
INSERT INTO `mesas` VALUES (1,'Mesa 1',4),(2,'Mesa 2',6);
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `conteudo` text NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `aprovado` tinyint(1) DEFAULT '0',
  `id_utilizador` int unsigned NOT NULL,
  `id_categoria` int unsigned NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Noite de Reggaeton com DJ Carla','Esta sexta, prepare-se para dançar com os melhores hits de reggaeton escolhidos por DJ Carla.','2025-05-01 22:00:00',1,4,2,''),(2,'Novo Sistema de Iluminação no H3X','Instalámos um novo sistema de luzes inteligentes para tornar cada noite inesquecível.','2025-05-02 18:30:00',1,2,8,'img2.webp'),(3,'Sunset Party no Terraço','Aproveita o fim de tarde com música ao vivo e cocktails no nosso terraço exclusivo.','2025-05-03 20:00:00',1,11,2,'img3.webp'),(4,'Concurso de Talentos H3X','Tens talento? Inscreve-te no nosso concurso e mostra o que vales ao vivo no palco!','2025-05-04 19:00:00',1,6,3,'img4.jpeg'),(5,'Luzes Neón: A Nova Tendência','Este mês apostamos em decorações com luzes neón para uma experiência visual única.','2025-05-05 21:00:00',1,9,1,'img5.jpeg'),(6,'DJ Léo em Set Exclusivo','Sábado é dia de festa com o DJ Léo, diretamente de Lisboa para uma atuação imperdível.','2025-05-06 23:00:00',1,8,2,'img6.jpg'),(7,'Noite de Karaoke no H3X','Vem soltar a tua voz na nossa noite de karaoke com prémios para os melhores!','2025-05-07 21:30:00',1,1,3,'img7.jpg'),(8,'Especial Anos 90','Volta aos anos 90 com uma seleção de músicas icónicas e decoração temática retro.','2025-05-08 22:00:00',1,13,1,'img8.jpg'),(9,'Ladies Night com Cocktails Grátis','As senhoras têm entrada gratuita e cocktails especiais até à meia-noite!','2025-05-09 22:00:00',1,3,2,'img9.jpg'),(11,'Noite Universitária no H3X','Descontos especiais para estudantes e música jovem para animar a tua semana.','2025-05-11 22:00:00',1,5,2,'img11.jpg'),(12,'Aniversário do H3X','Estamos a celebrar mais um ano de festa contigo! Vem brindar connosco!','2025-05-12 22:00:00',1,12,1,'img2.jpg'),(13,'Backstage Tour Exclusiva','Ganha acesso aos bastidores do H3X e descobre como tudo funciona por dentro.','2025-05-13 17:00:00',0,7,3,'img3.jpg'),(14,'After Hours até ao Amanhecer','A festa não para! Fica connosco até o sol nascer com DJ surpresa.','2025-05-14 02:00:00',1,10,2,'img4.jpeg'),(15,'Novos Cocktails no Bar','Experimenta os nossos novos cocktails exclusivos, criados pelos melhores bartenders.','2025-05-15 19:30:00',1,15,1,'img5.jpeg'),(16,'DJ Internacional: K-MAX no H3Xdsfsdf','O famoso DJ K-MAX chega ao H3X com um set eletrizante e cheio de energia.fsdfsdfjbljbjlbjbkbkjbjbkjb','2025-05-16 23:59:00',0,1,1,'682e4fb4849cf_caixa4.png');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `posts_por_aprovar`
--

DROP TABLE IF EXISTS `posts_por_aprovar`;
/*!50001 DROP VIEW IF EXISTS `posts_por_aprovar`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `posts_por_aprovar` AS SELECT 
 1 AS `ID`,
 1 AS `Título`,
 1 AS `Conteúdo`,
 1 AS `Data/Hora`,
 1 AS `Aprovação`,
 1 AS `Nome`,
 1 AS `Categoria`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `reservas_vip`
--

DROP TABLE IF EXISTS `reservas_vip`;
/*!50001 DROP VIEW IF EXISTS `reservas_vip`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `reservas_vip` AS SELECT 
 1 AS `ID`,
 1 AS `Mesa`,
 1 AS `Capacidade`,
 1 AS `Mensagem`,
 1 AS `Data`,
 1 AS `Nome`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizadores` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(9) NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `tipo` enum('c','f','a') NOT NULL DEFAULT 'c',
  `estado` enum('a','d') NOT NULL DEFAULT 'd',
  `ultima_atividade` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizadores`
--

LOCK TABLES `utilizadores` WRITE;
/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` VALUES (1,'Ana Ferreira2','ana.ferreira@gmail.com','919525148','6a0d81964747b912ae73dbb78e53fe3307c89cb327954d64ef5162d45be82d3ab07033e9408a7efc9d19a7718503bde61d8ea9a8075e9de5da6c152d18fe5d9b','2002-08-06','f','d','2025-05-21 13:38:09',''),(2,'Tiago Ramos','tiago.ramos@gmail.com','914679134','bbd64889a20c97863b24b3080640eb09e6628cd350b44c86eb224c38901589f6ab3b06170a58ef94c4ef5de64b7e38b5a8a12991bb09f64b4913e8cb0f0c5e69','2000-09-04','a','d','2025-05-20 14:45:28',''),(3,'Beatriz Lopes','beatriz.lopes@gmail.com','919756655','4c6aab2c3f30172aa32f5e65d769d3bb5e631e1bfb2388dddb6b98c89994433d64e108ab119d9c9b913f709c42219bfb402e48772f27fd0c199e7f123c585ad9','1996-07-04','c','d','2025-05-07 12:48:00',''),(4,'Miguel Antunes','miguel.antunes@gmail.com','913156512','4b8f5b1c90f1ab214f7e6d6c3a0114d2d01cf8b17d136b2be8d5d193e2e569b2fcd72ed74d754c7df1d456a40f272fd7dc747e403c8cfbde61719e4a79c1270a','1993-01-29','f','d','2025-05-04 19:12:00',''),(5,'Lúcia Mendes','lucia.mendes@gmail.com','911165306','0732cc44146b3eb30ebf62323a3d1fc8a23d1d7e7a4f7bdf12d7297f2a13cfe6c99dbf62d84e20ab0d2b471a2807fc477511ec0f8a2e1aaf38517441c42d805d','1995-10-27','a','d','2025-05-20 14:45:28',''),(6,'Pedro Costa','pedro.costa@gmail.com','919037261','29e764e5c5179ef0f4e81f7e76194df8dd60fbd032a4a222b01b0d92a464c8659e0bfb878c5bcbb969f29160d09c268c39e37eb4021e25929d8f164cb60b1f33','1999-06-23','c','d','2025-05-08 06:38:00',''),(7,'Carla Nunes','carla.nunes@gmail.com','919855447','d9c7c7d2713a7b041fcd1fa3db1f024e4fc574a1bdcb63c0a6827fcaa00ccbd8eafbc21455d2d3cebb78e64500dd3bc53fe3f9b4a3b16de4b6a703fcaab11c5f','1987-04-03','f','d','2025-05-05 15:00:00',''),(8,'Rui Moreira','rui.moreira@gmail.com','912438219','00627ad3b162b4cf26f3b58aeea43dfc06a279c75c1f309a5c1dc6f3b3f0fefdc37d3c6651a0b6a771e74cd6e0d089c3a26e7e9d374e0222b7e9c4508edcf5cd','1991-02-13','c','d','2025-05-01 21:18:00',''),(9,'Diana Silva','diana.silva@gmail.com','914839661','0bc5a7f53918ad9f44eb97ed87cc5a327fbfb07ce961003ecfdf80d67671f5887f10e7f8fd5ac43d9d6e96e41e31fc0c55626dcbba6bb55389d22792a9cc84c4','2001-03-16','a','d','2025-05-20 14:45:28',''),(10,'André Rocha','andre.rocha@gmail.com','919487262','78d47cb9f90e85f39d84ff1a9ac2b28b7e82ad5c194c8961c0b788fd893e5e2f009acbd66f1cb1c8d2b5b24b1cf4f573cd3d32cb2468e27101bcf287b2a3491e','1998-08-11','c','d','2025-05-09 11:42:00',''),(11,'Cátia Marques','catia.marques@gmail.com','913956721','2fd3c6a3f7473a43ea02df2629f6cfb64846ff73c166e999ec508fdfd3b8a4415d13e8c3cc1919bdf09f7b57b9aef786781bfe57c61b49e9f0c23c210960e765','1985-01-12','c','d','2025-05-04 09:15:00',''),(12,'Fábio Almeida','fabio.almeida@gmail.com','911472559','19881ec942e80cf15c00e232c76a4d299b2f30e5611e7aa9d4f134ae365eff369a87ff65c01bc4502dc509d5357bdb8a748b54652bda0b5141f33d478008c520','1992-05-24','f','d','2025-05-05 20:22:00',''),(13,'Sofia Teixeira','sofia.teixeira@gmail.com','912487350','0271878e47ab45f5b948c1f7b6e5eeec7c6d99d3c79e83c0b07e349ceadf994fa02fa844f73a447206a1ebbe769ed61e6934c31e04bd1c541c768b65ccf1b68c','1989-10-14','a','d','2025-05-20 14:45:28',''),(14,'Bruno Neves','bruno.neves@gmail.com','913244551','37b2a7a4f75d9e13e1bfb8e84cf03c6a86f3c26a7a29c7162b7e144a81c4a3cc63f34f8d8d0aa5fa4372a2a7ef6b7760a1b34aebbd54015f79a7f726cdd2354e','1986-11-02','c','d','2025-05-02 15:31:00',''),(15,'Helena Cruz','helena.cruz@gmail.com','914127888','3cc48601a2512ef58cb8591e4f3b44b17795ce791cb9c98e80f4cecd8d755d3c512d4589b6177f25c2b671fa96bcf4f5f6cc8d199abb69a1eebd407bf0ef5b9f','2000-04-18','c','d','2025-05-10 08:17:00',''),(16,'Admin','admin@gmail.com','914127888','3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2','2000-04-18','a','a','2025-05-27 12:49:59','68221b3b95864_ds.png'),(28,'Filipe Vieira','filipe@gmail.com','912345678','ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413','1999-05-21','f','d','2025-05-27 12:27:19','');
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `utilizadores_ativos`
--

DROP TABLE IF EXISTS `utilizadores_ativos`;
/*!50001 DROP VIEW IF EXISTS `utilizadores_ativos`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `utilizadores_ativos` AS SELECT 
 1 AS `ID`,
 1 AS `Nome`,
 1 AS `Tipo`,
 1 AS `Ultima`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `vip`
--

DROP TABLE IF EXISTS `vip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vip` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_mesa` int unsigned NOT NULL,
  `mensagem` text,
  `data_reserva` date NOT NULL,
  `id_utilizador` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mesa` (`id_mesa`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `vip_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id`),
  CONSTRAINT `vip_ibfk_2` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vip`
--

LOCK TABLES `vip` WRITE;
/*!40000 ALTER TABLE `vip` DISABLE KEYS */;
INSERT INTO `vip` VALUES (1,1,'Reserva para o aniversário de João','2025-05-10',1),(2,2,'Reserva para evento VIP','2025-06-12',2);
/*!40000 ALTER TABLE `vip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vip_mesas`
--

DROP TABLE IF EXISTS `vip_mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vip_mesas` (
  `id_vip` int unsigned NOT NULL,
  `id_mesas` int unsigned NOT NULL,
  PRIMARY KEY (`id_vip`,`id_mesas`),
  KEY `id_mesas` (`id_mesas`),
  CONSTRAINT `vip_mesas_ibfk_1` FOREIGN KEY (`id_vip`) REFERENCES `vip` (`id`),
  CONSTRAINT `vip_mesas_ibfk_2` FOREIGN KEY (`id_mesas`) REFERENCES `mesas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vip_mesas`
--

LOCK TABLES `vip_mesas` WRITE;
/*!40000 ALTER TABLE `vip_mesas` DISABLE KEYS */;
INSERT INTO `vip_mesas` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `vip_mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `comentarios_post`
--

/*!50001 DROP VIEW IF EXISTS `comentarios_post`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `comentarios_post` AS select `comentarios`.`id` AS `ID`,`comentarios`.`conteudo` AS `Conteúdo`,`comentarios`.`data_criacao` AS `Data/Hora`,`posts`.`id` AS `ID Post`,`posts`.`titulo` AS `Título Post`,`utilizadores`.`nome` AS `Nome` from ((`comentarios` join `posts` on((`comentarios`.`id_post` = `posts`.`id`))) join `utilizadores` on((`comentarios`.`id_utilizador` = `utilizadores`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `contatos_detalhada`
--

/*!50001 DROP VIEW IF EXISTS `contatos_detalhada`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `contatos_detalhada` AS select `contactos`.`id` AS `ID`,`contactos`.`nome` AS `Nome`,`contactos`.`email` AS `Email`,`contactos`.`telefone` AS `Telefone`,`contactos`.`mensagem` AS `Mensagem`,`utilizadores`.`nome` AS `Nome (Cliente)` from (`contactos` left join `utilizadores` on((`contactos`.`id_utilizador` = `utilizadores`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `eventos_futuros`
--

/*!50001 DROP VIEW IF EXISTS `eventos_futuros`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `eventos_futuros` AS select `eventos`.`id` AS `ID`,`eventos`.`titulo` AS `Título`,`eventos`.`data_inicio` AS `Data início`,`eventos`.`data_fim` AS `Data fim`,`eventos`.`hora_inicio` AS `Hora início`,`eventos`.`hora_fim` AS `Hora fim` from `eventos` where (`eventos`.`data_inicio` >= curdate()) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `imagens_por_aprovar`
--

/*!50001 DROP VIEW IF EXISTS `imagens_por_aprovar`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `imagens_por_aprovar` AS select `imagens_galeria`.`id` AS `ID`,`imagens_galeria`.`titulo` AS `Título`,`imagens_galeria`.`imagem` AS `Imagem`,`imagens_galeria`.`data_upload` AS `Data/Hora`,`imagens_galeria`.`aprovado` AS `Aprovação`,`utilizadores`.`nome` AS `Nome` from (`imagens_galeria` join `utilizadores` on((`imagens_galeria`.`id_utilizador` = `utilizadores`.`id`))) where (`imagens_galeria`.`aprovado` = false) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `posts_por_aprovar`
--

/*!50001 DROP VIEW IF EXISTS `posts_por_aprovar`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `posts_por_aprovar` AS select `posts`.`id` AS `ID`,`posts`.`titulo` AS `Título`,`posts`.`conteudo` AS `Conteúdo`,`posts`.`data_criacao` AS `Data/Hora`,`posts`.`aprovado` AS `Aprovação`,`utilizadores`.`nome` AS `Nome`,`categorias_posts`.`nome` AS `Categoria` from ((`posts` join `utilizadores` on((`posts`.`id_utilizador` = `utilizadores`.`id`))) join `categorias_posts` on((`posts`.`id_categoria` = `categorias_posts`.`id`))) where (`posts`.`aprovado` = false) */;
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
/*!50001 VIEW `reservas_vip` AS select `vip`.`id` AS `ID`,`mesas`.`nome` AS `Mesa`,`mesas`.`capacidade` AS `Capacidade`,`vip`.`mensagem` AS `Mensagem`,`vip`.`data_reserva` AS `Data`,`utilizadores`.`nome` AS `Nome` from ((`vip` join `mesas` on((`vip`.`id_mesa` = `mesas`.`id`))) join `utilizadores` on((`vip`.`id_utilizador` = `utilizadores`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `utilizadores_ativos`
--

/*!50001 DROP VIEW IF EXISTS `utilizadores_ativos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `utilizadores_ativos` AS select `utilizadores`.`id` AS `ID`,`utilizadores`.`nome` AS `Nome`,`utilizadores`.`tipo` AS `Tipo`,`utilizadores`.`ultima_atividade` AS `Ultima` from `utilizadores` where (`utilizadores`.`estado` = 'a') */;
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

-- Dump completed on 2025-05-27 13:51:41
h3x