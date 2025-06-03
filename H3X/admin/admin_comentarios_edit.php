<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

require_once "../db_config.php";
require_once "ultima_atividade.php";

$nomeUtilizador = $_SESSION["nome"] ?? "Utilizador";
$tipoUtilizador = $_SESSION["tipo"] ?? "c";

$tipoLabel = match ($tipoUtilizador) {
    'a' => "Administrador",
    'f' => "Funcionário",
    default => "Cliente",
};

$_SESSION["errors"] = [];

if (!isset($_GET["id"])) {
    $_SESSION["errors"]["not_found"] = "ID do comentário não fornecido.";
    header("Location: admin_comentarios.php");
    exit();
}

$id = (int) $_GET["id"];
$sql = "SELECT * FROM comentarios WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $_SESSION["errors"]["not_found"] = "Comentário não encontrado.";
    header("Location: admin_comentarios.php");
    exit();
}

$comentario = $result->fetch_assoc();

$posts = $conn->query("SELECT id, titulo FROM posts");
$utilizadores = $conn->query("SELECT id, nome FROM utilizadores");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conteudo = trim($_POST["conteudo"] ?? "");
    $id_post = $_POST["id_post"] ?? "";
    $id_utilizador = $_POST["id_utilizador"] ?? "";

    if ($conteudo === "")
        $_SESSION["errors"]["conteudo"] = "Conteúdo inválido";
    if ($id_post === "")
        $_SESSION["errors"]["id_post"] = "Post inválido";
    if ($id_utilizador === "")
        $_SESSION["errors"]["id_utilizador"] = "Utilizador inválido";

    if (count($_SESSION["errors"]) === 0) {
        $conteudo = mysqli_real_escape_string($conn, $conteudo);
        $id_post = mysqli_real_escape_string($conn, $id_post);
        $id_utilizador = mysqli_real_escape_string($conn, $id_utilizador);

        $sqlUpdate = "
            UPDATE comentarios
            SET conteudo = '$conteudo',
                id_post = '$id_post',
                id_utilizador = '$id_utilizador'
            WHERE id = $id
        ";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Comentário atualizado com sucesso.";
            header("Location: admin_comentarios.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar: " . $conn->error;
        }
    }
}
$pageTitle = "H3X ADMIN - Editar Comentário";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-edit me-2"></i>Editar Comentário</h1>
                <a href="admin_comentarios.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger'>$erro</div>";
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
                                maxlength="500"
                                title="O comentário deve ter entre 5 e 500 caracteres."><?= trim($comentario["conteudo"]) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="id_post" class="form-label">Post</label>
                            <select class="form-select" name="id_post" id="id_post" required>
                                <option value="">Escolher post</option>
                                <?php while ($p = $posts->fetch_assoc()): ?>
                                    <option value="<?= $p['id'] ?>" <?= $comentario["id_post"] == $p['id'] ? "selected" : "" ?>>
                                        <?= trim($p['titulo']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_utilizador" class="form-label">Utilizador</label>
                            <select class="form-select" name="id_utilizador" id="id_utilizador" required>
                                <option value="">Escolher utilizador</option>
                                <?php while ($u = $utilizadores->fetch_assoc()): ?>
                                    <option value="<?= $u['id'] ?>" <?= $comentario["id_utilizador"] == $u['id'] ? "selected" : "" ?>>
                                        <?= trim($u['nome']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Alterações
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <?php
            if ($result) {
                $result->free();
            }
            if ($posts) {
                $posts->free();
            }
            if ($utilizadores) {
                $utilizadores->free();
            }

            $conn->close();
            require 'partials/footer.php'; ?>
        </div>
    </div>
    <script>
        document.getElementById('comentarioForm').addEventListener('submit', function (submitEvent) {
            const conteudo = document.getElementById('conteudo').value.trim();
            const idPost = document.getElementById('id_post').value;
            const idUtilizador = document.getElementById('id_utilizador').value;

            if (conteudo.length < 5 || conteudo.length > 500) {
                alert("O comentário deve ter entre 5 e 500 caracteres.");
                submitEvent.preventDefault();
                return;
            }

            if (idPost === "") {
                alert("Escolha um post.");
                submitEvent.preventDefault();
                return;
            }

            if (idUtilizador === "") {
                alert("Escolha um utilizador.");
                submitEvent.preventDefault();
                return;
            }
        });
    </script>
</body>