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

$pageTitle = "H3X ADMIN - Reservas VIP";

require 'partials/header.php';

?>

<body>

    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="table-title m-0">Reservas VIP</h1>
                <div>
                    <a href="admin_vip_create.php" class="btn btn-success shadow-sm px-4 py-2 fw-semibold">
                        <i class="fas fa-plus me-2"></i> Adicionar Vip
                    </a>
                </div>
            </div>

            <?php require_once('partials/erros_sucesso_msgs.php'); ?>

            <?php

            $sql = "
            SELECT vip.id, vip.mensagem, vip.data_reserva,
                    utilizadores.nome AS nome_utilizador,
                    utilizadores.telefone,
                    utilizadores.email,
                    mesas.nome AS nome_mesa
            FROM vip
            LEFT JOIN utilizadores ON vip.id_utilizador = utilizadores.id
            LEFT JOIN mesas ON vip.id_mesa = mesas.id
            ORDER BY vip.id DESC
            ";
            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table id="svipTable" class="display table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome Utilizador</th>
                            <th>Mesa</th>
                            <th>Telemóvel</th>
                            <th>Email</th>
                            <th>Mensagem</th>
                            <th>Data Reserva</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($reserva = $result->fetch_object()):
                            $id = $reserva->id;
                            $nome = $reserva->nome_utilizador ?? 'Sem nome';
                            $telefone = $reserva->telefone ?? '';
                            $email = $reserva->email ?? '';
                            $nome_mesa = $reserva->nome_mesa ?? 'Sem mesa';
                            $mensagem_resumida = !empty(trim($reserva->mensagem ?? ''))
                                ? mb_strimwidth(strip_tags($reserva->mensagem ?? ''), 0, 80, '...')
                                : 'Sem mensagem';

                            $data_reserva = $reserva->data_reserva ?? '';
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= trim($nome) ?></td>
                                <td><?= trim($nome_mesa) ?></td>
                                <td><?= trim($telefone) ?></td>
                                <td><?= trim($email) ?></td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#mensagemModal<?= $id ?>">
                                        <?= trim($mensagem_resumida) ?>
                                    </a>

                                    <div class="modal fade" id="mensagemModal<?= $id ?>" tabindex="-1"
                                        aria-labelledby="mensagemModalLabel<?= $id ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mensagemModalLabel<?= $id ?>">Mensagem de
                                                        <?= trim($nome) ?>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fechar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?= nl2br(trim($reserva->mensagem ?? '')) ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= trim($data_reserva) ?></td>
                                <td>
                                    <a href="admin_vip_edit.php?id=<?= urlencode($id) ?>" title="Editar"><i
                                            class="fas fa-pen-to-square text-warning"></i></a>
                                    <a href="admin_vip_delete.php?id=<?= urlencode($id) ?>" title="Apagar" class="ms-2"><i
                                            class="fas fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="alert alert-warning">Sem reservas VIP encontradas.</p>
            <?php endif; ?>

        </div>
    </div>

    <?php require 'partials/footer.php'; ?>

</body>

</html>