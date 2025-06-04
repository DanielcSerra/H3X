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

$pageTitle = "H3X ADMIN - Categorias Posts";
?>

<?php require 'partials/header.php'; ?>

<body>

    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">Categorias Posts</h1>
                <div>
                    <a href="admin_categorias_posts_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-plus me-2"></i> Nova Categoria
                    </a>
                </div>
            </div>

            <?php
            require_once('partials/erros_sucesso_msgs.php');
            ?>

            <?php
            $sql = "SELECT * FROM categorias_posts ORDER BY id DESC";
            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="cpostTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cat = $result->fetch_object()): ?>
                            <tr>
                                <td><?= $cat->id ?></td>
                                <td><?= trim($cat->nome) ?></td>
                                <td>
                                    <a href="admin_categorias_posts_edit.php?id=<?= urlencode($cat->id) ?>" title="Editar"><i
                                            class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $cat->id ?>"
                                        title="Apagar">
                                        <i class="fas fa-trash text-danger ms-2"></i>
                                    </a>

                                    <div class="modal fade" id="deleteModal<?= $cat->id ?>" tabindex="-1"
                                        aria-labelledby="deleteModalLabel<?= $cat->id ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $cat->id ?>">Eliminar
                                                        Categoria</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fechar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja eliminar a categoria
                                                    <strong><?= trim($cat->nome) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="admin_categorias_posts.php" class="btn btn-secondary">Cancelar</a>
                                                    <a href="admin_categorias_posts_delete.php?id=<?= urlencode($cat->id) ?>"
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
            <?php else: ?>
                <p class="alert alert-warning">Sem categorias encontradas.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php require 'partials/footer.php'; ?>
    <?php
    if ($result) {
        $result->free();
    }

    $conn->close();
    ?>
</body>

</html>