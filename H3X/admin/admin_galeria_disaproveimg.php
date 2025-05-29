<?php
session_start();

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: login.php");
    exit();
}

require_once "../db_config.php";
require_once "ultima_atividade.php";

$_SESSION["errors"] = [];
$_SESSION["success"] = "";

if (!isset($_GET["id"])) {
    $_SESSION["errors"]["id"] = "ID da imagem não fornecida.";
    header("Location: admin_galeria.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM imagens_galeria WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Imagem não encontrada";
    $result->free();
    $conn->close();
    header("Location: admin_galeria.php");
    exit();
}

$updateSql = "UPDATE imagens_galeria SET aprovado = 0 WHERE id = $id";

if ($conn->query($updateSql)) {
    $_SESSION["success"] = "Estado da imagem atualizado com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao atualizar estado da imagem: " . $conn->error;
}

$result->free();
$conn->close();
header("Location: admin_galeria.php");
exit();