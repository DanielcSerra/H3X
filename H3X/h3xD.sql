-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           9.1.0 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para h3x
CREATE DATABASE IF NOT EXISTS `h3x` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `h3x`;

-- A despejar estrutura para tabela h3x.categorias_eventos
CREATE TABLE IF NOT EXISTS `categorias_eventos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.categorias_eventos: ~2 rows (aproximadamente)
INSERT INTO `categorias_eventos` (`id`, `nome`) VALUES
	(2, 'House Music'),
	(1, 'Techno');

-- A despejar estrutura para tabela h3x.categorias_posts
CREATE TABLE IF NOT EXISTS `categorias_posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.categorias_posts: ~4 rows (aproximadamente)
INSERT INTO `categorias_posts` (`id`, `nome`) VALUES
	(8, '123'),
	(2, 'Eventos Semanais'),
	(1, 'Notícias'),
	(3, 'Outros');

-- A despejar estrutura para tabela h3x.comentarios
CREATE TABLE IF NOT EXISTS `comentarios` (
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

-- A despejar dados para tabela h3x.comentarios: ~2 rows (aproximadamente)
INSERT INTO `comentarios` (`id`, `conteudo`, `data_criacao`, `id_post`, `id_utilizador`) VALUES
	(3, 'Adorei a nova decoração! O H3X sempre arrasa nos detalhes!', '2025-05-21 16:15:22', 2, 2),
	(5, '1231', '2025-05-22 00:22:47', 2, 1);

-- A despejar estrutura para vista h3x.comentarios_post
-- A criar tabela temporária para vencer erros de dependências VIEW
CREATE TABLE `comentarios_post` (
	`ID` INT UNSIGNED NOT NULL,
	`Conteúdo` TEXT NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Data/Hora` DATETIME NULL,
	`ID Post` INT UNSIGNED NOT NULL,
	`Título Post` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Nome` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- A despejar estrutura para tabela h3x.contactos
CREATE TABLE IF NOT EXISTS `contactos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(9) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `id_utilizador` int unsigned DEFAULT NULL,
  `data_contactos` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assunto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.contactos: ~3 rows (aproximadamente)
INSERT INTO `contactos` (`id`, `nome`, `email`, `telefone`, `mensagem`, `id_utilizador`, `data_contactos`, `assunto`) VALUES
	(3, '2we123', 'safdas@gmail.com', '123456789', '1243252352', NULL, '2025-06-04 11:26:44', '23242352345'),
	(5, 'asdadasda', 'afsdfds@gmail.com', '123545', 'aaaaaaaaaaaaaaaaaaaaaa', NULL, '2025-06-04 11:51:14', 'asdasdasdas'),
	(6, 'sdfsdf', 'xsfs@gmail.com', '111111111', 'aaaaaaaaaaaaaa', NULL, '2025-06-04 21:29:56', 'afsdfasdaaaaaaaaaaaaaaaaaaaa');

-- A despejar estrutura para vista h3x.contatos_detalhada
-- A criar tabela temporária para vencer erros de dependências VIEW
CREATE TABLE `contatos_detalhada` (
	`ID` INT UNSIGNED NOT NULL,
	`Nome` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Email` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Telefone` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Mensagem` TEXT NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Nome (Cliente)` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- A despejar estrutura para tabela h3x.djs
CREATE TABLE IF NOT EXISTS `djs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.djs: ~2 rows (aproximadamente)
INSERT INTO `djs` (`id`, `nome`, `imagem`, `video`) VALUES
	(1, 'DJ Tiesto', 'tiesto.jpg', 'tiesto_video.mp4'),
	(2, 'Armin van Buuren', 'armin.jpg', 'armin_video.mp4');

-- A despejar estrutura para tabela h3x.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  `imagem_banner` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `video_banner` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagem_card` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lineup` text COLLATE utf8mb4_general_ci,
  `aprovado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela h3x.eventos: ~6 rows (aproximadamente)
INSERT INTO `eventos` (`id`, `titulo`, `data_inicio`, `data_fim`, `imagem_banner`, `video_banner`, `imagem_card`, `lineup`, `aprovado`) VALUES
	(8, 'NECROTECH NIGHT', '2025-07-07 20:00:00', '2025-07-10 06:00:00', '6840e7f85567_artworks-000195124570-4jd3zy-t500x500-removebg-preview.png', '6840e7f85576d_1234.mp4', '6840e7f85576_Captura de ecrã 2025-04-06 145347.png', 'DJ SNTS;DJ Ø [Phase];DJ I Hate Models;DJ ¥OU$UKE ¥UK1MAT$U', 1),
	(9, 'NEUROCHROME', '2025-07-28 22:00:00', '2025-07-30 06:00:00', '6840edfb0c93_ds#696-min-removebg-preview.png', '6840edfb0c99_background3.mp4', '6840edfb0c98_111 (1).jpg', 'Mort-X; HexError; Zerkernel; COD3NAME', 1),
	(10, 'NoSleep Operation', '2025-08-06 21:00:00', '2025-08-12 07:00:00', '6840e2f4b7934_Credit-Soraya-Sanini-1e16107307385976-removebg-preview.png', '6840e2f4b793b_video landpage.mp4', '6840e2f4b793a_fundoofertez2.jpg', 'VX-13; CRPTA; Syntax Terror; Terminal_7; Holy Priest', 1),
	(11, 'Aftercore', '2025-08-24 17:00:00', '2025-08-26 03:00:00', '6840e2ef23fd1_0phase-removebg-preview.png', '6840e2ef23fd5_background3.mp4', '6840e2ef23fd4_Captura de ecrã 2025-04-29 105836.png', 'Liqr; N-Kode; Fermion;', 1),
	(12, 'Techno Bear', '2025-09-15 08:00:00', '2025-09-16 07:59:00', '6840effa0fb2_dgdtzp-81afd847-0e4a-44b4-8d03-72c5e26a841d.png', '6840effa0fb9_background3.mp4', '6840effa0fb8_maxresdefault.jpg', 'DJ Gummy Bear; DJ Leopoldina', 1),
	(13, 'asdasd', '2025-06-12 00:00:00', '2025-06-15 06:00:00', '68418ccf89c72_artworks-000195124570-4jd3zy-t500x500-removebg-preview 1.png', '68418ccf89c9f_Rectangle 1.png', '68418ccf89c94_abstract-colorful-party-silhouettes_1048-295.png', 'SDJSDSD ; JASDJASD ; AJSDJSAD', 1);

-- A despejar estrutura para vista h3x.eventos_futuros
-- A criar tabela temporária para vencer erros de dependências VIEW
CREATE TABLE `eventos_futuros` 
) ENGINE=MyISAM;

-- A despejar estrutura para tabela h3x.faq
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `resposta` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.faq: 3 rows
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` (`id`, `titulo`, `resposta`) VALUES
	(1, 'dddddd', 'Para redefinir sua senha, clique em "Esqueci minha senha" na página de login e siga as instruções.'),
	(0, 'SADASD', 'ADASDASDAS'),
	(4, 'Posso cancelar uma compra?', 'Sim, desde que o pedido ainda não tenha sido enviado. Acesse "Meus Pedidos" e clique em "Cancelar pedido"');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;

-- A despejar estrutura para tabela h3x.imagens_galeria
CREATE TABLE IF NOT EXISTS `imagens_galeria` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  `aprovado` tinyint(1) DEFAULT '0',
  `data_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_utilizador` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilizador` (`id_utilizador`),
  CONSTRAINT `imagens_galeria_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.imagens_galeria: ~6 rows (aproximadamente)
INSERT INTO `imagens_galeria` (`id`, `titulo`, `imagem`, `aprovado`, `data_upload`, `id_utilizador`) VALUES
	(16, 'wqw2eqwe', '68401d9212490_borboleta2 3.png', 1, '2025-06-04 10:18:00', 16),
	(17, 'Titulo', '68401e41f240d_artworks-000195124570-4jd3zy-t500x500-removebg-preview 1.png', 1, '2025-06-04 10:21:00', 16),
	(18, 'bom dia', '68401e4d12195_c4e91c8cac4159f5f73369a2e8a987d5-removebg-preview.png', 1, '2025-06-04 10:21:00', 16),
	(19, 'aaaaaaa', '68401e551813e_DER_logico_h3x.png', 1, '2025-06-04 10:22:00', 16),
	(20, 'asdasdasdasda', '68401e64136b2_abstract-colorful-party-silhouettes_1048-295.png', 0, '2025-06-04 10:22:00', 16),
	(21, '3124r3w423', '68418bed51626_ticket-blue-icon-logo-image-png-701751694966291y531wwmah2-removebg-preview.png', 1, '2025-06-04 10:32:00', 16);

-- A despejar estrutura para vista h3x.imagens_por_aprovar
-- A criar tabela temporária para vencer erros de dependências VIEW
CREATE TABLE `imagens_por_aprovar` (
	`ID` INT UNSIGNED NOT NULL,
	`Título` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Imagem` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Data/Hora` DATETIME NULL,
	`Aprovação` TINYINT(1) NULL,
	`Nome` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- A despejar estrutura para tabela h3x.mesas
CREATE TABLE IF NOT EXISTS `mesas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(15) NOT NULL,
  `capacidade` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.mesas: ~2 rows (aproximadamente)
INSERT INTO `mesas` (`id`, `nome`, `capacidade`) VALUES
	(1, 'Mesa 1', 4),
	(2, 'Mesa 2', 6);

-- A despejar estrutura para tabela h3x.posts
CREATE TABLE IF NOT EXISTS `posts` (
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.posts: ~15 rows (aproximadamente)
INSERT INTO `posts` (`id`, `titulo`, `conteudo`, `data_criacao`, `aprovado`, `id_utilizador`, `id_categoria`, `imagem`) VALUES
	(1, 'Noite de Reggaeton com DJ Carla', 'Esta sexta, prepare-se para dançar com os melhores hits de reggaeton escolhidos por DJ Carla.', '2025-05-01 22:00:00', 1, 4, 2, ''),
	(2, 'Novo Sistema de Iluminação no H3X', 'Instalámos um novo sistema de luzes inteligentes para tornar cada noite inesquecível.', '2025-05-02 18:30:00', 1, 2, 8, 'img2.webp'),
	(3, 'Sunset Party no Terraço', 'Aproveita o fim de tarde com música ao vivo e cocktails no nosso terraço exclusivo.', '2025-05-03 20:00:00', 1, 11, 2, 'img3.webp'),
	(4, 'Concurso de Talentos H3X', 'Tens talento? Inscreve-te no nosso concurso e mostra o que vales ao vivo no palco!', '2025-05-04 19:00:00', 1, 6, 3, 'img4.jpeg'),
	(5, 'Luzes Neón: A Nova Tendência', 'Este mês apostamos em decorações com luzes neón para uma experiência visual única.', '2025-05-05 21:00:00', 1, 9, 1, 'img5.jpeg'),
	(6, 'DJ Léo em Set Exclusivo', 'Sábado é dia de festa com o DJ Léo, diretamente de Lisboa para uma atuação imperdível.', '2025-05-06 23:00:00', 1, 8, 2, 'img6.jpg'),
	(7, 'Noite de Karaoke no H3X', 'Vem soltar a tua voz na nossa noite de karaoke com prémios para os melhores!', '2025-05-07 21:30:00', 1, 1, 3, 'img7.jpg'),
	(8, 'Especial Anos 90', 'Volta aos anos 90 com uma seleção de músicas icónicas e decoração temática retro.', '2025-05-08 22:00:00', 1, 13, 1, 'img8.jpg'),
	(9, 'Ladies Night com Cocktails Grátis', 'As senhoras têm entrada gratuita e cocktails especiais até à meia-noite!', '2025-05-09 22:00:00', 1, 3, 2, 'img9.jpg'),
	(12, 'Aniversário do H3X', 'Estamos a celebrar mais um ano de festa contigo! Vem brindar connosco!', '2025-05-12 22:00:00', 1, 12, 1, 'img2.jpg'),
	(13, 'Backstage Tour Exclusiva', 'Ganha acesso aos bastidores do H3X e descobre como tudo funciona por dentro.', '2025-05-13 17:00:00', 0, 7, 3, 'img3.jpg'),
	(14, 'After Hours até ao Amanhecer', 'A festa não para! Fica connosco até o sol nascer com DJ surpresa.', '2025-05-14 02:00:00', 1, 10, 2, 'img4.jpeg'),
	(15, 'Novos Cocktails no Bar', 'Experimenta os nossos novos cocktails exclusivos, criados pelos melhores bartenders.', '2025-05-15 19:30:00', 1, 15, 1, 'img5.jpeg'),
	(19, 'Daniel', 'aaaaaaaaaaaaaaaaaaaaaaa', '2025-06-04 11:47:46', 1, 11, 1, '68402452afe17_2025-06-04_10-47-46.png'),
	(20, 'kjfnsdifdsfsdfsdf', 'sdfsdfsdfsdfsd', '2025-06-05 13:21:04', 1, 6, 2, '68418bb0329fb_2025-06-05_12-21-04.png');

-- A despejar estrutura para vista h3x.posts_por_aprovar
-- A criar tabela temporária para vencer erros de dependências VIEW
CREATE TABLE `posts_por_aprovar` (
	`ID` INT UNSIGNED NOT NULL,
	`Título` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Conteúdo` TEXT NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Data/Hora` DATETIME NULL,
	`Aprovação` TINYINT(1) NULL,
	`Nome` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Categoria` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- A despejar estrutura para vista h3x.reservas_vip
-- A criar tabela temporária para vencer erros de dependências VIEW
CREATE TABLE `reservas_vip` (
	`ID` INT UNSIGNED NOT NULL,
	`Mesa` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Capacidade` INT UNSIGNED NULL,
	`Mensagem` TEXT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Data` DATE NOT NULL,
	`Nome` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- A despejar estrutura para tabela h3x.servicos_vip
CREATE TABLE IF NOT EXISTS `servicos_vip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.servicos_vip: ~3 rows (aproximadamente)
INSERT INTO `servicos_vip` (`id`, `titulo`, `imagem`, `criado_em`) VALUES
	(1, 'eeeee', 'Garrafa.png', '2025-05-14 21:57:30'),
	(2, 'Maior conforto', 'Conforto.png', '2025-05-14 21:57:30'),
	(4, '12121', '68418c6c297b7_2025-06-05_12-24-12_artworks-000195124570-4jd3zy-t500x500-removebg-preview 1.png', '2025-06-05 12:24:12');

-- A despejar estrutura para tabela h3x.utilizadores
CREATE TABLE IF NOT EXISTS `utilizadores` (
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.utilizadores: ~18 rows (aproximadamente)
INSERT INTO `utilizadores` (`id`, `nome`, `email`, `telefone`, `pass`, `data_nascimento`, `tipo`, `estado`, `ultima_atividade`, `foto`) VALUES
	(1, 'Ana Ferreira2', 'ana.ferreira@gmail.com', '919525148', '6a0d81964747b912ae73dbb78e53fe3307c89cb327954d64ef5162d45be82d3ab07033e9408a7efc9d19a7718503bde61d8ea9a8075e9de5da6c152d18fe5d9b', '2002-08-06', 'f', 'd', '2025-05-21 13:38:09', ''),
	(2, 'Tiago Ramos', 'tiago.ramos@gmail.com', '914679134', 'bbd64889a20c97863b24b3080640eb09e6628cd350b44c86eb224c38901589f6ab3b06170a58ef94c4ef5de64b7e38b5a8a12991bb09f64b4913e8cb0f0c5e69', '2000-09-04', 'a', 'd', '2025-05-20 14:45:28', ''),
	(3, 'Beatriz Lopes', 'beatriz.lopes@gmail.com', '919756655', '4c6aab2c3f30172aa32f5e65d769d3bb5e631e1bfb2388dddb6b98c89994433d64e108ab119d9c9b913f709c42219bfb402e48772f27fd0c199e7f123c585ad9', '1996-07-04', 'c', 'd', '2025-05-07 12:48:00', ''),
	(4, 'Miguel Antunes', 'miguel.antunes@gmail.com', '913156512', '4b8f5b1c90f1ab214f7e6d6c3a0114d2d01cf8b17d136b2be8d5d193e2e569b2fcd72ed74d754c7df1d456a40f272fd7dc747e403c8cfbde61719e4a79c1270a', '1993-01-29', 'f', 'd', '2025-05-04 19:12:00', ''),
	(5, 'Lúcia Mendes', 'lucia.mendes@gmail.com', '911165306', '0732cc44146b3eb30ebf62323a3d1fc8a23d1d7e7a4f7bdf12d7297f2a13cfe6c99dbf62d84e20ab0d2b471a2807fc477511ec0f8a2e1aaf38517441c42d805d', '1995-10-27', 'a', 'd', '2025-05-20 14:45:28', ''),
	(6, 'Pedro Costa', 'pedro.costa@gmail.com', '919037261', '29e764e5c5179ef0f4e81f7e76194df8dd60fbd032a4a222b01b0d92a464c8659e0bfb878c5bcbb969f29160d09c268c39e37eb4021e25929d8f164cb60b1f33', '1999-06-23', 'c', 'd', '2025-05-08 06:38:00', ''),
	(7, 'Carla Nunes', 'carla.nunes@gmail.com', '919855447', 'd9c7c7d2713a7b041fcd1fa3db1f024e4fc574a1bdcb63c0a6827fcaa00ccbd8eafbc21455d2d3cebb78e64500dd3bc53fe3f9b4a3b16de4b6a703fcaab11c5f', '1987-04-03', 'f', 'd', '2025-05-05 15:00:00', ''),
	(8, 'Rui Moreira', 'rui.moreira@gmail.com', '912438219', '00627ad3b162b4cf26f3b58aeea43dfc06a279c75c1f309a5c1dc6f3b3f0fefdc37d3c6651a0b6a771e74cd6e0d089c3a26e7e9d374e0222b7e9c4508edcf5cd', '1991-02-13', 'c', 'd', '2025-05-01 21:18:00', ''),
	(9, 'Diana Silva', 'diana.silva@gmail.com', '914839661', '0bc5a7f53918ad9f44eb97ed87cc5a327fbfb07ce961003ecfdf80d67671f5887f10e7f8fd5ac43d9d6e96e41e31fc0c55626dcbba6bb55389d22792a9cc84c4', '2001-03-16', 'a', 'd', '2025-05-20 14:45:28', ''),
	(10, 'André Rocha', 'andre.rocha@gmail.com', '919487262', '78d47cb9f90e85f39d84ff1a9ac2b28b7e82ad5c194c8961c0b788fd893e5e2f009acbd66f1cb1c8d2b5b24b1cf4f573cd3d32cb2468e27101bcf287b2a3491e', '1998-08-11', 'c', 'd', '2025-05-09 11:42:00', ''),
	(11, 'Cátia Marques', 'catia.marques@gmail.com', '913956721', '2fd3c6a3f7473a43ea02df2629f6cfb64846ff73c166e999ec508fdfd3b8a4415d13e8c3cc1919bdf09f7b57b9aef786781bfe57c61b49e9f0c23c210960e765', '1985-01-12', 'c', 'd', '2025-05-04 09:15:00', ''),
	(12, 'Fábio Almeida', 'fabio.almeida@gmail.com', '911472559', '19881ec942e80cf15c00e232c76a4d299b2f30e5611e7aa9d4f134ae365eff369a87ff65c01bc4502dc509d5357bdb8a748b54652bda0b5141f33d478008c520', '1992-05-24', 'f', 'd', '2025-05-05 20:22:00', ''),
	(13, 'Sofia Teixeira', 'sofia.teixeira@gmail.com', '912487350', '0271878e47ab45f5b948c1f7b6e5eeec7c6d99d3c79e83c0b07e349ceadf994fa02fa844f73a447206a1ebbe769ed61e6934c31e04bd1c541c768b65ccf1b68c', '1989-10-14', 'a', 'd', '2025-05-20 14:45:28', ''),
	(14, 'Bruno Neves', 'bruno.neves@gmail.com', '913244551', '37b2a7a4f75d9e13e1bfb8e84cf03c6a86f3c26a7a29c7162b7e144a81c4a3cc63f34f8d8d0aa5fa4372a2a7ef6b7760a1b34aebbd54015f79a7f726cdd2354e', '1986-11-02', 'c', 'd', '2025-05-02 15:31:00', ''),
	(15, 'Helena Cruz', 'helena.cruz@gmail.com', '914127888', '3cc48601a2512ef58cb8591e4f3b44b17795ce791cb9c98e80f4cecd8d755d3c512d4589b6177f25c2b671fa96bcf4f5f6cc8d199abb69a1eebd407bf0ef5b9f', '2000-04-18', 'c', 'd', '2025-05-10 08:17:00', ''),
	(16, 'Admin', 'admin@gmail.com', '914127888', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', '2000-04-18', 'a', 'a', '2025-06-06 12:51:38', '68221b3b95864_ds.png'),
	(28, 'Filipe Vieira', 'filipe@gmail.com', '912345678', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', '1999-05-21', 'f', 'd', '2025-05-27 12:27:19', ''),
	(34, 'Daniel Serra2', 'afsdfds@gmail.com', '987654321', 'cc534d82d249b477c6c5a29b07de08030b2de2556f6b5d9132a6f6bd37fd27e3a13324c9740c35774f40649405cab250514f3fd16603b73783ecf627b8dfebba', '2025-06-19', 'c', 'd', '2025-06-05 12:20:18', '');

-- A despejar estrutura para vista h3x.utilizadores_ativos
-- A criar tabela temporária para vencer erros de dependências VIEW
CREATE TABLE `utilizadores_ativos` (
	`ID` INT UNSIGNED NOT NULL,
	`Nome` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Tipo` ENUM('c','f','a') NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`Ultima` TIMESTAMP NULL
) ENGINE=MyISAM;

-- A despejar estrutura para tabela h3x.vip
CREATE TABLE IF NOT EXISTS `vip` (
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

-- A despejar dados para tabela h3x.vip: ~2 rows (aproximadamente)
INSERT INTO `vip` (`id`, `id_mesa`, `mensagem`, `data_reserva`, `id_utilizador`) VALUES
	(1, 1, 'Reserva para o aniversário de João', '2025-05-10', 1),
	(2, 2, 'Reserva para evento VIP', '2025-06-12', 2);

-- A despejar estrutura para tabela h3x.vip_mesas
CREATE TABLE IF NOT EXISTS `vip_mesas` (
  `id_vip` int unsigned NOT NULL,
  `id_mesas` int unsigned NOT NULL,
  PRIMARY KEY (`id_vip`,`id_mesas`),
  KEY `id_mesas` (`id_mesas`),
  CONSTRAINT `vip_mesas_ibfk_1` FOREIGN KEY (`id_vip`) REFERENCES `vip` (`id`),
  CONSTRAINT `vip_mesas_ibfk_2` FOREIGN KEY (`id_mesas`) REFERENCES `mesas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela h3x.vip_mesas: ~2 rows (aproximadamente)
INSERT INTO `vip_mesas` (`id_vip`, `id_mesas`) VALUES
	(1, 1),
	(2, 2);

-- A remover tabela temporária e a criar estrutura VIEW final
DROP TABLE IF EXISTS `comentarios_post`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `comentarios_post` AS select `comentarios`.`id` AS `ID`,`comentarios`.`conteudo` AS `Conteúdo`,`comentarios`.`data_criacao` AS `Data/Hora`,`posts`.`id` AS `ID Post`,`posts`.`titulo` AS `Título Post`,`utilizadores`.`nome` AS `Nome` from ((`comentarios` join `posts` on((`comentarios`.`id_post` = `posts`.`id`))) join `utilizadores` on((`comentarios`.`id_utilizador` = `utilizadores`.`id`)))
;

-- A remover tabela temporária e a criar estrutura VIEW final
DROP TABLE IF EXISTS `contatos_detalhada`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `contatos_detalhada` AS select `contactos`.`id` AS `ID`,`contactos`.`nome` AS `Nome`,`contactos`.`email` AS `Email`,`contactos`.`telefone` AS `Telefone`,`contactos`.`mensagem` AS `Mensagem`,`utilizadores`.`nome` AS `Nome (Cliente)` from (`contactos` left join `utilizadores` on((`contactos`.`id_utilizador` = `utilizadores`.`id`)))
;

-- A remover tabela temporária e a criar estrutura VIEW final
DROP TABLE IF EXISTS `eventos_futuros`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `eventos_futuros` AS select `eventos`.`id` AS `ID`,`eventos`.`titulo` AS `Título`,`eventos`.`data_inicio` AS `Data início`,`eventos`.`data_fim` AS `Data fim`,`eventos`.`hora_inicio` AS `Hora início`,`eventos`.`hora_fim` AS `Hora fim` from `eventos` where (`eventos`.`data_inicio` >= curdate())
;

-- A remover tabela temporária e a criar estrutura VIEW final
DROP TABLE IF EXISTS `imagens_por_aprovar`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `imagens_por_aprovar` AS select `imagens_galeria`.`id` AS `ID`,`imagens_galeria`.`titulo` AS `Título`,`imagens_galeria`.`imagem` AS `Imagem`,`imagens_galeria`.`data_upload` AS `Data/Hora`,`imagens_galeria`.`aprovado` AS `Aprovação`,`utilizadores`.`nome` AS `Nome` from (`imagens_galeria` join `utilizadores` on((`imagens_galeria`.`id_utilizador` = `utilizadores`.`id`))) where (`imagens_galeria`.`aprovado` = false)
;

-- A remover tabela temporária e a criar estrutura VIEW final
DROP TABLE IF EXISTS `posts_por_aprovar`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `posts_por_aprovar` AS select `posts`.`id` AS `ID`,`posts`.`titulo` AS `Título`,`posts`.`conteudo` AS `Conteúdo`,`posts`.`data_criacao` AS `Data/Hora`,`posts`.`aprovado` AS `Aprovação`,`utilizadores`.`nome` AS `Nome`,`categorias_posts`.`nome` AS `Categoria` from ((`posts` join `utilizadores` on((`posts`.`id_utilizador` = `utilizadores`.`id`))) join `categorias_posts` on((`posts`.`id_categoria` = `categorias_posts`.`id`))) where (`posts`.`aprovado` = false)
;

-- A remover tabela temporária e a criar estrutura VIEW final
DROP TABLE IF EXISTS `reservas_vip`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `reservas_vip` AS select `vip`.`id` AS `ID`,`mesas`.`nome` AS `Mesa`,`mesas`.`capacidade` AS `Capacidade`,`vip`.`mensagem` AS `Mensagem`,`vip`.`data_reserva` AS `Data`,`utilizadores`.`nome` AS `Nome` from ((`vip` join `mesas` on((`vip`.`id_mesa` = `mesas`.`id`))) join `utilizadores` on((`vip`.`id_utilizador` = `utilizadores`.`id`)))
;

-- A remover tabela temporária e a criar estrutura VIEW final
DROP TABLE IF EXISTS `utilizadores_ativos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `utilizadores_ativos` AS select `utilizadores`.`id` AS `ID`,`utilizadores`.`nome` AS `Nome`,`utilizadores`.`tipo` AS `Tipo`,`utilizadores`.`ultima_atividade` AS `Ultima` from `utilizadores` where (`utilizadores`.`estado` = 'a')
;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
