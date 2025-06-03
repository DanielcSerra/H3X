<?php
session_start();
require_once 'db_config.php';
require_once "admin/ultima_atividade.php";
?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'partials/head.php'; ?>
    <title>H3X - Termos e Condições</title>
    <link rel="stylesheet" href="css/termos.css">
</head>

<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="container">
        <div class="titulo">
            <h1 class="terc">TERMOS E CONDIÇÕES</h1>
            <h1 class="seg">TERMOS E CONDIÇÕES</h1>
            <h1 class="prim">TERMOS E CONDIÇÕES</h1>
        </div>
    </div>
    <div class="texto">
        <section>
            <h2>1. Aceitação dos Termos</h2>
            <p>Ao utilizar o site H3X, você aceita estes Termos e Condições. Caso não concorde com eles, por
                favor,
                não utilize os nossos serviços.</p>
        </section>
        <section>
            <h2>2. Serviços Disponíveis</h2>
            <p>O nosso site oferece serviços como reservas online, e subscrição de newsletters. </p>
        </section>
        <section>
            <h2>3. Política de Reservas</h2>
            <p>
                Para cancelar ou alterar a sua reserva, pedimos que entre em contacto com pelo menos 24 horas de
                antecedência.</p>
        </section>
        <section>
            <h2>4. Política de Cancelamento</h2>
            <p>Para cancelar ou alterar a sua reserva, pedimos que entre em contacto com pelo menos 24 horas de
                antecedência.</p>
        </section>
        <section>
            <h2>5. Propriedade Intelectual</h2>
            <p>Não nos responsabilizamos por quaisquer danos resultantes do uso inadequado ou incorreto do nosso
                site ou dos nossos serviços, exceto quando exigido por lei.</p>
        </section>
        <section>
            <h2>7. Alterações aos Termos</h2>
            <p>Reservamo-nos o direito de modificar estes Termos e Condições a qualquer momento. As alterações
                entrarão em vigor após serem publicadas no site, e o uso continuado do site será considerado
                como
                aceitação dos novos termos.</p>
        </section>
    </div>
    <div class="barrabranca">
        <img src="img/barratermo.png" alt="Barra">
    </div>
    <div class="contactos">
        <h2>Precisa de ajuda?</h2>
        <p class="pmaior">Entre em contacto connosco</p>
        <div class="botao2">
            <img src="img/caixabranca.png">
            <h2>CONTACTOS</h2>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?>
</body>

</html>