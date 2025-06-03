<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'partials/head.php'; ?>
    <title>H3X - Equipa</title>
    <link rel="stylesheet" href="css/equipa.css">
</head>

<body>

    <?php include 'partials/navbar.php'; ?>
    <div class="hero d-flex justify-content-center align-items-center text-center position-relative">
        <h1>A EQUIPA</h1>
    </div>
    <div class="titulo">
        <h1>FUNDADORES E GESTÃO <span class="staff">STAFF</span></h1>
    </div>
    <div class="partes-container">
        <div class="part1">
            <img src="img/fundador.png" alt="fundador">
            <h2>FUNDADOR</h2>
        </div>
        <div class="part2">
            <img src="img/manager.png" alt="manager">
            <h2>MANAGER</h2>
        </div>
    </div>

    <div class="imagem-topo">
        <img src="img/before.png" alt="Barra decorativa">
    </div>

    <section class="staff-section">
        <div class="staff2">
            <h3 class="titulo-staff">STAFF</h3>
            <div class="staff-imagens">
                <img src="img/ImagemBAR.png" alt="Staff 1">
                <img src="img/ImagemBAR2.png" alt="Staff 2">
                <img src="img/ImagemSecur.png" alt="Staff 3">
                <img src="img/ImagemDJ.png" alt="Staff 4">
            </div>
        </div>
    </section>

    <div class="barraverme">
        <img src="img/Barra.png" alt="barra" class="Barra2">
    </div>

    <div class="titulo23">
        <h1 class="prim">MOMENTOS DA EQUIPA</h1>
        <h1 class="seg">MOMENTOS DA EQUIPA</h1>
        <h1 class="terc">MOMENTOS DA EQUIPA</h1>
    </div>

    <div class="imagens-dj">
        <img src="img/imagemDJ1.png" alt="imagem DJ 1" class="Imagemdj1">
        <img src="img/imagemDJ2.png" alt="imagem DJ 2" class="Imagemdj2">
    </div>
    <?php include 'partials/footer.php'; ?>
</body>

</html>