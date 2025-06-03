<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "h3x";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Erro de ligação: " . $conn->connect_error);
}
?>