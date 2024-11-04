<?php
session_start();
include 'config/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
  $bairro = $_POST['bairro'];
  $logradouro = $_POST['logradouro'];
  $numero = $_POST['numero'];
  $complemento = $_POST['complemento'];

  // Insere os dados no banco de dados
  $sql = "INSERT INTO usuarios (nome, email, senha, bairro, logradouro, numero, complemento) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssss", $nome, $email, $senha, $bairro, $logradouro, $numero, $complemento);

  if ($stmt->execute()) {
    echo "Usuário cadastrado com sucesso!";
  } else {
    echo "Erro ao cadastrar o usuário.";
  }
}
?>




<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cadastro de usuario - Fast Food</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/cadastro.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

</head>

<body>
  </ /?php include 'includes/header.php' ; ?>
  <div class="container">


    <?php if (isset($erro)): ?>
      <p style="color: red;"><?= $erro; ?></p>
    <?php endif; ?>

    <div class="formulario">
      <h1>CADASTRAR-SE</h1>
      <h5>CADASTRE SEUS DADOS</h5>
      <form action="login.php" method="POST">

        <input type="text" placeholder="Nome de Usuário">

        <input type="email" placeholder="Email" ame="email" required>


        <input type="password" placeholder="Senha" name="senha" required>
        <h5>COLOQUE SEU ENDEREÇO ABAIXO</h5>

        <input type="text" placeholder="Rua">

        <input type="text" placeholder="Bairro">

        <input type="number" placeholder="Número">


        <input type="text" placeholder="Complemento">
      </form>

      <a href="./login.php" id="cadastrar">CADASTRAR </a>
      <div class="ir-login">
        <a href="./login.php" id="login">FAZER LOGIN</a>
      </div>
    </div>

  </div>

  <?php include 'includes/footer.php'; ?>

</body>

</html>