INSERT INTO utilizadores (nome, email, telefone, tipo, estado, ultima_atividade)
VALUES
('João Silva', 'joao.silva@email.com', '912345678', 'cliente', 'online', NOW()),
('Maria Oliveira', 'maria.oliveira@email.com', '913456789', 'funcionário', 'offline', NOW()),
('Carlos Costa', 'carlos.costa@email.com', '914567890', 'administrador', 'online', NOW()); 

INSERT INTO categorias_post (nomecat)
VALUES ('Notícias'), ('Eventos'), ('Promoções');


INSERT INTO posts (titulo, conteudo, data, aprovadoreprovado, id_utilizador, id_categoria)
VALUES
('Abertura do novo espaço VIP', 'Venham ver o nosso novo espaço VIP para clientes exclusivos!', NOW(), 'Aprovado', '3', '1'),
('Próximo evento com DJ SNTS', 'Prepare-se para a melhor festa da cidade com o DJ SNTS na próxima sexta-feira!', NOW(), 'Aprovado', '2', '2'),
('Promoção de bebidas', '50% de desconto em todas as bebidas durante a as 22h e a meia noite!', NOW(), 'Aprovado', '1', '3');


INSERT INTO comentarios (conteudo, data, id_post, id_utilizador)
VALUES
('O espaço VIP está mesmo incrível! Recomendo a todos!', NOW(), '11', '1'),
('DJ SNTS nunca desaponta, mal posso esperar!', NOW(), '12', '2'),
('Promoções assim deviam ser todos os dias!', NOW(), '13', '3');


INSERT INTO galeria (titulo, imagem, data_upload, id_utilizador)
VALUES
('Festa de Aniversário', 'evento_vip_1.jpg', NOW(), 3),
('Festa com o DJ SNTS', 'evento_dj_SNTS.jpg', NOW(), 2);


INSERT INTO mesa (numero, capacidade)
VALUES
('A1', 4),
('B2', 6),
('C3', 2);


INSERT INTO vip (instagram, data_nasc, mensagem, mesa_preferida, id_utilizador)
VALUES 
('@joao_vip', '1990-05-21', 'Mesa com vista para o DJ.', '1', '1'),        
('@maria_vip', '1985-12-10', 'Mesa no canto mais reservado.', '2', '2'),   
('@carlos_vip', '1988-07-15', 'Mesa próxima do bar.', '3', '3');           



INSERT INTO categoria_evento (nomecat)
VALUES ('Festa'), ('Concerto'), ('Afterwork');



INSERT INTO dj (nome, foto, video)
VALUES
('DJ SNTS', 'dj_snts.jpg', 'dj_snts_video.mp4'),
('DJ DJ I Hate Models', 'dj_Models.jpg', 'dj_Models_video.mp4');


INSERT INTO eventos (titulo, descricao, hora_inicio, hora_fim, data_inicio, data_fim, id_categoria, id_dj)
VALUES
('Noite de Techno', 'Uma noite intensa com batidas techno e DJ SNTS no comando!', '2025-06-10 22:00:00', '2025-06-11 03:00:00', '2025-06-10', '2025-06-11', '1', '2'),
('Techno Night Vibes', 'Prepare-se para uma noite eletrizante com os melhores sons techno ao vivo com DJ SNTS!', '2025-06-14 18:00:00', '2025-06-14 22:00:00', '2025-06-14', '2025-06-14', '3', '1'),
('Underground Techno Session', 'Explore o som profundo do techno underground com DJ SNTS numa noite inesquecível!', '2025-06-21 20:00:00', '2025-06-21 23:00:00', '2025-06-21', '2025-06-21', '2', '2');

