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
    $_SESSION["errors"]["id"] = "ID do contacto não fornecido.";
    header("Location: admin_contactos.php");
    exit();
}


$id = $_GET["id"];

$sql = "SELECT * FROM contactos WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Contacto não encontrado.";
    header("Location: admin_contactos.php");
    exit();
}

// Eliminar o contacto
$deleteSql = "DELETE FROM contactos WHERE id = $id";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Contacto eliminado com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar contacto: " . $conn->error;
}

$result->free();
$conn->close();

header("Location: admin_contactos.php");
exit();
?>
