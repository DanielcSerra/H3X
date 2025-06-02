<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

require_once "../db_config.php";
require_once "ultima_atividade.php";

$_SESSION["errors"] = [];
$_SESSION["success"] = null;

if (!isset($_GET["id"])) {
    $_SESSION["errors"]["not_found"] = "ID da categoria não fornecido.";
    header("Location: admin_categorias_posts.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM categorias_posts WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Categoria não encontrada.";
    header("Location: admin_categorias_posts.php");
    $result->free();
    exit();
}

$categoria = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");

    if ($nome === "") {
        $_SESSION["errors"]["nome"] = "Nome inválido.";
    } else {
        $nomeEscapado = mysqli_real_escape_string($conn, $nome);
        $verifica = $conn->query("SELECT id FROM categorias_posts WHERE nome = '$nomeEscapado' AND id != $id");

        if ($verifica && $verifica->num_rows > 0) {
            $_SESSION["errors"]["existe"] = "Já existe uma categoria com esse nome.";
        }
    }

    if (count($_SESSION["errors"]) === 0) {
        $sqlUpdate = "UPDATE categorias_posts SET nome = '$nomeEscapado' WHERE id = $id";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Categoria atualizada com sucesso.";
            header("Location: admin_categorias_posts.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar: " . $conn->error;
        }
    }
}
$pageTitle = "H3X ADMIN - Editar Categoria Post";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>
        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-edit me-2"></i>Editar Categoria</h1>
                <a href="admin_categorias_posts.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
                    <form method="POST" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:500px;">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                value="<?= trim($categoria["nome"]) ?>" required minlength="2" maxlength="20"
                                title="O nome da categoria deve ter entre 2 e 20 caracteres.">
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Alterações
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <?php require 'partials/footer.php'; ?>
        </div>
    </div>
    <?php
    if ($result) {
        $result->free();
    }

    $conn->close(); ?>
    <script>
        document.getElementById('categoriaForm').addEventListener('submit', function (e) {
            const nome = document.getElementById('nome').value.trim();

            if (nome.length < 2 || nome.length > 20) {
                alert("O nome da categoria deve ter entre 2 e 20 caracteres.");
                e.preventDefault();
                return;
            }
        });
    </script>
</body>

</html>