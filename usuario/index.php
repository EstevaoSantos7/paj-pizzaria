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
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/header.css">
</head>

<body>

  <?php include "../includes/header.php" ?>

  <div class="container">
    <h1>Bem-vindo ao Restaurante Fast Food!</h1>
    <p>Aqui estão os produtos disponíveis:</p>

    <!-- Seção para exibir todas as pizzas -->
    <div class="continer">
      <h1>EXPERIMENTE NOSSAS PIZZAS</h1>

      <!-- Início das pizzas dinâmicas -->
      <div class="pizzas">
        <?php
        // Loop para exibir todas as pizzas
        while ($produto = $result->fetch_assoc()) : ?>
          <div class="pizza">
            <div class="descricao-pizza">
              <p class="titulo-pizza"><?php echo $produto['nome']; ?></p>
              <a href="adicionar_ao_carrinho.php?id=<?php echo $produto['id']; ?>" class="adicionar">ADICIONAR AO CARRINHO</a>
              <p class="preco-cima">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            </div>
            <div class="baixo">
              <h1 class="nome-pizza"><?php echo $produto['nome']; ?></h1>
              <div class="back">
                <strong class="preco-baixo">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong>
                <img src="../imgs/produtos/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" class="piza">
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- Mostrar as pizzas em um formato de listagem geral -->
    <div class="produtos">
      <?php
      // Reiniciar o ponteiro do resultado para percorrer novamente
      $result->data_seek(0); // Reseta o ponteiro do resultado

      // Loop para exibir todos os produtos
      while ($produto = $result->fetch_assoc()) : ?>
        <div class="produto">
          <img src="../imgs/produtos/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" style="width: 200px; height: auto;">
          <h3><?php echo $produto['nome']; ?></h3>
          <p>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "cliente"): ?>
            <form action="adicionar_ao_carrinho.php" method="POST">
              <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
              <label for="quantidade">Quantidade:</label>
              <input type="number" name="quantidade" value="1" min="1">
              <input type="submit" value="Adicionar ao Carrinho">
            </form>
          <?php else : ?>
            <a href="../login.php">Adicionar ao Carrinho</a>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

</body>

</html>