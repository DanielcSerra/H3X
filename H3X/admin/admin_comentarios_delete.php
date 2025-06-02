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
    $_SESSION["errors"]["id"] = "ID do comentário não fornecido.";
    header("Location: admin_comentarios.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM comentarios WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Comentário não encontrado.";
    if ($result) {
        $result->free();
    }
    $conn->close();
    header("Location: admin_comentarios.php");
    exit();
}

$result->free();

$deleteSql = "DELETE FROM comentarios WHERE id = $id";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Comentário eliminado com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar comentário: " . $conn->error;
}

$conn->close();
header("Location: admin_comentarios.php");
exit();
