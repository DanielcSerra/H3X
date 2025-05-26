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
    $_SESSION["errors"]["id"] = "ID da categoria não fornecido.";
    header("Location: admin_categorias_posts.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM categorias_posts WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Categoria não encontrada.";
    header("Location: admin_categorias_posts.php");
    exit();
}

$verificaPosts = $conn->query("SELECT COUNT(*) as total FROM posts WHERE id_categoria = $id");
$contagem = $verificaPosts->fetch_assoc()["total"];

if ($contagem > 0) {
    $_SESSION["errors"]["ligacoes"] = "Não é possível eliminar esta categoria porque existem $contagem post(s) associados a ela.";
    header("Location: admin_categorias_posts.php");
    exit();
}

$deleteSql = "DELETE FROM categorias_posts WHERE id = $id";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Categoria eliminada com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar categoria: " . $conn->error;
}

header("Location: admin_categorias_posts.php");
exit();
