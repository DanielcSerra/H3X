<?php
session_start();
require_once 'db_config.php';
require_once "admin/ultima_atividade.php";

$postId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sqlPost = "SELECT posts.*, categorias_posts.nome AS categoria, utilizadores.nome AS autor
            FROM posts
            JOIN categorias_posts ON posts.id_categoria = categorias_posts.id
            JOIN utilizadores ON posts.id_utilizador = utilizadores.id
            WHERE posts.id = $postId AND posts.aprovado = 1";

$resultPost = mysqli_query($conn, $sqlPost);
$post = mysqli_fetch_assoc($resultPost);

if (!$post) {
    die("Post não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['authenticated']) && isset($_POST['comentario'])) {
    $comentario = mysqli_real_escape_string($conn, trim($_POST['comentario']));
    $id_utilizador = (int) $_SESSION['id'];

    if ($comentario) {
        $sqlInsert = "INSERT INTO comentarios (id_post, id_utilizador, conteudo, data_criacao)
                      VALUES ($postId, $id_utilizador, '$comentario', NOW())";
        mysqli_query($conn, $sqlInsert);
        header("Location: post.php?id=$postId");
        exit;
    }
}


$sqlComentarios = "SELECT * FROM comentarios WHERE id_post = $postId ORDER BY data_criacao DESC";
$resultComentarios = mysqli_query($conn, $sqlComentarios);
$totalComentarios = mysqli_num_rows($resultComentarios);
?>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'partials/head.php'; ?>
    <title>H3X | <?= htmlspecialchars($post['titulo']) ?></title>
    <link rel="stylesheet" href="css/post.css">
</head>

<body>

    <?php include 'partials/navbar.php'; ?>

    <main class="px-3 px-md-5">

        <div class="container post-container mt-5 pt-5">

            <div class="h3x-box">
                <img src="uploads/<?= htmlspecialchars(trim($post['imagem'])) ?>" alt="Imagem do post"
                    class="img-moldurada">
            </div>

            <div class="post-title"><?= htmlspecialchars($post['titulo']) ?></div>
            <div class="post-body"><?= nl2br(htmlspecialchars($post['conteudo'])) ?></div>
            <div class="post-meta mt-4">
                Publicado por <strong><?= htmlspecialchars($post['autor']) ?></strong> em
                <?= date("d/m/Y", strtotime($post['data_criacao'])) ?>
            </div>
            <div class="mt-5">
                <a href="blog.php" class="link-back">
                    <i class="ri-arrow-left-line"></i> Regressar ao Blog
                </a>
            </div>

        </div>

        <div class="container post-container mb-5">
            <img class="barra" src="img/barrabranca.png" alt="barrabranca">

            <div class="coment-title">COMENTÁRIOS</div>
            <div>
                <div class="coment-count"><?= $totalComentarios ?> comentário<?= $totalComentarios != 1 ? 's' : '' ?>
                </div>
                <hr>
            </div>

            <?php if (!empty($_SESSION['authenticated'])): ?>
                <form method="POST" class="coment-form">
                    <?php if (!empty($_SESSION['foto'])): ?>
                        <img src="uploads/<?= htmlspecialchars(trim($_SESSION['foto'])) ?>" alt="Foto" class="user-img">
                    <?php else: ?>
                        <div class="user-placeholder"><?= strtoupper(substr($_SESSION['nome'], 0, 1)) ?></div>
                    <?php endif; ?>

                    <div class="textarea-wrapper w-100">
                        <textarea name="comentario" class="comentario-textarea" placeholder="Escreve o teu comentário"
                            required></textarea>
                        <button type="submit" class="btn-enviar">Enviar</button>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-white mb-4">Precisas de ter <a href="admin/login.php" class="link-rosa">login</a> para
                    comentar.</p>
            <?php endif; ?>

            <?php
            $sqlComentarios = "SELECT comentarios.*, utilizadores.foto, utilizadores.nome 
                       FROM comentarios 
                       JOIN utilizadores ON comentarios.id_utilizador = utilizadores.id
                       WHERE id_post = $postId ORDER BY data_criacao DESC";
            $resultComentarios = mysqli_query($conn, $sqlComentarios);
            ?>

            <?php if (mysqli_num_rows($resultComentarios) > 0): ?>
                <?php while ($coment = mysqli_fetch_assoc($resultComentarios)): ?>
                    <div class="comentario d-flex gap-3">
                        <?php
                        if (!empty($coment['foto'])) {
                            echo '<img src="uploads/' . htmlspecialchars(trim($coment['foto'])) . '" alt="Foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">';
                        } else {
                            $letraComent = strtoupper(substr($coment['nome'], 0, 1));
                            echo '<div class="bg-light text-dark rounded-circle text-center fw-bold d-flex justify-content-center align-items-center" 
                            style="width: 40px; height: 40px;">' . $letraComent . '</div>';
                        }
                        ?>

                        <div>
                            <div class="nome"><?= htmlspecialchars($coment['nome']) ?></div>
                            <div class="data"><?= date("d/m/Y H:i", strtotime($coment['data_criacao'])) ?></div>
                            <div class="conteudo"><?= nl2br(htmlspecialchars($coment['conteudo'])) ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-white text-center">Ainda não há comentários.</p>
            <?php endif; ?>

        </div>

    </main>

    <?php include 'partials/footer.php'; ?>

</body>

</html>