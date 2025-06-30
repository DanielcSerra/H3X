USE discoteca;


INSERT INTO Utilizadores (nome, email, tipo, password, estado, ultima_atividade, nif, telefone, morada)
VALUES ('João Silva', 'joao@email.com', 'N', 'senha123', 'A', NOW(), '123456789', '912345678', 'Rua das Flores, 123');


INSERT INTO Djs (nome, tipo_musica, email, morada)
VALUES ('DJ Beat', 'Techno', 'djbeat@email.com', 'Av. da Música, 45');


INSERT INTO Categorias_Posts (nome, id_utilizador)
VALUES ('Eventos Noturnos', 1);


INSERT INTO Posts (titulo, imagem, descricao, data_publicacao, id_utilizador, id_categoria)
VALUES ('Melhor noite do ano!', 'noite.jpg', 'Imagens da festa eletrônica', NOW(), 1, 1);


INSERT INTO Eventos (titulo, Data_Hora_Inicio, Data_Hora_Fim, id_utilizador)
VALUES ('Festival de Verão', '2025-08-01 18:00:00', '2025-08-02 02:00:00', 1);


INSERT INTO Participacoes (Data_Hora, id_dj, id_eventos)
VALUES ('2025-08-01 21:00:00', 1, 1);


INSERT INTO Fotos (titulo, descricao, tipo_arquivo, data_upload, confirmacao, id_utilizador, id_utilizador_aprovar)
VALUES ('Festa de Aniversário', 'Foto tirada durante o evento de comemoração.', 'jpg', NOW(), 'PV', 1, NULL);


INSERT INTO Contactos (nome, email, mensagem, assunto)
VALUES ('Maria Santos', 'maria@email.com', 'Gostaria de saber mais sobre o evento.', 'Informações sobre o evento');


INSERT INTO Comentarios (conteudo, titulo, data_criacao, id_utilizador, id_post)
VALUES ('Essa festa foi demais!', 'Comentário sobre a festa', NOW(), 1, 1);


INSERT INTO Reservas_VIPs (descricao, data_reserva, id_utilizador)
VALUES ('Reserva para Bruno Marques', NOW(), 1);