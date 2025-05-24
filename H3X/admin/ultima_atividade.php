<?php
$email = $_SESSION['email'];
$conn->query("UPDATE utilizadores SET ultima_atividade = NOW(), estado = 'a' WHERE email = '$email'");

?>