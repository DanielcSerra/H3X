<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

if (!isset($_SESSION['tipo']) || !in_array($_SESSION['tipo'], ['a'])) {
   $_SESSION["errors"]["permissions"] = "Não tens permissões para aceder.";
    header("Location: admin_dashboard.php");
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

$pageTitle = "H3X ADMIN - Utilizadores";
?>

<?php require 'partials/header.php'; ?>

<body>

    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">Utilizadores</h1>
                <div>
                    <a href="atualizar_utilizadores.php"
                        class="btn btn-outline-primary me-2 shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-sync-alt me-2"></i> Atualizar Estado
                    </a>
                    <a href="admin_utilizadores_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-user-plus me-2"></i> Adicionar Utilizador
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
            $sql = "SELECT * FROM utilizadores";
            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows != 0): ?>
                <table id="utilizadoresTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
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
                    <tbody>
                        <?php while ($utilizador = $result->fetch_object()):
                            $tipo = match ($utilizador->tipo) {
                                'a' => 'Administrador',
                                'f' => 'Funcionário',
                                default => 'Cliente'
                            };
                            ?>
                            <tr>
                                <td><?= trim($utilizador->id) ?></td>

                                <td>
                                    <?php if (!empty($utilizador->foto)): ?>
                                        <img src="../uploads/<?= trim($utilizador->foto) ?>" alt="Foto do utilizador"
                                            class="fotousutilizador">
                                    <?php else:
                                        $primeiraLetra = strtoupper(substr($utilizador->nome, 0, 1));
                                        ?>
                                        <div class="primeiraletra">
                                            <?= $primeiraLetra ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td><?= trim($utilizador->nome) ?></td>
                                <td><?= trim($utilizador->email) ?></td>
                                <td><?= trim($utilizador->telefone) ?></td>
                                <td><?= trim($utilizador->data_nascimento) ?></td>
                                <td><?= $tipo ?></td>

                                <td class="text-center">
                                    <span class="badge bg-<?= $utilizador->estado === 'a' ? 'success' : 'secondary' ?>">
                                        <?= $utilizador->estado === 'a' ? 'Ativo' : 'Desativo' ?>
                                    </span>
                                </td>

                                <td><?= trim($utilizador->ultima_atividade) ?></td>

                                <td>
                                    <a href="admin_utilizadores_edit.php?email=<?= urlencode($utilizador->email) ?>"
                                        title="Editar">
                                        <i class="fas fa-pen-to-square text-warning"></i></a>

                                    <a href="admin_utilizadores_delete.php?email=<?= urlencode($utilizador->email) ?>"
                                        title="Apagar">
                                        <i class="fas fa-trash text-danger ms-2"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class='alert alert-warning'>Sem resultados encontrados.</p>
            <?php endif; ?>

        </div>
    </div>

    <?php require 'partials/footer.php'; ?>