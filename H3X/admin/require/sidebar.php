<?php
$fileName = basename($_SERVER["SCRIPT_NAME"]);
?>

<div class="col-md-2 sidebar">
    <div class="logo d-flex justify-content-center align-items-center mb-4">
        <img src="../img/logo.png" alt="Logo H3X" class="img-fluid">
    </div>

    <a href="#">Dashboard</a>
    <a href="dashboard_utilizadores.php"
        class="<?= $fileName == 'dashboard_utilizadores.php' ? 'sel_nav' : '' ?>">Utilizadores</a>

    <!-- Blog -->
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#postsDropdown"
            aria-expanded="<?= $fileName == 'dashboard_posts.php' ? 'true' : 'false' ?>">
            Blog
        </a>
        <div class="collapse <?= $fileName == 'dashboard_posts.php' ? 'show' : '' ?>" id="postsDropdown">
            <a href="dashboard_posts.php"
                class="ms-3 d-block <?= $fileName == 'dashboard_posts.php' ? 'sel_nav' : '' ?>">
                Posts
            </a>
            <a href="#" class="ms-3 d-block">Categorias Posts</a>
            <a href="#" class="ms-3 d-block">Comentários</a>
        </div>
    </div>

    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#vipDropdown"
            aria-expanded="false">
            VIP
        </a>
        <div class="collapse" id="vipDropdown">
            <a href="#" class="ms-3 d-block">VIP</a>
        </div>
        <div class="collapse" id="vipDropdown">
            <a href="#" class="ms-3 d-block">VIP_Mesas</a>
        </div>
        <div class="collapse" id="vipDropdown">
            <a href="#" class="ms-3 d-block">Mesas</a>
        </div>
    </div>

    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#eventosDropdown"
            aria-expanded="false">
            Eventos
        </a>
        <div class="collapse" id="eventosDropdown">
            <a href="#" class="ms-3 d-block">Eventos</a>
            <a href="#" class="ms-3 d-block">Categorias Eventos</a>
            <a href="#" class="ms-3 d-block">DJs</a>
        </div>
    </div>

    <a href="#">Galeria</a>
    <a href="#">Contactos</a>

    <hr class="text-secondary mx-3">
    <a href="../blog.php" class="btn btn-outline-light mx-3 mt-2">Voltar ao site</a>
</div>