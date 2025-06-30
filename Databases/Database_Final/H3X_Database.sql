
CREATE DATABASE IF NOT EXISTS `h3x`;
USE `h3x`;

CREATE TABLE IF NOT EXISTS `categorias_posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categorias_posts` (`id`, `nome`) VALUES
	(1, 'Notícias'),
	(2, 'Eventos Semanais'),
	(3, 'Outros');
	
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `utilizadores` (`id`, `nome`, `email`, `telefone`, `pass`, `data_nascimento`, `tipo`, `estado`, `ultima_atividade`, `foto`) VALUES
	(1, 'Ana Ferreira', 'ana.ferreira@gmail.com', '919525148', '6a0d81964747b912ae73dbb78e53fe3307c89cb327954d64ef5162d45be82d3ab07033e9408a7efc9d19a7718503bde61d8ea9a8075e9de5da6c152d18fe5d9b', '2002-08-06', 'f', 'd', '2025-06-14 11:31:46', '684d6bb206b24_2025-06-14_12-31-46.webp'),
	(2, 'Tiago Ramos', 'tiago.ramos@gmail.com', '914679134', 'bbd64889a20c97863b24b3080640eb09e6628cd350b44c86eb224c38901589f6ab3b06170a58ef94c4ef5de64b7e38b5a8a12991bb09f64b4913e8cb0f0c5e69', '2000-09-04', 'c', 'd', '2025-06-14 11:29:21', ''),
	(3, 'Beatriz Lopes', 'beatriz.lopes@gmail.com', '919756655', '4c6aab2c3f30172aa32f5e65d769d3bb5e631e1bfb2388dddb6b98c89994433d64e108ab119d9c9b913f709c42219bfb402e48772f27fd0c199e7f123c585ad9', '1996-07-04', 'c', 'd', '2025-05-07 11:48:00', ''),
	(4, 'Miguel Antunes', 'miguel.antunes@gmail.com', '913156512', '4b8f5b1c90f1ab214f7e6d6c3a0114d2d01cf8b17d136b2be8d5d193e2e569b2fcd72ed74d754c7df1d456a40f272fd7dc747e403c8cfbde61719e4a79c1270a', '1993-01-29', 'c', 'd', '2025-06-14 11:29:39', ''),
	(5, 'Lúcia Mendes', 'lucia.mendes@gmail.com', '911165306', '0732cc44146b3eb30ebf62323a3d1fc8a23d1d7e7a4f7bdf12d7297f2a13cfe6c99dbf62d84e20ab0d2b471a2807fc477511ec0f8a2e1aaf38517441c42d805d', '1995-10-27', 'c', 'd', '2025-06-14 11:29:32', ''),
	(6, 'Pedro Costa', 'pedro.costa@gmail.com', '919037261', '29e764e5c5179ef0f4e81f7e76194df8dd60fbd032a4a222b01b0d92a464c8659e0bfb878c5bcbb969f29160d09c268c39e37eb4021e25929d8f164cb60b1f33', '1999-06-23', 'c', 'd', '2025-05-08 05:38:00', ''),
	(7, 'Carla Nunes', 'carla.nunes@gmail.com', '919855447', 'd9c7c7d2713a7b041fcd1fa3db1f024e4fc574a1bdcb63c0a6827fcaa00ccbd8eafbc21455d2d3cebb78e64500dd3bc53fe3f9b4a3b16de4b6a703fcaab11c5f', '1987-04-03', 'f', 'd', '2025-05-05 14:00:00', ''),
	(8, 'Rui Moreira', 'rui.moreira@gmail.com', '912438219', '00627ad3b162b4cf26f3b58aeea43dfc06a279c75c1f309a5c1dc6f3b3f0fefdc37d3c6651a0b6a771e74cd6e0d089c3a26e7e9d374e0222b7e9c4508edcf5cd', '1991-02-13', 'c', 'd', '2025-05-01 20:18:00', ''),
	(9, 'Diana Silva', 'diana.silva@gmail.com', '914839661', '0bc5a7f53918ad9f44eb97ed87cc5a327fbfb07ce961003ecfdf80d67671f5887f10e7f8fd5ac43d9d6e96e41e31fc0c55626dcbba6bb55389d22792a9cc84c4', '2001-03-16', 'a', 'd', '2025-05-20 13:45:28', ''),
	(10, 'André Rocha', 'andre.rocha@gmail.com', '919487262', '78d47cb9f90e85f39d84ff1a9ac2b28b7e82ad5c194c8961c0b788fd893e5e2f009acbd66f1cb1c8d2b5b24b1cf4f573cd3d32cb2468e27101bcf287b2a3491e', '1998-08-11', 'c', 'd', '2025-05-09 10:42:00', ''),
	(11, 'Cátia Marques', 'catia.marques@gmail.com', '913956721', '2fd3c6a3f7473a43ea02df2629f6cfb64846ff73c166e999ec508fdfd3b8a4415d13e8c3cc1919bdf09f7b57b9aef786781bfe57c61b49e9f0c23c210960e765', '1985-01-12', 'c', 'd', '2025-05-04 08:15:00', ''),
	(12, 'Fábio Almeida', 'fabio.almeida@gmail.com', '911472559', '19881ec942e80cf15c00e232c76a4d299b2f30e5611e7aa9d4f134ae365eff369a87ff65c01bc4502dc509d5357bdb8a748b54652bda0b5141f33d478008c520', '1992-05-24', 'c', 'd', '2025-06-14 11:29:49', ''),
	(13, 'Sofia Teixeira', 'sofia.teixeira@gmail.com', '912487350', '0271878e47ab45f5b948c1f7b6e5eeec7c6d99d3c79e83c0b07e349ceadf994fa02fa844f73a447206a1ebbe769ed61e6934c31e04bd1c541c768b65ccf1b68c', '1989-10-14', 'c', 'd', '2025-06-14 11:29:26', ''),
	(14, 'Bruno Neves', 'bruno.neves@gmail.com', '913244551', '37b2a7a4f75d9e13e1bfb8e84cf03c6a86f3c26a7a29c7162b7e144a81c4a3cc63f34f8d8d0aa5fa4372a2a7ef6b7760a1b34aebbd54015f79a7f726cdd2354e', '1986-11-02', 'c', 'd', '2025-05-02 14:31:00', ''),
	(15, 'Helena Cruz', 'helena.cruz@gmail.com', '914127888', '3cc48601a2512ef58cb8591e4f3b44b17795ce791cb9c98e80f4cecd8d755d3c512d4589b6177f25c2b671fa96bcf4f5f6cc8d199abb69a1eebd407bf0ef5b9f', '2000-04-18', 'c', 'd', '2025-05-10 07:17:00', ''),
	(16, 'Admin', 'admin@gmail.com', '914127888', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', '2000-04-06', 'a', 'a', '2025-06-18 11:17:41', '684d6bc53ea8d_2025-06-14_12-32-05.jpg'),
	(28, 'Filipe Vieira', 'filipe@gmail.com', '912345678', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', '1999-05-21', 'c', 'd', '2025-06-14 11:29:56', ''),
	(41, 'Funcionário', 'funcionario@gmail.com', '', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', '2005-05-09', 'f', 'd', '2025-06-14 11:27:27', '684d6aafc0478_2025-06-14_12-27-27.jpg'),
	(42, 'Cliente', 'cliente@gmail.com', '973456765', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', '2009-02-03', 'c', 'd', '2025-06-14 11:28:54', '684d6b067662c_2025-06-14_12-28-54.jpg');


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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `posts` (`id`, `titulo`, `conteudo`, `data_criacao`, `aprovado`, `id_utilizador`, `id_categoria`, `imagem`) VALUES
	(15, 'Novos Cocktails no Bar', 'Apesar de estar a abrir agora, o H3X já promete tornar-se um dos grandes símbolos da vida noturna em Lisboa. Para celebrar a sua grande inauguração, a discoteca vai ter uma “festa memorável” já este sábado, 31 de agosto.\r\n\r\nSob o tema Neon Future, a noite promete surpreender os convidados com espetáculos envolventes e performances inesperadas que vão transformar a experiência num “evento único, extraordinário e inesquecível”, descreve a organização do espaço situado na zona de Santos.\r\n\r\nA música ficará a cargo dos famosos DJs brasileiros Bruna Lennon e Rodrigo Ribeiro. A eles juntam-se os residentes portugueses Ivo e Ricardo Coimbra, que vão garantir que “a energia na pista de dança se mantenha alta durante toda a noite”.\r\n\r\nA festa contará com a presença de mais de três mil pessoas, calculam os responsáveis pela discoteca, que tem cerca de dois mil metros quadrados. O melhor de tudo? A entrada é livre. Assim, todos poderão “fazer parte desta noite especial”, que será, simultaneamente, “a festa do ano”.\r\n\r\nAo longo dos dias, o H3X terá eventos temáticos com diferentes estilos musicais. Às quintas-feiras, por exemplo, poderá ouvir o melhor do funk brasileiro. A pop e a eletrónica também terão destaque. “As nossas festas refletem o melhor da vida noturna, combinando os sons mais atuais com DJs de renome internacional. Esta dedicação à excelência musical coloca-nos entre os melhores clubes e discotecas de Lisboa”, afirma a casa.\r\n\r\nAté ao final de setembro, o espaço estará aberto de terça-feira a sábado, da meia-noite às seis da manhã. Entre outubro e maio, poderá visitá-lo de quarta-feira a sábado, dentro do mesmo horário.\r\nAlém da pista de dança, ao lado do H3X encontra-se o Enigma, um restaurante que também oferece música ao vivo e outras performances, como dança. O espaço foi criado para proporcionar uma experiência completa, combinando gastronomia e entretenimento num só lugar.', '2025-05-15 19:30:00', 1, 16, 1, '684d74a333b20_2025-06-14_13-09-55.jpg'),
	(22, 'HEX Thursdays', 'A H3X apresenta as HEX Thursdays, um novo conceito que vai transformar as quintas-feiras em noites obrigatórias no calendário noturno de Lisboa. Num ambiente onde a descontração se cruza com a ousadia, o clube dá palco ao melhor do funk brasileiro, reggaeton e sonoridades afro-tropicais, com DJs nacionais e internacionais a assumirem o controlo da pista.\r\n\r\nA estreia acontece já esta quinta-feira, 19 de setembro, com a presença da carioca MC Mari Cruz, referência do funk 150 BPM e conhecida por atuações que misturam sensualidade e energia eletrizante. A noite contará ainda com os sets do coletivo AfroLisba Groove, que trazem batidas africanas e sons urbanos para um início de noite vibrante.\r\n\r\n“Queremos que a quinta seja uma celebração da liberdade, do corpo e do ritmo. É para dançar sem filtros”, explica a organização da H3X. Para criar a atmosfera perfeita, o clube vai apostar numa cenografia especial com luzes quentes, projeções visuais tropicais e uma pista preparada para transpirar calor e movimento.\r\n\r\nA entrada é livre até à 1h e os primeiros 200 convidados receberão um cocktail de boas-vindas temático. O dress code para a noite convida à criatividade: "cores vivas, brilho, pele — queremos ver o verão continuar na pista", afirma a produção.\r\n\r\nAlém de HEX Thursdays, a H3X reforça que as quintas-feiras são o espaço da diversidade musical e cultural. Ao longo das semanas, nomes da cena brasileira, africana e latina vão trazer novos ritmos à cidade. “Lisboa sempre foi uma cidade aberta ao mundo. A H3X quer ser o reflexo disso”, conclui a casa.', '2025-06-14 13:42:08', 1, 1, 2, '684d6e20bd18b_2025-06-14_12-42-08.jpg'),
	(23, 'Tech Noir', 'Esta sexta-feira, dia 20, a H3X transforma-se num universo paralelo com a primeira edição da Tech Noir, uma nova residência dedicada ao techno industrial, EBM, acid e ambient escuro, que pretende oferecer ao público de Lisboa uma experiência eletrónica fora do comum.\r\n\r\nO conceito da noite é inspirado nos clubes alternativos de Berlim e nos filmes de ficção científica dos anos 80. O objetivo? Criar um ambiente imersivo, onde a música e a estética trabalham juntas para transportar os convidados para uma realidade alternativa. “Queremos que as pessoas entrem num outro tempo, num outro espaço. Algo cru, mecânico, mas profundamente hipnótico”, descreve a curadoria da noite.\r\n\r\nNa cabine estarão Marcel Tonic, francês conhecido pelas suas atuações em antigos armazéns industriais transformados em clubes, e a portuguesa MINA, artista que tem vindo a destacar-se pela sua abordagem crua e emocional ao techno. Ambos prometem sets longos e intensos, com momentos de tensão e libertação.\r\n\r\nO espaço da H3X será modificado para esta noite especial: projeções glitch, lasers pontuais, nevoeiro contínuo e uma paleta de luz monocromática, tudo pensado para amplificar o impacto sonoro. A pista estará dividida em dois núcleos — um dedicado à dança e outro à contemplação — onde os convidados poderão experimentar o som de forma mais introspectiva.', '2025-06-14 13:43:08', 1, 1, 2, '684d6e5c93eb8_2025-06-14_12-43-08.jpg'),
	(24, 'Restaurante Enigma', 'A vida noturna não começa apenas na pista de dança. É com essa ideia que nasceu o Enigma, o restaurante que partilha morada com o H3X e que propõe uma abordagem diferente para quem quer mais da noite: mais sabor, mais arte, mais surpresa.\r\n\r\nLocalizado mesmo ao lado da discoteca, o Enigma é mais do que um restaurante. É um espaço híbrido que mistura gastronomia mediterrânica com performance artística, criando um ambiente sofisticado e ao mesmo tempo imprevisível. “O Enigma é para quem quer viver a noite desde o primeiro minuto. Para quem não quer apenas jantar, mas ser surpreendido”, explica o responsável artístico do espaço.\r\n\r\nTodas as sextas e sábados, a partir das 21h, o restaurante apresenta jantares performáticos, com dança contemporânea, música ao vivo, teatro físico e elementos visuais. O espetáculo acontece entre os pratos, no meio da sala ou à volta dos clientes, criando um ambiente quase cinematográfico.\r\n\r\nO menu é uma viagem pelos sabores do sul da Europa com toques do Médio Oriente, pensado para partilhar e explorar em grupo. “Queremos provocar todos os sentidos, incluindo o paladar. Cada noite no Enigma é única”, acrescenta a chef residente.\r\n\r\nAlém do jantar, os clientes do Enigma têm acesso prioritário à discoteca H3X, com entrada reservada até às 2h e zona exclusiva nos primeiros momentos da noite. O objetivo é proporcionar uma transição suave entre jantar e dança, sem perder o clima especial.\r\n\r\nAs reservas são feitas online ou por telefone, e os lugares são limitados. “O Enigma é o ponto de partida perfeito para uma noite inesquecível. É onde tudo começa”, conclui a produção.', '2025-06-14 13:43:49', 1, 9, 1, '684d6e858d768_2025-06-14_12-43-49.webp'),
	(25, 'Into the Abyss', 'A H3X prepara-se para abrir um novo portal sonoro com ‘Into the Abyss’, uma noite totalmente dedicada ao deep techno, minimal progressivo e paisagens sonoras imersivas. Este evento exclusivo acontece este sábado, 21 de setembro, e promete transportar os clubbers lisboetas para uma experiência sensorial intensa e atmosférica.\r\n\r\n“A noite foi pensada para quem procura mais do que o habitual ritmo da pista — queremos provocar introspeção, entrega e catarse”, explica a curadora sonora da casa. Para isso, a cabine da H3X será entregue ao alemão Joachim Walter, uma referência no panorama do techno hipnótico, conhecido por criar set lists densas e envolventes, quase cinematográficas. A acompanhá-lo estará a DJ portuguesa Vanda Azul, que tem vindo a conquistar o circuito nacional com atuações onde melodia e peso coexistem.\r\n\r\nA cenografia da noite será inspirada em cavernas abissais e ambientes aquáticos, com projeções líquidas, névoa contínua e uma iluminação azul profunda, pensada para fundir o espaço com o som. A pista será “um organismo vivo em movimento lento, onde cada batida se torna um passo para dentro de nós mesmos”.\r\n\r\nA noite começa à meia-noite e prolonga-se até às 7h da manhã. Os bilhetes estão à venda online e na porta, com valores entre os 10€ e os 15€, dependendo da hora de chegada. Para os primeiros 300 convidados, haverá uma instalação sensorial imersiva na entrada, como prelúdio da experiência.', '2025-06-14 13:44:45', 1, 9, 2, '684d6ebd478cf_2025-06-14_12-44-45.webp'),
	(26, 'Brunch & Bass', 'O Enigma, o restaurante performático vizinho da H3X, está a reinventar o conceito de domingo com o seu novo evento Brunch & Bass, uma fusão de brunch descontraído, cocktails ousados e música eletrónica em tom low tempo. A estreia será já este domingo, 22 de setembro, a partir das 14h.\r\n\r\n“Acreditamos que a energia da noite pode renascer à luz do dia — só muda o ritmo”, explica a equipa criativa do espaço. Durante seis horas, o Enigma vai abrir portas para um ambiente solarengo, com um menu especial de brunch mediterrânico, cocktails assinados por mixologistas convidados e DJ sets contínuos que oscilam entre o downtempo, house melódico e trip-hop.\r\n\r\nA curadoria sonora da primeira edição fica a cargo da dupla Duo Mirage, conhecida por criar paisagens sonoras perfeitas para ambientes chill mas ainda dançáveis. Os convidados podem optar por mesas no interior do restaurante ou no terraço coberto com decoração boho, ideal para prolongar o fim de semana com boa música e boa comida.', '2025-06-14 13:45:19', 1, 9, 3, '684d6edf51e5a_2025-06-14_12-45-19.webp'),
	(27, 'Nastia e o techno', 'Este sábado, dia 28, a H3X recebe uma das DJs mais respeitadas e magnéticas da cena europeia: Nastia. Nascida na Ucrânia, Nastia tornou-se um nome incontornável do techno global, com atuações que cruzam precisão técnica com uma entrega emocional inigualável. Em Lisboa, promete um set de longa duração, repleto de transições surpreendentes e momentos de euforia coletiva.\r\n\r\nA noite será parte da série H3X International Nights, que todas as últimas semanas do mês trazem um headliner internacional à cidade, promovendo uma ponte entre Lisboa e o circuito mundial da música eletrónica. Para esta noite, Nastia será precedida por Ricardo Coimbra, residente do H3X, e pela convidada especial SARAA, jovem promessa de Madrid que mistura ritmos percussivos com techno futurista.\r\n\r\nA pista principal será ambientada com uma cenografia inspirada em geometrias abstratas, projetadas em tempo real, num jogo entre luz e sombra que acompanhará as batidas. O bar contará com cocktails inspirados em cidades europeias — de Berlim a Kiev — numa homenagem à diversidade sonora que marca esta noite.\r\n\r\nA abertura de portas será à meia-noite, com bilhetes disponíveis a partir de 12€ (pré-venda) e 15€ na porta. A noite termina oficialmente às 7h, mas há rumores de after surpresa num espaço secreto. “Esta será uma daquelas noites que se contam, mas nunca se esquecem”, afirma a direção do clube.', '2025-06-14 13:46:23', 1, 41, 2, '684d6f1f6890e_2025-06-14_12-46-23.jpg'),
	(28, 'Identidade H3X', 'Por detrás do ambiente frenético das noites H3X, há uma dupla que tem vindo a moldar a alma sonora da casa: Ivo e Ricardo Coimbra, os DJs residentes e curadores musicais do espaço. Com uma abordagem pensada ao detalhe, os irmãos não são apenas os rostos da cabine — são os arquitetos da experiência auditiva que define a H3X.\r\n\r\nEm entrevista exclusiva ao blog, os DJs revelam os bastidores do seu trabalho. “Cada noite tem um arco narrativo. Desde o primeiro beat até ao último fade, queremos que a pista viva uma história”, explica Ivo. A dupla combina influências do techno melódico de Berlim, do groove hipnótico de Tel Aviv e até da eletrónica emocional de Lisboa.\r\n\r\nSão eles os responsáveis por convidar artistas, definir os warm-ups e os fechos, além de testarem novas sonoridades com o público. “Estamos sempre a ouvir, a ajustar. O som certo na hora certa pode mudar completamente a energia de uma noite”, completa Ricardo.\r\n\r\nPara além das atuações regulares às sextas e sábados, os irmãos Coimbra também têm um projeto paralelo de produção musical, com lançamento previsto ainda este ano — e, claro, estreia marcada para a H3X. “Este clube é mais do que um palco. É o nosso laboratório criativo”, concluem.', '2025-06-14 13:47:07', 1, 10, 3, '684d6f4b9de50_2025-06-14_12-47-07.jpg'),
	(29, 'HEX x Adidas', 'Este sábado, a H3X entra numa nova dimensão urbana com a colaboração inédita com a Adidas Originals, numa noite onde a música e o streetwear vão dançar lado a lado. A iniciativa marca o início de uma série de eventos sob o selo HEX x Brands, que vai trazer para o clube marcas icónicas e colaborações criativas.\r\n\r\nA festa, com início às 23h, terá como tema "Movement is Identity", e contará com um desfile-performance dentro do próprio clube, assinado pela plataforma criativa Lisbon Reborn. Durante a noite, modelos e performers circularão pela pista com peças exclusivas da Adidas, num espetáculo vivo de moda em sintonia com o som.\r\n\r\nNa cabine, a curadoria segue o espírito urbano: o britânico DJ Farris, nome ligado à cena UK bass e grime, junta-se a Aneeka, DJ lisboeta com raízes no hip hop, breakbeat e techno industrial. A fusão de estilos promete uma sonoridade eclética, vibrante e contemporânea.\r\n\r\nOs primeiros 500 convidados terão acesso a merch exclusivo e brindes da marca, além de zonas interativas no clube, incluindo uma cabine de fotos 360º e um lounge com realidade aumentada. A entrada é livre até à meia-noite, com dress code sugerido: "urban rebel".', '2025-06-14 13:47:36', 1, 41, 3, '684d6f68bcbc5_2025-06-14_12-47-36.webp'),
	(30, 'Noite Queer Kode', 'Na sexta-feira, 4 de outubro, a H3X apresenta a primeira edição da Queer Kode, uma noite dedicada à celebração da liberdade, da diversidade e do poder transformador da pista. Mais do que uma festa, trata-se de um espaço seguro e afirmativo para a comunidade LGBTQIA+ e seus aliados.\r\n\r\n“O Queer Kode nasce como resposta a uma necessidade real: um lugar onde todos possam existir plenamente, dançar sem medo, brilhar sem limites”, afirma Alex da produção artística. A cabine será entregue à lendária DJ Vani Bliss, figura incontornável da cena queer de Paris, e à dupla Glitch Bitches, conhecida por sets que cruzam voguing beats, techno sujo e samples de cultura pop.\r\n\r\nA festa terá uma cenografia provocadora inspirada em clubes underground de Nova Iorque nos anos 90, com neons rosa, esculturas infláveis, efeitos strobe e momentos performativos inesperados. Haverá ainda uma passarela improvisada para quem quiser desfilar, vogar ou simplesmente se exibir.\r\n\r\nO código de vestuário é claro: "Express Yourself" — quanto mais ousado, melhor. A entrada custa 10€, com descontos para estudantes e artistas queer. Parte das receitas será doada à associação ILGA Portugal. A pista da H3X promete tornar-se, nessa noite, um espaço de resistência, celebração e puro êxtase.', '2025-06-14 13:48:02', 1, 41, 2, '684d6f820fdce_2025-06-14_12-48-02.jpg'),
	(31, 'Nos bastidores H3X', 'Por trás das noites hipnóticas da H3X, existe uma engenharia invisível de luz e imagem que transforma cada festa numa experiência cinematográfica. O responsável por este universo visual é Tomás Figueiredo, light designer que já trabalhou em festivais como Boom, Sónar e Dekmantel, e que agora assina o conceito visual do clube.\r\n\r\n“O objetivo é que o público não pense na luz — mas a sinta. É um trabalho quase subconsciente”, explica Tomás. O sistema da H3X inclui mais de 200 pontos de luz programáveis, com tecnologia de última geração que permite reações em tempo real ao som, movimentos do público e batida.\r\n\r\nAlém da iluminação, a equipa utiliza projeções mapeadas, espelhos móveis e sensores de presença, criando atmosferas que oscilam entre o místico e o digital. “Temos festas que começam em ambientes etéreos e acabam no caos pulsante. O design segue esse arco narrativo”.\r\n\r\nTomás trabalha em conjunto com os DJs e performers para desenhar cada noite com detalhe. “A luz é a segunda batida. Quando ela entra no corpo, completa o som”, conclui. A cada noite, a H3X revela não só um espaço, mas uma experiência visual total.', '2025-06-14 13:48:35', 1, 9, 3, '684d6fa33efd2_2025-06-14_12-48-35.webp'),
	(32, 'Synesthesia', 'No sábado, 12 de outubro, a H3X desafia os sentidos com Synesthesia, uma festa imersiva criada para estimular audição, olfato, visão e tato. Mais do que música e dança, o evento propõe uma vivência corporal completa, onde cada sentido é ativado por estímulos cuidadosamente desenhados.\r\n\r\nÀ entrada, os convidados receberão um óleo essencial personalizado, escolhido com base num breve questionário emocional. No interior, diferentes zonas da pista estarão associadas a notas aromáticas, texturas e projeções cromáticas, criando microclimas emocionais.\r\n\r\nO som estará a cargo da dupla Lunar Bodies, que tocará um set techno downtempo de 4 horas, com variações suaves e camadas harmónicas. A iluminação será baseada em tons pastéis, lasers suaves e névoa aromática, enquanto performers discretos tocarão o público com tecidos de diferentes texturas durante momentos-chave da noite.\r\n\r\n“O objetivo é criar uma pista onde se dança com todos os sentidos. Um espaço entre sonho e corpo”, afirma a curadoria. Os bilhetes custam 15€, com possibilidade de reserva de zona sensorial exclusiva. Uma festa para sentir — literalmente — do início ao fim.', '2025-06-14 13:49:09', 1, 41, 2, '684d6fc555e53_2025-06-14_12-49-09.webp'),
	(37, 'O que vivi na H3X', 'Nunca fui muito de escrever sobre noites, mas depois da última sexta-feira, senti que tinha de partilhar. Fui à H3X com um grupo de amigos — alguns já conheciam, outros (como eu) iam pela primeira vez. Chegámos por volta da meia-noite e a fila já dava sinais do que nos esperava: um clube cheio de energia, diversidade e aquele tipo de entusiasmo que se sente antes mesmo de entrar.\r\n\r\nA primeira coisa que me impressionou foi o espaço em si. Alto, aberto, com uma arquitetura industrial mas ao mesmo tempo futurista. Havia neons que pareciam flutuar, instalações de luz que reagiam à música e, honestamente, uma organização impecável. Não me senti perdido em nenhum momento.\r\n\r\nA música? Absolutamente transcendente. Estava a tocar a DJ italiana Kiara Eléctrik e o set dela foi um crescendo perfeito. Começou com techno hipnótico e depois foi ficando mais pesado, mais tribal. Nunca pensei dançar tanto sem me cansar. A pista parecia um só corpo em movimento. É difícil explicar, mas houve momentos em que quase me emocionei — sim, com batidas de techno. Coisas que só quem vive sabe.\r\n\r\nGostei também do ambiente humano. Vi casais, grupos de amigos, pessoas sozinhas — todas a dançar sem julgamentos, sem pressas, sem dramas. Senti-me livre. Senti-me visto.\r\n\r\nPara mim, a H3X não é só uma discoteca. É um espaço onde tudo se transforma: a música, a luz, o tempo e até nós próprios. Obrigado por me fazerem viver algo assim.', '2025-06-14 14:06:55', 1, 8, 3, '684d73ef69bae_2025-06-14_13-06-55.jpg'),
	(38, 'A festa Synesthesia', 'Ouvi falar da Synesthesia no Instagram e confesso que fui pela curiosidade. Uma festa que mistura som, cheiro, toque e luz? Parecia-me algo entre o estranho e o genial. Bem... posso dizer com certeza: foi genial.\r\n\r\nDesde o momento em que entrei, percebi que aquilo não era uma festa qualquer. Havia um aroma subtil a sândalo no ar, e o staff entregava pequenos frascos de óleo essencial personalizado com base no teu estado emocional (respondes a umas perguntas antes). Só isso já me desarmou. A sensação era de estar num spa techno.\r\n\r\nMas quando entrei na pista… wow. Havia zonas com texturas diferentes no chão, luzes suaves que pareciam respirar contigo, e um som que te envolvia como se estivesses dentro de uma bolha. A música era tão bem pensada — techno lento, profundo, mas que se colava ao teu corpo como seda. Às vezes sentia uma mão com tecido nas costas ou nos braços — performers discretos, quase invisíveis, que te tocavam suavemente enquanto dançavas.\r\n\r\nFoi sensorialmente poderoso. Tive momentos de êxtase, introspeção e pura alegria. Nunca pensei que uma discoteca pudesse mexer tanto comigo. Saí de lá com vontade de voltar e de recomendar a toda a gente.\r\n\r\nParabéns, H3X. Isto é o futuro.', '2025-06-14 14:07:48', 0, 42, 3, '684d7424aa81e_2025-06-14_13-07-48.webp'),
	(39, 'A H3X animou-me', 'Sou frequentador assíduo de clubes desde que me lembro. Mas, nos últimos tempos, sentia que tudo soava ao mesmo: os mesmos DJs, os mesmos sons, a mesma pose. A H3X foi uma bofetada de frescura — no melhor sentido.\r\n\r\nFui pela primeira vez a uma noite temática chamada “Electric Bloom”, com um conceito visual de flores mutantes e estética cyberpunk. Não fazia ideia do que esperar. Entrei sozinho, com curiosidade, e saí com a sensação de que dancei durante horas sem parar. A música era pura eletricidade emocional: o DJ (que descobri depois que era o Ricardo Coimbra) fez uma progressão sonora tão fluida que nem percebi quando saí do warm-up para o pico da noite.\r\n\r\nO que mais me marcou, no entanto, foi o público. Ninguém ali estava a tentar parecer cool. As pessoas estavam ali para dançar de verdade. Vi movimentos espontâneos, genuínos, livres. Eu próprio dei por mim a libertar gestos que já não usava há anos. Senti-me em casa.\r\n\r\nQuando saí, já o sol nascia, e ainda havia gente lá dentro. Aquela noite ficou comigo — no corpo e na alma. A H3X devolveu-me o que achava que a noite lisboeta tinha perdido: autenticidade e prazer cru em dançar.', '2025-06-14 14:09:23', 0, 42, 3, '684d7483936ec_2025-06-14_13-09-23.webp');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `comentarios` (`id`, `conteudo`, `data_criacao`, `id_post`, `id_utilizador`) VALUES
	(10, 'Esta collab está insana 🔥 Adidas e techno é tudo o que eu quero!', '2025-06-14 14:11:15', 29, 9),
	(11, 'Já quero essa T-shirt exclusiva!!', '2025-06-14 14:11:27', 29, 42),
	(12, 'Lounge com RA e cabine 360º? H3X a dar cartas como sempre.', '2025-06-14 14:11:33', 29, 2),
	(13, 'Só o nome já me dá vontade de ir 💥', '2025-06-14 14:12:08', 30, 1),
	(14, 'Obrigada por criarem um espaço seguro para todes. Já é o meu clube preferido', '2025-06-14 14:12:14', 30, 6),
	(15, 'Vai ser épico! Mal posso esperar para brilhar sem filtros 💅', '2025-06-14 14:12:20', 30, 42),
	(16, 'Finalmente um espaço que promete algo diferente em Lisboa. Contem comigo neste sábado 🔥', '2025-06-14 14:13:09', 22, 8),
	(17, 'Entrada livre e DJ brasileiro? Já me convenceram 🤩', '2025-06-14 14:13:12', 22, 13),
	(18, 'Lisboa vai voltar a ter vida noturna como deve ser. Boraaaa H3X!', '2025-06-14 14:13:24', 22, 4),
	(19, 'Sou fã dos dois há anos! Ver os dois juntos na H3X vai ser mágico ✨', '2025-06-14 14:14:24', 28, 9),
	(20, 'Ivo + Ricardo = destruição total na pista! 🔊', '2025-06-14 14:14:29', 28, 15),
	(21, 'Jantei lá antes da festa, e foi tudo top. Ambiente + comida 👌', '2025-06-14 14:14:47', 24, 5),
	(22, 'Lindo ver o reconhecimento do pessoal da luz. São eles que nos fazem sentir a música nos ossos.', '2025-06-14 14:15:03', 31, 3),
  (23, 'Opinião muito boa!', '2025-06-14 14:11:15', 39, 9),
	(24, 'A festa foi top!', '2025-06-14 14:11:27', 39, 42);

CREATE TABLE IF NOT EXISTS `contactos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(9) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `data_contactos` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assunto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `contactos` (`id`, `assunto`, `nome`, `email`, `telefone`, `mensagem`, `data_contactos`) VALUES
(1, 'Informação sobre eventos', 'Carlos Silva', 'carlos.silva@email.com', '912345678', 'Gostaria de saber mais sobre os próximos eventos.', '2025-06-01'),
(2, 'Orçamento para casamento', 'Ana Oliveira', 'ana.oliveira@email.com', '913456789', 'Preciso de um orçamento para uma festa de casamento.', '2025-06-02'),
(3, 'Aluguer de espaço', 'Ricardo Mendes', 'ricardo.mendes@email.com', '914567890', 'Quero alugar o espaço para uma festa privada.', '2025-06-03'),
(4, 'Pedido de parceria', 'Mariana Costa', 'mariana.costa@email.com', '915678901', 'Gostaria de propor uma parceria comercial.', '2025-06-04'),
(5, 'Feedback do evento', 'João Rocha', 'joao.rocha@email.com', '916789012', 'O evento foi excelente, parabéns!', '2025-06-05'),
(6, 'Problema com reserva', 'Sofia Lima', 'sofia.lima@email.com', '917890123', 'Houve um problema com a minha reserva.', '2025-06-06'),
(7, 'Pedido de informações técnicas', 'Tiago Martins', 'tiago.martins@email.com', '918901234', 'Quais são os requisitos técnicos do palco?', '2025-06-07'),
(8, 'Voluntariado', 'Beatriz Gonçalves', 'beatriz.goncalves@email.com', '919012345', 'Gostaria de ser voluntária nos eventos.', '2025-06-08'),
(9, 'Reclamação', 'André Sousa', 'andre.sousa@email.com', '910123456', 'O som estava muito alto durante o evento.', '2025-06-09'),
(10, 'Informações sobre DJ', 'Cláudia Ferreira', 'claudia.ferreira@email.com', '911234567', 'Quem foi o DJ na última noite?', '2025-06-10'),
(11, 'Pedido de orçamento empresarial', 'Pedro Ramos', 'pedro.ramos@email.com', '912345679', 'Pretendo organizar um evento da empresa.', '2025-06-11'),
(12, 'Sugestão de melhoria', 'Inês Moreira', 'ines.moreira@email.com', '913456780', 'Sugiro mais opções vegetarianas nos eventos.', '2025-06-12'),
(13, 'Confirmação de presença', 'Rui Carvalho', 'rui.carvalho@email.com', '914567891', 'Confirmo a minha presença no evento.', '2025-06-13'),
(14, 'Informações sobre bilhetes', 'Lara Figueiredo', 'lara.figueiredo@email.com', '915678902', 'Onde posso comprar os bilhetes?', '2025-06-14'),
(15, 'Evento infantil', 'Miguel Pinto', 'miguel.pinto@email.com', '916789013', 'Quais eventos são apropriados para crianças?', '2025-06-15');

CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  `imagem_banner` varchar(255) DEFAULT NULL,
  `video_banner` varchar(255) DEFAULT NULL,
  `imagem_card` varchar(255) DEFAULT NULL,
  `lineup` text,
  `videoyt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `eventos` (`id`, `titulo`, `data_inicio`, `data_fim`, `imagem_banner`, `video_banner`, `imagem_card`, `lineup`, `videoyt`) VALUES
(12, 'EMOTRANCE', '2025-09-15 08:00:00', '2025-09-16 07:59:00', '686307a50d5e9_ab6761610000e5eb61ad1f6f29edbabf3db5022f.png', '686307a50e3c4_684024fe8a360_background3 - Cópia.mp4', '686307a50dd8a_Captura de ecrã 2025-06-30 224650.png', 'Amelie Lens; ANNA; Enrico Sangiuliano; Tale of Us', 'https://youtu.be/vjR_gc6c1xw?si=YTdHEhIgp2y-djAW'),
(9, 'NEUROCHROME', '2025-07-28 22:00:00', '2025-07-30 06:00:00', '686306ce24792_holy-priest-hd_optimized.png', '686306ce25f7a_video2.mp4', '686306ce251e1_Captura de ecrã 2025-06-30 224513.png', 'HOLY PRIEST; SaraLandry; DaxJ', 'https://youtu.be/pPGrNNQhXK4?si=L6SYNcoE61Ce4AlG'),
(10, 'NoSleep Operation', '2025-08-06 21:00:00', '2025-08-12 07:00:00', '68630754c582e_Charlotte_De_Witte_Bandcamp_BW.png', '68630754c6cad_video1.mp4', '68630754c6303_Captura de ecrã 2025-06-30 224452.png', 'Charlotte de Witte; Chris Liebing; Richie Hawtin; Carl Cox', 'https://youtu.be/XFLIztjVaR8?si=6pMPVUG3KYuDXjuW'),
(8, 'NECROTECH NIGHT', '2025-07-07 20:00:00', '2025-07-10 06:00:00', '6852139ba58f5_6840e7f855767_artworks-000195124570-4jd3zy-t500x500-removebg-preview - Cópia.png', '6852122fd31d6_6840e7f85576d_1234 - Cópia.mp4', '6852139ba607c_6840e7f85576c_Captura de ecrã 2025-04-06 145347 - Cópia.png', 'DJ SNTS;DJ Ø [Phase];DJ I Hate Models;DJ ¥ØU$UK€ ¥UK1MAT$U', 'https://www.youtube.com/live/Vk7Qr6I4nfk?si=jJAN7NLtTS9qgiWa'),
(13, 'NOISE CODEX', '2025-08-14 23:00:00', '2025-08-22 06:00:00', '68630816debc6_ab6761610000e5ebd1b0c16bf77cfe30c09b4951.png', '68630816e02da_video2.mp4', '68630816df2dc_Captura de ecrã 2025-06-30 224513.png', 'Gesaffelstein; Brutalismus3000; Acid Asian; Spectral', 'https://youtu.be/AaAb9qNv_-U?si=Q0aKDmYL-2ccuw31'),
(14, 'MECHANOID RITUAL', '2025-09-25 23:00:00', '2025-09-27 05:00:00', '686309d481eb9_unnamed.png', '686309d481ebe_video4.mp4', '686309d481ebc_Captura de ecrã 2025-06-30 224545.png', 'Surgeon; Rebekah; Paula Temple; Ancient Methods', 'https://youtu.be/Ww9VtKqprUY?si=eeCyfBPY7SypjSmr'),
(15, 'CINEØTECH', '2025-08-24 00:00:00', '2025-08-26 06:00:00', '68630a57e8f7d_15954699.png', '68630a57e8f91_video5.mp4', '68630a57e8f8d_Captura de ecrã 2025-06-30 224600.png', 'Anyma; Boris Brejcha; &ME; Miss Monique', 'https://youtu.be/lIdrRRofKm0?si=BJH2xQtauVTNoGAr'),
(16, 'RITUALIZED WAVES', '2025-06-26 22:00:00', '2025-06-27 05:00:00', '68630af239c29_4-2880x1909.png', '68630af239c33_686309d481ebe_video4.mp4', '68630af239c31_Captura de ecrã 2025-06-30 224545.png', 'NeneH; SPFDJ; Tauceti; Cloudy', 'https://youtu.be/Didjvrf66aE?si=RD6UjFR0Jkd4wOr1'),
(17, 'FUTURE HERITAGE', '2025-07-11 00:00:00', '2025-07-14 22:00:00', '68630b504de99_6840e7f855767_artworks-000195124570-4jd3zy-t500x500-removebg-preview - Cópia.png', '68630b504dea0_68630816e02da_video2.mp4', '68630b504de9f_Captura de ecrã 2025-06-30 224513.png', 'SNTS; Bigod20; Jeff Mills; Sven Väth', ''),
(18, 'MALIGNANCE', '2025-09-30 22:10:00', '2025-10-01 06:00:00', '68630c0057177_686306ce24792_holy-priest-hd_optimized.png', '68630c0057183_video3.mp4', '68630c0057181_Captura de ecrã 2025-06-30 224532.png', 'HOLY PRIEST;VANTABLACK MESSIAH; SISTER PHOBIA; KODEX NULL', 'https://youtu.be/pPGrNNQhXK4?si=DUNLskTjAN8rSvt5'),
(19, 'RELIC UNIT', '2025-10-05 00:00:00', '2025-10-07 06:00:00', '68630c6e64a1b_6840edffbdc93_dsf8966-min-removebg-preview - Cópia.png', '68630c6e64a21_685213d15da93_6840edffbdc99_background3 - Cópia.mp4', '68630c6e64a20_Captura de ecrã 2025-06-30 224650.png', '¥ØU$UK€ ¥UK1MAT$U; CATHARSIS BLEED; NIGHT PACT; ALTAR XIII', 'https://youtu.be/T1tcUfUhR5U?si=K7IF5077ORDbQEwT'),
(20, 'VOID SAINTS', '2026-01-05 22:15:00', '2026-01-06 22:15:00', '68630cdb625ea_6840e7f855767_artworks-000195124570-4jd3zy-t500x500-removebg-preview - Cópia.png', '68630cdb625f0_6852122fd31d6_6840e7f85576d_1234 - Cópia.mp4', '68630cdb625ef_6852122fcfb58_6840e7f85576c_Captura de ecrã 2025-04-06 145347 - Cópia.png', 'SNTS;MOURN CIRCUIT; DRONE SAINT; STIGMA VOID', 'https://www.youtube.com/live/Vk7Qr6I4nfk?si=9q908gsVLSwRWvlq'),
(21, 'CRYPTOMORPH', '2025-09-06 22:00:00', '2025-09-11 05:00:00', '68630d5203f1f_68630a57e8f7d_15954699.png', '68630d5203f25_video6.mp4', '68630d5203f24_Captura de ecrã 2025-06-30 224617.png', 'Anyma;SYS!FAULT; K-TRAXX', 'https://youtu.be/lIdrRRofKm0?si=GfpDH9NMOYLwM2-4'),
(22, 'BLOOD TEMPO', '2025-11-17 22:00:00', '2025-11-19 06:00:00', '68630da0ad2d6_6840ef2ef23d1_0phase-removebg-preview - Cópia.png', '68630da0ad2dc_video4.mp4', '68630da0ad2db_68630af239c31_Captura de ecrã 2025-06-30 224545.png', 'Ø [Phase];LUMINAIRE; SILTGRAVITY; DELPHOS', 'https://www.youtube.com/live/o2FFsovUGWE?si=YQxxuUE_G-qw70-R'),
(23, 'OBELISK SOUND', '2025-12-24 22:20:00', '2025-12-26 05:20:00', '68630de57306b_6840ee74b7934_Credit-Soraya-Sanini-1-e1607370385976-removebg-preview - Cópia.png', '68630de573070_video1.mp4', '68630de57306f_Captura de ecrã 2025-06-30 224452.png', 'I Hate Models;OBSERVA; VARINTH; ECHOMORPH', 'https://youtu.be/8CT6HxYA0cg?si=Z4gmngBtT0HajAbr');

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) DEFAULT NULL,
  `resposta` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `faq` (`id`, `titulo`, `resposta`) VALUES
(1, 'Como posso comprar bilhetes?', 'Os bilhetes podem ser adquiridos online através do nosso site ou na bilheteira no dia do evento.'),
(2, 'Qual é a idade mínima para entrar?', 'A idade mínima para entrada é 18 anos. É necessário apresentar documento de identificação.'),
(3, 'Há estacionamento disponível?', 'Sim, temos estacionamento gratuito para os participantes durante o evento.'),
(4, 'Aceitam pagamentos por MB Way?', 'Sim, aceitamos pagamentos por MB Way, multibanco, e cartões de crédito.'),
(5, 'O evento tem acessibilidade para pessoas com mobilidade reduzida?', 'Sim, o espaço está adaptado para pessoas com mobilidade reduzida.'),
(6, 'Posso levar comida ou bebida?', 'Não é permitido entrar com comida ou bebida. Temos bares e food trucks no local.'),
(7, 'Os animais de estimação são permitidos?', 'Infelizmente, não é permitida a entrada de animais, exceto cães-guia.'),
(8, 'Que tipo de música será tocada?', 'O evento é focado em música eletrónica, especialmente techno e house.'),
(9, 'Como posso entrar em contacto com a organização?', 'Pode contactar-nos através do formulário no site ou pelo e-mail geral@h3xeventos.com.'),
(10, 'Há zona VIP?', 'Sim, temos zonas VIP com serviços exclusivos. Pode reservar antecipadamente no nosso site.'),
(11, 'Há guarda-roupa no local?', 'Sim, há serviço de guarda-roupa com um custo adicional simbólico.'),
(12, 'O evento é cancelado em caso de chuva?', 'Não, o evento acontece em espaço coberto e não será afetado pela chuva.'),
(13, 'Como posso ser voluntário?', 'Pode candidatar-se como voluntário através da nossa página de recrutamento no site.'),
(14, 'Que roupa devo usar?', 'Sugerimos roupas confortáveis e estilosas. O tema é urbano e moderno.'),
(15, 'Há reembolsos disponíveis?', 'Bilhetes não são reembolsáveis, exceto em caso de cancelamento do evento.');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `imagens_galeria` (`id`, `titulo`, `imagem`, `aprovado`, `data_upload`, `id_utilizador`) VALUES
(1, 'O logo é brutal', '68401d9212490_borboleta2 3.png', 1, '2025-06-04 10:18:00', 1),
(2, 'Dj que vi esta noite', '68401e4d12195_c4e91c8cac4159f5f73369a2e8a987d5-removebg-preview.png', 1, '2025-06-04 10:21:00', 11),
(3, 'Old school h3x', '68528a426ecaa_Captura de ecrã 2025-03-25 093759.png', 1, '2025-06-18 09:42:00', 10),
(4, 'Definição desta disco', '68528baa11c7e_Captura de ecrã 2025-05-13 130040.png', 1, '2025-06-18 09:46:00', 15),
(5, 'Foi uma boa noite', '686302f71e367_pexels-cottonbro-10188456.jpg', 1, '2025-06-30 21:13:00', 14),
(6, 'bar é muito bom', '68630346771de_pexels-rdne-6174011.jpg', 1, '2025-06-30 21:34:00', 12),
(7, 'Uns copos com o meu amigo', '6863035e3c074_pexels-mart-production-7270917.jpg', 1, '2025-06-30 21:36:00', 4),
(8, 'Este dj tem aura', '6863036e01cc9_pexels-gustavo-h-328143-922322.jpg', 1, '2025-06-30 21:36:00', 1),
(10, 'Dj que vi esta noite', '68401e4d12195_c4e91c8cac4159f5f73369a2e8a987d5-removebg-preview.png', 1, '2025-06-04 10:21:00', 11),
(35, 'Sempre adorei este bar', '6863040948ba0_pexels-chanwalrus-941864.jpg', 1, '2025-06-30 21:39:00', 8),
(36, 'Esta vibe meu deus', '6863042943f3c_pexels-maxandrey-1979252.jpg', 1, '2025-06-30 21:39:00', 28),
(37, 'concerto hype', '68630442b8a42_pexels-doubleseven-736355.jpg', 1, '2025-06-30 21:40:00', 9),
(38, 'Eu na noite passada', '686304a75a79f_pexels-mediocrememories-2240772.jpg', 1, '2025-06-30 21:41:00', 4),
(39, 'Amigos para sempre', '686304bacd831_pexels-yankrukov-9005485.jpg', 1, '2025-06-30 21:42:00', 15),
(40, 'Dj americano?', '686304c997974_pexels-maumascaro-1716400.jpg', 1, '2025-06-30 21:42:00', 12);


CREATE TABLE IF NOT EXISTS `servicos_vip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `servicos_vip` (`id`, `titulo`, `imagem`, `criado_em`) VALUES
	(1, 'Estacionamento VIP Gratuito', 'car.png', '2025-05-14 21:57:30'),
	(2, '2 Garrafas Premium', 'Garrafa.png', '2025-05-14 21:57:30'),
	(4, 'Conhece os DJs', 'Dj.png', '2025-06-05 12:24:12'),
	(5, 'Zona VIP Reservada', 'Conforto.png', '2025-06-18 11:12:51');

CREATE TABLE IF NOT EXISTS `mesas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(15) NOT NULL,
  `capacidade` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `mesas` (`id`, `nome`, `capacidade`) VALUES
	(1, 'Mesa 1', 4),
	(2, 'Mesa 2', 6),
  (3, 'Mesa 3', 4),
	(4, 'Mesa 4', 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `vip` (`id`, `id_mesa`, `mensagem`, `data_reserva`, `id_utilizador`) VALUES
    (1, 1, 'Reserva para o aniversário de João', '2025-05-10', 1),
    (2, 2, NULL, '2025-06-12', 2),
    (3, 1, 'Jantar de negócios - Pedro Silva', '2025-06-12', 16),
    (4, 3, NULL, '2025-06-15', 10),
    (5, 2, 'Olá António, reserva confirmada', '2025-06-17', 15),
    (6, 2, NULL, '2025-06-25', 13),
    (7, 3, 'Reserva para jantar de despedida', '2025-06-02', 9),
    (8, 4, NULL, '2025-07-01', 15),
    (9, 2, 'Reunião com clientes importantes', '2025-07-03', 8),
    (10, 3, NULL, '2025-07-05', 7),
    (11, 1, 'Noite especial para o Pedro', '2025-07-10', 14),
    (12, 4, NULL, '2025-07-12', 3),
    (13, 1, 'Reserva para grupo de amigos', '2025-07-15', 11),
    (14, 2, NULL, '2025-07-18', 3),
    (15, 3, 'Reunião de projeto com a equipa', '2025-07-20', 5);


DROP TABLE IF EXISTS `comentarios_post`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `comentarios_post` AS select `comentarios`.`id` AS `ID`,`comentarios`.`conteudo` AS `Conteúdo`,`comentarios`.`data_criacao` AS `Data/Hora`,`posts`.`id` AS `ID Post`,`posts`.`titulo` AS `Título Post`,`utilizadores`.`nome` AS `Nome` from ((`comentarios` join `posts` on((`comentarios`.`id_post` = `posts`.`id`))) join `utilizadores` on((`comentarios`.`id_utilizador` = `utilizadores`.`id`)))
;

DROP VIEW IF EXISTS `contatos_detalhada`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `contatos_detalhada` AS SELECT id AS ID,nome AS Nome,email AS Email,telefone AS Telefone,mensagem AS Mensagem FROM contactos
;

DROP TABLE IF EXISTS `imagens_por_aprovar`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `imagens_por_aprovar` AS select `imagens_galeria`.`id` AS `ID`,`imagens_galeria`.`titulo` AS `Título`,`imagens_galeria`.`imagem` AS `Imagem`,`imagens_galeria`.`data_upload` AS `Data/Hora`,`imagens_galeria`.`aprovado` AS `Aprovação`,`utilizadores`.`nome` AS `Nome` from (`imagens_galeria` join `utilizadores` on((`imagens_galeria`.`id_utilizador` = `utilizadores`.`id`))) where (`imagens_galeria`.`aprovado` = false)
;

DROP TABLE IF EXISTS `posts_por_aprovar`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `posts_por_aprovar` AS select `posts`.`id` AS `ID`,`posts`.`titulo` AS `Título`,`posts`.`conteudo` AS `Conteúdo`,`posts`.`data_criacao` AS `Data/Hora`,`posts`.`aprovado` AS `Aprovação`,`utilizadores`.`nome` AS `Nome`,`categorias_posts`.`nome` AS `Categoria` from ((`posts` join `utilizadores` on((`posts`.`id_utilizador` = `utilizadores`.`id`))) join `categorias_posts` on((`posts`.`id_categoria` = `categorias_posts`.`id`))) where (`posts`.`aprovado` = false)
;

DROP TABLE IF EXISTS `reservas_vip`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `reservas_vip` AS select `vip`.`id` AS `ID`,`mesas`.`nome` AS `Mesa`,`mesas`.`capacidade` AS `Capacidade`,`vip`.`mensagem` AS `Mensagem`,`vip`.`data_reserva` AS `Data`,`utilizadores`.`nome` AS `Nome` from ((`vip` join `mesas` on((`vip`.`id_mesa` = `mesas`.`id`))) join `utilizadores` on((`vip`.`id_utilizador` = `utilizadores`.`id`)))
;

DROP TABLE IF EXISTS `utilizadores_ativos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `utilizadores_ativos` AS select `utilizadores`.`id` AS `ID`,`utilizadores`.`nome` AS `Nome`,`utilizadores`.`tipo` AS `Tipo`,`utilizadores`.`ultima_atividade` AS `Ultima` from `utilizadores` where (`utilizadores`.`estado` = 'a')
;

