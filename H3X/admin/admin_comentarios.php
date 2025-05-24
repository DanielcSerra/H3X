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

$pageTitle = "H3X ADMIN - Comentários";
?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">Comentários</h1>
                <div>
                    <a href="admin_comentarios_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-plus me-2"></i> Adicionar Comentário
                    </a>
                </div>
            </div>

            <?php
            if (!empty($_SESSION["success"])) {
                echo "<div class='alert alert-success fade-out'>" . $_SESSION["success"] . "</div>";
                unset($_SESSION["success"]);
            }
            if (!empty($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $erro) {
                    echo "<div class='alert alert-danger fade-out'>$erro</div>";
                }
                unset($_SESSION["errors"]);
            }
            ?>

            <?php
            $sql = "SELECT 
                        c.id, c.conteudo, c.data_criacao,
                        p.titulo AS titulo_post, 
                        u.nome AS nome_utilizador
                    FROM comentarios c
                    LEFT JOIN posts p ON c.id_post = p.id
                    LEFT JOIN utilizadores u ON c.id_utilizador = u.id
                    ORDER BY c.data_criacao DESC";

            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="utilizadoresTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Conteúdo</th>
                            <th>Data</th>
                            <th>Post</th>
                            <th>Utilizador</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($comentario = $result->fetch_object()):
                            $id = $comentario->id;
                            $conteudo_resumido = mb_strimwidth($comentario->conteudo, 0, 60, '...');
                            ?>
                            <tr>
                                <td><?= $id ?></td>

                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#conteudoModal<?= $id ?>">
                                        <?= trim($conteudo_resumido) ?>
                                    </a>

                                    <div class="modal fade" id="conteudoModal<?= $id ?>" tabindex="-1"
                                        aria-labelledby="conteudoModalLabel<?= $id ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="conteudoModalLabel<?= $id ?>">Comentário
                                                        Completo</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fechar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?= trim($comentario->conteudo) ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td><?= date('d/m/Y H:i', strtotime($comentario->data_criacao)) ?></td>
                                <td><?= trim($comentario->titulo_post ?? 'Desconhecido') ?></td>
                                <td><?= trim($comentario->nome_utilizador ?? 'Anónimo') ?></td>


                                <td>
                                    <a href="admin_comentarios_edit.php?id=<?= urlencode($id) ?>" title="Editar"><i
                                            class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="admin_comentarios_delete.php?id=<?= urlencode($id) ?>" title="Apagar"
                                        class="ms-2"><i class="fas fa-trash text-danger"></i></a>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            <?php else: ?>
                <p class="alert alert-warning">Sem comentários encontrados.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php require 'partials/footer.php'; ?>
</body>

</html>