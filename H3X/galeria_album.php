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
    <!--Grande coleção de imagens que ao clicar podemos ver o post inteiro e a dar hover podemos ver o titulo-->
    <!--seleção de página <1|2|3|...|10> ao clicar nos 3 pontos deixar utilizador adicionar um numero para ir á página respetiva-->
</body>
<?php include 'partials/footer.php'; ?>