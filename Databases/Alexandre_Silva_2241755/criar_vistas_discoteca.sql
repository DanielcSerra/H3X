USE discoteca;

CREATE VIEW lista_utilizadores_ativos AS
SELECT * 
FROM Utilizadores 
WHERE estado = 'A' 
ORDER BY nome;

CREATE OR REPLACE VIEW lista_vips AS
SELECT *
FROM Reservas_VIPs
ORDER BY descricao;  

CREATE OR REPLACE VIEW lista_posts_recentes AS
SELECT * 
FROM Posts 
ORDER BY data_publicacao DESC;


CREATE OR REPLACE VIEW lista_comentarios_recentes AS
SELECT * 
FROM Comentarios 
ORDER BY data_criacao DESC;


CREATE OR REPLACE VIEW lista_fotos_por_data AS
SELECT * 
FROM Fotos 
ORDER BY data_upload DESC;