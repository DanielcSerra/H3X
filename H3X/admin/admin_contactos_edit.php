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

// Verifica se o ID foi fornecido
if (!isset($_GET["id"])) {
    $_SESSION["errors"]["not_found"] = "ID do contacto não fornecido.";
    header("Location: admin_contactos.php");
    exit();
}

$id = $_GET["id"];

// Busca o contacto
$sql = "SELECT * FROM contactos WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $_SESSION["errors"]["not_found"] = "Contacto não encontrado.";
    header("Location: admin_contactos.php");
    exit();
}

$contacto = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $assunto = trim($_POST["assunto"] ?? "");
    $telemovel = trim($_POST["telemovel"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $mensagem = trim($_POST["mensagem"] ?? "");

    // Validações básicas
    if ($nome === "")
        $_SESSION["errors"]["nome"] = "Nome não pode estar vazio.";
    if ($assunto === "")
        $_SESSION["errors"]["assunto"] = "Assunto não pode estar vazio.";
    if ($telemovel === "")
        $_SESSION["errors"]["telemovel"] = "Telemóvel não pode estar vazio.";
    if ($email === "")
        $_SESSION["errors"]["email"] = "Email não pode estar vazio.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $_SESSION["errors"]["email"] = "Email inválido.";
    if ($mensagem === "")
        $_SESSION["errors"]["mensagem"] = "Mensagem não pode estar vazia.";

    if (count($_SESSION["errors"]) === 0) {
        $nomeEscaped = mysqli_real_escape_string($conn, $nome);
        $assuntoEscaped = mysqli_real_escape_string($conn, $assunto);
        $telemovelEscaped = mysqli_real_escape_string($conn, $telemovel);
        $emailEscaped = mysqli_real_escape_string($conn, $email);
        $mensagemEscaped = mysqli_real_escape_string($conn, $mensagem);

        $sqlUpdate = "UPDATE contactos SET 
            nome = '$nomeEscaped', 
            assunto = '$assuntoEscaped', 
            telemovel = '$telemovelEscaped', 
            email = '$emailEscaped', 
            mensagem = '$mensagemEscaped' 
            WHERE id = $id";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Contacto atualizado com sucesso.";
            header("Location: admin_contactos.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar contacto: " . $conn->error;
        }
    }
}

$pageTitle = "H3X ADMIN - Editar Contacto";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-envelope me-2"></i>Editar Contacto</h1>
                <a href="admin_contactos.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger'>$erro</div>";
                }
            }

            if (!empty($_SESSION["success"])) {
                echo "<div class='alert alert-success'>{$_SESSION["success"]}</div>";
            }
            ?>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" class="bg-white p-4 rounded shadow-sm w-100" style="max-width:700px;">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome"
                                value="<?= htmlspecialchars($contacto["nome"]) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="assunto" class="form-label">Assunto</label>
                            <input type="text" class="form-control" name="assunto" id="assunto"
                                value="<?= htmlspecialchars($contacto["assunto"]) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telemovel" class="form-label">Telemóvel</label>
                            <input type="text" class="form-control" name="telemovel" id="telemovel"
                                value="<?= htmlspecialchars($contacto["telemovel"]) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="<?= htmlspecialchars($contacto["email"]) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Mensagem</label>
                            <textarea class="form-control" name="mensagem" id="mensagem" rows="6" required><?= htmlspecialchars($contacto["mensagem"]) ?></textarea>
                        </div>

                        <div class="mb-3 text-center">
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
</body>
