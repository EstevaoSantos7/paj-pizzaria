<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário é admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Lógica para processar o formulário de cadastro de produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = trim($_POST['nome']);
  $preco = $_POST['preco'];
  $imagem = $_FILES['imagem']['name']; // Nome do arquivo da imagem
  $imagem_temp = $_FILES['imagem']['tmp_name']; // Caminho temporário da imagem

  // Diretório onde as imagens serão armazenadas
  $imagem_destino = "../imgs/produtos/" . basename($imagem); // Evita problemas com caminhos relativos

  // Verifica o tamanho do arquivo (tamanho máximo de 5MB, por exemplo)
  if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) {
    $erro = "O arquivo da imagem é muito grande. O tamanho máximo permitido é 5MB.";
  } else {
    // Verifica se o diretório existe, se não, cria
    if (!is_dir("../imgs/produtos")) {
      mkdir("../imgs/produtos", 0777, true);
    }

    // Verifica se o arquivo foi movido com sucesso
    if (move_uploaded_file($imagem_temp, $imagem_destino)) {
      // Insere o novo produto no banco de dados
      $sql = "INSERT INTO produtos (nome, preco, imagem) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
          $erro = "Erro na preparação da consulta: " . $conn->error;
      } else {
          $stmt->bind_param("sds", $nome, $preco, $imagem);
          if ($stmt->execute()) {
              $msg = "Produto cadastrado com sucesso!";
          } else {
              $erro = "Erro ao cadastrar o produto: " . $stmt->error;
          }
          $stmt->close();
      }
    } else {
      $erro = "Erro ao fazer o upload do arquivo. Verifique as permissões do diretório.";
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
  <title>Adicionar Produto - Fast Food</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/produto.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <div class="container">
    <!-- Exibe mensagens de sucesso ou erro -->
    <?php if (isset($msg)): ?>
      <p style="color: green;"><?= htmlspecialchars($msg); ?></p>
    <?php elseif (isset($erro)): ?>
      <p style="color: red;"><?= htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <!-- Formulário de cadastro de produto -->
    <div class="pai">
      <h1 class="titulo">Cadastrar Produto</h1>
      <form action="adicionar_produto.php" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" id="nome" required>
        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" required>
        <label for="imagem">Imagem do Produto:</label>
        <input type="file" name="imagem" id="imagem" required>
        <div class="cadastrar">
          <button type="submit" id="cadastrar">Cadastrar Produto</button>
        </div>
      </form>
      <div class="voltar">
        <a href="../admin/index.php" id="voltar">VOLTAR</a>
      </div>
    </div>
  </div>

  <?php include '../includes/footer.php'; ?>

</body>
</html>
