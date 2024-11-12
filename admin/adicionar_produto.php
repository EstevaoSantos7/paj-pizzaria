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
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $preco = $_POST['preco'];
  $imagem = $_FILES['imagem']['name']; // Nome do arquivo da imagem
  $imagem_temp = $_FILES['imagem']['tmp_name']; // Caminho temporário da imagem


  // Diretório onde as imagens serão armazenadas
  $imagem_destino = "../imgs/produtos/" . $imagem;


  // Verifica se a imagem foi movida com sucesso
  if (move_uploaded_file($imagem_temp, $imagem_destino)) {
    // Insere o novo produto no banco de dados
    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $nome, $descricao, $preco, $imagem);


    if ($stmt->execute()) {
      $msg = "Produto cadastrado com sucesso!";
    } else {
      $erro = "Erro ao cadastrar o produto.";
    }
  } else {
    $erro = "Erro ao fazer o upload da imagem.";
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
      <p style="color: green;"><?= $msg; ?></p>
    <?php elseif (isset($erro)): ?>
      <p style="color: red;"><?= $erro; ?></p>
    <?php endif; ?>


    <!-- Formulário de cadastro de produto -->
    <div class="pai">
      <h1 class="titulo">Cadastrar Produto</h1>
      <form action="adicionar_produto.php" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" id="nome" required>
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required></textarea>
        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" required>
        <label for="imagem">Imagem do Produto:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*" required>
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