USE H3X;

CREATE VIEW utilizadores_ativos AS
SELECT 
utilizadores.id AS ID,
utilizadores.nome AS Nome,
utilizadores.tipo AS Tipo
FROM utilizadores
WHERE estado = 'a';

CREATE VIEW posts_por_aprovar AS
SELECT 
 posts.id AS ID,
 posts.titulo AS Título,
 posts.conteudo AS Conteúdo,
 posts.data_criacao AS "Data/Hora", 
 posts.aprovado AS Aprovação, 
 utilizadores.nome AS Nome, 
 categorias_posts.nome AS Categoria
FROM posts
JOIN utilizadores ON posts.id_utilizador = utilizadores.id
JOIN categorias_posts ON posts.id_categoria = categorias_posts.id
WHERE posts.aprovado = FALSE;

CREATE VIEW imagens_por_aprovar AS
SELECT 
imagens_galeria.id AS ID,
imagens_galeria.titulo AS Título,
imagens_galeria.imagem AS Imagem,
imagens_galeria.data_upload AS "Data/Hora",
imagens_galeria.aprovado AS Aprovação,
utilizadores.nome AS Nome
FROM imagens_galeria
JOIN utilizadores ON imagens_galeria.id_utilizador = utilizadores.id
WHERE imagens_galeria.aprovado = FALSE;

CREATE VIEW reservas_vip AS
SELECT 
vip.id AS ID,
mesas.nome AS Mesa,
mesas.capacidade AS Capacidade,
vip.mensagem AS Mensagem,
vip.data_reserva AS Data,
utilizadores.nome AS Nome
FROM vip
JOIN mesas ON vip.id_mesa = mesas.id
JOIN utilizadores ON vip.id_utilizador = utilizadores.id;

CREATE VIEW contatos_detalhada AS
SELECT 
contactos.id AS ID,
contactos.nome AS Nome,
contactos.email AS Email, 
contactos.telefone AS Telefone, 
contactos.mensagem AS Mensagem,
utilizadores.nome AS "Nome (Cliente)"
FROM contactos
LEFT JOIN utilizadores ON contactos.id_utilizador = utilizadores.id;

CREATE VIEW eventos_futuros AS
SELECT 
id AS ID,
titulo AS Título,
data_inicio AS "Data início",
data_fim AS "Data fim",
hora_inicio AS "Hora início", 
hora_fim AS "Hora fim"
FROM eventos
WHERE data_inicio >= CURDATE();

CREATE VIEW comentarios_post AS
SELECT 
comentarios.id AS ID,
comentarios.conteudo AS Conteúdo,
comentarios.data_criacao AS "Data/Hora",
posts.id AS "ID Post",
posts.titulo AS "Título Post",
utilizadores.nome AS Nome
FROM comentarios
JOIN posts ON comentarios.id_post = posts.id
JOIN utilizadores ON comentarios.id_utilizador = utilizadores.id;
