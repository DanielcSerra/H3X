<?php include 'require/head.php'; 

?>
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
        <img class="imgborder" src="img/galeria1.jpg" alt="foto">
    </div>
    <div class="caixaimg">
        <img class="imgborder" src="img/galeria2.jpg" alt="">
    </div>
    <div class="caixaimg">
        <img class="imgborder" src="img/galeria3.jpg" alt="">
    </div>
    <div class="caixaimg">
        <img class="imgborder" src="img/galeria4.jpg" alt="">
    </div>
</div>
<div class="container d-flex justify-content-end mt-4">
<div class="botao direita">
    <h2>Ver album completo</h2>
    </div>
</div>
<div class="containersubmit mt-5 mb-5">
<div class="submitimg">
<h3 class="mb-5 mt-0">Adicionar imagem á coleção</h3>
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
            <input type="file" id="img" name="imgfile" />
                <label for="img" class="file-upload">
                    <img src="img/imgattach.png" alt="Attach file icon" />
                    <h3>Attach File</h3>
                </label>
                <div class="submit-btn-container mt-3">
                <input type="submit" value="Submeter" name="post" class="submit-btn">
                </div>
        </div>
    </form>
</div>
<div class="regras">
<h2>Olá Utilizador</h2>
<p>Antes de adicionar algo pedimos que leia as regras!</p>
<h3 class="text-white">Regras:</h3>
<p>Regra 1: Nada de conteúdo explicito</p>
<p>Regra 2: Tamanho de imagem deve ser menor que 25mb</p>
<p>Regra 3: Não use palavras ofensivas</p>
<p>Regra 4: Divertir-se</p>
</div>
</div>
</section>
</main>
</body>
<?php include 'require/footer.php';?>