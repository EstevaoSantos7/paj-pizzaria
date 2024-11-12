  <?php
  session_start();
  include 'config/conexao.php';

  // Verifica se o formulário foi enviado
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Obtém os dados do formulário e faz a validação básica
      $nome = $_POST['nome'] ?? '';
      $email = $_POST['email'] ?? '';
      $senha = $_POST['senha'] ?? '';
      $bairro = $_POST['bairro'] ?? '';
      $logradouro = $_POST['logradouro'] ?? '';
      $numero = $_POST['numero'] ?? '';
      $complemento = $_POST['complemento'] ?? '';

      // Validação simples
      if (empty($nome) || empty($email) || empty($senha) || empty($bairro) || empty($logradouro) || empty($numero)) {
          $erro = "Por favor, preencha todos os campos obrigatórios.";
      } else {
          // Criptografa a senha
          $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

          // Insere os dados no banco de dados
          $sql = "INSERT INTO usuarios (nome, email, senha, bairro, logradouro, numero, complemento) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sssssss", $nome, $email, $senhaHash, $bairro, $logradouro, $numero, $complemento);

          if ($stmt->execute()) {
              // Redireciona para a página de login após sucesso
              header("Location: login.php?msg=Cadastro realizado com sucesso!");
              exit;
          } else {
              $erro = "Erro ao cadastrar o usuário. Tente novamente.";
          }
      }
  }
  ?>

  <!DOCTYPE html>
  <html lang="pt-BR">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cadastro de Usuario - Fast Food</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/cadastro.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  </head>

  <body>
    
    <div class="container">
      <?php if (isset($erro)): ?>
        <p style="color: red;"><?= $erro; ?></p>
      <?php endif; ?>

      <div class="formulario">
        <h1>CADASTRAR-SE</h1>
        <h5>CADASTRE SEUS DADOS</h5>
        <form action="" method="POST">
          <input type="text" name="nome" placeholder="Nome de Usuário" value="<?= $nome ?? ''; ?>" required>
          <input type="email" name="email" placeholder="Email" value="<?= $email ?? ''; ?>" required>
          <input type="password" name="senha" placeholder="Senha" required>
          <h5>COLOQUE SEU ENDEREÇO ABAIXO</h5>
          <input type="text" name="logradouro" placeholder="Rua" value="<?= $logradouro ?? ''; ?>" required>
          <input type="text" name="bairro" placeholder="Bairro" value="<?= $bairro ?? ''; ?>" required>
          <input type="number" name="numero" placeholder="Número" value="<?= $numero ?? ''; ?>" required>
          <input type="text" name="complemento" placeholder="Complemento" value="<?= $complemento ?? ''; ?>">

          <button type="submit" id="cadastrar">CADASTRAR</button>
        </form>

        <div class="ir-login">
          <a href="./login.php" id="login"> FAZER LOGIN</a>
        </div>
      </div>

    </div>

    <?php include 'includes/footer.php'; ?>

  </body>
  </html>
