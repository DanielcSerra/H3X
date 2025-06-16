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



$limiteIndex = 1;

$sqlIndex = "SELECT posts.id, posts.titulo, posts.conteudo, posts.imagem, posts.data_criacao,
                    categorias_posts.nome AS categoria, utilizadores.nome AS autor
             FROM posts
             JOIN categorias_posts ON posts.id_categoria = categorias_posts.id
             JOIN utilizadores ON posts.id_utilizador = utilizadores.id
             WHERE posts.aprovado = 1
             ORDER BY posts.data_criacao DESC
             LIMIT $limiteIndex";

$resultIndex = mysqli_query($conn, $sqlIndex);
$posts = [];
if ($resultIndex && mysqli_num_rows($resultIndex) > 0) {
    while ($post = mysqli_fetch_assoc($resultIndex)) {
        $posts[] = $post;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'partials/head.php'; ?>
    <title>H3X - Home Page</title>
    <link rel="stylesheet" href="css/index.css">
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHRKosi_QbT8SoLjpqlJ7D5TuvaFvebKc&callback=console.debug&libraries=maps,marker&v=beta"></script>
</head>

<body>
    <?php include 'partials/navbar.php'; ?>


    <div class="banner-container">
        <!-- H3X Rotating Logo Video -->
        <video class="h3x-logo" autoplay loop muted playsinline>
        <source src="uploads/H3X.webm" type="video/webm">
        </video>

        <!-- Butterfly Glitch Video -->
        <video class="butterfly" autoplay loop muted playsinline>
        <source src="uploads/bannervideo.mp4" type="video/mp4">
        </video>

        <!-- Buttons -->
        <div class="container">
            <div class="butoes mt-5 mb-5">

                <div class="left-button ">
                    <div class="button-content">
                    <span class="button-text">VER MAIS</span>
                    </div>
                </div>

                <div class="center-button">
                    <div class="button-content">
                    <span class="button-text">VER MAIS</span>
                    </div>
                </div>
                
                <div class="right-button">
                    <div class="button-content">
                    <span class="button-text">VER MAIS</span>
                    </div>
                </div>
            </div>
            

        </div>
        
        <!-- White Bar at Bottom -->
        <div class="divisao">
            <img src="img/barra3.png">
            <img src="img/barra3.png">
        </div>
        <div class="container mt-5">

            <div class="container caixa-com-cantos py-5 px-3 px-md-5 position-relative">
                <img src="img/bordatopesquerda.png" class="canto top-left d-none d-md-block">
                <img src="img/bordatopdireita.png" class="canto top-right d-none d-md-block">
                <img src="img/bordabotesquerda.png" class="canto bottom-left d-none d-md-block">
                <img src="img/bordabotdireita.png" class="canto bottom-right d-none d-md-block">

                <div class="titulo">
                    <h1 class="terc">EVENTOS</h1>
                    <h1 class="seg">EVENTOS</h1>
                    <h1 class="prim">EVENTOS</h1>
                </div>

                <div class="container ">
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
                                    <button class="mini-button"><span class="button-text">Details</span></button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="eventos-button">
                        <a href="eventos.php"></a> 
                        <span class="button-text">VER MAIS</span>
                    </div>

                    

                </div>

            </div>
        </div>

        <div class="white-section mt-5">
            <div class="container d-flex justify-content-between align-items-center py-4 mt-4 mb-4">
            
                <!-- Left box with image -->
                <div class="white-section-card">
                <img src="uploads/MAPAH3X.png" alt="VIP Image">
                </div>
                
                <!-- VIP big text -->
                <h1 class="vip-text">VIP</h1>
                <img class="borboleta" src="img/borboleta.png">
                
                <!-- Right box with text + button -->
                <div class="white-section-card d-flex flex-column justify-content-between">
                <div>
                    <p>A H3X oferece uma experiência VIP exclusiva para quem procura elevar a sua noite a um novo patamar. A nossa área VIP proporciona um ambiente sofisticado e reservado, onde poderá desfrutar de atendimento personalizado, acesso prioritário e uma seleção premium de bebidas. Ideal para celebrar ocasiões especiais ou simplesmente para desfrutar da noite com conforto e estilo. Reserve já a sua mesa e descubra o que significa viver a verdadeira experiência VIP na H3X.</p>
                </div>
                <button class="center-button" style="width: 100%; height: auto; padding: 1rem 0;">
                    <span class="button-text">VER MAIS</span>
                </button>
                </div>
                
            </div>
        </div>

        <section class="light-gray-section">
            <div class="container light-gray-container caixa-com-cantos">
                <!-- New corners for Sobre-Nós -->
                <img src="img/bordatopesquerda.png" alt="corner top left" class="canto-sobre top-left d-none d-md-block">
                <img src="img/bordabotdireita.png" alt="corner bottom right" class="canto-sobre bottom-right d-none d-md-block">

                <div class="content-wrapper">
                
                <!-- Left: text + button -->
                <div class="left-part">
                    <p>​A H3X é uma discoteca em Lisboa, inspirada na estética cyberpunk, que oferece uma experiência imersiva de música eletrónica. Localizada na Av. Brasília 66, em Alcântara, destaca-se por eventos temáticos semanais com DJs nacionais e internacionais.
                    Na H3X, comprometemo-nos a proporcionar um ambiente seguro, inclusivo e vibrante, onde todos são bem-vindos para celebrar a música e a cultura noturna de Lisboa.</p>
                    <button class="center-button">
                    <span class="button-text">Ver Mais</span>
                    </button>
                </div>

                <!-- Center: card with image -->
                <div class="center-card">
                    <img src="img/h3xhouse.png" alt="Sobre Nós Image" />
                </div>

                <!-- Right: sideways title -->
                <div class="right-title">
                    <h1 class="prim2">SOBRE-NÓS</h1>
                    <h1 class="seg2">SOBRE-NÓS</h1>
                    <h1 class="terc2">SOBRE-NÓS</h1>
                </div>

                </div>
            </div>
        </section>
        

        

        <section class="blog-gallery-section">
            <div class="blog-gallery-container py-4 mt-4 mb-4">
                <div class="side-column blog-side">
                    <div class="top-content">
                        <div class="rotated-title mirrored">BLOG</div>
                        
                        <div class="blog-image-stack">


                            <?php if (!empty($posts)): ?>
                            <?php foreach ($posts as $post): ?>
                                
                                    <div class="h3x-box1 text-white">
                                        <div class="h3x-img-container">
                                            <img src="uploads/<?= trim($post['imagem']) ?>" alt="Imagem do post" loading="lazy" />
                                        </div>

                                        
                                    </div>

                                    <div class="h3x-box2 text-white">
                                        <div class="h3x-content mt-2 px-2">
                                            <h6 class="fw-bold"><?= $post['titulo'] ?></h6>
                                            <h5><?= $post['data_criacao'] ?></h5>
                                            <h5><?= $post['autor'] ?></h5>
                                            <a href="post.php?id=<?= $post['id'] ?>" class="post-link">
                                                <i class="ri-arrow-right-up-line"></i> IR PARA POST
                                            </a>
                                        </div>
                                    </div>


                               
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="text-light text-center">Nenhum post encontrado.</div>
                            <?php endif; ?>

                        </div>
                       
                        
                         

                    </div>
                    <div class="bottom-button">
                        <button class="galeria-button"><span>+ IMAGENS</span></button>
                    </div>
                </div>
                 

            
                <div class="divider-bar">
                    <img src="img/barra2.png" alt="Divider bar">
                </div>

               


                <div class="side-column galeria-side">
                    <div class="top-content">
                        <div class="galeria-image-stack">

                        <div class="h3x-box1 text-white">
                            <div class="h3x-img-container">
                                <img src="img/111.jpg" alt="Gallery 1" loading="lazy" />
                            </div>              
                        </div> 

                        <div class="h3x-box1 text-white">
                            <div class="h3x-img-container">
                                <img src="img/222.jpg" alt="Gallery 2" loading="lazy" />
                            </div>              
                        </div> 

                        
                        </div>
                        <div class="rotated-title">GALERIA</div>
                        
                    </div>
                    <div class="bottom-button">
                        <button class="galeria-button"><span>+ IMAGENS</span></button>
                    </div>
                </div>
            </div>
        </section>


    <?php include 'partials/footer.php'; ?>
</body>

</html>