<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <?php include 'require/head.php'; ?>
    <title>H3X - Pagina</title>
    <link rel="stylesheet" href="css/arcade.css">
</head>

<body>

    <?php include 'require/navbar.php'; ?>
    <div class="hero d-flex justify-content-center align-items-center text-center position-relative">
        <h1>ARCADE</h1>


    </div>

    <main class="px-3 px-md-5">

        <div class="container caixa-com-cantos mt-5 py-5 px-3 px-md-5 position-relative">
            <img src="img/lefttop.png" class="canto top-left d-none d-md-block">
            <img src="img/righttop.png" class="canto top-right d-none d-md-block">
            <img src="img/leftbottom.png" class="canto bottom-left d-none d-md-block">
            <img src="img/rightbottom.png" class="canto bottom-right d-none d-md-block">

            <h2 class="section-title mb-4">DESTAQUES DA SALA</h2>

            <div class="row align-items-center gy-4">
                <div class="col-md-7">
                    <p>
                        A nossa sala de arcade foi desenhada para proporcionar uma experiência imersiva e eletrizante.
                        Com
                        iluminação neon, telas gigantes e som surround, vais sentir-te dentro de um verdadeiro universo
                        cyberpunk.
                        Quer sejas um jogador casual ou um competidor hardcore, temos um espaço feito à tua medida.
                    </p>
                </div>
                <div class="col-md-5 text-center">
                    <div class="image-frame mx-auto">
                    </div>
                </div>
            </div>
        </div>

        <div class="hr_title my-5">
            <hr>
            <h2 class="section-title">TIPOS DE JOGOS</h2>
            <hr>
        </div>

        <div class="container pb-5">
            <div class="row g-4 justify-content-center text-center text-white">

                <div class="col-12 col-sm-6 col-lg-3 d-flex justify-content-center">
                    <div class="destaque-card">
                        <img src="img/arcade.png" alt="Arcade Retro" class="img-fluid mb-3" style="max-height: 250px;">
                        <div class="card-text">
                            <h5 class="fw-bold mb-2">Arcade Retro</h5>
                            <p class="small">Os clássicos que nunca saem de moda.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 d-flex justify-content-center">
                    <div class="destaque-card">
                        <img src="img/simracing.png" alt="Simuladores de Corrida" class="img-fluid mb-3"
                            style="max-height: 250px;">
                        <div class="card-text">
                            <h5 class="fw-bold mb-2">Simuladores de Corrida</h5>
                            <p class="small">Acelera como se estivesses na pista.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 d-flex justify-content-center">
                    <div class="destaque-card">
                        <img src="img/dance.png" alt="Jogos de Ritmo e Dança" class="img-fluid mb-3"
                            style="max-height: 250px;">
                        <div class="card-text">
                            <h5 class="fw-bold mb-2">Jogos de Ritmo e Dança</h5>
                            <p class="small">Liberta os teus movimentos na pista.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 d-flex justify-content-center">
                    <div class="destaque-card">
                        <img src="img/vr.png" alt="Realidade Virtual" class="img-fluid mb-3" style="max-height: 250px;">
                        <div class="card-text">
                            <h5 class="fw-bold mb-2">Realidade Virtual</h5>
                            <p class="small">Mergulha num jogo fora da realidade.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <?php include 'require/footer.php'; ?>
</body>

</html>