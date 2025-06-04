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

    $nome = isset($_POST["nome"]) ? trim($_POST["nome"]) : "";
    $assunto = isset($_POST["assunto"]) ? trim($_POST["assunto"]) : "";
    $telefone = isset($_POST["telefone"]) ? trim($_POST["telefone"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $mensagem = isset($_POST["mensagem"]) ? trim($_POST["mensagem"]) : "";

    if (strlen($nome) == 0) {
        $_SESSION["errors"]["nome"] = "Nome inválido";
    }

    if (strlen($assunto) == 0) {
        $_SESSION["errors"]["assunto"] = "Assunto inválido";
    }

    if (strlen($telefone) == 0 ) {
        $_SESSION["errors"]["telefone"] = "Telemóvel inválido (deve conter 9 dígitos)";
    }

    if (strlen($email) == 0) {
        $_SESSION["errors"]["email"] = "Email inválido";
    }

    if (strlen($mensagem) == 0) {
        $_SESSION["errors"]["mensagem"] = "Mensagem inválida";
    }

    if (count($_SESSION["errors"]) === 0) {
        $nomeEscaped = mysqli_real_escape_string($conn, $nome);
        $assuntoEscaped = mysqli_real_escape_string($conn, $assunto);
        $telefoneEscaped = mysqli_real_escape_string($conn, $telefone);
        $emailEscaped = mysqli_real_escape_string($conn, $email);
        $mensagemEscaped = mysqli_real_escape_string($conn, $mensagem);

        $sql = "INSERT INTO contactos (nome, assunto, telefone, email, mensagem) 
                VALUES ('$nomeEscaped', '$assuntoEscaped', '$telefoneEscaped', '$emailEscaped', '$mensagemEscaped')";

        if ($conn->query($sql)) {
            $_SESSION["success"] = "Contacto adicionado com sucesso.";
            header("Location: admin_contactos.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao adicionar contacto: " . $conn->error;
        }
    }
} else {
    $_SESSION["errors"] = [];
}

$pageTitle = "H3X ADMIN - Adicionar Contacto";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-address-book me-2"></i>Adicionar Contacto</h1>
                <a href="admin_contactos.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" required
                                placeholder="Digite o nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="assunto" class="form-label">Assunto</label>
                            <input type="text" class="form-control" name="assunto" id="assunto" required
                                placeholder="Digite o assunto" value="<?= htmlspecialchars($_POST['assunto'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telemóvel</label>
                            <input type="tel" class="form-control" name="telefone" id="telefone" required pattern="\d{9}"
                                maxlength="9" title="Telemóvel deve conter exatamente 9 dígitos numéricos"
                                placeholder="912345678" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required
                                placeholder="exemplo@dominio.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Mensagem</label>
                            <textarea class="form-control" name="mensagem" id="mensagem" rows="5" required
                                placeholder="Digite a mensagem"><?= htmlspecialchars($_POST['mensagem'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus-circle me-1"></i> Adicionar Contacto
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
