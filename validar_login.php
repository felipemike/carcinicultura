<?php
session_start();

include 'conecta.php';

// Definir uma variável para a mensagem de erro
$error = "";

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os valores enviados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifique as credenciais no banco de dados
    $query = "SELECT * FROM usuarios WHERE login = '$username' AND senha = '$password'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Erro ao consultar os usuários: " . mysqli_error($conn));
    }

    // Verifique se encontrou um usuário com as credenciais fornecidas
    if (mysqli_num_rows($result) === 1) {
        // Credenciais válidas, crie uma sessão para o usuário
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Consultar o nome do usuário no banco de dados
        $nameQuery = "SELECT name FROM usuarios WHERE login = '$username'";
        $nameResult = mysqli_query($conn, $nameQuery);
        if (!$nameResult) {
            die("Erro ao consultar o nome do usuário: " . mysqli_error($conn));
        }

        // Verificar se encontrou o nome do usuário
        if (mysqli_num_rows($nameResult) === 1) {
            $nameRow = mysqli_fetch_assoc($nameResult);
            $name = $nameRow['name'];

            // Armazenar o nome do usuário na sessão
            $_SESSION['name'] = $name;
        }

        // Redirecione para a página principal
        header("Location: index.php");
        exit();
    } else {
        // Credenciais inválidas, defina a mensagem de erro
        $error = "Credenciais inválidas. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h1>Login</h1>
  
  <form class="login-form" action="validar_login.php" method="POST">
    <label for="username">Usuário:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
    <?php if (!empty($error)) { ?>
      <p class="error"><?php echo $error; ?></p>
    <?php } ?>
  </form>

  <script src="script.js"></script>
</body>
</html>