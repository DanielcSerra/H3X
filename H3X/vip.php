<?php
session_start();
?>
<?php
// 1. Conexão com o banco de dados
require_once("db_config.php");

// 2. Consulta os dados
$sql = "SELECT * FROM servicos_vip";
$result = $conn->query($sql);
?>
<?php include 'partials/head.php'; ?>
<title>H3X - Pagina</title>
<link rel="stylesheet" href="css/vip.css"> <!-- CSS AQUI -->
</head>

<body>
    <?php include 'partials/navbar.php'; ?>

    <div class="Parte1">
        <h1 class="terceiro">ZONA VIP</h1>
        <h1 class="segundo">ZONA VIP</h1>
        <h1 class="primeiro">ZONA VIP</h1>
    </div>

    <div class="container">
        <section>
            <div class="textodepois">
                <div class="text1">
                    <p class="prim">A zona VIP da H3X é o local onde a festa se torna pessoal e onde cada
                        momento se transforma numa memória inesquecível. Se procuras a melhor forma de desfrutar
                        da
                        noite, este é o lugar para estar.
                    </p>
                    <p class="segun">Vem e descobre o que significa viver a verdadeira experiência VIP na
                        H3X!
                    </p>
                    <p class="terc">Junta os teus amigos, e diverte-te próximo dos teus DJs e artistas
                        favoritos. Garante a tua reserva através do nosso contacto telefónico, pelas nossas
                        redes
                        sociais ou através do formulário.
                    </p>
                </div>
            </div>
        </section>
    </div>
    <div class="container">
        <div class="form-botao">
            <div class="botao">
                <img src="img/caixabranca.png">
                <h2>FORMULARIO</h2>
            </div>
        </div>
    </div>


    <section>
        <div class="container">
            <div class="caixas">
                <h2 class="beneficios">BENEFÍCIOS VIP</h2>
                <div class="cartas2">
                    <div class="cartas-sobre-fundo">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="carta-bloco d-flex flex-column align-items-center">
                                <img src="uploads/<?php echo trim($row['imagem']); ?>" class="CARD img-fluid mb-2"
                                    alt="Card" style="height: 400px; object-fit: contain;">
                                <h3 class="text-center m-0"><?php echo trim($row['titulo']); ?></h3>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php $conn->close(); ?>
                <div class="botao-reservar">
                    <img src="img/Botao_Rese.png" alt="Botão Reservar">
                    <h2 class="texto-reservar">RESERVAR</h2>
                </div>
            </div>
        </div>
        <img src="img/before.png" class="before" alt="Carta 3">
        <img src="img/Ret_Branco.png" class="quadrado" alt="Carta 3">
    </section>

    <div class="container">
        <div class="formulario-container">
            <div class="mapa-area">
                <img src="img/MAPA H3X 1.png" class="imagem-fundo" alt="Mapa do estabelecimento">
            </div>
            <div class="formulario-area">
                <h1>FORMULÁRIO DE RESERVA</h1>
                <form action="#" method="post">
                    <label for="nome">Nome:</label><br>
                    <input type="text" id="nome" name="nome" required><br><br>

                    <label for="telefone">Telefone:</label><br>
                    <input type="tel" id="telefone" name="telefone" required><br><br>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="data_nascimento">Data de Nascimento:</label><br>
                    <input type="date" id="data_nascimento" name="data_nascimento" required><br><br>

                    <label for="mesa">Escolher a Mesa:</label><br>
                    <select id="mesa" name="mesa" required>
                        <option value="mesa1">Mesa 1</option>
                        <option value="mesa2">Mesa 2</option>
                        <option value="mesa3">Mesa 3</option>
                        <option value="mesa4">Mesa 4</option>
                    </select><br><br>

                    <label for="instagram">@ Instagram:</label><br>
                    <input type="text" id="instagram" name="instagram" required><br><br>

                    <label for="mensagem">Mensagem:</label><br>
                    <textarea id="mensagem" name="mensagem" rows="4" cols="50" required></textarea><br><br>

                    <!-- Botão de submit como imagem -->
                    <button type="submit" class="image-submit-button">
                        <img src="img/Botao_Reserv3.png" alt="Reservar">
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
<?php include 'partials/footer.php'; ?>