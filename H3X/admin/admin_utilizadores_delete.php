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

if (!isset($_GET["email"])) {
    $_SESSION["errors"]["email"] = "Email não fornecido.";
    header("Location: admin_utilizadores.php");
    exit();
}

$email = mysqli_real_escape_string($conn, $_GET["email"]);

if (isset($_SESSION["email"]) && isset($_GET["email"]) && $_SESSION["email"] === $_GET["email"]) {
    $_SESSION["errors"]["self_delete"] = "Não pode eliminar o utilizador atualmente autenticado.";
    header("Location: admin_utilizadores.php");
    exit();
}


$sql = "SELECT * FROM utilizadores WHERE email = '$email'";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Utilizador não encontrado.";
    header("Location: admin_utilizadores.php");
    exit();
}

$utilizador = $result->fetch_assoc();

$postCheck = $conn->query("SELECT id FROM posts WHERE id_utilizador = " . $utilizador["id"] . " LIMIT 1");
if ($postCheck && $postCheck->num_rows > 0) {
    $_SESSION["errors"]["posts"] = "Não é possível eliminar o utilizador porque existem posts associados.";
    header("Location: admin_utilizadores.php");
    exit();
}

$comentarioCheck = $conn->query("SELECT id FROM comentarios WHERE id_utilizador = " . $utilizador["id"] . " LIMIT 1");
if ($comentarioCheck && $comentarioCheck->num_rows > 0) {
    $_SESSION["errors"]["comentarios"] = "Não é possível eliminar o utilizador porque existem comentários associados.";
    header("Location: admin_utilizadores.php");
    exit();
}

$galeriaCheck = $conn->query("SELECT id FROM imagens_galeria WHERE id_utilizador = " . $utilizador["id"] . " LIMIT 1");
if ($galeriaCheck && $galeriaCheck->num_rows > 0) {
    $_SESSION["errors"]["imagens_galeria"] = "Não é possível eliminar o utilizador porque existem imagens associadas.";
    header("Location: admin_utilizadores.php");
    exit();
}

$vipCheck = $conn->query("SELECT id FROM vip WHERE id_utilizador = " . $utilizador["id"] . " LIMIT 1");
if ($vipCheck && $vipCheck->num_rows > 0) {
    $_SESSION["errors"]["vip"] = "Não é possível eliminar o utilizador porque está associado à tabela VIP.";
    header("Location: admin_utilizadores.php");
    exit();
}

if (!empty($utilizador["foto"])) {
    $fotoPath = "../uploads/" . $utilizador["foto"];
    if (file_exists($fotoPath)) {
        unlink($fotoPath);
    }
}

$deleteSql = "DELETE FROM utilizadores WHERE email = '$email'";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Utilizador eliminado com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar utilizador: " . $conn->error;
}

$result->free();
$conn->close();

header("Location: admin_utilizadores.php");
exit();
?>