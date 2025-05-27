<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: login.php");
    exit();
}

require_once "../db_config.php";
require_once 'ultima_atividade.php';

$_SESSION["errors"] = [];
$_SESSION["success"] = "";

// Verifica se foi fornecido o ID
if (!isset($_GET["id"])) {
    $_SESSION["errors"]["id"] = "ID da FAQ não fornecido.";
    header("Location: admin_faq.php");
    exit();
}

$id = (int) $_GET["id"]; // Força a ser número

// Verifica se a FAQ existe
$sql = "SELECT * FROM faq WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "FAQ não encontrada.";
    header("Location: admin_faq.php");
    exit();
}

// Elimina a FAQ
$deleteSql = "DELETE FROM faq WHERE id = $id";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "FAQ eliminada com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar FAQ: " . $conn->error;
}

header("Location: admin_faq.php");
exit();
?>
