<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="login-body">
  <h1 class="login-title">Login</h1>
  
  <form class="login-form" action="validar_login.php" method="POST">
    <label for="username">Usuário:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
  </form>

  <script src="script.js"></script>
</body>
</html>
