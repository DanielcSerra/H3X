<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

require_once "../db_config.php";
require_once 'ultima_atividade.php';

$nomeUtilizador = $_SESSION["nome"] ?? "Utilizador";
$tipoUtilizador = $_SESSION["tipo"] ?? "c";

switch ($tipoUtilizador) {
    case 'a':
        $tipoLabel = "Administrador";
        break;
    case 'f':
        $tipoLabel = "Funcionário";
        break;
    default:
        $tipoLabel = "Cliente";
        break;
}

$utilizadores = $conn->query("SELECT id, nome FROM utilizadores");
$categorias = $conn->query("SELECT id, nome FROM categorias_posts");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["errors"] = [];

    $titulo = isset($_POST["titulo"]) ? trim($_POST["titulo"]) : "";
    $conteudo = isset($_POST["conteudo"]) ? trim($_POST["conteudo"]) : "";
    $aprovado = isset($_POST["aprovado"]) ? '1' : '0';
    $id_utilizador = $_POST["id_utilizador"] ?? "";
    $id_categoria = $_POST["id_categoria"] ?? "";

    if (strlen($titulo) == 0)
        $_SESSION["errors"]["titulo"] = "Título inválido";
    if (strlen($conteudo) == 0)
        $_SESSION["errors"]["conteudo"] = "Conteúdo inválido";
    if (strlen($id_utilizador) == 0)
        $_SESSION["errors"]["id_utilizador"] = "Utilizador inválido";
    if (strlen($id_categoria) == 0)
        $_SESSION["errors"]["id_categoria"] = "Categoria inválida";
    if (!isset($_FILES["imagem"]) || $_FILES["imagem"]["error"] !== 0) {
        $_SESSION["errors"]["imagem"] = "Imagem obrigatória";
    }

    if (count($_SESSION["errors"]) === 0) {
        $titulo = mysqli_real_escape_string($conn, $titulo);
        $conteudo = mysqli_real_escape_string($conn, $conteudo);
        $id_utilizador = mysqli_real_escape_string($conn, $id_utilizador);
        $id_categoria = mysqli_real_escape_string($conn, $id_categoria);

        $dirUpload = "../uploads";
        if (!is_dir($dirUpload))
            mkdir($dirUpload, 0777, true);
        $timestamp = date("Y-m-d_H-i-s");
        $extensao = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
        $imagemNome = uniqid() . "_" . $timestamp . "." . $extensao;
        move_uploaded_file($_FILES["imagem"]["tmp_name"], "$dirUpload/$imagemNome");

        $sql = "INSERT INTO posts (titulo, conteudo, data_criacao, aprovado, id_utilizador, id_categoria, imagem)
                VALUES ('$titulo', '$conteudo', NOW(), '$aprovado', '$id_utilizador', '$id_categoria', '$imagemNome')";

        if ($conn->query($sql)) {
            $_SESSION["success"] = "Post criado com sucesso.";
            header("Location: admin_posts.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao inserir post: " . $conn->error;
        }
    }
}
$pageTitle = "H3X ADMIN - Criar Post";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-plus me-2"></i>Criar Post</h1>
                <a href="admin_posts.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
            if (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $msg) {
                    echo "<div class='alert alert-danger'>$msg</div>";
                }
                unset($_SESSION["errors"]);
            }
            ?>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm w-100"
                        style="max-width:600px;">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" required maxlength="20"
                                title="O título deve no maximo 20 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label for="conteudo" class="form-label">Conteúdo</label>
                            <textarea class="form-control" name="conteudo" id="conteudo" rows="10" required
                                minlength="10" title="Mínimo 10 caracteres"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            <input type="file" class="form-control" name="imagem" id="imagem" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_utilizador" class="form-label">Utilizador</label>
                            <select class="form-select" name="id_utilizador" id="id_utilizador" required>
                                <option value="">Escolher utilizador</option>
                                <?php while ($u = $utilizadores->fetch_assoc()): ?>
                                    <option value="<?= $u['id'] ?>"><?= trim($u['nome']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_categoria" class="form-label">Categoria</label>
                            <select class="form-select" name="id_categoria" id="id_categoria" required>
                                <option value="">Escolher categoria</option>
                                <?php while ($c = $categorias->fetch_assoc()): ?>
                                    <option value="<?= $c['id'] ?>"><?= trim($c['nome']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <?php
                        $utilizadores->free();
                        $categorias->free();
                        $conn->close();
                        ?>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="aprovado" id="aprovado" value="1">
                            <label class="form-check-label" for="aprovado">Aprovado</label>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Criar Post
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <?php require 'partials/footer.php'; ?>
        </div>
    </div>
    <script>
        document.getElementById(' postForm').addEventListener('submit', function (submitEvent) {
            const
                titulo = document.getElementById('titulo').value.trim(); const
                    conteudo = document.getElementById('conteudo').value.trim(); const
                        imagem = document.getElementById('imagem').files.length; const
                            utilizador = document.getElementById('id_utilizador').value; const
                                categoria = document.getElementById('id_categoria').value; if (titulo.length < 5 ||
                                    titulo.length > 20) {
                alert("O título deve ter entre 5 e 20 caracteres.");
                submitEvent.preventDefault();
                return;
            }

            if (conteudo.length < 10) {
                alert("O conteúdo deve ter pelo menos 10 caracteres.");
                submitEvent.preventDefault(); return;
            } if (imagem === 0) {
                alert("Escolha uma imagem.");
                submitEvent.preventDefault(); return;
            } if (utilizador === "") {
                alert("Escolha um utilizador.");
                submitEvent.preventDefault(); return;
            } if (categoria === "") {
                alert("Escolha uma categoria.");
                submitEvent.preventDefault(); return;
            }
        }); </script>
</body>

</html>