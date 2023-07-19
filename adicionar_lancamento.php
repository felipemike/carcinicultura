<?php
include 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os valores enviados via POST
    $manha = $_POST['manha'];
    $tarde = $_POST['tarde'];
    $total = $manha + $tarde;

    // Verificar se já existe um lançamento para a data atual
    $dataAtual = date("Y-m-d");
    $queryVerifica = "SELECT * FROM lancamentos WHERE data = '$dataAtual'";
    $resultVerifica = mysqli_query($conn, $queryVerifica);
    if (!$resultVerifica) {
        die("Erro ao consultar os lançamentos: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($resultVerifica) > 0) {
    // Já existe um lançamento para a data atual, então vamos atualizá-lo
    if ($manha != 0) {
        $queryAtualiza = "UPDATE lancamentos SET manha = $manha, total = total - tarde + $manha WHERE data = '$dataAtual'";
    } else {
        $queryAtualiza = "UPDATE lancamentos SET tarde = $tarde, total = total - manha + $tarde WHERE data = '$dataAtual'";
    }
    $resultAtualiza = mysqli_query($conn, $queryAtualiza);
    if (!$resultAtualiza) {
        die("Erro ao atualizar o lançamento: " . mysqli_error($conn));
    }

    } else {
        // Não existe um lançamento para a data atual, então vamos inserir um novo
        $queryInsere = "INSERT INTO lancamentos (data, manha, tarde, total) VALUES ('$dataAtual', $manha, $tarde, $total)";
        $resultInsere = mysqli_query($conn, $queryInsere);
        if (!$resultInsere) {
            die("Erro ao inserir o lançamento: " . mysqli_error($conn));
        }
    }

    // Consultar todos os lançamentos da tabela
    $queryConsulta = "SELECT * FROM lancamentos";
    $resultConsulta = mysqli_query($conn, $queryConsulta);
    if (!$resultConsulta) {
        die("Erro ao consultar os lançamentos: " . mysqli_error($conn));
    }

    // Gerar o HTML para a tabela com os lançamentos
    $html = "";
    while ($row = mysqli_fetch_assoc($resultConsulta)) {
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