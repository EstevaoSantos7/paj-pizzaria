<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
  header('Location: ../login.php');
  exit;
}

// Verifica se o ID do pedido foi passado como parâmetro
if (!isset($_GET['id'])) {
  echo "<p>ID do pedido não fornecido.</p>";
  include '../includes/footer.php';
  exit;
}

$pedido_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Verifica se o pedido pertence ao usuário logado e obtém os dados do pedido e endereço
$sql = "SELECT p.*, u.bairro, u.logradouro, u.numero, u.complemento
        FROM pedidos p
        JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.id = ? AND p.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $pedido_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  echo "<p>Pedido não encontrado ou você não tem permissão para visualizar este pedido.</p>";
  include '../includes/footer.php';
  exit;
}

// Obtém os detalhes do pedido
$pedido = $result->fetch_assoc();

// Obtém os itens do pedido (incluindo imagem do produto)
$sql_itens = "SELECT i.quantidade, p.nome, p.preco, p.imagem
              FROM itens_pedido i
              JOIN produtos p ON i.produto_id = p.id
              WHERE i.pedido_id = ?";
$stmt_itens = $conn->prepare($sql_itens);
$stmt_itens->bind_param("i", $pedido_id);
$stmt_itens->execute();
$result_itens = $stmt_itens->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Detalhes do Pedido - Fast Food</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/detalhes-pedido.css">
</head>
<body>

  <div class="container">
    <div class="titulo">
      <h1>Detalhes do Pedido #<?= $pedido['id']; ?></h1>
    </div>
    <div class="info-usuario">
      <p><strong>Data do Pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['created_at'])); ?></p>
      <p><strong>Status:</strong> <?= ucfirst($pedido['status']); ?></p>
    </div>

    <div class="titulo">
      <h1>Itens do Pedido</h1>
    </div>

    <?php if ($result_itens->num_rows > 0): ?>
      <div class="item-pedido">
        <?php while ($item = $result_itens->fetch_assoc()): ?>
          <div class="detalhes">
            <p class="nome-pizza"><?= $item['nome']; ?></p>
            <div class="back">
              <div class="info-back">
                <p id="preco">R$ <?= number_format($item['preco'], 2, ',', '.'); ?></p>
                <p>QUANTIDADE: <?= $item['quantidade']; ?></p>
              </div>
              <!-- Corrigido a variável para obter a imagem do produto -->
              <img src="../imgs/produtos/<?= $item['imagem']; ?>" alt="<?= $item['nome']; ?>" class="piza">
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <!-- Total do Pedido: Exibido uma única vez após o laço -->
      <div class="total">
        <p id="total">Total: R$ <?= number_format($pedido['total'], 2, ',', '.'); ?></p>
      </div>
    <?php else: ?>
      <p>Não há itens neste pedido.</p>
    <?php endif; ?>

    <div class="endereco">
      <h1 class="entrega">Endereço de Entrega</h1>
      <div class="detalhes-entrega">
        <p><strong>Bairro:</strong> <?= $pedido['bairro']; ?></p>
        <p><strong>Logradouro:</strong> <?= $pedido['logradouro']; ?></p>
        <p><strong>Número:</strong> <?= $pedido['numero']; ?></p>
        <p><strong>Complemento:</strong> <?= $pedido['complemento']; ?></p>
      </div>
    </div>
    <div class="voltar">
        <a id="volta" href="../usuario/compras.php">Voltar</a>
      </div>
  </div>



</body>
</html>
