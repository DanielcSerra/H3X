<?php
$servername = "localhost";
$username = "root";
$password = "Ferreira2016";
$database = "h3x";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Erro de ligação: " . $conn->connect_error);
}
?>