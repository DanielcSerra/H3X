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
    $_SESSION["errors"][] = "ID do post não fornecido.";
    header("Location: admin_posts.php");
    exit();
}

$id = (int) $_GET["id"];

mysqli_report(MYSQLI_REPORT_OFF);

$sql = "SELECT * FROM posts WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    $_SESSION["errors"][] = "Post não encontrado.";
    header("Location: admin_posts.php");
    exit();
}

$post = $result->fetch_assoc();
$result->free();

if (!empty($post["imagem"])) {
    $imagemPath = "../uploads/" . $post["imagem"];
    if (file_exists($imagemPath)) {
        unlink($imagemPath);
    }
}

$deleteSql = "DELETE FROM posts WHERE id = $id";

if ($conn->query($deleteSql)) {
    $_SESSION["success"] = "Post eliminado com sucesso.";
} else {
    $_SESSION["errors"][] = "Não foi possível eliminar o post. Pode haver comentários associados.";
}
$conn->close();
header("Location: admin_posts.php");
exit();

?>