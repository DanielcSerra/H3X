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

if (!isset($_GET["id"])) {
    $_SESSION["errors"]["not_found"] = "ID do serviço não fornecido.";
    header("Location: admin_servicos_vip.php");
    exit();
}

$id = intval($_GET["id"]);

$sql = "SELECT * FROM servicos_vip WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $_SESSION["errors"]["not_found"] = "Serviço VIP não encontrado.";
    header("Location: admin_servicos_vip.php");
    exit();
}

$servico = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");

    if ($titulo === "") {
        $_SESSION["errors"]["titulo"] = "Título inválido.";
    }

    if (count($_SESSION["errors"]) === 0) {
        $tituloEscaped = mysqli_real_escape_string($conn, $titulo);
        $imagemSql = "";

        if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === 0) {
            $dirUpload = "../uploads";

            if (!is_dir($dirUpload)) {
                mkdir($dirUpload, 0777, true);
            }

            $timestamp = date("Y-m-d_H-i-s");
            $imagemNome = uniqid() . "_" . $timestamp;
            $imagemCaminho = $dirUpload . "/" . $imagemNome;

            move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagemCaminho);
            $imagemSql = ", imagem = '$imagemNome'";

            if (!empty($servico["imagem"])) {
                $imagemAntiga = $dirUpload . "/" . $servico["imagem"];
                if (file_exists($imagemAntiga)) {
                    unlink($imagemAntiga);
                }
            }
        }

        $sqlUpdate = "UPDATE servicos_vip SET titulo = '$tituloEscaped' $imagemSql WHERE id = $id";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Serviço VIP atualizado com sucesso.";
            header("Location: admin_servicos_vip.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar: " . $conn->error;
        }
    }
}
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <h1 class="mb-4"><i class="fas fa-star me-2"></i>Editar Serviço VIP</h1>

            <?php
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger'>$erro</div>";
                }
            }
            ?>

            <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm w-100"
                style="max-width:600px; margin: auto;">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" name="titulo" id="titulo"
                        value="<?= trim($servico["titulo"]) ?>" required minlength="2" maxlength="100">
                </div>

                <?php if (!empty($servico["imagem"])): ?>
                <div class="mb-3">
                    <label class="form-label d-block">Imagem Atual:</label>
                    <img src="../uploads/<?= trim($servico["imagem"]) ?>" alt="Imagem Serviço" class="img-thumbnail"
                        style="max-width: 200px;">
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="imagem" class="form-label">Nova Imagem (opcional)</label>
                    <input type="file" class="form-control" name="imagem" id="imagem" accept="image/*">
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Alterações
                    </button>
                    <a href="admin_servicos_vip.php" class="btn btn-secondary ms-2">Cancelar</a>
                </div>
            </form>

            <?php $conn->close(); require 'partials/footer.php'; ?>
        </div>
    </div>

    <script>
    function validarFormulario(event) {
        var titulo = document.getElementById("titulo").value.trim();

        if (titulo.length < 2 || titulo.length > 100) {
            alert("O título deve ter entre 2 e 100 caracteres.");
            event.preventDefault();
            return;
        }
    }

    window.onload = function() {
        var form = document.querySelector("form");
        form.addEventListener("submit", validarFormulario);
    }
    </script>

</body>