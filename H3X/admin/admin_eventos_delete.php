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

if (!isset($_GET["id"])) {
    $_SESSION["errors"]["id"] = "ID do evento não fornecido.";
    header("Location: admin_eventos.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM eventos WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Evento não encontrado.";
    header("Location: admin_eventos.php");
    exit();
}

$evento = $result->fetch_assoc();


if (!empty($evento["imagem"])) {
    $imagemPath = "../uploads/" . $evento["imagem"];
    if (file_exists($imagemPath)) {
        unlink($imagemPath);
    }
}


$deleteSql = "DELETE FROM eventos WHERE id = $id";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Evento eliminado com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar evento: " . $conn->error;
}

$result->free();
$conn->close();

header("Location: admin_eventos.php");
exit();
?>