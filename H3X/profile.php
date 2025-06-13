<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: admin/login.php");
    exit;
}

include 'partials/head.php';
include 'partials/navbar.php';
include 'db_config.php';
require_once "admin/ultima_atividade.php";

$email = $_SESSION['email'];

$queryUser = "SELECT id, nome, telefone, data_nascimento, foto,email FROM utilizadores WHERE email = '$email'";
$resultUser = mysqli_query($conn, $queryUser);

if (!$resultUser || mysqli_num_rows($resultUser) == 0) {
    $_SESSION['errors']['user'] = "Usuário não encontrado.";
    header("Location: login.php");
    exit();
}


$user = mysqli_fetch_assoc($resultUser);

$userId = $user['id'];
$userNome = $user['nome'];
$userEmail = $user['email'];
$userTelefone = $user['telefone'];
$userNascimento = date('d/m/Y', strtotime($user['data_nascimento']));
$userFoto = $user['foto'] ?: '';

$queryGaleria = "SELECT imagem, titulo FROM imagens_galeria WHERE id_utilizador = $userId ORDER BY id DESC";
$galeria = mysqli_query($conn, $queryGaleria);

$queryPosts = "SELECT titulo, conteudo, data_criacao FROM posts WHERE id_utilizador = $userId ORDER BY data_criacao DESC";
$posts = mysqli_query($conn, $queryPosts);

