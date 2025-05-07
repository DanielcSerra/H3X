USE H3X;

INSERT INTO Utilizadores (id_utilizador, nome_utilizador, tipo)
VALUES
(1, 'Rita Fernandes', 'cliente'),
(2, 'Bruno Carvalho', 'admin'),

INSERT INTO Contactos (telefone, email, id_utilizador)
VALUES
('919876543', 'rita.fernandes@mail.com', 1),
('926543210', 'bruno.moreira@mail.com', 2);

INSERT INTO Categoriapost (id_categoria, nome_categoria)
VALUES
(1, 'Atualizações'),
(2, 'Line-ups'),
(3, 'Curiosidades');

INSERT INTO Posts (id_post, titulo, conteudo, data, aprovado_reprovado, id_utilizador, id_categoria)
VALUES
(1, 'Novo Som Ambiente', 'Instalamos um sistema de som 360º. Experiência imersiva garantida!', '2025-04-10 19:30:00', TRUE, 2, 1),
(2, 'Line-up de Sábado Confirmado', 'DJ Karma, DJ Flow e DJ Nite sobem ao palco neste sábado.', '2025-04-12 18:00:00', TRUE, 3, 2),
(3, 'Sabias que...', 'O nosso palco principal tem LEDs com mais de 1 milhão de cores.', '2025-04-15 21:45:00', FALSE, 2, 3);

INSERT INTO Comentarios (id_comentario, conteudo, id_utilizador, id_post)
VALUES
(1, 'Mal posso esperar para ouvir esse novo sistema de som ao vivo!', 1, 1),
(2, 'Line-up de respeito! Vai ser uma noite épica.', 1, 2),
(3, 'Uau, não fazia ideia dos LEDs! Muito fixe!', 3, 3);

INSERT INTO Galeria (id_galeria, imagem, data, titulo, id_utilizador)
VALUES
(1, 'ambiente_som.jpg', '2025-04-10 22:00:00', 'Nova iluminação e som', 2),
(2, 'lineup_sabado.jpg', '2025-04-12 23:15:00', 'Noite de Sábado', 3),
(3, 'palco_leds.jpg', '2025-04-15 21:50:00', 'Curiosidade sobre o palco', 2);

INSERT INTO Mesas (id_mesa, nome, capacidade)
VALUES
(1, 'Mesa Sunset', 5),
(2, 'Mesa Vibe', 8);

INSERT INTO Vip (id_vip, mensagem, id_utilizador, id_mesa)
VALUES
(1, 'Gostaria de reservar para a comemoração de aniversário.', 1, 1),
(2, 'Mesa para grupo fechado de 8 pessoas no dia 15.', 3, 2);

INSERT INTO VIP_Mesas (Id_vip, Id_mesa)
VALUES
(1, 1),
(2, 2);

INSERT INTO DJS (ID_djs, Video, Foto, nome_dj)
VALUES
(1, 'karma_live.mp4', 'karma.jpg', 'DJ Karma'),
(2, 'flow_mix.mp4', 'flow.jpg', 'DJ Flow');

INSERT INTO Eventos (id_evento, Data, Horas, Imagem, nome_evento)
VALUES
(1, 20250420, 2200, 'event_spring.jpg', 'Spring Sounds'),
(2, 20250505, 2100, 'event_night.jpg', 'Midnight Bass');

INSERT INTO Categoriaevento (id_categoria, nome_categoria)
VALUES
(1, 'Electro House'),
(2, 'Progressive');

INSERT INTO Evento_Categoria (Id_evento, Id_categoria)
VALUES
(1, 1),
(2, 2);

INSERT INTO DJS_Eventos (Id_djs, Id_eventos)
VALUES
(1, 1),
(2, 2);