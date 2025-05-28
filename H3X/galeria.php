<?php  include 'require/navbar.php';
$id_utilizador = $_SESSION['id'] ?? null;

var_dump($id_utilizador);

include 'require/head.php'; 
require_once 'db_config.php';

$sql = "SELECT g.*, u.id AS id_utilizador, u.nome AS nome_utilizador
        FROM imagens_galeria g
        LEFT JOIN utilizadores u ON g.id_utilizador = u.id
        WHERE g.aprovado = 1
        ORDER BY g.data_upload DESC
        LIMIT 4";

/* $result = $conn->query($sql); */
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$popular_images = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $popular_images[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["errors"] = [];

    if (isset($_POST["titulo"])) {
        $titulo = trim($_POST["titulo"]);
    } else {
        $titulo = "";
    }

    if (strlen($titulo) == 0) {
        $_SESSION["errors"]["titulo"] = "Título inválido";
    }

    if (count($_SESSION["errors"]) === 0) {


            $imagem = "";

            if (isset($_FILES["imgfile"]) && $_FILES["imgfile"]["error"] == 0) {
                $imagem = uniqid() . "_" . basename($_FILES["imgfile"]["name"]);
                $upload_path = "uploads/galeria/" . $imagem;
                move_uploaded_file($_FILES["imgfile"]["tmp_name"], $upload_path);
            }


           $sql = "INSERT INTO imagens_galeria (titulo, imagem, id_utilizador) VALUES ('$titulo', '$imagem', '$id_utilizador')";
            if ($conn->query($sql)) {
                $_SESSION["errors"] = [];
                header("Location: galeria.php");
                exit();
            } else {
                $_SESSION["errors"]["db"] = "Erro ao inserir imagem: " . $conn->error;
            }
        }
    }

?>
<title>H3X - Galeria</title>
<link rel="stylesheet" href="css/galeria.css">
</head>

<body>

<main>
<div class="container" id="bannertext">
            <div class="titulo">
                <h1 class="terc">GALERIA</h1>
                <h1 class="seg">GALERIA</h1>
                <h1 class="prim">GALERIA</h1>
            </div>
</div>
<section id="populares">
    <div class="container">
        <h1>Fotos Populares</h1>
    </div>
<div class="container d-flex flex-column flex-md-row justify-content-center mt-4">
    <?php

    $sql = "SELECT * FROM imagens_galeria WHERE aprovado = 1 ORDER BY data_upload DESC LIMIT 4";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($image = $result->fetch_object()) {
            echo '
            <div class="caixaimg">
                <img class="imgborder" src="uploads/galeria/'.htmlspecialchars($image->imagem).'" 
                     alt="'.htmlspecialchars($image->titulo ?: 'Gallery image').'">
            </div>';
        }
    } else {

        echo '
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
        </div>';
    }
    ?>
</div>
<div class="container d-flex justify-content-end mt-4">
<div class="botao direita">
    <h2>Ver album completo</h2>
    </div>
</div>
<div class="containersubmit mt-5 mb-5">
<div class="submitimg">
<h3 class="mb-5 mt-0">Adicionar imagem á coleção</h3>
    <form method="POST" enctype=multipart/form-data>
        <div class="form-group">
            <label class="text-white" for="titulo">Título</label>
            <textarea class="form-control" id="titulo" name="titulo" rows="1"></textarea>
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