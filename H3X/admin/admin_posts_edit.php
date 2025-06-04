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
    $_SESSION["errors"]["not_found"] = "ID do post não fornecido.";
    header("Location: admin_posts.php");
    exit();
}

$id = (int) $_GET["id"];
$sql = "SELECT * FROM posts WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $_SESSION["errors"]["not_found"] = "Post não encontrado.";
    header("Location: admin_posts.php");
    exit();
}

$post = $result->fetch_assoc();
$result->free();

$utilizadores = $conn->query("SELECT id, nome FROM utilizadores");
$categorias = $conn->query("SELECT id, nome FROM categorias_posts");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");
    $conteudo = trim($_POST["conteudo"] ?? "");
    $aprovado = isset($_POST["aprovado"]) ? '1' : '0';
    $id_utilizador = $_POST["id_utilizador"] ?? "";
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($titulo === "")
        $_SESSION["errors"]["titulo"] = "Título inválido";
    if ($conteudo === "")
        $_SESSION["errors"]["conteudo"] = "Conteúdo inválido";
    if ($id_utilizador === "")
        $_SESSION["errors"]["id_utilizador"] = "Utilizador inválido";
    if ($id_categoria === "")
        $_SESSION["errors"]["id_categoria"] = "Categoria inválida";

    if (count($_SESSION["errors"]) === 0) {
        $titulo = mysqli_real_escape_string($conn, $titulo);
        $conteudo = mysqli_real_escape_string($conn, $conteudo);
        $id_utilizador = mysqli_real_escape_string($conn, $id_utilizador);
        $id_categoria = mysqli_real_escape_string($conn, $id_categoria);

        $imagemSql = "";
        if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === 0) {
            $dirUpload = "../uploads";

            if (!is_dir($dirUpload))
                mkdir($dirUpload, 0777, true);

            $timestamp = date("Y-m-d_H-i-s");

            $extensao = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
            $imagemNome = uniqid() . "_" . $timestamp . "." . $extensao;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], "$dirUpload/$imagemNome");

            $imagemSql = ", imagem = '$imagemNome'";
        }

        $sqlUpdate = "
            UPDATE posts 
            SET titulo = '$titulo',
                conteudo = '$conteudo',
                aprovado = '$aprovado',
                id_utilizador = '$id_utilizador',
                id_categoria = '$id_categoria'
                $imagemSql
            WHERE id = $id
        ";

        if ($conn->query($sqlUpdate)) {
            $_SESSION["success"] = "Post atualizado com sucesso.";
            header("Location: admin_posts.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao atualizar: " . $conn->error;
        }
    }
}
$pageTitle = "H3X ADMIN - Editar Post";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0"><i class="fas fa-edit me-2"></i>Editar Post</h1>
                <a href="admin_posts.php" class="btn btn-secondary shadow-sm px-4 py-2 fw-semibold">
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
            ?>

            <div class="container mt-4">
                <div class="d-flex justify-content-center">
                    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm w-100"
                        style="max-width:600px;">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" id="titulo"
                                value="<?= trim($post["titulo"]) ?>" required maxlength="20"
                                title="O título deve no maximo 20 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label for="conteudo" class="form-label">Conteúdo</label>
                            <textarea class="form-control" name="conteudo" id="conteudo" rows="10" required
                                minlength="10" title="Mínimo 10 caracteres"><?= trim($post["conteudo"]) ?></textarea>
                        </div>


                        <?php if (!empty($post["imagem"])): ?>
                            <div class="mb-3">
                                <label class="form-label d-block">Imagem Atual:</label>
                                <img src="../uploads/<?= trim($post["imagem"]) ?>" alt="Imagem do post"
                                    class="img-thumbnail" style="max-width: 150px;">
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="imagem" class="form-label">Nova Imagem (opcional)</label>
                            <input type="file" class="form-control" name="imagem" id="imagem" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="id_utilizador" class="form-label">Utilizador</label>
                            <select class="form-select" name="id_utilizador" id="id_utilizador" required>
                                <option value="">Escolher utilizador</option>
                                <?php while ($u = $utilizadores->fetch_assoc()): ?>
                                    <option value="<?= $u['id'] ?>" <?= $post["id_utilizador"] == $u['id'] ? "selected" : "" ?>>
                                        <?= trim($u['nome']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_categoria" class="form-label">Categoria</label>
                            <select class="form-select" name="id_categoria" id="id_categoria" required>
                                <option value="">Escolher categoria</option>
                                <?php while ($c = $categorias->fetch_assoc()): ?>
                                    <option value="<?= $c['id'] ?>" <?= $post["id_categoria"] == $c['id'] ? "selected" : "" ?>>
                                        <?= trim($c['nome']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="aprovado" id="aprovado" value="1"
                                <?= $post["aprovado"] ? "checked" : "" ?>>
                            <label class="form-check-label" for="aprovado">Aprovado</label>
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
    <?php $conn->close(); ?>
    <script>
        document.getElementById(' postForm').addEventListener('submit', function (submitEvent) {
            const
                titulo = document.getElementById('titulo').value.trim(); const
                    conteudo = document.getElementById('conteudo').value.trim(); const
                        imagem = document.getElementById('imagem').files.length; const
                            utilizador = document.getElementById('id_utilizador').value; const
                                categoria = document.getElementById('id_categoria').value; if (titulo.length < 5 ||
                                    titulo.length > 20) {
                alert("O título deve ter entre 5 e 20 caracteres.");
                submitEvent.preventDefault();
                return;
            }

            if (conteudo.length < 10) {
                alert("O conteúdo deve ter pelo menos 10 caracteres.");
                submitEvent.preventDefault(); return;
            } if (imagem === 0) {
                alert("Escolha uma imagem.");
                submitEvent.preventDefault(); return;
            } if (utilizador === "") {
                alert("Escolha um utilizador.");
                submitEvent.preventDefault(); return;
            } if (categoria === "") {
                alert("Escolha uma categoria.");
                submitEvent.preventDefault(); return;
            }
        }); </script>
</body>