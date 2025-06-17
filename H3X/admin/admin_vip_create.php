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

$pageTitle = "H3X ADMIN - Adicionar Reserva VIP";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["errors"] = [];

    $id_mesa = $_POST["id_mesa"] ?? '';
    $mensagem = trim($_POST["mensagem"] ?? '');
    $data_reserva = $_POST["data_reserva"] ?? '';
    $id_utilizador = $_POST["id_utilizador"] ?? '';

    if (!$id_mesa || !$data_reserva || !$id_utilizador) {
        $_SESSION["errors"][] = "Preencha todos os campos obrigatórios.";
    }

    if (empty($_SESSION["errors"])) {
        $stmt = $conn->prepare("INSERT INTO vip (id_mesa, mensagem, data_reserva, id_utilizador) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $id_mesa, $mensagem, $data_reserva, $id_utilizador);

        if ($stmt->execute()) {
            $_SESSION["success"] = "Reserva Vip adicionada com sucesso.";
            header("Location: admin_vip.php");
            exit();
        } else {
            $_SESSION["errors"][] = "Erro ao inserir reserva: " . $conn->error;
        }
    }
}
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-plus me-2"></i>Adicionar Reserva Vip</h1>
                <a href="admin_vip.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
        if (isset($_SESSION["errors"])) {
            foreach ($_SESSION["errors"] as $erro) {
                echo "<div class='alert alert-danger'>$erro</div>";
            }
            unset($_SESSION["errors"]);
        }

        if (isset($_SESSION["success"])) {
            echo "<div class='alert alert-success'>" . $_SESSION["success"] . "</div>";
            unset($_SESSION["success"]);
        }

$mesas = $conn->query("SELECT id, nome FROM mesas");

        $utilizadores = $conn->query("SELECT id, nome, email, telefone FROM utilizadores");

        $utilizadorJS = [];
        while ($u = $utilizadores->fetch_assoc()) {
            $utilizadorJS[$u['id']] = $u;
        }
        ?>

            <form method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width:600px; margin:auto;">
                <div class="mb-3">
                    <label class="form-label">Mesa</label>
                    <select name="id_mesas" class="form-select" required>
                        <option value="">-- Selecionar Mesa --</option>
                        <?php foreach ($mesas as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= trim($row['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Utilizador</label>
                    <select name="id_utilizador" id="id_utilizador" class="form-select" required>
                        <option value="">-- Selecionar Utilizador --</option>
                        <?php foreach ($utilizadorJS as $id => $user): ?>
                        <option value="<?= $id ?>"><?= trim($user['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telemóvel</label>
                    <input type="text" class="form-control" id="telefone" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mensagem</label>
                    <textarea name="mensagem" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Data da Reserva</label>
                    <input type="date" name="data_reserva" class="form-control" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i> Adicionar Reserva Vip
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const utilizadores = <?= json_encode($utilizadorJS) ?>;

    document.getElementById('id_utilizador').addEventListener('change', function() {
        const selectedId = this.value;
        const emailField = document.getElementById('email');
        const telefoneField = document.getElementById('telefone');

        if (utilizadores[selectedId]) {
            emailField.value = utilizadores[selectedId].email || '';
            telefoneField.value = utilizadores[selectedId].telefone || '';
        } else {
            emailField.value = '';
            telefoneField.value = '';
        }
    });

    function validarFormulario(event) {
        var mesa = document.querySelector("select[name='id_mesas']").value.trim();
        var utilizador = document.getElementById("id_utilizador").value.trim();
        var dataReserva = document.querySelector("input[name='data_reserva']").value.trim();

        if (!mesa) {
            alert("Por favor, selecione uma mesa.");
            event.preventDefault();
            return;
        }

        if (!utilizador) {
            alert("Por favor, selecione um utilizador.");
            event.preventDefault();
            return;
        }

        if (!dataReserva) {
            alert("Por favor, selecione a data da reserva.");
            event.preventDefault();
            return;
        }

        var mensagem = document.querySelector("textarea[name='mensagem']").value.trim();
        if (mensagem && mensagem.length < 5) {
            alert("A mensagem deve ter pelo menos 5 caracteres, ou deixe-a em branco.");
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
</body>

</html>