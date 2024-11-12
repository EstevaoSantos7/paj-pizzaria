<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
  header('Location: ../login.php');
  exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Inicializa variáveis
$total = 0;
$items = [];

// Processa a atualização da quantidade de um item no carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['atualizar'])) {
    // Atualiza a quantidade do item no carrinho
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];

    if ($quantidade > 0) {
      // Atualiza a quantidade no banco
      $sql = "UPDATE carrinho SET quantidade = ? WHERE usuario_id = ? AND produto_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("iii", $quantidade, $usuario_id, $produto_id);
      $stmt->execute();
    }
  }

  // Incrementar a quantidade (botão "Mais")
  if (isset($_POST['incrementar'])) {
    $produto_id = $_POST['produto_id'];
    $sql = "UPDATE carrinho SET quantidade = quantidade + 1 WHERE usuario_id = ? AND produto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $produto_id);
    $stmt->execute();
  }

  // Decrementar a quantidade (botão "Menos")
  if (isset($_POST['decrementar'])) {
    $produto_id = $_POST['produto_id'];
    $sql = "UPDATE carrinho SET quantidade = quantidade - 1 WHERE usuario_id = ? AND produto_id = ? AND quantidade > 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $produto_id);
    $stmt->execute();
  }

  if (isset($_POST['remover'])) {
    // Remove um item do carrinho
    $produto_id = $_POST['produto_id'];
    $sql = "DELETE FROM carrinho WHERE usuario_id = ? AND produto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $produto_id);
    $stmt->execute();
  }

  // Se o pedido for finalizado
  if (isset($_POST['finalizar'])) {
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Calcula o total
    $sql = "SELECT SUM(p.preco * c.quantidade) as total
                FROM carrinho c
                JOIN produtos p ON c.produto_id = p.id
                WHERE c.usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc()['total'];

    // Cria o pedido
    $sql_pedido = "INSERT INTO pedidos (usuario_id, total, metodo_pagamento, status) VALUES (?, ?, ?, 'pendente')";
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("ids", $usuario_id, $total, $metodo_pagamento);
    $stmt_pedido->execute();
    $pedido_id = $stmt_pedido->insert_id;

    // Insere os itens do pedido
    $sql_itens = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco)
                      SELECT ?, produto_id, quantidade, preco
                      FROM carrinho
                      WHERE usuario_id = ?";
    $stmt_itens = $conn->prepare($sql_itens);
    $stmt_itens->bind_param("ii", $pedido_id, $usuario_id);
    $stmt_itens->execute();

    // Limpa o carrinho após finalizar o pedido
    $sql_limpar = "DELETE FROM carrinho WHERE usuario_id = ?";
    $stmt_limpar = $conn->prepare($sql_limpar);
    $stmt_limpar->bind_param("i", $usuario_id);
    $stmt_limpar->execute();

    // Redireciona para a página de compras ou confirmação
    header('Location: compras.php');
    exit;
  }
}

// Obtém os itens do carrinho para o usuário logado
$sql = "SELECT c.quantidade, p.id as produto_id, p.nome, p.preco, p.imagem
        FROM carrinho c
        JOIN produtos p ON c.produto_id = p.id
        WHERE c.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Armazena os itens do carrinho no array
while ($item = $result->fetch_assoc()) {
  $items[] = $item;
  $total += $item['preco'] * $item['quantidade'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Carrinho - Fast Food</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/carrinho.css">
</head>

<body>
  <div class="container">
    <div class="carrinho">
      <h1>Meu Carrinho</h1>
      <?php if (count($items) > 0): ?>
        <?php foreach ($items as $item): ?>
          <div class="item-carrinho">
            <div class="detalhes-produto">
            <div class="container-nome">
              <h3><?= $item['nome']; ?></h3>
              <form action="carrinho.php" method="POST">
                <input type="hidden" name="produto_id" value="<?= $item['produto_id']; ?>">
                <button type="submit" name="remover" id="remover">Remover</button>
              </div>
            </form>

              <form action="carrinho.php" method="POST" class="form-quantidade">
                <input type="hidden" name="produto_id" value="<?= $item['produto_id']; ?>">
                <!-- Botão de diminuir quantidade -->
                <button type="submit" name="decrementar" class="quantidade-btn" >-</button>

                <!-- Exibe a quantidade do produto -->
                <input type="number" name="quantidade" value="<?= $item['quantidade']; ?>" min="1" class="quantidade-input" style="width: 50px;" required>

                <!-- Botão de aumentar quantidade -->
                <button type="submit" name="incrementar" class="quantidade-btn">+</button>
              </form>
              <p>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></p>
            </div>
            <!-- Botões para aumentar e diminuir a quantidade -->

            <!-- Formulário para remover o item -->
           
          </div>
        <?php endforeach; ?>
        <div class="total-carrinho">
          <h2 id="total">Total: R$ <?= number_format($total, 2, ',', '.'); ?></h2>
        </div>
        <!-- Formulário para escolher o método de pagamento e finalizar o pedido -->
        
          <form action="carrinho.php" method="POST">
          <div  class="pagamento">
            <h3 id="metodo">Método de Pagamento</h3>
            <select name="metodo_pagamento" required class="opcoes">
              <option value="cartao_credito">Cartão de Crédito</option>
              <option value="cartao_debito">Cartão de Débito</option>
              <option value="pix">PIX</option>
            </select>
        </div>
          <div class="finalizar">
            <button type="submit" name="finalizar" id="finaliza">Finalizar Pedido</button>
          </div>
        </form>
    </div>

  <?php else: ?>
    <p>Seu carrinho está vazio.</p>
  <?php endif; ?>
  </div>
</body>

</html>