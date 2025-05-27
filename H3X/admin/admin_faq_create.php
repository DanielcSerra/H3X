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

    $titulo = isset($_POST["titulo"]) ? trim($_POST["titulo"]) : "";
    $resposta = isset($_POST["resposta"]) ? trim($_POST["resposta"]) : "";

    if (strlen($titulo) == 0) {
        $_SESSION["errors"]["titulo"] = "Título inválido";
    }

    if (strlen($resposta) == 0) {
        $_SESSION["errors"]["resposta"] = "Resposta inválida";
    }

    if (count($_SESSION["errors"]) === 0) {
        $titulo = mysqli_real_escape_string($conn, $titulo);
        $resposta = mysqli_real_escape_string($conn, $resposta);

        $sql = "INSERT INTO faq (titulo, resposta) VALUES ('$titulo', '$resposta')";

        if ($conn->query($sql)) {
            $_SESSION["success"] = "FAQ adicionada com sucesso.";
            header("Location: admin_faq.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao adicionar FAQ: " . $conn->error;
        }
    }
} else {
    $_SESSION["errors"] = [];
}

$pageTitle = "H3X ADMIN - Adicionar FAQ";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-question-circle me-2"></i>Adicionar FAQ</h1>
                <a href="admin_faq.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
            if (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger'>$erro</div>";
                }
            }

            if (isset($_SESSION["success"])) {
                echo "<div class='alert alert-success'>{$_SESSION["success"]}</div>";
                unset($_SESSION["success"]);
            }
            ?>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px;">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" required
                                placeholder="Digite o título da FAQ">
                        </div>

                        <div class="mb-3">
                            <label for="resposta" class="form-label">Resposta</label>
                            <textarea class="form-control" name="resposta" id="resposta" rows="5" required
                                placeholder="Digite a resposta da FAQ"></textarea>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus-circle me-1"></i> Adicionar FAQ
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