<?php
session_start();
include '../config/conexao.php';

$sql = "SELECT * FROM produtos WHERE status = 'ativo'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fast Food</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="./css/reset.css">
</head>

<body>

<?php include "../includes/header.php"?>

  <div class="container">
    <h1>Bem-vindo ao Restaurante Fast Food!</h1>
    <p>Aqui estão os produtos disponíveis:</p>

    <div class="produtos">
      <?php while ($produto = $result->fetch_assoc()) : ?>
        <div class="produto">
          <img src="https://placehold.co/400x400" alt="<?php echo $produto['nome']; ?>" style="width: 200px; height: auto;">
          <h3><?php echo $produto['nome']; ?></h3>
          <p><?php echo $produto['descricao']; ?></p>
          <p>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "cliente"): ?>
            <form action="adicionar_ao_carrinho.php" method="POST">
              <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
              <label for="quantidade">Quantidade:</label>
              <input type="number" name="quantidade" value="1" min="1">
              <input type="submit" value="Adicionar ao Carrinho">
            </form>
          <?php else :?>
            <a href="../login.php">Adicionar ao Carrinho</a>
          <?php endif ;?>
        </div>
      <?php endwhile ;?>
    </div>
  </div>
</body>

</html>
