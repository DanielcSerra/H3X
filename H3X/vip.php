<?php
session_start();

require_once("db_config.php");
require_once "admin/ultima_atividade.php";

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mesa = $_POST['id_mesa'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';
    $data_reserva = $_POST['data_reserva'] ?? '';
    $id_utilizador = $_SESSION['id'] ?? null;

    if (!$id_mesa || !$data_reserva) {
        $_SESSION['errors'][] = "Por favor preencha os campos obrigatórios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO vip (id_mesa, mensagem, data_reserva, id_utilizador) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $id_mesa, $mensagem, $data_reserva, $id_utilizador);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Reserva efetuada com sucesso!";
            header("Location: vip.php#formulario");
            exit();
        } else {
            $_SESSION['errors'][] = "Erro ao efetuar reserva: " . $stmt->error;
        }
    }
}

$sql = "SELECT * FROM servicos_vip";
$result = $conn->query($sql);
?>
<?php include 'partials/head.php'; ?>
<title>H3X - Pagina</title>
<link rel="stylesheet" href="css/vip.css">
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
                        da noite, este é o lugar para estar.</p>
                    <p class="segun">Vem e descobre o que significa viver a verdadeira experiência VIP na H3X!</p>
                    <p class="terc">Junta os teus amigos, e diverte-te próximo dos teus DJs e artistas
                        favoritos. Garante a tua reserva através do nosso contacto telefónico, pelas nossas redes
                        sociais ou através do formulário.</p>
                </div>
            </div>
        </section>
    </div>

    <div class="container">
        <div class="form-botao">
            <a href="#formulario" class="botao-link">
                <div class="botao">
                    <img src="img/caixabranca.png">
                    <h2>FORMULÁRIO</h2>
                </div>
            </a>
        </div>
    </div>

    <div class="imagem-topo">
        <img src="img/before.png" width="100%" alt="Barra decorativa">
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
                        style="height: 450px; object-fit: contain;">
                    <h3><?php echo trim($row['titulo']); ?></h3>
                </div>
                <?php
                    }
                } else {
                    echo "<p>Nenhum benefício VIP encontrado.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-6 imagemplanta mb-4">
                <img src="img/MAPA H3X 1.png" alt="Planta Discoteca" class="img-fluid">
            </div>
            <div class="col-md-6 formulario" id="formulario">
                <h4>FORMULÁRIO DE RESERVA</h4>

                <?php if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true): ?>
                <div class="text-center mt-3 mb-4">
                    <p>Para efetuar uma reserva, por favor <a href="admin/login.php">faça login</a>.</p>
                </div>
                <?php else: ?>
                <form action="#formulario" method="post">
                    <div class="mb-3">
                        <label for="data_reserva" class="form-label">DATA DA RESERVA</label>
                        <input type="date" class="form-control" id="data_reserva" name="data_reserva"
                            placeholder="Indique a sua reserva" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_mesa" class="form-label">ESCOLHA A SUA MESA</label>
                        <select class="form-select" id="id_mesa" name="id_mesa" required>
                            <option value="" disabled selected>Selecione uma mesa</option>
                            <option value="1">Mesa 1</option>
                            <option value="2">Mesa 2</option>
                            <option value="3">Mesa 3</option>
                            <option value="4">Mesa 4</option>
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
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
<?php include 'partials/footer.php'; ?>