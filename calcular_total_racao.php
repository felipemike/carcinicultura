<?php
include 'conecta.php';

// Consultar a soma total da coluna 'total' na tabela 'lancamentos'
$querySoma = "SELECT SUM(total) AS totalRacao FROM lancamentos";
$resultSoma = mysqli_query($conn, $querySoma);
if (!$resultSoma) {
    die("Erro ao calcular o total de ração: " . mysqli_error($conn));
}

// Extrair o valor do total de ração usado
$row = mysqli_fetch_assoc($resultSoma);
$totalRacao = $row['totalRacao'];

// Exibir o total de ração usado
echo $totalRacao;

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>
