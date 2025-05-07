CREATE VIEW utilizadores_online AS
SELECT id, nome, email, telefone
FROM utilizadores
WHERE estado = 'online';

CREATE VIEW posts_aprovados AS
SELECT posts.id, posts.titulo, posts.conteudo, posts.data, utilizadores.nome AS nome_utilizador, categorias_post.nomecat AS categoria
FROM posts
JOIN utilizadores ON posts.id_utilizador = utilizadores.id
JOIN categorias_post ON posts.id_categoria = categorias_post.id
WHERE posts.aprovadoreprovado = 'aprovado';

CREATE VIEW galeria_aprovada AS
SELECT galeria.id, galeria.titulo, galeria.imagem, galeria.data_upload, utilizadores.nome AS nome_utilizador
FROM galeria
JOIN utilizadores ON galeria.id_utilizador = utilizadores.id;

CREATE VIEW reservas_vip AS
SELECT vip.id, vip.instagram, vip.data_nasc, vip.mensagem, vip.mesa_preferida, utilizadores.nome AS nome_utilizador
FROM vip
JOIN mesa ON vip.mesa_preferida = mesa.id
JOIN utilizadores ON vip.id_utilizador = utilizadores.id;

CREATE VIEW eventos_com_dj_e_categoria AS
SELECT eventos.id, eventos.titulo, eventos.descricao, eventos.hora_inicio, eventos.hora_fim, eventos.data_inicio, eventos.data_fim, categoria_evento.nomecat AS categoria_evento, dj.nome AS nome_dj
FROM eventos
JOIN categoria_evento ON eventos.id_categoria = categoria_evento.id
JOIN dj ON eventos.id_dj = dj.id;








