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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION["errors"][] = "ID de imagem inválido.";
    header("Location: admin_galeria.php");
    exit();
}

$idImagem = intval($_GET['id']);
$sqlSelect = "SELECT * FROM imagens_galeria WHERE id = $idImagem";
$result = $conn->query($sqlSelect);

if ($result->num_rows === 0) {
    $_SESSION["errors"][] = "Imagem não encontrada.";
    header("Location: admin_galeria.php");
    exit();
}

$imagemData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["errors"] = [];
    $titulo = trim($_POST["titulo"] ?? "");
    $data = $_POST["data"] ?? date("Y-m-d H:i:s");
    $data = str_replace('T', ' ', $data);
    $aprovado = isset($_POST['aprovado']) ? 1 : 0;

    if (empty($titulo)) {
        $_SESSION["errors"][] = "O título não pode estar vazio.";
    }

    if (empty($_SESSION["errors"])) {
        $tituloEscaped = $conn->real_escape_string($titulo);
        $dataEscaped = $conn->real_escape_string($data);

        $novaImagem = $imagemData['imagem']; 
        if (isset($_FILES["imgfile"]) && $_FILES["imgfile"]["error"] === UPLOAD_ERR_OK) {
            $novaImagem = uniqid() . "_" . basename($_FILES["imgfile"]["name"]);
            $upload_path = "../uploads/" . $novaImagem;
            if (!move_uploaded_file($_FILES["imgfile"]["tmp_name"], $upload_path)) {
                $_SESSION["errors"][] = "Erro ao guardar a nova imagem.";
            }
        }

        if (empty($_SESSION["errors"])) {
            $imagemEscaped = $conn->real_escape_string($novaImagem);

            $sqlUpdate = "UPDATE imagens_galeria 
                          SET titulo = '$tituloEscaped', imagem = '$imagemEscaped', data_upload = '$dataEscaped', aprovado = $aprovado 
                          WHERE id = $idImagem";

            if ($conn->query($sqlUpdate)) {
                $_SESSION["success"] = "Imagem atualizada com sucesso.";
                header("Location: admin_galeria.php");
                exit();
            } else {
                $_SESSION["errors"][] = "Erro ao atualizar imagem: " . $conn->error;
            }
        }
    }
}

$pageTitle = "H3X ADMIN - Editar Imagem";
require 'partials/header.php';
?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-edit me-2"></i>Editar Imagem</h1>
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
                    <form method="POST" enctype="multipart/form-data"
                        class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px;">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <textarea class="form-control" id="titulo" name="titulo" rows="1" maxlength="100"
                                required><?= htmlspecialchars($_POST['titulo'] ?? $imagemData['titulo']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="data" class="form-label">Data e Hora</label>
                            <input type="datetime-local" class="form-control" id="data" name="data"
                                value="<?= htmlspecialchars($_POST['data'] ?? date('Y-m-d\TH:i', strtotime($imagemData['data_upload']))) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="imgfile" class="form-label">Imagem (deixe vazio para manter a atual)</label>
                            <input type="file" class="form-control" id="imgfile" name="imgfile" accept="image/*">
                            <div class="mt-2">
                                <strong>Imagem atual:</strong><br>
                                <img src="../uploads/<?= htmlspecialchars($imagemData['imagem']) ?>" alt="Imagem atual" style="max-width: 100%; height: auto;">
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="aprovado" id="aprovado" value="1"
                                <?= (isset($_POST['aprovado']) ? 'checked' : ($imagemData['aprovado'] ? 'checked' : '')) ?>>
                            <label class="form-check-label" for="aprovado">Aprovado</label>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="update">
                                <i class="fas fa-save me-1"></i> Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php require 'partials/footer.php'; ?>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function (submitEvent) {
            const titulo = document.getElementById('titulo').value.trim();

            if (titulo.length < 3) {
                alert("Por favor, insira um título maior.");
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
