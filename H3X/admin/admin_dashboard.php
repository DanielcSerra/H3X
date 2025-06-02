<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
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

$pageTitle = "H3X ADMIN - Dashboard";

$sqlUtilizadores = "SELECT COUNT(*) AS total FROM utilizadores";
$result = $conn->query($sqlUtilizadores);
$totalUtilizadores = $result->fetch_assoc()['total'] ?? 0;

$sqlAtivos = "SELECT COUNT(*) AS total FROM utilizadores WHERE estado = 'a'";
$result = $conn->query($sqlAtivos);
$totalAtivos = $result->fetch_assoc()['total'] ?? 0;

$sqlPosts = "SELECT COUNT(*) AS total FROM posts";
$result = $conn->query($sqlPosts);
$totalPosts = $result->fetch_assoc()['total'] ?? 0;

$sqlVIP = "SELECT COUNT(*) AS total FROM vip";
$result = $conn->query($sqlVIP);
$totalVIP = $result->fetch_assoc()['total'] ?? 0;

$sqlEventos = "SELECT COUNT(*) AS total FROM eventos";
$result = $conn->query($sqlEventos);
$totalEventos = $result->fetch_assoc()['total'] ?? 0;

$sqlGaleria = "SELECT COUNT(*) AS total FROM imagens_por_aprovar";
$result = $conn->query($sqlGaleria);
$pedidosGaleria = $result->fetch_assoc()['total'] ?? 0;

$sqlPosts = "SELECT COUNT(*) AS total FROM posts_por_aprovar";
$result = $conn->query($sqlPosts);
$pedidosBlog = $result->fetch_assoc()['total'] ?? 0;


$sqlTipos = "SELECT tipo, COUNT(*) AS total FROM utilizadores GROUP BY tipo";
$resultTipos = $conn->query($sqlTipos);
$tiposCount = ['a' => 0, 'f' => 0, 'c' => 0];
while ($row = $resultTipos->fetch_assoc()) {
    $tiposCount[$row['tipo']] = (int) $row['total'];
}

function tipoLabel($tipo)
{
    return match ($tipo) {
        'a' => 'Administrador',
        'f' => 'Funcionário',
        'c' => 'Cliente',
        default => 'Erro',
    };
}

$sqlPostsPorSemana = "
    SELECT YEARWEEK(data_criacao, 1) AS ano_semana, COUNT(*) AS total
    FROM posts
    WHERE data_criacao >= DATE_SUB(CURDATE(), INTERVAL 8 WEEK)
    GROUP BY ano_semana
    ORDER BY ano_semana ASC
";

$resultPostsSemana = $conn->query($sqlPostsPorSemana);

$semanasLabels = [];
$postsPorSemana = [];

$meses = [
    1 => 'janeiro',
    2 => 'fevereiro',
    3 => 'março',
    4 => 'abril',
    5 => 'maio',
    6 => 'junho',
    7 => 'julho',
    8 => 'agosto',
    9 => 'setembro',
    10 => 'outubro',
    11 => 'novembro',
    12 => 'dezembro'
];

while ($row = $resultPostsSemana->fetch_assoc()) {
    $anoSemana = $row['ano_semana'];
    $ano = substr($anoSemana, 0, 4);
    $semana = substr($anoSemana, 4, 2);

    $date = new DateTime();
    $date->setISODate((int) $ano, (int) $semana);

    $dia = $date->format('d');
    $mes = (int) $date->format('m');

    $semanasLabels[] = $semana . "ª sem (" . $dia . " " . $meses[$mes] . ")";
    $postsPorSemana[] = (int) $row['total'];
}

$sqlContactos = "
    SELECT 
        COALESCE(u.nome, c.nome) AS nome,
        c.mensagem,
        c.data_contactos
    FROM contactos c
    LEFT JOIN utilizadores u ON c.id_utilizador = u.id
    ORDER BY c.data_contactos DESC
    LIMIT 5
";
$resultContactos = $conn->query($sqlContactos);



$sqlUltimasReservasVIP = "
    SELECT u.nome AS nome_cliente, v.data_reserva
    FROM vip v
    JOIN utilizadores u ON v.id_utilizador = u.id
    ORDER BY v.data_reserva DESC
    LIMIT 5
";
$resultReservasVIP = $conn->query($sqlUltimasReservasVIP);

?>

<?php require 'partials/header.php'; ?>

