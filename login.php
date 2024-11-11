<?php
session_start();
include 'config/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta para verificar o usuário
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        // Verifica a senha
        if (password_verify($senha, $usuario['senha'])) {
            // Define as variáveis de sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['role'] = $usuario['role'];

            header('Location: /index.php');
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login - Fast Food</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/login.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <div class="container">
    <?php if (isset($erro)): ?>
      <p style="color: red;"><?= $erro; ?></p>
    <?php endif; ?>
    
    <!-- Formulário de Login -->
    <form class="formulario" action="login.php" method="POST">
      <div class="interna">
        <h1>ACESSAR MINHA CONTA</h1>
        <input type="email" name="email" placeholder="Email" value="<?= $email ?? ''; ?>" required>
        <input type="password" placeholder="Senha" name="senha" value="<?= $senha ?? ''; ?>" required>
        <h4>ESQUECI MINHA SENHA</h4>
      </div>

      <div class="botao">
        <input type="checkbox" value="" class="robo">
        <p>Não sou um robô</p>
      </div>
    
      <!-- O botão 'Entrar' agora está dentro do formulário -->
      <div class="botao-continuar">
        <button type="submit" id="continuar">Entrar</button> <!-- Botão de submit para o formulário -->
      </div>
      
      <div class="cadastrar">
        <p>Ainda não tem um cadastro? Clique no botão ao lado. É rápido e fácil.</p>
        <a href="cadastro.php" id="cadastro">QUERO ME CADASTRAR</a>
      </div>
    </form>
  </div>

  <?php include 'includes/footer.php'; ?>

</body>

</html>
