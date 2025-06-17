<?php
session_start();
require_once 'db_config.php';
require_once "admin/ultima_atividade.php";
?>
<?php include 'partials/head.php'; ?>
<title>H3X - Album</title>
<link rel="stylesheet" href="css/galeria.css">
</head>

<body>
    <?php include 'partials/navbar.php'; ?>
    <main>
            <div id="bannertext">
            <div class="titulo">
                <h1 class="terc">ALBUM</h1>
                <h1 class="seg">ALBUM</h1>
                <h1 class="prim">ALBUM</h1>
            </div>
        </div>
            <div class="container d-flex justify-content-end mt-4">
                <div class="botao direita">
                    <h2><a href="galeria.php">Voltar á Galeria</a></h2>
                </div>
            </div>
    <!--Grande coleção de imagens que ao clicar podemos ver o post inteiro e a dar hover podemos ver o titulo-->
                <div class="d-flex flex-wrap justify-content-center gap-4 mt-4">
                <?php

                $sql = "SELECT * FROM imagens_galeria WHERE aprovado = 1 ORDER BY data_upload DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($image = $result->fetch_object()) { ?>
                    <div class="col-6 col-md-4 col-lg-3  d-flex justify-content-center">
                    <h3><?= htmlspecialchars($image->titulo) ?></h>
                        <div class="caixaimg">
                            <img class="imgborder" src="uploads/<?= htmlspecialchars($image->imagem) ?>"
                                alt="<?= htmlspecialchars($image->titulo ?: 'Gallery image') ?>">
                        </div>
                        </div>
                    <?php }

                } else { ?>


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
                <?php }
                ?>
            </div>
            </main>
    <!--seleção de página <1|2|3|...|10> ao clicar nos 3 pontos deixar utilizador adicionar um numero para ir á página respetiva-->
</body>
<?php include 'partials/footer.php'; ?>