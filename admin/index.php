<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário é admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Deletar produto
if (isset($_GET['remover_id'])) {
  $remover_id = $_GET['remover_id'];
  $delete_sql = "DELETE FROM produtos WHERE id = ?";
  $stmt = $conn->prepare($delete_sql);
  $stmt->bind_param("i", $remover_id);

  if ($stmt->execute()) {
    echo "<script>alert('Produto removido com sucesso!'); window.location.href = 'index.php';</script>";
  } else {
    echo "<script>alert('Erro ao remover o produto!');</script>";
  }
  $stmt->close();
}

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Painel Admin - Fast Food</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/header.css">
</head>

<body>
  <?php include '../includes/header.php'; ?>
  <div class="container">
    <h1>Produtos</h1>

    <div class="produtos">
      <?php while ($produto = $result->fetch_assoc()) : ?>
        <div class="produto">
          <img src="../imgs/produtos/<?= $produto['imagem']; ?>" alt="<?= $produto['nome']; ?>">
          <h3><?= $produto['nome']; ?></h3>
          <p>Descrição: <?= $produto['descricao']; ?></p>
          <p>Preço: R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></p>
          <p>Status: <?= ucfirst($produto['status']); ?></p>

          <!-- Botões de edição e remoção para admin -->
          <a href="editar_produto.php?id=<?= $produto['id']; ?>">Editar</a> |
          <a href="index.php?remover_id=<?= $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja remover este produto?')">Remover</a>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
  <?php include '../includes/footer.php'; ?>

</body>

</html>

