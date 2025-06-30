<div class="sidebar" id="sidebar">
    <a href="../index.php" class="nav-link">
        <i class="fas fa-code"></i>
        <span class="link-text fw-bold">H3X</span>
    </a>

    <a href="admin_dashboard.php" class="nav-link">
        <i class="fas fa-th-large"></i>
        <span class="link-text">Dashboard</span>
    </a>

    <a href="admin_utilizadores.php" class="nav-link">
        <i class="fas fa-users"></i>
        <span class="link-text">Utilizadores</span>
    </a>

    <div class="nav-link d-flex align-items-center" data-target="dropdown3">
        <i class="fas fa-blog"></i>
        <span class="link-text">Blog</span>
        <i class="fas fa-chevron-down arrow-icon ms-auto"></i>
    </div>
    <div class="dropdown-container" id="dropdown3">
        <a href="admin_posts.php">Posts</a>
        <a href="admin_categorias_posts.php">Categorias</a>
        <a href="admin_comentarios.php">Comentários</a>
    </div>

    <div class="nav-link d-flex align-items-center" data-target="dropdown1">
        <i class="fas fa-star"></i>
        <span class="link-text">VIP</span>
        <i class="fas fa-chevron-down arrow-icon ms-auto"></i>
    </div>
    <div class="dropdown-container" id="dropdown1">
        <a href="admin_vip.php">Reservas Vip</a>
        <a href="admin_servicos_vip.php">Serviços Vip</a>
    </div>

    <a href="admin_eventos.php" class="nav-link">
        <i class="fas fa-layer-group"></i>
         <span class="link-text">Eventos</span>
    </a>

    <a href="admin_galeria.php" class="nav-link">
        <i class="fas fa-chart-line"></i>
        <span class="link-text">Galeria</span>
    </a>

    <a href="admin_faq.php" class="nav-link">
        <i class="fas fa-plug"></i>
        <span class="link-text">FAQ</span>
    </a>

    <a href="admin_contactos.php" class="nav-link">
        <i class="fas fa-chart-pie"></i>
        <span class="link-text">Contactos</span>
    </a>

    <div class="profile w-100 justify-content-between pe-3">
        <div class="d-flex align-items-center gap-2">
            <?php
            $sql = "SELECT * FROM utilizadores";
            $result = $conn->query($sql);
            if ($result && $result->num_rows != 0) {
                $user = $result->fetch_object();
                if (!empty($_SESSION["foto"])) {
                    echo '<img src="../uploads/' . trim($_SESSION["foto"]) . '" alt="Foto do usuário" class="fotousutilizador">';
                } else {
                    $primeiraLetra = strtoupper(substr($user->nome, 0, 1));
                    echo '<div class="primeiraletra">' . $primeiraLetra . '</div>';
                }
            }
            ?>
            <div class="profile-details">
                <div><?= trim($nomeUtilizador) ?></div>
                <small><?= trim($tipoLabel) ?></small>
            </div>
        </div>

        <a href="../index.php" class="btn  btn-outline-danger ms-3 btn-sm logout-btn d-flex align-items-center gap-1">
            <i class="bi bi-box-arrow-right"></i>
        </a>

    </div>



</div>