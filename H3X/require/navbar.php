<?php
$fileName = basename($_SERVER["SCRIPT_NAME"]);
?>

<nav class="navbar fixed-top">
  <a href="index.php">
    <img src="img/logo.png" alt="Logo H3X">
  </a>
  <div class="menu-container">
    <button class="login-btn">Login / Registar</button>
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
    <a href="#">BLOG</a>
    <a href="arcade.php" class="<?= $fileName == 'arcade.php' ? 'sel_nav' : '' ?>">ARCADE</a>
    <a href="comochegar.php" class="<?= $fileName == 'comochegar.php' ? 'sel_nav' : '' ?>">COMO CHEGAR</a>
    <a href="#">CONTACTOS</a>
  </div>
</div>