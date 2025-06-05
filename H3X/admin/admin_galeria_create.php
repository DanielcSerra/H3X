<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

if (!isset($_SESSION['tipo']) || !in_array($_SESSION['tipo'], ['a', 'f'])) {
    header("Location: login.php");
    exit();
}

require_once "../db_config.php";
require_once 'ultima_atividade.php';

$id_utilizador = $_SESSION["id"] ?? null;
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["errors"] = [];
    $titulo = trim($_POST["titulo"] ?? "");
    $data = $_POST["data"] ?? date("Y-m-d H:i:s");

    $data = str_replace('T', ' ', $data);

    if (empty($titulo)) {
        $_SESSION["errors"][] = "Imagem não tem título";
    }

    if (!isset($_FILES["imgfile"]) || $_FILES["imgfile"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION["errors"][] = "Erro ao carregar a imagem.";
    }

    if (empty($_SESSION["errors"])) {

        $imagem = uniqid() . "_" . basename($_FILES["imgfile"]["name"]);
        $upload_path = "../uploads/" . $imagem;

        if (move_uploaded_file($_FILES["imgfile"]["tmp_name"], $upload_path)) {
            $tituloEscaped = $conn->real_escape_string($titulo);
            $imagemEscaped = $conn->real_escape_string($imagem);
            $dataEscaped = $conn->real_escape_string($data);

            $aprovado = isset($_POST['aprovado']) ? (int) $_POST['aprovado'] : 1;
            $sql = "INSERT INTO imagens_galeria (titulo, imagem, data_upload, id_utilizador, aprovado)
        VALUES ('$tituloEscaped', '$imagemEscaped', '$dataEscaped', '$id_utilizador', $aprovado)";


            if ($conn->query($sql)) {
                $_SESSION["success"] = "Imagem inserida com sucesso.";
                header("Location: admin_galeria.php");
                exit();
            } else {
                $_SESSION["errors"][] = "Erro ao inserir imagem: " . $conn->error;
            }
        } else {
            $_SESSION["errors"][] = "Erro ao guardar o ficheiro no servidor.";
        }
    }
}

$pageTitle = "H3X ADMIN - Criar Imagem";
require 'partials/header.php';
?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-plus me-2"></i>Criar Imagem</h1>
                <a href="admin_galeria.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
                    <form method="POST" id="galeriaadminform" enctype="multipart/form-data"
                        class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px;">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <textarea class="form-control" id="titulo" name="titulo" rows="1" maxlength="100"
                                required><?= htmlspecialchars($_POST['titulo'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="data" class="form-label">Data e Hora</label>
                            <input type="datetime-local" class="form-control" id="data" name="data"
                                value="<?= htmlspecialchars($_POST['data'] ?? date('Y-m-d\TH:i')) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="imgfile" class="form-label">Imagem</label>
                            <input type="file" class="form-control" id="imgfile" name="imgfile" accept="image/*"
                                required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="aprovado" id="aprovado" value="1">
                            <label class="form-check-label" for="aprovado">Aprovado</label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="post">
                                <i class="fas fa-upload me-1"></i> Submeter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php require 'partials/footer.php'; ?>
        </div>
    </div>
    <script>
        document.getElementById('galeriaadminform').addEventListener('submit', function (submitEvent) {
            const titulo = document.getElementById('titulo').value.trim();

            if (titulo.length < 3) {
                alert("Por favor, insira um título maior");
                submitEvent.preventDefault();
                return;
            }

            if (titulo.length > 100) {
                alert("O título não pode exceder 100 caracteres.");
                submitEvent.preventDefault();
                return;
            }
        });
    </script>
</body>

</html>