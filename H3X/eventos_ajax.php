<?php
require_once 'db_config.php';

$hoje = date('Y-m-d');
$queryBanner = "SELECT * FROM eventos WHERE data_inicio >= '$hoje' ORDER BY data_inicio ASC LIMIT 4";
$resultBanner = mysqli_query($conn, $queryBanner);

if (mysqli_num_rows($resultBanner) === 0) {
    
    $queryBanner = "SELECT * FROM eventos WHERE data_inicio < '$hoje' ORDER BY data_inicio DESC LIMIT 1";
    $resultBanner = mysqli_query($conn, $queryBanner);
}


$eventos = [];
while ($evento = mysqli_fetch_assoc($resultBanner)) {
    $eventos[] = $evento;
}


header('Content-Type: application/json');
echo json_encode($eventos);