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

$tipoLabel = match ($tipoUtilizador) {
    'a' => "Administrador",
    'f' => "Funcionário",
    default => "Cliente",
};

$_SESSION["errors"] = [];

if (!isset($_GET["email"])) {
    $_SESSION["errors"]["not_found"] = "Email do utilizador não fornecido.";
    header("Location: admin_utilizadores.php");
    exit();
}

$emailOriginal = mysqli_real_escape_string($conn, $_GET["email"]);

$sql = "SELECT * FROM utilizadores WHERE email = '$emailOriginal'";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $_SESSION["errors"]["not_found"] = "Utilizador não encontrado.";
    header("Location: admin_utilizadores.php");
    exit();
}

$utilizador = $result->fetch_assoc();
$result->free();
$id = $utilizador["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $data_nascimento = $_POST["data_nascimento"] ?? "";
    $senha = trim($_POST["senha"] ?? "");
    $tipo = $_POST["tipo"] ?? "";

    if ($nome === "")
        $_SESSION["errors"]["nome"] = "Nome inválido";
    if ($email === "")
        $_SESSION["errors"]["email"] = "Email inválido";
    if ($telefone === "")
        $_SESSION["errors"]["telefone"] = "Telefone inválido";
    if ($data_nascimento === "")
        $_SESSION["errors"]["data_nascimento"] = "Data de nascimento inválida";
    if ($tipo === "" || !in_array($tipo, ['a', 'f', 'c']))
        $_SESSION["errors"]["tipo"] = "Tipo inválido";

    $emailEscaped = mysqli_real_escape_string($conn, $email);
    if ($email !== $utilizador["email"]) {
        $checkEmail = $conn->query("SELECT id FROM utilizadores WHERE email = '$emailEscaped'");
        if ($checkEmail && $checkEmail->num_rows > 0) {
            $_SESSION["errors"]["email"] = "Email já está em uso por outro utilizador.";
        }
    }

    if (count($_SESSION["errors"]) === 0) {
        $nome = mysqli_real_escape_string($conn, $nome);
        $telefone = mysqli_real_escape_string($conn, $telefone);
        $data_nascimento = mysqli_real_escape_string($conn, $data_nascimento);
        $tipo = mysqli_real_escape_string($conn, $tipo);
        $senhaSql = "";

        if (!empty($senha)) {
            $senhaHash = hash("sha512", $senha);
            $senhaSql = ", pass = '$senhaHash'";
        }

        $fotoSql = "";
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            $dirUpload = "../uploads";

            if (!is_dir($dirUpload)) {
                mkdir($dirUpload, 0777, true);
            }

            $timestamp = date("Y-m-d_H-i-s");

            $extensao = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
            $fotoNome = uniqid() . "_" . $timestamp . "." . $extensao;

            move_uploaded_file($_FILES["foto"]["tmp_name"], $dirUpload . "/" . $fotoNome);

            $fotoSql = ", foto = '$fotoNome'";
        }

        $sqlUpdate = "
            UPDATE utilizadores 
            SET nome = '$nome', email = '$email', telefone = '$telefone', 
                data_nascimento = '$data_nascimento', tipo = '$tipo'
                $senhaSql
                $fotoSql
            WHERE id = $id
        ";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Utilizador atualizado com sucesso.";
            header("Location: admin_utilizadores.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar: " . $conn->error;
        }
    }
}
$pageTitle = "H3X ADMIN - Editar Utilizador";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-user-edit me-2"></i>Editar Utilizador</h1>
                <a href="admin_utilizadores.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <?php
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger'>$erro</div>";
                }
            }
            ?>

            <div id="mensagemErro" class="alert alert-danger d-none" role="alert"></div>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm w-100"
                        style="max-width:600px;">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome"
                                value="<?= trim($utilizador["nome"]) ?>" required minlength="2" maxlength="15"
                                pattern="[A-Za-zÀ-ÿ\s'´`-]{2,15}" title="Nome deve conter entre 2 e 15 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="<?= trim($utilizador["email"]) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone (opcional)</label>
                            <input type="tel" class="form-control" name="telefone" id="telefone"
                                value="<?= trim($utilizador["telefone"]) ?>" minlength="9" maxlength="9" pattern="\d{9}"
                                title="O telefone deve conter exatamente 9 dígitos numéricos.">
                        </div>

                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" name="data_nascimento" id="data_nascimento"
                                value="<?= trim($utilizador["data_nascimento"]) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Nova Palavra-passe (opcional)</label>
                            <input type="password" class="form-control" name="senha" id="senha" minlength="6"
                                pattern=".{6,20}" maxlength="20"
                                title="A palavra-passe deve ter entre 6 e 20 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" name="tipo" id="tipo" required>
                                <option value="c" <?= $utilizador["tipo"] == "c" ? "selected" : "" ?>>Cliente</option>
                                <option value="f" <?= $utilizador["tipo"] == "f" ? "selected" : "" ?>>Funcionário
                                </option>
                                <option value="a" <?= $utilizador["tipo"] == "a" ? "selected" : "" ?>>Administrador
                                </option>
                            </select>
                        </div>

                        <?php if (!empty($utilizador["foto"])): ?>
                            <div class="mb-3">
                                <label class="form-label d-block">Foto Atual:</label>
                                <img src="../uploads/<?= trim($utilizador["foto"]) ?>" alt="Foto de perfil"
                                    class="img-thumbnail" style="max-width: 100px;">
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Nova Foto de Perfil (opcional)</label>
                            <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Alterações
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <?php
            $conn->close();
            require 'partials/footer.php'; ?>
        </div>
    </div>
    <script>
        function mostrarErro(msg) {
            const alerta = document.getElementById('mensagemErro');
            alerta.textContent = msg;
            alerta.classList.remove('d-none');
        }

        function validarFormulario(submitEvent) {
            var nome = document.getElementById("nome").value.trim();
            var email = document.getElementById("email").value.trim();
            var telefone = document.getElementById("telefone").value.trim();
            var dataNascimento = document.getElementById("data_nascimento").value.trim();
            var senha = document.getElementById("senha").value.trim();
            var tipo = document.getElementById("tipo").value;
            var inputFoto = document.getElementById("foto");

            document.getElementById('mensagemErro').classList.add('d-none');

            if (nome.length < 2 || nome.length > 15) {
                mostrarErro("O nome deve ter entre 2 e 15 caracteres.");
                submitEvent.preventDefault();
                return;
            }

            if (email === "") {
                mostrarErro("O email é obrigatório.");
                submitEvent.preventDefault();
                return;
            }

            if (email.length > 100) {
                mostrarErro("O email deve ter no máximo 100 caracteres.");
                submitEvent.preventDefault();
                return;
            }

            if (telefone !== "") {
                if (telefone.length !== 9 || isNaN(telefone)) {
                    mostrarErro("O telefone deve conter exatamente 9 dígitos numéricos.");
                    submitEvent.preventDefault();
                    return;
                }
            }

            if (dataNascimento === "") {
                mostrarErro("Preencha a data de nascimento.");
                submitEvent.preventDefault();
                return;
            }

            if (senha.length > 0 && (senha.length < 6 || senha.length > 20)) {
                mostrarErro("A palavra-passe deve ter entre 6 e 20 caracteres.");
                submitEvent.preventDefault();
                return;
            }

            if (tipo === "") {
                mostrarErro("Selecione o tipo de utilizador.");
                submitEvent.preventDefault();
                return;
            }

            if (inputFoto.files.length > 0) {
                var file = inputFoto.files[0];
                var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];

                if (!allowedTypes.includes(file.type)) {
                    mostrarErro("Por favor, selecione um ficheiro de imagem válido (JPEG, PNG, GIF, WEBP, BMP).");
                    submitEvent.preventDefault();
                    return;
                }

                var maxSize = 2 * 1024 * 1024;
                if (file.size > maxSize) {
                    mostrarErro("A imagem não pode ter mais que 2MB.");
                    submitEvent.preventDefault();
                    return;
                }
            }
        }

        window.onload = function () {
            var form = document.querySelector("form");
            form.addEventListener("submit", validarFormulario);
        }
    </script>
</body>