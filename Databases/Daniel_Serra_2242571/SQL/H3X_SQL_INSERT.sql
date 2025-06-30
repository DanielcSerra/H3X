USE H3X;

INSERT INTO utilizadores (nome, email, telefone, password, data_nascimento, tipo, estado, ultima_atividade)
VALUES 
('João Silva', 'joao.silva@gmail.com', '912345678', 'senha123', '1990-05-15', 'c', 'a', CURRENT_TIMESTAMP),
('Maria Oliveira', 'maria.oliveira@gmail.com', '913456789', 'senha123', '1985-03-20', 'f', 'd', CURRENT_TIMESTAMP),
('Carlos Almeida', 'carlos.almeida@gmail.com', '914567890', 'senha123', '1980-07-30', 'a', 'a', CURRENT_TIMESTAMP);

INSERT INTO categorias_posts (nome)
VALUES 
('Notícias'),
('Eventos Semanais'),
('Outros');

INSERT INTO posts (titulo, conteudo, id_utilizador, id_categoria)
VALUES 
('Nova Noite Temática: Anos 80', 'Prepare-se para uma noite nostálgica com os maiores hits dos anos 80! Não perca esta experiência única no H3X.', 1, 1),  
('DJ Internacional no H3X', 'O DJ X estará ao vivo no H3X nesta sexta-feira, trazendo os maiores sucessos do momento. Não fique de fora!', 2, 2),  
('Decoração do H3X para o Verão', 'O H3X está se preparando para o verão com uma nova decoração vibrante e cheia de cores! Venha conferir!', 3, 3);  

INSERT INTO comentarios (conteudo, id_post, id_utilizador)
VALUES 
('Essa noite temática dos anos 80 vai ser demais! Mal posso esperar!', 1, 2), 
('Vai ser incrível ver o DJ X no H3X! Já estou contando os dias!', 2, 1),  
('Adorei a nova decoração! O H3X sempre arrasa nos detalhes!', 3, 2);  

INSERT INTO imagens_galeria (titulo, imagem, aprovado, id_utilizador)
VALUES 
('Foto do evento 1', 'evento1_imagem.jpg', TRUE, 1),
('Foto do evento 2', 'evento2_imagem.jpg', FALSE, 2),
('Foto do DJ no palco', 'dj_palco.jpg', TRUE, 3);

-- Utilizador autenticado

INSERT INTO contactos (mensagem, id_utilizador)
VALUES 
('Quero saber mais sobre os eventos.', 1);

-- Utilizador não autenticado

INSERT INTO contactos (nome, email, telefone, mensagem) 
VALUES 
('José Faria','josefaria@gmail.com','912345678','Gostaria de fazer uma reserva para a mesa VIP.');

INSERT INTO mesas (nome, capacidade)
VALUES 
('Mesa 1', 4),
('Mesa 2', 6);

INSERT INTO vip (id_mesa, mensagem, data_reserva, id_utilizador)
VALUES 
(1, 'Reserva para o aniversário de João', '2025-05-10', 1),
(2, 'Reserva para evento VIP', '2025-06-12', 2);

INSERT INTO vip_mesas (id_vip, id_mesas)
VALUES
(1, 1),
(2, 2);

INSERT INTO djs (nome, imagem, video)
VALUES 
('DJ Tiesto', 'tiesto.jpg', 'tiesto_video.mp4'),
('Armin van Buuren', 'armin.jpg', 'armin_video.mp4');

INSERT INTO eventos (titulo, data_inicio, data_fim, hora_inicio, hora_fim, id_utilizador)
VALUES 
('Festival de Música Eletrônica', '2025-05-15', '2025-05-16', '22:00:00', '06:00:00', 3),
('Noite Escura', '2025-06-01', '2025-06-01', '09:00:00', '18:00:00', 3);

INSERT INTO categorias_eventos (nome)
VALUES 
('Techno'),
('House Music');

INSERT INTO eventos_djs (id_evento, id_dj)
VALUES 
(1, 1),
(1, 2);

INSERT INTO eventos_categorias (id_evento, id_categoria)
VALUES 
(1, 1),
(2, 2);