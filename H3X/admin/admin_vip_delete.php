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
    $_SESSION["errors"]["id"] = "ID do serviço não fornecido.";
    header("Location: admin_vip.php");
    exit();
}

$id = intval($_GET["id"]);

$sql = "SELECT * FROM vip WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Reserva VIP não encontrada.";
    header("Location: admin_vip.php");
    exit();
}

$servico = $result->fetch_assoc();



$deleteSql = "DELETE FROM vip WHERE id = $id";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Reserva VIP eliminada com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar a reserva: " . $conn->error;
}

$result->free();
$conn->close();

header("Location: admin_vip.php");
exit();
?>