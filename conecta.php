<?php
$host = 'localhost';
$username = 'root';
$password = 'blink182182';
$database = 'controle_racao';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
