<?php
session_start();
require_once 'db_config.php';
require_once "admin/ultima_atividade.php";

$categorias = [];
$resultadoCategorias = mysqli_query($conn, "SELECT id, nome FROM categorias_posts ORDER BY nome");
while ($cat = mysqli_fetch_assoc($resultadoCategorias)) {
    $categorias[] = $cat;
}

$limiteIncremento = 8;
$limite = isset($_GET['limite']) ? (int) $_GET['limite'] : $limiteIncremento;
$categoriaSelecionada = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;
$pesquisa = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '';
$pesquisa = mysqli_real_escape_string($conn, $pesquisa);

$sql = "SELECT posts.id, posts.titulo, posts.conteudo, posts.imagem, posts.data_criacao,
               categorias_posts.nome AS categoria, utilizadores.nome AS autor
        FROM posts
        JOIN categorias_posts ON posts.id_categoria = categorias_posts.id
        JOIN utilizadores ON posts.id_utilizador = utilizadores.id
        WHERE posts.aprovado = 1";

if ($categoriaSelecionada > 0) {
    $sql .= " AND posts.id_categoria = $categoriaSelecionada";
}

if (!empty($pesquisa)) {
    $sql .= " AND (posts.titulo LIKE '%$pesquisa%')";
}

$sql .= " ORDER BY posts.data_criacao DESC LIMIT $limite";

$resultadoPosts = mysqli_query($conn, $sql);
$posts = [];
while ($post = mysqli_fetch_assoc($resultadoPosts)) {
    $posts[] = $post;
}

$sqlCount = "SELECT COUNT(*) as total FROM posts WHERE aprovado = 1";
if ($categoriaSelecionada > 0) {
    $sqlCount .= " AND id_categoria = $categoriaSelecionada";
}
$resultadoTotal = mysqli_query($conn, $sqlCount);
$totalPosts = mysqli_fetch_assoc($resultadoTotal)['total'];


$categorias = $conn->query("SELECT id, nome FROM categorias_posts");

