<?php
session_start();
include 'partials/head.php';
require_once 'db_config.php';
require_once "admin/ultima_atividade.php";


// Obter o evento mais próximo (futuro)
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
?>

    <title>H3X - Eventos</title>
    <link rel="stylesheet" href="css/eventos.css">
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHRKosi_QbT8SoLjpqlJ7D5TuvaFvebKc&callback=console.debug&libraries=maps,marker&v=beta"></script>
</head>

<body>
    <?php include 'partials/navbar.php';
    ?>
    <div class="banner">
        <video autoplay loop muted playsinline class="banner-video">
            <source src="uploads/Eventos/<?= htmlspecialchars($evento['video_banner']); ?>" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
        <div class="overlay"></div>


        <div class="side-video left-video">
            <video class="vertical-video" autoplay muted loop playsinline>
                <source src="img/textolateral_1.webm" type="video/webm">
                Your browser does not support the video tag.
            </video>
        </div>


        <div class="banner-left-texts">
            <div class="event-date date3">
                <?= date("d–m", strtotime($evento['data_inicio'])) . ' – ' . date("d-m", strtotime($evento['data_fim'])) ?>
            </div>
            <div class="event-title eventtitle2"><?= $evento['titulo']; ?></div>
            <div class="event-lineup lineup3">
                <?= nl2br(str_replace(';', '<br>', $evento['lineup'])); ?>
            </div>
        </div>

        <div class="center-button">
                <a href="eventos2.php?id=<?php echo urlencode($evento['id']); ?>" class="button-text">VER MAIS</a>
        </div>

        <div class="banner-right-image">
            <img src="uploads/Eventos/<?= htmlspecialchars($evento['imagem_banner']); ?>" alt="Foto DJ" />
        </div>


        <div class="side-video right-video">
            <video class="vertical-video" autoplay muted loop playsinline>
                <source src="img/textolateral_1.webm" type="video/webm">
                Your browser does not support the video tag.
            </video>
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
            <a href="?mostrar=<?= $mostrarTodos ? 'menos' : 'todos' ?>" class="button-content">
                <span class="button-text"><?= $mostrarTodos ? 'VER MENOS' : 'VER MAIS' ?></span>
            </a>
        </div>

    </div>

    <div class="white-section">
        <div class="container">
            <div class="content-box">
                <div class="hr_title mt-5">
                    <h2 class="section-title2">EVENTOS SEMANAIS</h2>
                </div>
                <div class="row-section mt-5 mb-5">

                    <div class="image-wrapper">
                        <img src="img/caixa10.png" alt="frame" class="frame-image">
                        <img src="img/tercafeira.jpg" alt="content" class="inner-image">
                    </div>
                    <div class="text-column">
                        <div class="name">
                            <div class="name2">
                                <h2>TUESDAY SPECTRUM</h2>
                                <h3>terças-feiras</h3>
                            </div>
                        </div>
                        <div class="desc1">As terças no H3X são uma transição cromática entre o caos da cidade e a paz
                            do ritmo. Em “Tuesday Spectrum”, os sons são profundos mas não pesados — techno melódico com
                            alma, linhas minimalistas que se desdobram como luz através de prismas. Uma noite para quem
                            aprecia detalhe, groove e atmosfera.</div>
                        <div class="desc2">Género musical: Melodic Techno / Deep Techno / Minimal / Downtempo</div>
                        <div class="button-wrapper">
                            <button class="custom-button">VER FOTOS</button>
                        </div>
                    </div>
                </div>


                <div class="row-section reverse-row mt-5 mb-5">
                    <div class="text-column">
                        <div class="name">
                            <div class="name2">
                                <h2>FRIDAY HAZE</h2>
                                <h3>sextas-feiras</h3>
                            </div>
                        </div>
                        <div class="desc1">Quando o sol se põe, a H3X acende. “Solar Drift” é a noite mais solar do
                            clube — grooves quentes, batidas soul e texturas suaves misturam-se com house atmosférico e
                            techno relaxado. É o preâmbulo perfeito do fim de semana, com cocktails na mão e o corpo
                            entregue ao ritmo.</div>
                        <div class="desc2">Género musical: techno House / sunset House / Soft Techno / Deep House</div>
                        <div class="button-wrapper">
                            <button class="custom-button">VER FOTOS</button>
                        </div>
                    </div>
                    <div class="image-wrapper">
                        <img src="img/caixa10.png" alt="frame" class="frame-image">
                        <img src="img/sextafeira.jpg" alt="content" class="inner-image">
                    </div>
                </div>

            </div>

        </div>


    </div>



    <script src="js/index.js"></script>
    <?php include 'partials/footer.php'; ?>
</body>