<?php
session_start();

$fileName = basename($_SERVER["SCRIPT_NAME"]);
?>

<nav class="navbar fixed-top">
  <a href="index.php">
    <img src="img/logo.png" alt="Logo H3X">
  </a>
  <div class="menu-container">
    <?php if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true): ?>
      <a href="admin/login.php" class="login-btn text-decoration-none">Login / Registar</a>
    <?php else: ?>
      <div class="dropdown">
        <a class="login-btn dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php
            if (!empty($_SESSION['foto']) && file_exists('../uploads/' . $_SESSION['foto'])) {
                echo '<img src="../uploads/' . htmlspecialchars($_SESSION['foto']) . '" alt="Foto" style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%; margin-right: 8px;">';
            } else {
                $letra = strtoupper(substr($_SESSION['nome'], 0, 1));
                echo '<div class="bg-light text-dark rounded-circle text-center me-2 fw-bold" 
                style="width: 32px; height: 32px; line-height: 32px; display: flex; justify-content: center; align-items: center;">' . $letra . '</div>';
            }
          ?>
          <?= htmlspecialchars($_SESSION['nome']) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow-sm border-0">
          <li><a class="dropdown-item" href="admin/perfil.php">Perfil</a></li>
          <?php if (in_array($_SESSION['tipo'], ['a', 'f'])): ?>
            <li><a class="dropdown-item" href="admin/dashboard_utilizadores.php">Dashboard</a></li>
          <?php endif; ?>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="admin/logout.php">Logout</a></li>
        </ul>
      </div>
    <?php endif; ?>

    <button class="menu-toggle" id="menuToggle">
      <i class="ri-menu-line"></i>
    </button>
  </div>
</nav>


<div class="fullscreen-menu" id="fullscreenMenu">
  <div class="fullscreen-box" id="fullscreenbox">
    <a href="#" class="<?= $fileName == 'index.php' ? 'sel_nav' : '' ?>">HOME</a>
    <a href="sobrenos.php" class="<?= $fileName == 'sobrenos.php' ? 'sel_nav' : '' ?>">SOBRE NÓS</a>
    <a href="#">EVENTOS</a>
    <a href="vip.php" class="<?= $fileName == 'vip.php' ? 'sel_nav' : '' ?>">VIP</a> 
    <a href="galeria.php" class="<?= $fileName == 'galeria.php' ? 'sel_nav' : '' ?>">GALERIA</a> 
    <a href="blog.php" class="<?= $fileName == 'blog.php' ? 'sel_nav' : '' ?>">BLOG</a>
    <a href="arcade.php" class="<?= $fileName == 'arcade.php' ? 'sel_nav' : '' ?>">ARCADE</a>
    <a href="comochegar.php" class="<?= $fileName == 'comochegar.php' ? 'sel_nav' : '' ?>">COMO CHEGAR</a>
    <a href="#">CONTACTOS</a>
  </div>
</div>
