<?php
session_start();

// Verificar se o usuário não está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirecionar para a página de login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle de Qualidade de Ração</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h1>Controle de Quantidade de Ração</h1>
  
 <div id="user-info">
  <span class="welcome-message">Bem-vindo, <?php echo $_SESSION['name']; ?>!</span>
  <a href="logout.php" class="logout-button">Logout</a>
</div>
<br>
  
  <div id="inputs">
    <label for="manha">Ração Pela Manhã (kg):</label>
    <input type="number" id="manha">
    <label for="tarde">Ração Pela Tarde (kg):</label>
    <input type="number" id="tarde">
    <button onclick="adicionarRacao()">Adicionar Ração</button>
  </div>

  <table>
    <thead>
      <tr>
        <th>Data</th>
        <th>Ração Pela Manhã (kg)</th>
        <th>Ração Pela Tarde (kg)</th>
        <th>Total de Ração (kg)</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody id="table-body">
      <?php
        include 'conecta.php';
        
        // Consultar todos os lançamentos da tabela
        $query = "SELECT * FROM lancamentos";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Erro ao consultar os lançamentos: " . mysqli_error($conn));
        }

        // Variável para armazenar o total de ração usado
        $totalRacaoUsada = 0;

        // Gerar o HTML para a tabela com os lançamentos e calcular o total de ração usado
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['data'] . "</td>";
            echo "<td>" . $row['manha'] . "</td>";
            echo "<td>" . $row['tarde'] . "</td>";
            echo "<td>" . $row['total'] . "</td>";
            echo "<td><button onclick=\"excluirLancamento(this)\">x</button></td>";
            echo "</tr>";

            // Adicionar o valor do total de ração usado ao totalRacaoUsada
            $totalRacaoUsada += $row['total'];
        }
      ?>
    </tbody>
  </table>

  <p>Total de Ração Usada: <span id="totalRacao"><?php echo $totalRacaoUsada; ?></span> kg</p>

  <script src="script.js"></script>
</body>
</html>