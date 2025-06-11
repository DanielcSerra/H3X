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

    if (strlen($titulo) < 2) {
        $_SESSION["errors"]["titulo"] = "Título inválido. Deve ter pelo menos 2 caracteres.";
    }

    $imagemNome = "";

    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
        $dirUpload = "../uploads";

        if (!is_dir($dirUpload)) {
            mkdir($dirUpload, 0777, true);
        }

        $timestamp = date("Y-m-d_H-i-s");
        $imagemNome = uniqid() . "_" . $timestamp . "_" . basename($_FILES["imagem"]["name"]);

        if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], "$dirUpload/$imagemNome")) {
            $_SESSION["errors"]["imagem"] = "Erro ao carregar a imagem.";
        }
    }

    if (count($_SESSION["errors"]) === 0) {
       
        if (count($_SESSION["errors"]) === 0) {
            $titulo = mysqli_real_escape_string($conn, $titulo);
            $imagemNome = mysqli_real_escape_string($conn, $imagemNome);

            $sql = "INSERT INTO servicos_vip (titulo, imagem) VALUES ('$titulo', '$imagemNome')";

            if ($conn->query($sql)) {
                $_SESSION["success"] = "Serviço VIP adicionado com sucesso.";
                header("Location: admin_servicos_vip.php");
                exit();
            } else {
                $_SESSION["errors"]["db"] = "Erro ao inserir serviço: " . $conn->error;
            }
        }
    }
}

$pageTitle = "H3X ADMIN - Adicionar Serviço Vip";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-plus me-2"></i>Adicionar Serviço Vip</h1>
                <a href="admin_servicos_vip.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
                echo "<div class='alert alert-success'>" . $_SESSION["success"] . "</div>";
                unset($_SESSION["success"]);
            }
            ?>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm w-100"
                        style="max-width:600px;">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" required minlength="2"
                                title="Insira um título válido.">
                        </div>

                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            <input type="file" class="form-control" name="imagem" id="imagem" accept="image/*" required>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i> Adicionar Serviço Vip
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
            function validarFormulario(event) {
                var titulo = document.getElementById("titulo").value.trim();
                var imagemInput = document.getElementById("imagem");
                var imagem = imagemInput.files[0];

                if (titulo.length < 2) {
                    alert("O título deve ter pelo menos 2 caracteres.");
                    event.preventDefault();
                    return;
                }

                if (!imagem) {
                    alert("Selecione uma imagem.");
                    event.preventDefault();
                    return;
                }

                var tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (tiposPermitidos.indexOf(imagem.type) === -1) {
                    alert("Tipo de imagem inválido. Formatos permitidos: JPEG, PNG, GIF, WEBP.");
                    event.preventDefault();
                    return;
                }

                var tamanhoMaxMB = 5;
                var tamanhoMaxBytes = tamanhoMaxMB * 1024 * 1024;

                if (imagem.size > tamanhoMaxBytes) {
                    alert("A imagem deve ter no máximo 5MB.");
                    event.preventDefault();
                    return;
                }
            }

            window.onload = function() {
                var form = document.querySelector("form");
                form.addEventListener("submit", validarFormulario);
            }
            </script>

            <?php require 'partials/footer.php'; ?>