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

// Carregar posts e utilizadores para selects
$posts = $conn->query("SELECT id, titulo FROM posts");
$utilizadores = $conn->query("SELECT id, nome FROM utilizadores");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["errors"] = [];

    $conteudo = isset($_POST["conteudo"]) ? trim($_POST["conteudo"]) : "";
    $id_post = $_POST["id_post"] ?? "";
    $id_utilizador = $_POST["id_utilizador"] ?? "";

    if (strlen($conteudo) == 0)
        $_SESSION["errors"]["conteudo"] = "Conteúdo inválido";
    if (strlen($id_post) == 0)
        $_SESSION["errors"]["id_post"] = "Post inválido";
    if (strlen($id_utilizador) == 0)
        $_SESSION["errors"]["id_utilizador"] = "Utilizador inválido";

    if (count($_SESSION["errors"]) === 0) {
        $conteudo = mysqli_real_escape_string($conn, $conteudo);
        $id_post = mysqli_real_escape_string($conn, $id_post);
        $id_utilizador = mysqli_real_escape_string($conn, $id_utilizador);

        $sql = "INSERT INTO comentarios (conteudo, data_criacao, id_post, id_utilizador)
                VALUES ('$conteudo', NOW(), '$id_post', '$id_utilizador')";

        if ($conn->query($sql)) {
            $_SESSION["success"] = "Comentário criado com sucesso.";
            header("Location: admin_comentarios.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao inserir comentário: " . $conn->error;
        }
    }
}
$pageTitle = "H3X ADMIN - Criar Comentário";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-plus me-2"></i>Criar Comentário</h1>
                <a href="admin_comentarios.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
                    <form method="POST" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px;">

                        <div class="mb-3">
                            <label for="conteudo" class="form-label">Conteúdo</label>
                            <textarea class="form-control" name="conteudo" id="conteudo" rows="5" required minlength="5"
                                maxlength="500" title="O comentário deve ter entre 5 e 500 caracteres."><?= trim($comentario["conteudo"]) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="id_post" class="form-label">Post</label>
                            <select class="form-select" name="id_post" id="id_post" required>
                                <option value="">Escolher post</option>
                                <?php while ($p = $posts->fetch_assoc()): ?>
                                    <option value="<?= $p['id'] ?>"><?= trim($p['titulo']) ?></option>
                                <?php endwhile; ?>
                            </select>
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

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Criar Comentário
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <?php require 'partials/footer.php'; ?>
        </div>
    </div>
</body>

</html>