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

$_SESSION["errors"] = [];
$_SESSION["success"] = "";

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

$pageTitle = "H3X ADMIN - Serviços VIP";
if (!isset($_GET["id"])) {
    $_SESSION["errors"]["not_found"] = "ID da reserva Vip não fornecido.";
    header("Location: admin_vip.php");
    exit();
}

$id = intval($_GET["id"]);

$sql = "SELECT vip.*, mesas.nome AS nome_mesa FROM vip LEFT JOIN mesas ON vip.id_mesa = mesas.id WHERE vip.id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $_SESSION["errors"]["not_found"] = "Reserva Vip não encontrada.";
    header("Location: admin_vip.php");
    exit();
}

$reserva = $result->fetch_assoc();

$sqlMesas = "SELECT id, nome FROM mesas ORDER BY nome ASC";
$resultMesas = $conn->query($sqlMesas);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mensagem = trim($_POST["mensagem"] ?? "");
    $data_reserva = trim($_POST["data_reserva"] ?? "");
    $id_mesa = intval($_POST["id_mesa"] ?? 0);

    if ($mensagem === "") {
        $_SESSION["errors"]["mensagem"] = "Mensagem não pode estar vazia.";
    }



    if (count($_SESSION["errors"]) === 0) {
        $mensagemEscaped = $conn->real_escape_string($mensagem);
        $dataReservaEscaped = $conn->real_escape_string($data_reserva);

        $sqlUpdate = "
            UPDATE vip 
            SET mensagem = '$mensagemEscaped',
                data_reserva = '$dataReservaEscaped',
                id_mesa = $id_mesa
            WHERE id = $id
        ";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Reserva VIP atualizada com sucesso.";
            header("Location: admin_vip.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar reserva: " . $conn->error;
        }
    }
}

$pageTitle = "Editar Reserva Vip";

require 'partials/header.php';
?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-edit me-2"></i>Editar Reservas Vip</h1>
                <a href="admin_vip.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger'>" . trim($erro) . "</div>";
                }
            }

            if (!empty($_SESSION["success"])) {
                echo "<div class='alert alert-success'>" . trim($_SESSION["success"]) . "</div>";
            }
            ?>

            <form method="POST" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:600px; margin: auto;">
                <div class="mb-3">
                    <label for="mensagem" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" rows="4"
                        required><?= trim($_POST["mensagem"] ?? $reserva["mensagem"]) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Data da Reserva</label>
                    <input type="date" name="data_reserva" class="form-control" required
                        value="<?= trim($_POST['data_reserva'] ?? $reserva['data_reserva']) ?>">
                </div>

                <div class="mb-3">
                    <label for="id_mesa" class="form-label">Mesa</label>
                    <select class="form-select" id="id_mesa" name="id_mesa" required>
                        <option value="">-- Selecione uma mesa --</option>
                        <?php while ($mesa = $resultMesas->fetch_assoc()): ?>
                        <option value="<?= $mesa['id'] ?>"
                            <?= (($mesa['id'] == ($_POST['id_mesa'] ?? $reserva['id_mesa'])) ? 'selected' : '') ?>>
                            <?= trim($mesa['nome']) ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Alterações
                    </button>
                    <a href="admin_vip.php" class="btn btn-secondary ms-2">Cancelar</a>
                </div>
            </form>

            <?php $conn->close(); require 'partials/footer.php'; ?>
        </div>
    </div>
    <script>
    function validarFormulario(event) {
        const mensagem = document.getElementById("mensagem").value.trim();
        const dataReserva = document.querySelector("input[name='data_reserva']").value;
        const idMesa = document.getElementById("id_mesa").value;

        if (mensagem.length < 2 || mensagem.length > 1000) {
            alert("A mensagem deve ter entre 2 e 1000 caracteres.");
            event.preventDefault();
            return;
        }

        if (!dataReserva) {
            alert("Por favor, selecione uma data de reserva.");
            event.preventDefault();
            return;
        }

        if (!idMesa) {
            alert("Por favor, selecione uma mesa.");
            event.preventDefault();
            return;
        }
    }

    window.onload = function() {
        const form = document.querySelector("form");
        form.addEventListener("submit", validarFormulario);
    }
    </script>
</body>

</html>