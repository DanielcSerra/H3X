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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["errors"] = [];
    $titulo = trim($_POST["titulo"] ?? "");
    $datainic = $_POST["datainic"] ?? date("Y-m-d H:i:s");

    $datainic = str_replace('T', ' ', $datainic);

    $datafin = $_POST["datafin"] ?? date("Y-m-d H:i:s");

    $datafin = str_replace('T', ' ', $datafin);

    $lineup = trim($_POST["lineup"] ?? "");
    
    if (empty($titulo)) {
        $_SESSION["errors"][] = "Evento não tem título";
    }

    if (!isset($_FILES["imgfile"]) || $_FILES["imgfile"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION["errors"][] = "Erro ao carregar a imagem.";
    }

     if (!isset($_FILES["imgfile2"]) || $_FILES["imgfile2"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION["errors"][] = "Erro ao carregar a imagem.";
    }

     if (!isset($_FILES["imgfile3"]) || $_FILES["imgfile3"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION["errors"][] = "Erro ao carregar o vídeo.";
    }

    if (empty($lineup)) {
        $_SESSION["errors"][] = "Evento não tem lineup";
    }

    if (empty($_SESSION["errors"])) {

        $imagem1 = uniqid() . "_" . basename($_FILES["imgfile"]["name"]);
        $imagem2 = uniqid() . "_" . basename($_FILES["imgfile2"]["name"]);
        $video = uniqid() . "_" . basename($_FILES["imgfile3"]["name"]);

        $upload_path1 = "../uploads/Eventos/" . $imagem1;
        $upload_path2 = "../uploads/Eventos/" . $imagem2;
        $upload_path3 = "../uploads/Eventos/" . $video;
        


        if (
            move_uploaded_file($_FILES["imgfile"]["tmp_name"], $upload_path1) &&
            move_uploaded_file($_FILES["imgfile2"]["tmp_name"], $upload_path2) &&
            move_uploaded_file($_FILES["imgfile3"]["tmp_name"], $upload_path3)
        ) {
            $tituloEscaped = $conn->real_escape_string($titulo);
            $imagem1Escaped = $conn->real_escape_string($imagem1);
            $imagem2Escaped = $conn->real_escape_string($imagem2);
            $videoEscaped = $conn->real_escape_string($video);
            $datainicEscaped = $conn->real_escape_string($datainic);
            $datafinEscaped = $conn->real_escape_string($datafin);
            $lineupEscaped = $conn->real_escape_string($lineup);

            
            $sql = "INSERT INTO eventos (
                titulo, data_inicio, data_fim, imagem_banner, imagem_card, video_banner, lineup, aprovado
            ) VALUES (
                '$tituloEscaped', '$datainicEscaped', '$datafinEscaped',
                '$imagem1Escaped', '$imagem2Escaped', '$videoEscaped',
                '$lineupEscaped', 1
            )";
            
            if ($conn->query($sql)) {
                $_SESSION["success"] = "Evento inserido com sucesso.";
                header("Location: admin_eventos.php");
                exit();
            } else {
                $_SESSION["errors"][] = "Erro ao inserir evento: " . $conn->error;
            }
        } else {
            $_SESSION["errors"][] = "Erro ao guardar o ficheiro no servidor.";
        }
    }
}

$pageTitle = "H3X ADMIN - Criar Evento";
require 'partials/header.php';
?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-plus me-2"></i>Criar Evento</h1>
                <a href="admin_eventos.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
                    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px;">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <textarea class="form-control" id="titulo" name="titulo" rows="1" maxlength="100" required><?= htmlspecialchars($_POST['titulo'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="datainic" class="form-label">Data de início</label>
                            <input type="datetime-local" class="form-control" id="datainic" name="datainic" value="<?= htmlspecialchars($_POST['data'] ?? date('Y-m-d\TH:i')) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="datafin" class="form-label">Data final</label>
                            <input type="datetime-local" class="form-control" id="datafin" name="datafin" value="<?= htmlspecialchars($_POST['data'] ?? date('Y-m-d\TH:i')) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="imgfile" class="form-label">Imagem Banner</label>
                            <input type="file" class="form-control" id="imgfile" name="imgfile" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="imgfile2" class="form-label">Imagem Card</label>
                            <input type="file" class="form-control" id="imgfile2" name="imgfile2" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="imgfile3" class="form-label">Video</label>
                            <input type="file" class="form-control" id="imgfile3" name="imgfile3" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="lineup" class="form-label">Lineup (dividido com ; )</label>
                            <textarea class="form-control" id="lineup" name="lineup" rows="1" maxlength="100" required><?= htmlspecialchars($_POST['lineup'] ?? '') ?></textarea>
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
    function validarFormularioEvento(e) {
        const titulo = document.getElementById("titulo").value.trim();
        const datainic = document.getElementById("datainic").value;
        const datafin = document.getElementById("datafin").value;
        const imgfile = document.getElementById("imgfile").value;
        const imgfile2 = document.getElementById("imgfile2").value;
        const imgfile3 = document.getElementById("imgfile3").value;
        const lineup = document.getElementById("lineup").value.trim();

        if (titulo.length < 3 || titulo.length > 100) {
            alert("O título deve ter entre 3 e 100 caracteres.");
            e.preventDefault();
            return;
        }


        if (!datainic || !datafin) {
            alert("As datas de início e fim são obrigatórias.");
            e.preventDefault();
            return;
        }

        if (new Date(datainic) >= new Date(datafin)) {
            alert("A data final deve ser posterior à data de início.");
            e.preventDefault();
            return;
        }


        if (!imgfile || !imgfile2 || !imgfile3) {
            alert("Todas as imagens e vídeo devem ser carregados.");
            e.preventDefault();
            return;
        }


        if (lineup.length === 3) {
            alert("O lineup é obrigatório.");
            e.preventDefault();
            return;
        }

 
        if (!lineup.includes(";") && lineup.split(" ").length < 2) {
            alert("O lineup deve conter pelo menos dois artistas separados por ';' ou um nome composto.");
            e.preventDefault();
            return;
        }
    }

    window.addEventListener("load", function () {
        const form = document.querySelector("form");
        if (form) {
            form.addEventListener("submit", validarFormularioEvento);
        }
    });
</script>

</body>

</html>