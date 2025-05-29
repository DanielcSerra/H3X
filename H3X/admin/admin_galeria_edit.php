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

$pageTitle = "H3X ADMIN - Editar Imagem";

require 'partials/header.php';
?>

<body>
        <?php require 'partials/sidebar.php'; ?>
        <div class="d-flex">
        <div class="content">
                <h1 class="table-title m-0">Editar Imagem</h1>
        </div>
        </div>
        
    
<?php require 'partials/footer.php'; ?>

</body>

</html>