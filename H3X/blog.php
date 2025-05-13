<?php
require_once 'db_config.php';

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
?>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'require/head.php'; ?>
    <title>H3X - Blog</title>
    <link rel="stylesheet" href="css/blog.css">
</head>

<body>

    <?php include 'require/navbar.php'; ?>

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
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                            <div class="h3x-box text-white">
                                <div class="h3x-img-container">
                                    <img src="uploads/<?= trim($post['imagem']) ?>" alt="Imagem do post" />
                                </div>
                                <div class="h3x-content mt-2 px-2">
                                    <h6 class="fw-bold"><?= $post['titulo'] ?></h6>
                                    <h5><?= $post['data_criacao'] ?></h5>
                                    <h5><?= $post['autor'] ?></h5>
                                    <a href="post.php?id=<?= $post['id'] ?>" class="post-link">
                                        <i class="ri-arrow-right-up-line"></i> IR PARA POST
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                } else {
                    echo "
<div class='bg-dark text-light border border-secondary rounded p-4 text-center'>
  <i class='bi bi-exclamation-triangle-fill me-2'></i>
  Nenhum post encontrado.
</div>";

                } ?>
            </div>
        </div>


        <div class="d-flex justify-content-center my-4">
            <?php if ($limite < $totalPosts): ?>
                <a class="botao-custom px-4 py-2"
                    href="?categoria=<?= $categoriaSelecionada ?>&limite=<?= $limite + $limiteIncremento ?>">
                    + POSTS
                </a>
            <?php else: ?>
                <span class="botao-custom px-4 py-2" style="background-color:#ccc; cursor: not-allowed;">Não há mais
                    posts</span>
            <?php endif; ?>
        </div>


        <img class="barra" src="img/barrabranca.png" alt="barrabranca">


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
                    <div class="container caixa-com-cantos py-4 px-4 position-relative">
                        <img src="img/lefttop.png" class="canto top-left d-none d-md-block" alt="">
                        <img src="img/righttop.png" class="canto top-right d-none d-md-block" alt="">
                        <img src="img/leftbottom.png" class="canto bottom-left d-none d-md-block" alt="">
                        <img src="img/rightbottom.png" class="canto bottom-right d-none d-md-block" alt="">

                        <form class="mt-4">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título do Post</label>
                                <input type="text" class="form-control inputtext bg-transparent text-white" id="titulo"
                                    placeholder="Digite o título do post">
                            </div>

                            <div class="mb-3">
                                <label for="imagem" class="form-label">Imagem</label>
                                <input type="file" class="form-control inputtext bg-transparent text-white" id="imagem"
                                    accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select class="form-select bg-transparent text-white border-white" id="categoria">
                                    <option value="categoria1">Eventos Semanais</option>
                                    <option value="categoria2">Notícias</option>
                                    <option value="categoria3">Outros</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="texto" class="form-label">Texto</label>
                                <textarea class="form-control inputtext bg-transparent text-white" id="texto" rows="4"
                                    placeholder="Digite o conteúdo do post"></textarea>
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

    <?php include 'require/footer.php'; ?>

</body>

</html>