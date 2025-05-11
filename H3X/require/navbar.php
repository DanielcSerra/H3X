<?php
session_start();
$fileName = basename($_SERVER["SCRIPT_NAME"]);
?>

<nav class="navbar fixed-top">
  <a href="index.php">
    <img src="img/logo.png" alt="Logo H3X">
  </a>
  <div class="menu-container">
      <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['tipo'], ['a', 'f'])): ?>
    <a href="admin/dashboard_utilizadores.php" class="<?= $fileName == 'admin/dashboard_utilizadores.php' ? 'sel_nav' : '' ?>">DASHBOARD</a>
  <?php endif; ?>
    <?php if (!isset($_SESSION['user'])): ?>
      <a href="admin/login.php" class="login-btn">Login / Registar</a>
    <?php else: ?>
      <span class="login-btn"><?= htmlspecialchars($_SESSION['user']['nome']) ?></span>
      <a href="admin/logout.php" class="login-btn">Logout</a>
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
    <a href="#">VIP</a>
    <a href="#">GALERIA</a>
    <a href="blog.php" class="<?= $fileName == 'blog.php' ? 'sel_nav' : '' ?>">BLOG</a>
    <a href="arcade.php" class="<?= $fileName == 'arcade.php' ? 'sel_nav' : '' ?>">ARCADE</a>
    <a href="comochegar.php" class="<?= $fileName == 'comochegar.php' ? 'sel_nav' : '' ?>">COMO CHEGAR</a>
    <a href="#">CONTACTOS</a>
  </div>
</div>