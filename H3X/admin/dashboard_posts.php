<?php
session_start();

require_once '../db_config.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['tipo'], ['a', 'f'])) {
    header("Location: login.php");
    exit();
}

$pesquisa = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : "";

$por_pagina = 10;
$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$offset = ($pagina - 1) * $por_pagina;

if (!empty($pesquisa)) {
    $like = "%$pesquisa%";

    $stmt_total = $conn->prepare("SELECT COUNT(*) FROM posts WHERE titulo LIKE ? OR conteudo LIKE ?");
    $stmt_total->bind_param("ss", $like, $like);
    $stmt_total->execute();
    $stmt_total->bind_result($total_resultados);
    $stmt_total->fetch();
    $stmt_total->close();

    $stmt = $conn->prepare("SELECT id, titulo, data_criacao, aprovado, id_utilizador, id_categoria, imagem FROM posts WHERE titulo LIKE ? OR conteudo LIKE ? ORDER BY id DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ssii", $like, $like, $por_pagina, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result_total = $conn->query("SELECT COUNT(*) as total FROM posts");
    $total_resultados = $result_total->fetch_assoc()['total'];

    $query = "SELECT id, titulo, data_criacao, aprovado, id_utilizador, id_categoria, imagem FROM posts ORDER BY id DESC LIMIT $por_pagina OFFSET $offset";
    $result = $conn->query($query);
}

$total_paginas = ceil($total_resultados / $por_pagina);
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php include 'require/sidebar.php'; ?>

            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <h2 class="m-0">Posts</h2>
                        <form class="d-flex" method="GET" action="">
                            <input class="form-control form-control-sm" type="search" name="pesquisa"
                                placeholder="Pesquisar..." value="<?= htmlspecialchars($pesquisa) ?>">
                            <button class="btn btn-sm btn-outline-secondary ms-2" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    <button class="btn btn-dark" disabled>+ Adicionar</button>
                </div>

                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Data</th>
                            <th>Aprovado</th>
                            <th>Utilizador</th>
                            <th>Categoria</th>
                            <th>Imagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['titulo']) ?></td>
                                <td><?= $row['data_criacao'] ?></td>
                                <td><?= $row['aprovado'] ? 'Sim' : 'Não' ?></td>
                                <td><?= $row['id_utilizador'] ?></td>
                                <td><?= $row['id_categoria'] ?></td>
                                <td>
                                    <?php if (!empty($row['imagem'])): ?>
                                        <img src="../<?= htmlspecialchars($row['imagem']) ?>" alt="Imagem do post">
                                    <?php else: ?>
                                        <em>Sem imagem</em>
                                    <?php endif; ?>
                                </td>
                                <td class="table-actions">
                                    <i class="bi bi-pencil-square text-primary" title="Editar"></i>
                                    <i class="bi bi-trash text-danger" title="Remover"></i>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <nav aria-label="Paginação">
                    <ul class="pagination justify-content-center mt-4">
                        <?php if ($pagina > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?pagina=<?= $pagina - 1 ?>&pesquisa=<?= urlencode($pesquisa) ?>">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?pagina=<?= $i ?>&pesquisa=<?= urlencode($pesquisa) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($pagina < $total_paginas): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?pagina=<?= $pagina + 1 ?>&pesquisa=<?= urlencode($pesquisa) ?>">Seguinte</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>