<body>
    <div class="d-flex">
        <?php require 'partials/sidebar.php'; ?>

        <div class="content">

            <div class="justify-content-between align-items-center mb-3">
                <h1 class="table-title m-0 mb-4">Dashboard</h1>


                <?php

                if (!empty($_SESSION["errors"])) {
                    foreach ($_SESSION["errors"] as $erro) {
                        echo "<div class='alert alert-danger fade-out'>$erro</div>";
                    }
                    unset($_SESSION["errors"]);
                }
                ?>

                <div class="row g-4 mb-5">
                    <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                        <div class="card text-white bg-primary shadow-sm rounded-4 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-people-fill fs-1"></i>
                                </div>
                                <h6 class="card-title">Utilizadores</h6>
                                <p class="fs-2 fw-bold mb-0"><?= $totalUtilizadores ?></p>
                                <small class="text-light">Ativos: <?= $totalAtivos ?></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                        <div class="card text-white bg-success shadow-sm rounded-4 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-star-fill fs-1"></i>
                                </div>
                                <h6 class="card-title">Reservas VIP</h6>
                                <p class="fs-2 fw-bold mb-0"><?= $totalVIP ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                        <div class="card text-white bg-warning shadow-sm rounded-4 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-journal-text fs-1"></i>
                                </div>
                                <h6 class="card-title">Posts no Blog</h6>
                                <p class="fs-2 fw-bold mb-0"><?= $totalPosts ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                        <div class="card text-white bg-info shadow-sm rounded-4 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-calendar-event-fill fs-1"></i>
                                </div>
                                <h6 class="card-title">Eventos Futuros</h6>
                                <p class="fs-2 fw-bold mb-0"><?= $totalEventos ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                        <div class="card text-white bg-danger shadow-sm rounded-4 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-image-fill fs-1"></i>
                                </div>
                                <h6 class="card-title">Pedidos Galeria</h6>
                                <p class="fs-2 fw-bold mb-0"><?= $pedidosGaleria ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                        <div class="card text-white bg-dark shadow-sm rounded-4 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-chat-left-text-fill fs-1"></i>
                                </div>
                                <h6 class="card-title">Pedidos Blog</h6>
                                <p class="fs-2 fw-bold mb-0"><?= $pedidosBlog ?></p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body d-flex flex-column align-items-center">
                                <h5 class="card-title text-center">Distribuição de Utilizadores por Tipo</h5>
                                <div
                                    style="display: flex; align-items: center; justify-content: center; gap: 20px; width: 100%;">
                                    <canvas id="utilizadoresChart"
                                        style="max-width: 200px; max-height: 250px;"></canvas>
                                    <div id="legendContainer"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title text-center">Posts Criados por Semana (Últimas Semanas)</h5>
                                <canvas id="postsSemanaChart" style="max-width: 100%; max-height: 250px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Últimos 5 Pedidos de Contacto</h5>
                                    <a href="admin_contactos.php" class="btn btn-primary btn-sm">Ver mais</a>
                                </div>
                                <?php if ($resultContactos && $resultContactos->num_rows > 0): ?>
                                    <div class="list-group">
                                        <?php while ($row = $resultContactos->fetch_assoc()): ?>
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="mb-1"><?= trim($row['nome']) ?></h6>
                                                    <small
                                                        class="text-muted"><?= date('d/m/Y H:i', strtotime($row['data_contactos'])) ?></small>
                                                </div>
                                                <p class="mb-1 text-truncate" style="max-width: 100%;">
                                                    <?= trim(substr($row['mensagem'] ?? '', 0, 80)) ?>
                                                    <?= (strlen($row['mensagem'] ?? '') > 80) ? '...' : '' ?>
                                                </p>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-center">Nenhum contacto encontrado.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Últimas 5 Reservas VIP</h5>
                                    <a href="admin_vip.php" class="btn btn-primary btn-sm">Ver mais</a>
                                </div>
                                <?php if ($resultReservasVIP && $resultReservasVIP->num_rows > 0): ?>
                                    <div class="list-group">
                                        <?php while ($row = $resultReservasVIP->fetch_assoc()): ?>
                                            <div class="list-group-item">
                                                <h6 class="mb-1"><?= trim($row['nome_cliente']) ?></h6>
                                                <small
                                                    class="text-muted"><?= date('d/m/Y H:i', strtotime($row['data_reserva'])) ?></small>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-center">Nenhuma reserva encontrada.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                </div>

                <script>
                    window.utilizadoresData = [
                        <?= $tiposCount['a'] ?>,
                        <?= $tiposCount['f'] ?>,
                        <?= $tiposCount['c'] ?>
                    ];

                    window.semanasLabels = <?= json_encode($semanasLabels) ?>;
                    window.postsPorSemana = <?= json_encode($postsPorSemana) ?>;
                </script>
                <script src="js/charts.js"></script>
                <?php
                if ($result)
                    $result->free();
                if ($resultTipos)
                    $resultTipos->free();
                if ($resultPostsSemana)
                    $resultPostsSemana->free();
                if ($resultContactos)
                    $resultContactos->free();
                if ($resultReservasVIP)
                    $resultReservasVIP->free();

                $conn->close();
                ?>
                <?php require 'partials/footer.php'; ?>

</body>

</html>