$queryReservas = "SELECT data_reserva, mensagem FROM vip WHERE id_utilizador = $userId ORDER BY data_reserva DESC";
$reservas = mysqli_query($conn, $queryReservas);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_perfil'])) {
    $_SESSION['errors'] = [];

    $novoNome = trim($_POST['nome'] ?? '');
    $novoTelefone = trim($_POST['telefone'] ?? '');
    $novaData = trim($_POST['data_nascimento'] ?? '');
    $novoEmail = trim($_POST['email'] ?? '');
    $novaSenha = trim($_POST['senha'] ?? '');

    if ($novoNome === '')
        $_SESSION['errors']['nome'] = "Nome inválido.";
    if ($novoTelefone === '')
        $_SESSION['errors']['telefone'] = "Telefone inválido.";
    if ($novaData === '')
        $_SESSION['errors']['data_nascimento'] = "Data de nascimento inválida.";
    if ($novoEmail === '')
        $_SESSION['errors']['email'] = "Email inválido.";

    if ($novoEmail !== $email) {
        $novoEmailEsc = mysqli_real_escape_string($conn, $novoEmail);
        $checkEmail = $conn->query("SELECT id FROM utilizadores WHERE email = '$novoEmailEsc' AND id != $userId");
        if ($checkEmail && $checkEmail->num_rows > 0) {
            $_SESSION['errors']['email'] = "Email já está em uso por outro utilizador.";
        }
    }

    if (count($_SESSION['errors']) > 0) {
        header("Location: profile.php");
        exit();
    }

    $novoNomeEsc = mysqli_real_escape_string($conn, $novoNome);
    $novoTelefoneEsc = mysqli_real_escape_string($conn, $novoTelefone);
    $novaDataEsc = mysqli_real_escape_string($conn, $novaData);
    $novoEmailEsc = mysqli_real_escape_string($conn, $novoEmail);

    $senhaSql = "";
    if (!empty($novaSenha)) {
        $senhaHash = hash("sha512", $novaSenha);
        $senhaSql = ", pass = '$senhaHash'";
    }

    $fotoSql = "";
    if (!empty($_FILES['foto']['name'])) {
        $dirUpload = 'uploads';

        if (!is_dir($dirUpload)) {
            mkdir($dirUpload, 0777, true);
        }

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoNome = time() . '_' . uniqid() . '.' . $ext;
        $destino = $dirUpload . '/' . $fotoNome;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $fotoSql = ", foto = '$fotoNome'";
        } else {
            $_SESSION['errors']['foto'] = "Erro no upload da foto.";
            header("Location: profile.php");
            exit();
        }
    }

    $sqlUpdate = "
        UPDATE utilizadores SET 
        nome = '$novoNomeEsc',
        telefone = '$novoTelefoneEsc',
        data_nascimento = '$novaDataEsc',
        email = '$novoEmailEsc'
        $senhaSql
        $fotoSql
        WHERE id = $userId
    ";

    if ($conn->query($sqlUpdate)) {
        $_SESSION['success'] = "Perfil atualizado com sucesso.";
        $_SESSION['email'] = $novoEmailEsc;
    } else {
        $_SESSION['errors']['db'] = "Erro ao atualizar: " . $conn->error;
    }
    header("Location: profile.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <title>H3X | <?= trim($userNome) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <main class="mt-5 pt-5">
        <div class="container profile-container mt-5">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="avatar-wrapper">
                        <?php if (!empty($_SESSION['foto'])): ?>
                            <img src="uploads/<?= trim($userFoto) ?>" alt="Foto de Perfil" class="user-img">
                        <?php else: ?>
                            <div class="user-placeholder"><?= strtoupper(substr($userNome, 0, 1)) ?></div>
                        <?php endif; ?>
                    </div>

                    <h3><strong><?= trim($userNome) ?></strong></h3>
                    <p><strong>Email:</strong> <?= trim($email) ?></p>
                    <p><strong>Telefone:</strong>
                        <?= !empty($userTelefone) ? trim($userTelefone) : 'Sem número' ?></p>
                    <p><strong>Nascimento:</strong> <?= $userNascimento ?></p>
                    <button class="btn btn-outline-light mt-3" data-bs-toggle="modal"
                        data-bs-target="#editarPerfilModal">
                        Editar Perfil
                    </button>
                    <a href="admin/logout.php" class="btn btn-outline-danger mt-3 ms-2">
                        Logout
                    </a>


                    <div class="modal fade" id="editarPerfilModal" tabindex="-1"
                        aria-labelledby="editarPerfilModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form id="perfilForm" method="POST" enctype="multipart/form-data" action="profile.php"
                                class="modal-content border-0 shadow-lg rounded-4 p-4">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title w-100" id="editarPerfilModalLabel">Editar Perfil</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fechar"></button>
                                </div>

                                <?php if (!empty($_SESSION['errors'])): ?>
                                    <div class="alert alert-danger mx-3 my-2">
                                        <ul>
                                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                                <li><?= trim($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <?php unset($_SESSION['errors']); ?>
                                <?php endif; ?>

                                <div id="mensagemErro" class="alert alert-danger d-none"></div>

                                <div class="modal-body pt-2">
                                    <div class="mb-4">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome"
                                            value="<?= trim($userNome) ?>" required minlength="2"
                                            maxlength="15" pattern="[A-Za-zÀ-ÿ '´`-]{2,15}"
                                            title="Nome deve conter entre 2 e 15 letras.">
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="<?= trim($userEmail) ?>" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="tel" class="form-control" name="telefone" id="telefone"
                                            value="<?= trim($userTelefone) ?>" pattern="\d{9}" minlength="9"
                                            maxlength="9" title="Telefone deve conter exatamente 9 dígitos numéricos.">
                                    </div>

                                    <div class="mb-4">
                                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                        <input type="date" class="form-control" name="data_nascimento"
                                            id="data_nascimento"
                                            value="<?= date('Y-m-d', strtotime($user['data_nascimento'])) ?>" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="foto" class="form-label">Foto de Perfil</label>
                                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                                    </div>

                                    <div class="mb-4 position-relative">
                                        <label for="senha" class="form-label">Nova Senha</label>
                                        <input type="password" class="form-control" name="senha" id="senha"
                                            minlength="6" maxlength="20" placeholder="Deixe em branco para não alterar"
                                            title="A senha deve conter entre 6 e 20 caracteres.">
                                    </div>
                                </div>

                                <div class="modal-footer border-0 pt-0">
                                    <button type="submit" name="atualizar_perfil" class="btn w-100 py-2">Salvar
                                        Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

                <div class="col-md-8">
                    <h4 class="section-title"><strong>Imagens</strong></h4>
                    <div class="row">
                        <?php if (mysqli_num_rows($galeria) > 0): ?>
                            <?php while ($img = mysqli_fetch_assoc($galeria)): ?>
                                <div class="col-6 col-md-4 mb-3 gallery-item">
                                    <img src="uploads/<?= trim($img['imagem']) ?>"
                                        alt="<?= trim($img['titulo']) ?>">
                                    <small><?= trim($img['titulo']) ?></small>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Nenhuma imagem encontrada.</p>
                        <?php endif; ?>
                    </div>

                    <h4 class="section-title"><strong>Posts</strong></h4>
                    <?php if (mysqli_num_rows($posts) > 0): ?>
                        <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                            <div class="card custom-card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?= trim($post['titulo']) ?></h5>
                                    <p class="card-text"><small>Publicado em:
                                            <?= date('d/m/Y', strtotime($post['data_criacao'])) ?></small></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Sem posts ainda.</p>
                    <?php endif; ?>

                    <h4 class="section-title"><strong>Reservas VIP</strong></h4>
                    <?php if (mysqli_num_rows($reservas) > 0): ?>
                        <?php while ($reserva = mysqli_fetch_assoc($reservas)): ?>
                            <div class="card custom-card mb-3">
                                <div class="card-body">
                                    <p><strong>Mensagem:</strong> <?= trim($reserva['mensagem']) ?></p>
                                    <p><strong>Data:</strong> <?= date("d/m/Y", strtotime($reserva['data_reserva'])) ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Sem reservas VIP.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'partials/footer.php'; ?>
    <script>
        function mostrarErro(msg) {
            const alerta = document.getElementById('mensagemErro');
            alerta.textContent = msg;
            alerta.classList.remove('d-none');
        }

        function validarFormulario(event) {
            const nome = document.getElementById("nome").value.trim();
            const email = document.getElementById("email").value.trim();
            const telefone = document.getElementById("telefone").value.trim();
            const dataNascimento = document.getElementById("data_nascimento").value.trim();
            const senha = document.getElementById("senha").value.trim();
            const inputFoto = document.getElementById("foto");

            const alerta = document.getElementById('mensagemErro');
            alerta.classList.add('d-none');
            alerta.textContent = '';

            if (nome.length < 2 || nome.length > 15) {
                mostrarErro("O nome deve ter entre 2 e 15 caracteres.");
                event.preventDefault();
                return false;
            }

            if (email === "") {
                mostrarErro("O email é obrigatório.");
                event.preventDefault();
                return false;
            }

            if (email.length > 100) {
                mostrarErro("O email deve ter no máximo 100 caracteres.");
                event.preventDefault();
                return false;
            }

            if (telefone !== "") {
                if (telefone.length !== 9 || isNaN(telefone)) {
                    mostrarErro("O telefone deve conter exatamente 9 dígitos numéricos.");
                    event.preventDefault();
                    return false;
                }
            }

            if (dataNascimento === "") {
                mostrarErro("Preencha a data de nascimento.");
                event.preventDefault();
                return false;
            }

            if (senha.length > 0 && (senha.length < 6 || senha.length > 20)) {
                mostrarErro("A palavra-passe deve ter entre 6 e 20 caracteres.");
                event.preventDefault();
                return false;
            }

            if (inputFoto.files.length > 0) {
                const file = inputFoto.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
                const maxSize = 2 * 1024 * 1024;

                if (!allowedTypes.includes(file.type)) {
                    mostrarErro("Por favor, selecione um ficheiro de imagem válido (JPEG, PNG, GIF, WEBP, BMP).");
                    event.preventDefault();
                    return false;
                }

                if (file.size > maxSize) {
                    mostrarErro("A imagem não pode ter mais que 2MB.");
                    event.preventDefault();
                    return false;
                }
            }

            return true;
        }

        window.onload = function () {
            const form = document.getElementById('perfilForm');
            const modalElement = document.getElementById('editarPerfilModal');

            const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);

            form.addEventListener("submit", function (event) {
                const valido = validarFormulario(event);
                if (!valido) {
                    event.preventDefault();
                } else {
                    event.preventDefault(); 
                    form.submit();
                    modal.hide(); 
                }
            });
        }

    </script>

</body>

</html>