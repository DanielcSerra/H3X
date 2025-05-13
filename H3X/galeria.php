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
<div class="container" id="bannertext">
            <div class="titulo">
                <h1 class="terc">GALERIA</h1>
                <h1 class="seg">GALERIA</>
                <h1 class="prim">GALERIA</h1>
            </div>
</div>
<section id="populares">
    <div class="container">
        <h1>Fotos Populares</h1>
    </div>
<div class="container d-flex flex-row justify-content-center mt-4">
    <div class="caixaimg">
        <img class="imgborder" src="" alt="foto">
    </div>
    <div class="caixaimg">
        <img class="imgborder" src="" alt="">
    </div>
    <div class="caixaimg">
        <img class="imgborder" src="" alt="">
    </div>
    <div class="caixaimg">
        <img class="imgborder" src="" alt="">
    </div>
</div>
<div class="container d-flex justify-content-end mt-4">
<div class="botao direita">
    <h2>Ver album completo</h2>
    </div>
</div>
<div class="submitimg">
<h3>Adicionar imagem á coleção</h3>
    <form method="GET">
        <div class="form-group">
            <label class="text-white" for="titulo">Título</label>
            <textarea class="form-control" id="titulo" name="titulo" rows="1"></textarea>
        </div>  
        <div class="form-group">
        <label class="text-white" for="descricao">Descrição</label>
        <div class="container caixa-com-cantos position-relative">
            <img src="img/lefttop.png" class="canto top-left d-none d-md-block">
            <img src="img/rightbottom.png" class="canto bottom-right d-none d-md-block">
            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>
        </div>
    </form>
</div>
</section>
</main>
</body>
<?php include 'require/footer.php';?>