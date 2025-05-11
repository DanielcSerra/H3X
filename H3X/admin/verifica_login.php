<?php
session_start();
require_once '../db_config.php'; 

$email = $_POST['email'];
$password = $_POST['password'];
$senhaHash = hash('sha512', $password);

$sql = "SELECT * FROM utilizadores WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senhaHash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['user'] = [
        'nome' => $user['nome'],
        'email' => $user['email'],
        'tipo' => $user['tipo']
    ];
    header("Location: ../blog.php");
    exit();
} else {
    echo "Email ou senha inválidos!";
}

?>