$titulo = isset($_POST["titulo"]) ? trim($_POST["titulo"]) : "";
$conteudo = isset($_POST["conteudo"]) ? trim($_POST["conteudo"]) : "";
$id_categoria = $_POST["id_categoria"] ?? "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["errors"] = [];

    if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
        $_SESSION["errors"][] = "Tens de iniciar sessão para criar um post.";
    }

    if (strlen($titulo) < 5 || strlen($titulo) > 20)
        $_SESSION["errors"]["titulo"] = "Título deve ter entre 5 e 20 caracteres.";
    if (strlen($conteudo) < 10)
        $_SESSION["errors"]["conteudo"] = "Conteúdo deve ter no mínimo 10 caracteres.";
    if (strlen($id_categoria) == 0)
        $_SESSION["errors"]["id_categoria"] = "Categoria inválida.";

    if (count($_SESSION["errors"]) === 0) {
        $titulo = mysqli_real_escape_string($conn, $titulo);
        $conteudo = mysqli_real_escape_string($conn, $conteudo);
        $id_categoria = mysqli_real_escape_string($conn, $id_categoria);
        $id = $_SESSION["id"];

        $dirUpload = "uploads/blog/";
        if (!is_dir($dirUpload))
            mkdir($dirUpload, 0777, true);
        $timestamp = date("Y-m-d_H-i-s");
        $extensao = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
        $imagemNome = uniqid() . "_" . $timestamp . "." . $extensao;
        move_uploaded_file($_FILES["imagem"]["tmp_name"], "$dirUpload/$imagemNome");

        $sql = "INSERT INTO posts (titulo, conteudo, data_criacao, aprovado, id_categoria, id_utilizador, imagem)
                    VALUES ('$titulo', '$conteudo', NOW(), '0', '$id_categoria', $id,'$imagemNome')";

        if ($conn->query($sql)) {
            $_SESSION["success"] = "Post criado com sucesso.";
            header("Location: blog.php");
            exit();
        } else {
            $_SESSION["errors"]["db"] = "Erro ao inserir no banco: " . $conn->error;
        }
    } else {
        $_SESSION["errors"]["imagem"] = "Falha no upload da imagem.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'partials/head.php'; ?>
    <title>H3X - Blog</title>
    <link rel="stylesheet" href="css/blog.css">
</head>

<body>

    <?php include 'partials/navbar.php'; ?>

    <main class="px-3 px-md-5">



        <div class="container caixa-com-cantos mt-5 pt-5 px-3 position-relative">
            <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap">
                <h2 class="section-title text-center">BLOG</h2>
            </div>
        </div>




        <div class="container py-5">
            <div
                class="d-flex flex-column flex-md-row justify-content-center justify-content-md-end align-items-center gap-3 w-100 mb-5">
                <div
                    class="d-flex flex-column flex-md-row gap-3 w-md-auto justify-content-center justify-content-md-end">
                    <form method="GET" class="order-2 order-md-1">
                        <div class="input-group" style="width: 280px;">
                            <input type="text" name="pesquisa" class="form-control pesquisar py-2"
                                placeholder="Pesquisar..."
                                value="<?= isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '' ?>">
                            <button type="submit" class="btn btn-light px-3">
                                <i class="ri-search-line"></i>
                            </button>
                            <a href="blog.php" class="btn btn-light px-3">
                                <i class="ri-close-line"></i>
                            </a>

                        </div>
                    </form>


                    <form method="GET" class="order-1 order-md-2">
                        <div class="position-relative" style="width: 180px;">
                            <select name="categoria" id="categoria" class="form-select py-2"
                                onchange="this.form.submit()">
                                <option value="0">Categorias</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $categoriaSelecionada == $cat['id'] ? 'selected' : '' ?>>
                                        <?= trim($cat['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="ri-arrow-down-s-line position-absolute end-0 top-50 translate-middle-y me-3"></i>
                        </div>
                        <input type="hidden" name="pesquisa" value="<?= trim($_GET['pesquisa'] ?? '') ?>">
                        <input type="hidden" name="limite" value="<?= $limite ?>">
                    </form>
                </div>
            </div>
            <div class="row g-4">
                <?php
                $result = $conn->query($sql);
                if ($result && $result->num_rows != 0) {
                    foreach ($posts as $post): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                            <a href="post.php?id=<?= $post['id'] ?>" class="text-decoration-none text-white w-100 h-100">
                                <div class="h3x-box d-flex flex-column h-100">
                                    <div class="h3x-img-container">
                                        <img src="uploads/blog/<?= trim($post['imagem']) ?>" alt="<?= $post['titulo'] ?>"
                                            loading="lazy" />
                                    </div>

                                    <div class="h3x-content d-flex flex-column flex-grow-1 mt-2 px-2">
                                        <div class="mb-2">
                                            <h6 class="fw-bold mb-0"><?= $post['titulo'] ?></h6>
                                            <h5 class="mb-4 mt-4"><?= $post['data_criacao'] ?></h5>
                                            <h5 class="mb-0"><?= $post['autor'] ?></h5>
                                        </div>

                                        <div class="mt-auto pt-2">
                                            <i class="ri-arrow-right-up-line"></i> IR PARA POST
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;
                } else { ?>
                    <div class="bg-dark text-light border border-secondary rounded p-4 text-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Nenhum post encontrado.
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="d-flex justify-content-center my-4">
            <?php if ($limite < $totalPosts): ?>
                <a class="botao-custom px-4 py-2"
                    href="?categoria=<?= $categoriaSelecionada ?>&limite=<?= $limite + $limiteIncremento ?>">
                    + POSTS
                </a>
            <?php else: ?>
                <span class="botao-custom px-4 py-2" style="background-color:#ccc; cursor: not-allowed;">Sem mais
                    posts</span>
            <?php endif; ?>
        </div>


        <img class="barra" src="img/barrabranca.png" alt="">


        <div class="container caixa-com-cantos my-5 py-5 px-3 px-md-5 position-relative">
            <img src="img/lefttop.png" class="canto top-left d-none d-md-block" alt="">
            <img src="img/righttop.png" class="canto top-right d-none d-md-block" alt="">
            <img src="img/leftbottom.png" class="canto bottom-left d-none d-md-block" alt="">
            <img src="img/rightbottom.png" class="canto bottom-right d-none d-md-block" alt="">

            <div class="row align-items-center">
                <div class="col-12 col-md-3 d-flex justify-content-center">
                    <div class="titulo text-center text-md-start">
                        <h1 class="prim">NOVO POST</h1>
                        <h1 class="seg">NOVO POST</h1>
                        <h1 class="terc">NOVO POST</h1>
                    </div>
                </div>

                <div class="col-12 col-md-6 formulario">
                    <div class="container caixa-com-cantos py-1 px-1 position-relative">
                        <img src="img/lefttop.png" class="canto top-left d-none d-md-block" alt="">
                        <img src="img/righttop.png" class="canto top-right d-none d-md-block" alt="">
                        <img src="img/leftbottom.png" class="canto bottom-left d-none d-md-block" alt="">
                        <img src="img/rightbottom.png" class="canto bottom-right d-none d-md-block" alt="">

                        <form method="POST" enctype="multipart/form-data" class="mt-4 form-size" id="postForm">
                            <?php if (!empty($_SESSION["success"])): ?>
                                <div class="alert-custom alert-success-custom">
                                    <?= trim($_SESSION["success"]) ?>
                                </div>
                                <?php unset($_SESSION["success"]); ?>
                            <?php endif; ?>

                            <?php if (!empty($_SESSION["errors"])): ?>
                                <div class="alert-error">
                                    <ul class="mb-0">
                                        <?php foreach ($_SESSION["errors"] as $erro): ?>
                                            <li><?= trim($erro) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php unset($_SESSION["errors"]); ?>
                            <?php endif; ?>

                            <div id="mensagemErro" class="alert-error d-none"></div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título do Post</label>
                                <input type="text" class="form-control inputtext bg-transparent text-white" id="titulo"
                                    name="titulo" placeholder="Digite o título do post" required maxlength="20"
                                    pattern="^[\wÀ-ÿ\s'.,!?-]{5,20}$" title="O título deve ter entre 5 e 20 caracteres."
                                    value="<?= trim($titulo) ?>">
                            </div>

                            <div class="mb-3">
                                <label for="imagem" class="form-label">Imagem</label>
                                <input type="file" class="form-control inputtext bg-transparent text-white" id="imagem"
                                    name="imagem" accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select class="form-select select-cat" id="id_categoria" name="id_categoria" required>
                                    <option value="">Escolher categoria</option>
                                    <?php foreach ($categorias as $c): ?>
                                        <option value="<?= trim($c['id']) ?>">
                                            <?= trim($c['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="texto" class="form-label">Texto</label>
                                <textarea class="form-control inputtext bg-transparent text-white" id="conteudo"
                                    name="conteudo" rows="4" placeholder="Digite o conteúdo do post" required
                                    minlength="10"><?= trim($conteudo) ?></textarea>
                            </div>

                            <div class="d-flex justify-content-center my-4">
                                <button type="submit" class="botao-custom px-4 py-2">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-3 mt-5 mt-md-0">
                    <div class="text-center">
                        <img src="img/regras-completas.png" alt="Regras do blog"
                            class="regras-imagem img-fluid mx-auto">
                    </div>
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

        document.getElementById('postForm').addEventListener('submit', function (event) {
            const titulo = document.getElementById('titulo').value.trim();
            const conteudo = document.getElementById('conteudo').value.trim();
            const imagemInput = document.getElementById('imagem');
            const imagem = imagemInput.files;
            const categoria = document.getElementById('id_categoria').value;

            if (titulo.length < 5 || titulo.length > 20) {
                mostrarErro("O título deve ter entre 5 e 20 caracteres.");
                event.preventDefault();
                return;
            }

            if (conteudo.length < 10) {
                mostrarErro("O conteúdo deve ter no mínimo 10 caracteres.");
                event.preventDefault();
                return;
            }

            if (imagem.length === 0) {
                mostrarErro("Escolha uma imagem.");
                event.preventDefault();
                return;
            } else {
                const file = imagem[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
                const maxSize = 10 * 1024 * 1024;

                if (!allowedTypes.includes(file.type)) {
                    mostrarErro("Formato de imagem inválido. Use JPEG, PNG, GIF, WEBP ou BMP.");
                    event.preventDefault();
                    return;
                }

                if (file.size > maxSize) {
                    mostrarErro("Imagem deve ter no máximo 10MB.");
                    event.preventDefault();
                    return;
                }
            }

            if (categoria === "") {
                mostrarErro("Escolha uma categoria.");
                event.preventDefault();
                return;
            }
        });
    </script>

</body>

</html>