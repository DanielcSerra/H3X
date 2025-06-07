<?php
session_start();
 
require_once("db_config.php");
require_once "admin/ultima_atividade.php";

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
            <a href="#formulario" class="botao-link">
                <div class="botao">
                    <img src="img/caixabranca.png">
                    <h2>FORMULARIO</h2>
                </div>
            </a>
        </div>
    </div>


    <div class="imagem-topo">
        <img src="img/before.png" width="100%" atl="Barra decorativa">
    </div>

    <section class="staff-section">
        <div class="staff2">
            <h3 class="titulo-staff">BENEFÍCIOS VIP</h3>
            <div class="staff-imagens">
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                <div class="staff-item">
                    <img src="img/<?php echo trim($row['imagem']); ?>" alt="<?php echo trim($row['titulo']); ?>"
                        style="height: 500px; object-fit: contain;">
                    <h3><?php echo trim($row['titulo']); ?></h3>
                </div>
                <?php
                    }
                } else {
                    echo "<p>Nenhum benefício VIP encontrado.</p>";
                }
                ?>
            </div>
            <div class="botao-form-Reservar d-flex justify-content-center">
                <button type="submit" class="botao-reservar-form text-black">
                    RESERVAR
                </button>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-6 imagemplanta">
                <img src="img/MAPA H3X 1.png" alt="Planta Discoteca">
            </div>
            <div class="col-md-6 formulario">
                <h4>FORMULÁRIO DE RESERVA</h4>
                <form>
                    <div class="mb-3 ">
                        <label for="name" class="form-label">NOME</label>
                        <input type="text" class="form-control" id="name" placeholder="Escreva o seu nome">
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">TELEFONE</label>
                        <input type="tel" class="form-control" id="Telefone" placeholder="Escreva o seu número">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Escreva o seu email" required>
                    </div>
                    <div class="mb-3">
                        <label for="dataReserva" class="form-label">DATA DA RESERVA</label>
                        <input type="date" class="form-control" id="dataReserva" name="dataReserva"
                            placeholder="Indique a sua reserva" required>
                    </div>
                    <div class="mb-3">
                        <label for="mesa" class="form-label">ESCOLHA A SUA MESA</label>
                        <select class="form-select" id="mesa" name="mesa" required>
                            <option value="" disabled selected>Selecione uma mesa</option>
                            <option value="1">Mesa 1</option>
                            <option value="2">Mesa 2</option>
                            <option value="3">Mesa 3</option>
                            <option value="3">Mesa 4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mensagem" class="form-label">MENSAGEM</label>
                        <textarea class="form-control" id="mensagem" name="mensagem" rows="4"
                            placeholder="Escreva uma mensagem"></textarea>
                    </div>
                    <div class="botao-form-Reservar d-flex justify-content-center">
                        <button type="submit" class="botao-reservar-form">
                            RESERVAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
<?php include 'partials/footer.php'; ?>