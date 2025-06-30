<?php
session_start();
include 'partials/head.php';
require_once 'db_config.php';

if (!isset($_GET['id'])) {
    echo "<p>Evento não especificado.</p>";
    exit;
}

$hoje = date('Y-m-d');
$queryBanner = "SELECT * FROM eventos WHERE data_inicio >= '$hoje' ORDER BY data_inicio ASC LIMIT 1";
$resultBanner = mysqli_query($conn, $queryBanner);

if (mysqli_num_rows($resultBanner) === 0) {
    // Se não houver evento futuro, pega o mais recente do passado
    $queryBanner = "SELECT * FROM eventos WHERE data_inicio < '$hoje' ORDER BY data_inicio DESC LIMIT 1";
    $resultBanner = mysqli_query($conn, $queryBanner);
}

$evento = mysqli_fetch_assoc($resultBanner);

$mostrarTodos = isset($_GET['mostrar']) && $_GET['mostrar'] === 'todos';

$queryEventos = "SELECT * FROM eventos WHERE data_inicio >= '$hoje' ORDER BY data_inicio ASC";
if (!$mostrarTodos) {
    $queryEventos .= " LIMIT 4";
}

$resultEventos = mysqli_query($conn, $queryEventos);

$eventId = intval($_GET['id']);

$query = "SELECT * FROM eventos WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $eventId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo "<p>Evento não encontrado.</p>";
    exit;
}

$evento = mysqli_fetch_assoc($result);

// Format dates
$startDate = new DateTime($evento['data_inicio']);
$endDate = new DateTime($evento['data_fim']);
$formattedDate = $startDate->format('d') . '-' . $endDate->format('d') . ' de ' . $startDate->format('F');
$formattedTime = $startDate->format('H:i') . ' - ' . $endDate->format('H:i');
?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'partials/head.php'; ?>
    <title>H3X - Eventos2</title>
    <link rel="stylesheet" href="css/eventos.css">
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHRKosi_QbT8SoLjpqlJ7D5TuvaFvebKc&callback=console.debug&libraries=maps,marker&v=beta"></script>
</head>
<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="banner2">
        <!-- Left side -->
        <div class="banner2-left">
            <video autoplay muted loop>
                <source src="uploads/Eventos/<?php echo htmlspecialchars($evento['video_banner']); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="banner2-overlay">
                <h1 class="event-title title2"><?php echo htmlspecialchars($evento['titulo']); ?></h1>
                <div class="d-flex justify-content-between align-items-end mt-auto">
                    <div class="event-lineup lineup2 text-start">
                        <?= nl2br(str_replace(';', '<br>', $evento['lineup'])); ?>
                    </div>
                    <img src="uploads/Eventos/<?php echo htmlspecialchars($evento['imagem_banner']); ?>" class="banner-right-image image2" alt="DJ Image">
                </div>
            </div>
        </div>

        <!-- Right side -->
        <div class="banner2-right">
            <div class="container caixa-com-cantos">
                <img src="img/bordatopesquerda.png" alt="corner top left" class="canto-sobre top-left d-none d-md-block">
                <img src="img/bordabotdireita.png" alt="corner bottom right" class="canto-sobre bottom-right d-none d-md-block">
                <h3>Evento</h3>
                <h2><?php echo htmlspecialchars($evento['titulo']); ?></h2>
                <div class="divisao">
                    <img src="img/barra.png">
                </div>
                <h4><?php echo $formattedDate; echo " / ".$formattedTime;?></h4>
                
                <video class="small-video" autoplay muted loop>
                    <source src="uploads/Eventos/<?php echo htmlspecialchars($evento['video_banner']); ?>" type="video/mp4">
                </video>

                <a href="vip.php" class="btn mini-button card-button">Details</a>
            </div>
        </div>
    </div>

    <div class="hr_title my-5">
        <h2 class="section-title">PRÓXIMOS EVENTOS</h2>
    </div>


    <div class="container pb-5">
        <div class="cards-container row g-4 justify-content-center text-center text-white">
            <?php while ($eventoCard = mysqli_fetch_assoc($resultEventos)) : ?>
                <div class="col-12 col-sm-6 col-lg-3 d-flex justify-content-center">
                    <div class="destaque-card">
                        <div class="card-bg" style="background-image: url('uploads/eventos/<?= $eventoCard['imagem_card'] ?>');"></div>
                        <div class="card-content">
                            <div class="event-date">
                                <?= date("d–m", strtotime($eventoCard['data_inicio'])) . ' – ' . date("d-m", strtotime($eventoCard['data_fim'])) ?>
                            </div>
                            <div class="event-title"><?= htmlspecialchars($eventoCard['titulo']); ?></div>
                            <div class="dj1-image-wrapper">
                                <img src="uploads/Eventos/<?= htmlspecialchars($eventoCard['imagem_banner']); ?>" alt="DJ" />
                            </div>
                            <div class="event-lineup">
                                <?= nl2br(str_replace(';', '<br>', htmlspecialchars($eventoCard['lineup']))); ?>
                            </div>
                        </div>
                        <a href="eventos2.php?id=<?= htmlspecialchars(urlencode($eventoCard['id'])) ?>" class="btn mini-button card-button">+ INFO</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="eventos-button">
            <a href="eventos.php" class="button-content">
                <span class="button-text">VER MAIS</span>
            </a>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>
</body>

