<?php

session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("location:login.php");
    exit();
}

if (!isset($_SESSION['tipo']) || !in_array($_SESSION['tipo'], ['a', 'f'])) {
    header("Location: login.php");
    exit();
}

require_once "../db_config.php";

$conn->query("UPDATE utilizadores SET estado = 'd' WHERE TIMESTAMPDIFF(MINUTE, ultima_atividade, NOW()) > 10");

header("location:admin_utilizadores.php");
exit();
?>