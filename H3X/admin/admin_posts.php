<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

if (!isset($_SESSION['tipo']) || !in_array($_SESSION['tipo'], ['a', 'f'])) {
    header("Location: login.php");
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

$pageTitle = "H3X ADMIN - Posts";
?>

<?php require 'partials/header.php'; ?>

<body>

    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">Posts</h1>
                <div>
                    <a href="admin_posts_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-plus me-2"></i> Adicionar Post
                    </a>
                </div>
            </div>

            <?php
            require_once('partials/erros_sucesso_msgs.php');
            ?>

            <?php
            $sql = "SELECT 
                        p.*, 
                        u.nome AS nome_utilizador, 
                        c.nome AS nome_categoria
                    FROM posts p
                    LEFT JOIN utilizadores u ON p.id_utilizador = u.id
                    LEFT JOIN categorias_posts c ON p.id_categoria = c.id";

            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="postsTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Conteúdo</th>
                            <th>Data</th>
                            <th>Aprovado</th>
                            <th>Utilizador</th>
                            <th>Categoria</th>
                            <th>Imagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = $result->fetch_object()):
                            $id = $post->id;
                            $conteudo_resumido = mb_strimwidth($post->conteudo, 0, 80, '...');
                            ?>
                            <tr>
                                <td><?= trim($id) ?></td>
                                <td><?= trim($post->titulo) ?></td>

                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#conteudoModal<?= $id ?>">
                                        <?= trim($conteudo_resumido) ?>
                                    </a>

                                    <div class="modal fade" id="conteudoModal<?= $id ?>" tabindex="-1"
                                        aria-labelledby="conteudoModalLabel<?= $id ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="conteudoModalLabel<?= $id ?>">Conteúdo
                                                        - <?= trim($post->titulo) ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fechar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?= nl2br(trim($post->conteudo)) ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td><?= date('d/m/Y H:i', strtotime($post->data_criacao)) ?></td>
                                <td>
                                    <?= $post->aprovado ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-secondary">Não</span>' ?>
                                </td>

                                <td><?= trim($post->nome_utilizador ?? 'Desconhecido') ?></td>
                                <td><?= trim($post->nome_categoria ?? 'Sem categoria') ?></td>

                                <td>
                                    <?php if (!empty($post->imagem)): ?>
                                        <img src="../uploads/<?= trim($post->imagem) ?>" alt="Imagem do post <?= $id ?>"
                                            style="width: 100px; height: 60px; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#imagemModal<?= $id ?>" />

                                        <div class="modal fade" id="imagemModal<?= $id ?>" tabindex="-1"
                                            aria-labelledby="imagemModalLabel<?= $id ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imagemModalLabel<?= $id ?>">Imagem -
                                                            <?= trim($post->titulo) ?>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fechar"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="../uploads/<?= trim($post->imagem) ?>"
                                                            alt="Imagem do post <?= $id ?>" class="img-fluid" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Sem imagem</span>
                                    <?php endif; ?>
                                </td>


                                <td>
                                    <a href="admin_posts_edit.php?id=<?= urlencode($id) ?>" title="Editar"><i
                                            class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?= $id ?>"
                                        title="Apagar">
                                        <i class="fas fa-trash text-danger ms-2"></i>
                                    </a>

                                    <div class="modal fade" id="confirmDeleteModal<?= $id ?>" tabindex="-1"
                                        aria-labelledby="confirmDeleteLabel<?= $id ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteLabel<?= $id ?>">Eliminar Post</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fechar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja eliminar o post
                                                    <strong><?= trim($post->titulo) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="admin_posts.php" class="btn btn-secondary">Cancelar</a>
                                                    <a href="admin_posts_delete.php?id=<?= urlencode($id) ?>"
                                                        class="btn btn-danger">Confirmar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php
                $result->free();
                $conn->close();
                ?>
            <?php else: ?>
                <p class="alert alert-warning">Sem resultados encontrados.</p>
            <?php endif; ?>

        </div>
    </div>

    <?php require 'partials/footer.php'; ?>


</body>

</html>