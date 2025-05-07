USE H3X;

CREATE VIEW utilizadores_ativos AS
SELECT 
    Utilizadores.id_utilizador AS ID,
    Utilizadores.nome_utilizador AS Nome,
    Utilizadores.tipo AS Tipo
FROM Utilizadores;

CREATE VIEW posts_aprovados_detalhe AS
SELECT 
    Posts.id_post AS ID,
    Posts.titulo AS Titulo,
    Posts.data AS "Data/Hora",
    Utilizadores.nome_utilizador AS Autor,
    Categoriapost.nome_categoria AS Categoria
FROM Posts
JOIN Utilizadores ON Posts.id_utilizador = Utilizadores.id_utilizador
JOIN Categoriapost ON Posts.id_categoria = Categoriapost.id_categoria
WHERE Posts.aprovado_reprovado = TRUE;

CREATE VIEW imagens_pendentes AS
SELECT 
    Galeria.id_galeria AS ID,
    Galeria.titulo AS Titulo,
    Galeria.imagem AS Imagem,
    Galeria.data AS "Data/Hora",
    Utilizadores.nome_utilizador AS Utilizador
FROM Galeria
JOIN Utilizadores ON Galeria.id_utilizador = Utilizadores.id_utilizador
WHERE Galeria.imagem IS NOT NULL;

CREATE VIEW reservas_vip_detalhada AS
SELECT 
    Vip.id_vip AS ID,
    Mesas.nome AS Mesa,
    Mesas.capacidade AS Capacidade,
    Vip.mensagem AS Mensagem,
    Utilizadores.nome_utilizador AS Cliente
FROM Vip
JOIN Mesas ON Vip.id_mesa = Mesas.id_mesa
JOIN Utilizadores ON Vip.id_utilizador = Utilizadores.id_utilizador;

CREATE VIEW eventos_djs_categorias AS
SELECT 
    Eventos.id_evento AS ID,
    Eventos.nome_evento AS Evento,
    DJS.nome_dj AS DJ,
    Categoriaevento.nome_categoria AS Categoria
FROM Eventos
JOIN DJS_Eventos ON Eventos.id_evento = DJS_Eventos.Id_eventos
JOIN DJS ON DJS_Eventos.Id_djs = DJS.ID_djs
JOIN Evento_Categoria ON Eventos.id_evento = Evento_Categoria.Id_evento
JOIN Categoriaevento ON Evento_Categoria.Id_categoria = Categoriaevento.id_categoria;