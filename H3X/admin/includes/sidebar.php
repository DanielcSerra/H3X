<?php

$fileName = basename($_SERVER["SCRIPT_NAME"]);
?>


<div class="col-md-2 sidebar" style="background-color: #2C2C2C; height: 100vh; padding-top: 20px; display: flex; flex-direction: column; align-items: center;">

    <div class="logo d-flex justify-content-center align-items-center mb-4">
        <img src="../uploads/logo.png" alt="Logo H3X" class="img-fluid" style="max-width: 150px;">
    </div>

    <a href="#" class="d-block px-3 py-2 w-100 text-start <?= $fileName == 'dashboard.php' ? 'sel_nav' : '' ?>" style="font-size: 18px;">
        <i class="ri-apps-line"></i> Dashboard
    </a>

    <a href="dashboard_utilizadores.php" class="d-block px-3 py-2 w-100 text-start <?= $fileName == 'dashboard_utilizadores.php' ? 'sel_nav' : '' ?>" style="font-size: 18px;">
        <i class="ri-user-line"></i> Utilizadores
    </a>

    <div class="dropdown w-100">
        <a href="#" class="d-block px-3 py-2 text-start dropdown-toggle <?= $fileName == 'dashboard_posts.php' ? 'sel_nav' : '' ?>" data-bs-toggle="collapse" data-bs-target="#postsDropdown" aria-expanded="<?= $fileName == 'dashboard_posts.php' ? 'true' : 'false' ?>" style="font-size: 18px;">
            <i class="ri-article-line"></i> Blog
        </a>
        <div class="collapse <?= $fileName == 'dashboard_posts.php' ? 'show' : '' ?>" id="postsDropdown">
            <a href="dashboard_posts.php" class="ms-3 d-block <?= $fileName == 'dashboard_posts.php' ? 'sel_nav' : '' ?>" style="font-size: 16px;">Posts</a>
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">Categorias Posts</a>
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">Comentários</a>
        </div>
    </div>

    <div class="dropdown w-100">
        <a href="#" class="d-block px-3 py-2 text-start dropdown-toggle <?= $fileName == 'dashboard_vip.php' ? 'sel_nav' : '' ?>" data-bs-toggle="collapse" data-bs-target="#vipDropdown" aria-expanded="false" style="font-size: 18px;">
            <i class="ri-vip-line"></i> VIP
        </a>
        <div class="collapse <?= $fileName == 'dashboard_vip.php' ? 'show' : '' ?>" id="vipDropdown">
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">VIP</a>
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">VIP_Mesas</a>
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">Mesas</a>
        </div>
    </div>

    <div class="dropdown w-100">
        <a href="#" class="d-block px-3 py-2 text-start dropdown-toggle <?= $fileName == 'dashboard_eventos.php' ? 'sel_nav' : '' ?>" data-bs-toggle="collapse" data-bs-target="#eventosDropdown" aria-expanded="false" style="font-size: 18px;">
            <i class="ri-calendar-event-line"></i> Eventos
        </a>
        <div class="collapse <?= $fileName == 'dashboard_eventos.php' ? 'show' : '' ?>" id="eventosDropdown">
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">Eventos</a>
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">Categorias Eventos</a>
            <a href="#" class="ms-3 d-block" style="font-size: 16px;">DJs</a>
        </div>
    </div>

    <a href="#" class="d-block px-3 py-2 w-100 text-start" style="font-size: 18px;">
        <i class="ri-gallery-line"></i> Galeria
    </a>
    <a href="#" class="d-block px-3 py-2 w-100 text-start" style="font-size: 18px;">
        <i class="ri-mail-line"></i> Contactos
    </a>
    

    <div class="dropdown w-100">
        <a href="#" class="d-block px-3 py-2 text-start  <?= $fileName == 'dashboard_eventos.php' ? 'sel_nav' : '' ?>" data-bs-toggle="collapse" data-bs-target="#faqdropdown" aria-expanded="false" style="font-size: 18px;">
            <i class="ri-calendar-event-line"></i> FAQ
        </a>
        <div class="collapse <?= $fileName == 'dashboard_faq.php' ? 'show' : '' ?>" id="faq_dropdown">
        </div>
    </div>
    
        <div class="position-absolute bottom-0 w-100 p-3 border-top d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <?php
                $sql = "SELECT * FROM utilizadores WHERE nome = '$nomeUtilizador'";
                $result = $conn->query($sql);

                if ($result && $result->num_rows == 1) {
                    $user = $result->fetch_object();

                    if (!empty($user->foto)) {
                        echo '<td class="d-flex justify-content-center align-items-center">
            <img src="../uploads/' . trim($user->foto) . '" 
            class="me-2"
            style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;" alt="Foto do usuário">
        </td>';
                    } else {
                        $primeiraLetra = strtoupper(substr($user->nome, 0, 1));
                        echo '<td class="d-flex justify-content-center align-items-center">
            <div class="bg-light text-dark rounded-circle text-center me-2 fw-bold" 
            style="width: 40px; height: 40px; line-height: 40px; display: flex; justify-content: center; align-items: center;">
            ' . $primeiraLetra . '
            </div>
        </td>';
                    }
                }
                ?>

                <div>
                    <div class="fw-semibold text-white mb-0"><?= trim($nomeUtilizador) ?></div>
                    <small class="text-secondary"><?= $tipoLabel ?></small>
                </div>
            </div>
            <a href="../blog.php" class="btn btn-sm d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;" title="Terminar Sessão">
                <i class="ri-logout-box-r-line" style="font-size: 20px;"></i>
            </a>
        </div>
    </div>