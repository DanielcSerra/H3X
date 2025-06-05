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
    $_SESSION["errors"]["not_found"] = "ID do evento não fornecido.";
    header("Location: admin_eventos.php");
    exit();
}

$id = (int) $_GET["id"];
$sql = "SELECT * FROM eventos WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Evento não encontrado.";
    header("Location: admin_eventos.php");
    exit();
}

$evento = $result->fetch_assoc();
$result->free();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");
    $datainic = str_replace('T', ' ', $_POST["datainic"] ?? "");
    $datafin = str_replace('T', ' ', $_POST["datafin"] ?? "");
    $lineup = trim($_POST["lineup"] ?? "");

    if ($titulo === "") $_SESSION["errors"]["titulo"] = "Título inválido.";
    if ($datainic === "") $_SESSION["errors"]["datainic"] = "Data de início inválida.";
    if ($datafin === "") $_SESSION["errors"]["datafin"] = "Data de fim inválida.";
    if ($lineup === "") $_SESSION["errors"]["lineup"] = "Lineup não pode estar vazio.";

    if (count($_SESSION["errors"]) === 0) {
        $titulo = $conn->real_escape_string($titulo);
        $datainic = $conn->real_escape_string($datainic);
        $datafin = $conn->real_escape_string($datafin);
        $lineup = $conn->real_escape_string($lineup);

        $updates = [];
        $dirUpload = "../uploads/Eventos";

        if (!is_dir($dirUpload)) {
            mkdir($dirUpload, 0777, true);
        }

        if (isset($_FILES["imgfile"]) && $_FILES["imgfile"]["error"] === 0) {
            $imagem1 = uniqid() . "_" . basename($_FILES["imgfile"]["name"]);
            move_uploaded_file($_FILES["imgfile"]["tmp_name"], "$dirUpload/$imagem1");
            $updates[] = "imagem_banner = '$imagem1'";
        }

        if (isset($_FILES["imgfile2"]) && $_FILES["imgfile2"]["error"] === 0) {
            $imagem2 = uniqid() . "_" . basename($_FILES["imgfile2"]["name"]);
            move_uploaded_file($_FILES["imgfile2"]["tmp_name"], "$dirUpload/$imagem2");
            $updates[] = "imagem_card = '$imagem2'";
        }

        if (isset($_FILES["imgfile3"]) && $_FILES["imgfile3"]["error"] === 0) {
            $video = uniqid() . "_" . basename($_FILES["imgfile3"]["name"]);
            move_uploaded_file($_FILES["imgfile3"]["tmp_name"], "$dirUpload/$video");
            $updates[] = "video_banner = '$video'";
        }

        $updates = array_merge($updates, [
            "titulo = '$titulo'",
            "data_inicio = '$datainic'",
            "data_fim = '$datafin'",
            "lineup = '$lineup'"
        ]);

        $sqlUpdate = "UPDATE eventos SET " . implode(", ", $updates) . " WHERE id = $id";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Evento atualizado com sucesso.";
            header("Location: admin_eventos.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar: " . $conn->error;
        }
    }
}

$pageTitle = "H3X ADMIN - Editar Evento";
require 'partials/header.php';
?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-edit me-2"></i>Editar Evento</h1>
                <a href="admin_eventos.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
                            <input type="text" class="form-control" id="titulo" name="titulo" required maxlength="100"
                                value="<?= htmlspecialchars($evento["titulo"]) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="datainic" class="form-label">Data de início</label>
                            <input type="datetime-local" class="form-control" id="datainic" name="datainic"
                                value="<?= date('Y-m-d\TH:i', strtotime($evento["data_inicio"])) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="datafin" class="form-label">Data final</label>
                            <input type="datetime-local" class="form-control" id="datafin" name="datafin"
                                value="<?= date('Y-m-d\TH:i', strtotime($evento["data_fim"])) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Imagem Banner Atual:</label>
                            <img src="../uploads/Eventos/<?= $evento["imagem_banner"] ?>" class="img-thumbnail mb-2" style="max-width: 150px;">
                            <input type="file" class="form-control" id="imgfile" name="imgfile" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Imagem Card Atual:</label>
                            <img src="../uploads/Eventos/<?= $evento["imagem_card"] ?>" class="img-thumbnail mb-2" style="max-width: 150px;">
                            <input type="file" class="form-control" id="imgfile2" name="imgfile2" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Vídeo Atual:</label>
                            <video src="../uploads/Eventos/<?= $evento["video_banner"] ?>" class="img-thumbnail mb-2" style="max-width: 150px;" controls></video>
                            <input type="file" class="form-control" id="imgfile3" name="imgfile3" accept="video/*">
                        </div>

                        <div class="mb-3">
                            <label for="lineup" class="form-label">Lineup (separado por ; )</label>
                            <textarea class="form-control" id="lineup" name="lineup" rows="2" maxlength="200"><?= htmlspecialchars($evento["lineup"]) ?></textarea>
                        </div>

                        <div class="text-center">
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

    <script>
        function validarFormularioEvento(e) {
            const titulo = document.getElementById("titulo").value.trim();
            const datainic = document.getElementById("datainic").value;
            const datafin = document.getElementById("datafin").value;
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

            if (lineup.length < 3) {
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