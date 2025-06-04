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
    $nome = $_POST["nome"] ?? "";
    $assunto = $_POST["assunto"] ?? "";
    $telefone = trim($_POST["telefone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $mensagem = $_POST["mensagem"] ?? "";

    if ($nome === "")
        $_SESSION["errors"]["nome"] = "Nome não pode estar vazio.";
    if ($assunto === "")
        $_SESSION["errors"]["assunto"] = "Assunto não pode estar vazio.";
    if ($telefone === "")
        $_SESSION["errors"]["telefone"] = "Telemóvel não pode estar vazio.";
    
    if ($email === "")
        $_SESSION["errors"]["email"] = "Email não pode estar vazio.";
    if ($mensagem === "")
        $_SESSION["errors"]["mensagem"] = "Mensagem não pode estar vazia.";

    if (count($_SESSION["errors"]) === 0) {
        $nomeEscaped = mysqli_real_escape_string($conn, $nome);
        $assuntoEscaped = mysqli_real_escape_string($conn, $assunto);
        $telefoneEscaped = mysqli_real_escape_string($conn, $telefone);
        $emailEscaped = mysqli_real_escape_string($conn, $email);
        $mensagemEscaped = mysqli_real_escape_string($conn, $mensagem);

        $sqlUpdate = "UPDATE contactos SET 
            nome = '$nomeEscaped', 
            assunto = '$assuntoEscaped', 
            telefone = '$telefoneEscaped', 
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
                            <label for="telefone" class="form-label">Telemóvel</label>
                            <input type="text" class="form-control" name="telefone" id="telefone"
                                value="<?= htmlspecialchars($contacto["telefone"]) ?>" required>
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

   
  <script>
function validarFormulario(submitEvent) {
    var id = document.getElementById("id")?.value.trim(); 
    var nome = document.getElementById("nome").value.trim();
    var assunto = document.getElementById("assunto").value.trim();
    var telefone = document.getElementById("telefone").value.trim();
    var email = document.getElementById("email").value.trim();
    var mensagem = document.getElementById("mensagem").value.trim();

    if (nome.length < 2 || nome.length > 50) {
        alert("O nome deve ter entre 2 e 50 caracteres.");
        submitEvent.preventDefault();
        return;
    }

    if (assunto.length < 10 || assunto.length > 100) {
        alert("O assunto deve ter entre 2 e 100 caracteres.");
        submitEvent.preventDefault();
        return;
    }

    if (telefone !== "") {
        if (telefone.length !== 9 || isNaN(telefone)) {
            alert("O telefone deve conter exatamente 9 dígitos numéricos.");
            submitEvent.preventDefault();
            return;
        }
    }

    if (email === "") {
        alert("O email é obrigatório.");
        submitEvent.preventDefault();
        return;
    }

    if (email.length > 150) {
        alert("O email deve ter no máximo 100 caracteres.");
        submitEvent.preventDefault();
        return;
    }


    if (mensagem.length < 5 || mensagem.length > 300) {
        alert("A mensagem deve ter entre 5 e 300 caracteres.");
        submitEvent.preventDefault();
        return;
    }
}

window.onload = function () {
    var form = document.querySelector("form");
    form.addEventListener("submit", validarFormulario);
}
</script>

</body>
