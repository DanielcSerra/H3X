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

$pageTitle = "H3X ADMIN - Utilizadores";

?>
<?php require 'includes/header.php'; ?>

<?php require 'includes/sidebar.php'; ?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">Utilizadores</h2>

        <div class="d-flex align-items-center gap-2">
            <form method="GET" class="d-flex align-items-center gap-2 mb-0">
                <input type="text" name="pesquisa" class="form-control form-control-sm" placeholder="Pesquisar..."
                    style="width: 200px;">
                <button type="submit" class="btn btn-outline-secondary btn-sm px-2">
                    <i class="ri-search-line"></i>
                </button>
                <a href="dashboard_utilizadores.php" class="btn btn-outline-danger btn-sm px-2">
                    <i class="ri-close-line"></i>
                </a>
            </form>

            <a href="adicionar.php" class="btn btn-dark btn-sm px-3">
                <i class="ri-add-line me-1"></i> Adicionar
            </a>
        </div>
    </div>

    <div class="table-container">
        <?php
        if (isset($_GET["pesquisa"]) && !empty($_GET["pesquisa"])) {
            $pesquisa = $_GET["pesquisa"];
            $pesquisa = mysqli_real_escape_string($conn, $pesquisa);
            $sql = "SELECT * FROM utilizadores WHERE nome LIKE '%$pesquisa%' OR email LIKE '%$pesquisa%' ";
        } else {
            $sql = "SELECT * FROM utilizadores";
        }

        $result = $conn->query($sql);
        if ($result && $result->num_rows != 0) {
            echo '
<table class="table table-borderless align-middle text-center shadow-sm rounded-3 overflow-hidden">
    <thead class="bg-light text-secondary">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Data Nascimento</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Última Atividade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody class="bg-white">';

            $count = 1;
            while ($user = $result->fetch_object()) {
                switch ($user->tipo) {
                    case 'a':
                        $tipo = 'Administrador';
                        break;
                    case 'f':
                        $tipo = 'Funcionário';
                        break;
                    default:
                        $tipo = 'Cliente';
                        break;
                }

                echo '<tr class="border-bottom">
        <td>' . $count++ . '</td>';

                // FOTO
                if (!empty($user->foto)) {
                    echo '<td class="d-flex justify-content-center align-items-center">
            <img src="../uploads/' . trim($user->foto) . '" 
            class="me-2"
            style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" alt="Foto do usuário">
        </td>';
                } else {
                    $primeiraLetra = strtoupper(substr($user->nome, 0, 1));
                    echo '<td class="d-flex justify-content-center align-items-center">
            <div class="bg-light text-dark rounded-circle text-center me-2 fw-bold" 
            style="width: 40px; height: 40px; line-height: 40px; display: flex; justify-content: center; align-items: center;">
            ' . $primeiraLetra . '
            </div>
        </td>';
                }

                echo '
        <td>' . trim($user->nome) . '</td>
        <td>' . trim($user->email) . '</td>
        <td>' . trim($user->telefone) . '</td>
        <td>' . trim($user->data_nascimento) . '</td>
        <td>' . $tipo . '</td>
        <td>
            <span class="badge bg-' . ($user->estado === 'a' ? 'success' : 'secondary') . '">
                ' . ($user->estado === 'a' ? 'Ativo' : 'Desativo') . '
            </span>
        </td>
        <td>' . trim($user->ultima_atividade) . '</td>
        <td>
            <a href="edit.php?email=' . urlencode($user->email) . '" class="btn btn-link text-warning p-0 me-2">
                <i class="ri-pencil-line"></i>
            </a>
            <a href="delete.php?email=' . urlencode($user->email) . '" class="btn btn-link text-danger p-0">
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