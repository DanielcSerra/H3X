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
    header("Location: admin_servicos_vip.php");
    exit();
}

$id = intval($_GET["id"]);

$sql = "SELECT * FROM servicos_vip WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"]["not_found"] = "Serviço VIP não encontrado.";
    header("Location: admin_servicos_vip.php");
    exit();
}

$servico = $result->fetch_assoc();

if (!empty($servico["imagem"])) {
    $imagemPath = "../uploads/" . $servico["imagem"];
    if (file_exists($imagemPath)) {
        unlink($imagemPath);
    }
}

$deleteSql = "DELETE FROM servicos_vip WHERE id = $id";
if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Serviço VIP eliminado com sucesso.";
} else {
    $_SESSION["errors"]["db"] = "Erro ao eliminar serviço: " . $conn->error;
}

$result->free();
$conn->close();

header("Location: admin_servicos_vip.php");
exit();
?>