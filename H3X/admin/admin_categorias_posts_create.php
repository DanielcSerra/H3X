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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["errors"] = [];

    $nome = isset($_POST["nome"]) ? trim($_POST["nome"]) : "";

    if (strlen($nome) == 0) {
        $_SESSION["errors"]["nome"] = "Nome da categoria é obrigatório";
    } else {
        // Verificar se já existe categoria com esse nome
        $nomeEscaped = mysqli_real_escape_string($conn, $nome);
        $checkSql = "SELECT id FROM categorias_posts WHERE nome = '$nomeEscaped' LIMIT 1";
        $checkResult = $conn->query($checkSql);
        if ($checkResult && $checkResult->num_rows > 0) {
            $_SESSION["errors"]["nome"] = "Já existe uma categoria com este nome.";
        }
    }

    if (count($_SESSION["errors"]) === 0) {
        $nomeEscaped = mysqli_real_escape_string($conn, $nome);

        $sql = "INSERT INTO categorias_posts (nome) VALUES ('$nomeEscaped')";

        if ($conn->query($sql)) {
            $_SESSION["success"] = "Categoria criada com sucesso.";
            header("Location: admin_categorias_posts.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao inserir categoria: " . $conn->error;
        }
    }
}
$pageTitle = "H3X ADMIN - Criar Categoria Post";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-plus me-2"></i>Criar Categoria</h1>
                <a href="admin_categorias_posts.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
            if (isset($_SESSION["success"])) {
                echo "<div class='alert alert-success'>" . $_SESSION["success"] . "</div>";
                unset($_SESSION["success"]);
            }
            ?>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px;">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" name="nome" id="nome" required
                                value="<?= trim($_POST['nome'] ?? '') ?>" maxlength="20" pattern="^[A-Za-zÀ-ÿ\s]{2,20}$"
                                title="O nome da categoria deve ter entre 2 e 20 caracteres.">
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Criar Categoria
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