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
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $telefone = isset($_POST["telefone"]) ? trim($_POST["telefone"]) : "";
    $data_nascimento = isset($_POST["data_nascimento"]) ? $_POST["data_nascimento"] : "";
    $senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";

    if (strlen($nome) == 0) {
        $_SESSION["errors"]["nome"] = "Nome inválido";
    }

    if (strlen($email) == 0) {
        $_SESSION["errors"]["email"] = "Email inválido";
    }

    if (strlen($telefone) == 0) {
        $_SESSION["errors"]["telefone"] = "Telefone inválido";
    }

    if (strlen($data_nascimento) == 0) {
        $_SESSION["errors"]["data_nascimento"] = "Data de nascimento inválida";
    }

    if (strlen($senha) == 0) {
        $_SESSION["errors"]["senha"] = "Password inválida";
    }

    if (strlen($tipo) == 0 || !in_array($tipo, ['a', 'f', 'c'])) {
        $_SESSION["errors"]["tipo"] = "Tipo inválido";
    }


    if (count($_SESSION["errors"]) === 0) {
        $email = mysqli_real_escape_string($conn, $email);
        $nome = mysqli_real_escape_string($conn, $nome);
        $telefone = mysqli_real_escape_string($conn, $telefone);
        $data_nascimento = mysqli_real_escape_string($conn, $data_nascimento);
        $senha = mysqli_real_escape_string($conn, $senha);
        $tipo = mysqli_real_escape_string($conn, $tipo);

        $sql = "SELECT email FROM utilizadores WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows != 0) {
            $_SESSION["errors"]["email"] = "Email já existe";
        } else {
            $senhaHash = hash("sha512", $senha);

            $fotoNome = "";

            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
                $dirUpload = "../uploads";

                if (!is_dir($dirUpload)) {
                    mkdir($dirUpload, 0777, true);
                }

                $timestamp = date("Y-m-d_H-i-s");

                $extensao = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                $fotoNome = uniqid() . "_" . $timestamp . "." . $extensao;

                move_uploaded_file($_FILES["foto"]["tmp_name"], $dirUpload . "/" . $fotoNome);
            }

            $sql = "INSERT INTO utilizadores (nome, email, telefone, data_nascimento, pass, tipo, estado, foto) 
                    VALUES ('$nome', '$email', '$telefone', '$data_nascimento', '$senhaHash', '$tipo', 'd', '$fotoNome')";

            if ($conn->query($sql)) {
                $_SESSION["errors"] = [];
                $_SESSION["success"] = "Utilizador adicionado.";
                $conn->close();
                header("Location: admin_utilizadores.php");
                exit();
            } else {
                $_SESSION["errors"]["db"] = "Erro ao inserir utilizador: " . $conn->error;
            }
        }
    }
} else {
    $_SESSION["errors"] = [];
}
$pageTitle = "H3X ADMIN - Criar Utilizador";
?>



<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-user-plus me-2"></i>Adicionar Utilizador</h1>
                <a href="admin_utilizadores.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            </div>

            <div id="mensagens-erros">
                <?php
                if (isset($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $chave => $valor) {
                        echo "<div class='alert alert-danger'>$valor</div>";
                    }
                }
                ?>
            </div>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm w-100"
                        style="max-width:600px;">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" required minlength="2"
                                maxlength="15" title="Nome deve conter entre 2 e 15 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone (opcional)</label>
                            <input type="tel" class="form-control" name="telefone" id="telefone" minlength="9"
                                maxlength="9" title="Telefone deve conter exatamente 9 dígitos numéricos.">
                        </div>

                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" name="data_nascimento" id="data_nascimento"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Palavra-passe</label>
                            <input type="password" class="form-control" name="senha" id="senha" required minlength="6"
                                maxlength="20" title="A palavra-passe deve ter entre 6 e 20 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" name="tipo" id="tipo" required>
                                <option value="">Selecione</option>
                                <option value="c">Cliente</option>
                                <option value="f">Funcionário</option>
                                <option value="a">Administrador</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto de Perfil</label>
                            <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus me-1"></i> Adicionar
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <script>
                function validarFormulario(submitEvent) {
                    var nome = document.getElementById("nome").value.trim();
                    var email = document.getElementById("email").value.trim();
                    var telefone = document.getElementById("telefone").value.trim();
                    var dataNascimento = document.getElementById("data_nascimento").value.trim();
                    var senha = document.getElementById("senha").value.trim();
                    var tipo = document.getElementById("tipo").value;

                    if (nome.length < 2 || nome.length > 15) {
                        alert("O nome deve ter entre 2 e 15 caracteres.");
                        submitEvent.preventDefault();
                        return;
                    }

                    if (email === "") {
                        alert("O email é obrigatório.");
                        submitEvent.preventDefault();
                        return;
                    }

                    if (email.length > 100) {
                        alert("O email deve ter no máximo 100 caracteres.");
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

                    if (dataNascimento === "") {
                        alert("Preencha a data de nascimento.");
                        submitEvent.preventDefault();
                        return;
                    }

                    if (senha.length < 6 || senha.length > 20) {
                        alert("A palavra-passe deve ter entre 6 e 20 caracteres.");
                        submitEvent.preventDefault();
                        return;
                    }

                    if (tipo === "") {
                        alert("Selecione o tipo de utilizador.");
                        submitEvent.preventDefault();
                        return;
                    }
                }

                window.onload = function () {
                    var form = document.querySelector("form");
                    form.addEventListener("submit", validarFormulario);
                }
            </script>



            <?php require 'partials/footer.php'; ?>