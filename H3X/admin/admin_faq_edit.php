<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

require_once "../db_config.php";
require_once 'ultima_atividade.php';

$_SESSION["errors"] = [];
$_SESSION["success"] = "";

// Verifica se o ID foi fornecido
if (!isset($_GET["id"])) {
    $_SESSION["errors"]["not_found"] = "ID da FAQ não fornecido.";
    header("Location: admin_faq.php");
    exit();
}

$id = (int) $_GET["id"];

// Busca a FAQ
$sql = "SELECT * FROM faq WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $_SESSION["errors"]["not_found"] = "FAQ não encontrada.";
    header("Location: admin_faq.php");
    exit();
}

$faq = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");
    $resposta = trim($_POST["resposta"] ?? "");

    if ($titulo === "")
        $_SESSION["errors"]["titulo"] = "Título não pode estar vazio.";
    if ($resposta === "")
        $_SESSION["errors"]["resposta"] = "Resposta não pode estar vazia.";

    if (count($_SESSION["errors"]) === 0) {
        $tituloEscaped = mysqli_real_escape_string($conn, $titulo);
        $respostaEscaped = mysqli_real_escape_string($conn, $resposta);

        $sqlUpdate = "UPDATE faq SET titulo = '$tituloEscaped', resposta = '$respostaEscaped' WHERE id = $id";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "FAQ atualizada com sucesso.";
            header("Location: admin_faq.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar FAQ: " . $conn->error;
        }
    }
}

$pageTitle = "H3X ADMIN - Editar FAQ";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-question-circle me-2"></i>Editar FAQ</h1>
                <a href="admin_faq.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger'>$erro</div>";
                }
            }
            ?>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px;">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo"
                                value="<?= htmlspecialchars($faq["titulo"]) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="resposta" class="form-label">Resposta</label>
                            <textarea class="form-control" name="resposta" id="resposta" rows="6" required><?= htmlspecialchars($faq["resposta"]) ?></textarea>
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
</body>
