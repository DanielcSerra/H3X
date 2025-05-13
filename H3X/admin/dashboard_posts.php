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
<?php require 'includes/header.php'; ?>

<?php require 'includes/sidebar.php'; ?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">Posts</h2>

        <div class="d-flex align-items-center gap-2">
            <form method="GET" class="d-flex align-items-center gap-2 mb-0">
                <input type="text" name="pesquisa" class="form-control form-control-sm" placeholder="Pesquisar..."
                    style="width: 200px;">
                <button type="submit" class="btn btn-outline-secondary btn-sm px-2">
                    <i class="ri-search-line"></i>
                </button>
                <a href="dashboard_posts.php" class="btn btn-outline-danger btn-sm px-2">
                    <i class="ri-close-line"></i>
                </a>
            </form>

            <a href="adicionar_post.php" class="btn btn-dark btn-sm px-3">
                <i class="ri-add-line me-1"></i> Adicionar
            </a>
        </div>
    </div>

    <div class="table-container">
        <?php
        if (isset($_GET["pesquisa"]) && !empty($_GET["pesquisa"])) {
            $pesquisa = $_GET["pesquisa"];
            $pesquisa = mysqli_real_escape_string($conn, $pesquisa);
            $sql = "SELECT * FROM posts WHERE titulo LIKE '%$pesquisa%' OR conteudo LIKE '%$pesquisa%'";
        } else {
            $sql = "SELECT * FROM posts";
        }

        $result = $conn->query($sql);
        if ($result && $result->num_rows != 0) {
            echo '
            <table class="table table-borderless align-middle text-center shadow-sm rounded-3 overflow-hidden">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Conteúdo</th>
                        <th>Data Criação</th>
                        <th>Aprovado</th>
                        <th>Autor</th>
                        <th>Categoria</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white">';

            $count = 1;
            while ($post = $result->fetch_object()) {
                $sqlAutor = "SELECT nome FROM utilizadores WHERE id = " . (int)$post->id_utilizador;
                $resultAutor = $conn->query($sqlAutor);
                $autor = $resultAutor ? $resultAutor->fetch_object()->nome : "Desconhecido";

                $sqlCategoria = "SELECT nome FROM categorias_posts WHERE id = " . (int)$post->id_categoria;
                $resultCategoria = $conn->query($sqlCategoria);
                $categoria = $resultCategoria ? $resultCategoria->fetch_object()->nome : "Sem Categoria";

                echo '<tr class="border-bottom">
                        <td>' . $count++ . '</td>
                        <td>' . htmlspecialchars($post->titulo) . '</td>
                        <td>' . htmlspecialchars(substr($post->conteudo, 0, 100)) . '...</td>
                        <td>' . date("d/m/Y H:i", strtotime($post->data_criacao)) . '</td>
                        <td>
                            <span class="badge bg-' . ($post->aprovado === '1' ? 'success' : 'secondary') . '">
                                ' . ($post->aprovado === '1' ? 'Aprovado' : 'Pendente') . '
                            </span>
                        </td>
                        <td>' . $autor . '</td>
                        <td>' . $categoria . '</td>';

                if (!empty($post->imagem)) {
                    echo '<td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal' . $post->id . '">
                            <img src="../uploads/' . trim($post->imagem) . '" class="img-fluid" style="width: 60px; height: auto;" alt="Imagem do post">
                        </a>
                    </td>';

                    echo '<div class="modal fade" id="imageModal' . $post->id . '" tabindex="-1" aria-labelledby="imageModalLabel' . $post->id . '" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel' . $post->id . '">Imagem do Post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="../uploads/' . trim($post->imagem) . '" class="img-fluid" alt="Imagem do post">
                                    </div>
                                </div>
                            </div>
                        </div>';
                } else {
                    echo '<td><span class="text-muted">Sem imagem</span></td>';
                }

                echo '
                        <td>
                            <a href="edit_post.php?id=' . urlencode($post->id) . '" class="btn btn-link text-warning p-0 me-2">
                                <i class="ri-pencil-line"></i>
                            </a>
                            <a href="delete_post.php?id=' . urlencode($post->id) . '" class="btn btn-link text-danger p-0">
                                <i class="ri-delete-bin-line"></i>
                            </a>
                        </td>
                    </tr>';
            }
            echo '</tbody></table>';
        } else {
            echo "<p class='alert alert-warning'>Sem resultados encontrados.</p>";
        }
        ?>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
