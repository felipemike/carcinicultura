<?php
include 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter a data enviada via POST
    $data = $_POST['data'];

    // Excluir o lançamento com a data especificada
    $query = "DELETE FROM lancamentos WHERE data = '$data'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Erro ao excluir o lançamento: " . mysqli_error($conn));
    }

    // Consultar todos os lançamentos da tabela
    $query = "SELECT * FROM lancamentos";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Erro ao consultar os lançamentos: " . mysqli_error($conn));
    }

    // Gerar o HTML para a tabela com os lançamentos
    $html = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr>";
        $html .= "<td>" . $row['data'] . "</td>";
        $html .= "<td>" . $row['manha'] . "</td>";
        $html .= "<td>" . $row['tarde'] . "</td>";
        $html .= "<td>" . $row['total'] . "</td>";
        $html .= "<td><button onclick=\"excluirLancamento(this)\">x</button></td>";
        $html .= "</tr>";
    }

    // Enviar o HTML da tabela como resposta para a chamada AJAX
    echo $html;
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>