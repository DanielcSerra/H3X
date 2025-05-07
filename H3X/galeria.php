<?php include 'require/head.php'; ?>
<title>H3X - Galeria</title>
<link rel="stylesheet" href="css/galeria.css">
</head>

<body>
<?php include 'require/navbar.php';?>
<!--banner/mudar para estilo cruz-->
<!--Secção "fotos populares" com 4 fotos e um botão ver mais/ver album completo-->
<!--se o utilizador estiver logado ->formulário para adicionar imagem á coleção
    se o utilizador não estiver logado -> secção com botões registrar ou login-->
<!--secção de regras(lado a lado ao formulário ou em baixo dos botões-->
<main>
<div class="container">
    <h1>Galeria</h1>
</div>
<section id="populares">
    <h2>Fotos Populares</h2>

<div class="container d-flex flex-row justify-content-center">
    <div class="caixaimg">
        <img src="" alt="foto">
    </div>
    <div class="caixaimg">
        <img src="" alt="">
    </div>
    <div class="caixaimg">
        <img src="" alt="">
    </div>
    <div class="caixaimg">
        <img src="" alt="">
    </div>
</div>
<div class="botao">
    <h2>Ver album completo</h2>
</div>
</section>
</main>
</body>
<?php include 'require/footer.php';?>