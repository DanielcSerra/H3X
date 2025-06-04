<?php
if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true) {
    $email = $_SESSION['email'];

    $conn->query("UPDATE utilizadores SET ultima_atividade = NOW(), estado = 'a' WHERE email = '$email'");
}
?>