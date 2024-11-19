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

  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/index_adm.css">
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/header.css">
</head>

<body>
  <?php include '../includes/header.php'; ?>
  <div class="container">
    <h1 class="titulo">Produtos</h1>

    <div class="produtos">
      <div class="pizzas">
        <?php while ($produto = $result->fetch_assoc()) : ?>
          <div class="pizza">
            <div class="descricao-pizza">
            <p class="titulo-pizza"><?php echo $produto['nome']; ?></p>
            <p class="preco-cima">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
              <form class="formulario" action="adicionar_ao_carrinho.php" method="POST">
                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
               

                <input hidden type="number" name="quantidade" value="1" min="1" required>
                
                <!-- Botões de edição e remoção para admin -->
                <a class="botao-cima" href="editar_produto.php?id=<?= $produto['id']; ?>">Editar</a> |
                <a class="botao-cima" href="index.php?remover_id=<?= $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja remover este produto?')">Remover</a>
              </form>
              
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
    <?php include '../includes/footer.php'; ?>

</body>

</html>