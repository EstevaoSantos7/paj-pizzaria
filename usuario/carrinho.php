<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
  header('Location: ../login.php');
  exit;
}

// Obtém os itens do carrinho para o usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT c.quantidade, p.id as produto_id, p.nome, p.preco, p.imagem
        FROM carrinho c
        JOIN produtos p ON c.produto_id = p.id
        WHERE c.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$items = []; // Array para armazenar os itens do carrinho

// Armazena os itens do carrinho no array
while ($item = $result->fetch_assoc()) {
  $items[] = $item;
  $total += $item['preco'] * $item['quantidade'];
}

// Lógica para incremento e decremento de quantidade
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['incrementar']) || isset($_POST['decrementar'])) {
    $produto_id = $_POST['produto_id'];
    $nova_quantidade = $_POST['quantidade'];
    
    // Verifica se o botão de incremento ou decremento foi pressionado
    if (isset($_POST['incrementar'])) {
      $nova_quantidade++;
    } elseif (isset($_POST['decrementar']) && $nova_quantidade > 1) {
      $nova_quantidade--;
    }

    // Atualiza a quantidade no banco de dados
    $sql_update = "UPDATE carrinho SET quantidade = ? WHERE produto_id = ? AND usuario_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $nova_quantidade, $produto_id, $usuario_id);
    $stmt_update->execute();

    // Redireciona para a mesma página para atualizar as informações
    header("Location: carrinho.php");
    exit;
  }

  if (isset($_POST['remover'])) {
    $produto_id = $_POST['produto_id'];
    $sql_remover = "DELETE FROM carrinho WHERE produto_id = ? AND usuario_id = ?";
    $stmt_remover = $conn->prepare($sql_remover);
    $stmt_remover->bind_param("ii", $produto_id, $usuario_id);
    $stmt_remover->execute();
    header("Location: carrinho.php");
    exit;
  }

  if (isset($_POST['finalizar'])) {
    $metodo_pagamento = $_POST['metodo_pagamento'];
    
    // Cria um novo pedido
    $sql_pedido = "INSERT INTO pedidos (usuario_id, total, status) VALUES (?, ?, 'pendente')";
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("id", $usuario_id, $total);
    if ($stmt_pedido->execute()) {
      $pedido_id = $stmt_pedido->insert_id;

      // Insere os itens do pedido usando o array de itens do carrinho
      foreach ($items as $item) {
        $sql_itens = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco)
                      VALUES (?, ?, ?, ?)";
        $stmt_itens = $conn->prepare($sql_itens);
        $stmt_itens->bind_param("iiid", $pedido_id, $item['produto_id'], $item['quantidade'], $item['preco']);
        $stmt_itens->execute();
      }

      // Limpa o carrinho do usuário
      $sql_limpar = "DELETE FROM carrinho WHERE usuario_id = ?";
      $stmt_limpar = $conn->prepare($sql_limpar);
      $stmt_limpar->bind_param("i", $usuario_id);
      $stmt_limpar->execute();

      // Redireciona para a página de compras após o pedido ser finalizado
      header('Location: compras.php');
      exit;
    } else {
      $erro = "Erro ao finalizar o pedido. Tente novamente.";
    }
  }
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
            <h1 class="titulo">CONFIRA SEU PEDIDO</h1>
            <?php if (count($items) > 0): ?>
                <?php foreach ($items as $item): ?>
                    <div class="item-carrinho">
                        <div class="detalhes-produto">
                            <div class="container-nome">
                                <h3><?= $item['nome']; ?></h3>
                                <form action="carrinho.php" method="POST">
                                    <input type="hidden" name="produto_id" value="<?= $item['produto_id']; ?>">
                                    <button type="submit" name="remover" id="remover">Remover</button>
                                </form>
                            </div>

                            <form action="carrinho.php" method="POST" class="form-quantidade">
                                <input type="hidden" name="produto_id" value="<?= $item['produto_id']; ?>">
                                <button type="submit" name="decrementar" class="quantidade-btn">-</button>
                                <input type="number" name="quantidade" value="<?= $item['quantidade']; ?>" min="1" class="quantidade-input" required>
                                <button type="submit" name="incrementar" class="quantidade-btn">+</button>
                            </form>

                            <p>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="total-carrinho">
                    <h2 id="total">Total: R$ <?= number_format($total, 2, ',', '.'); ?></h2>
                </div>
                <form action="carrinho.php" method="POST">
                    <div class="pagamento">
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
                    <div class="voltar">
                    <a id="volta"  href="../usuario/index.php">Voltar</a>
                    </div>
                </form>
            <?php else: ?>
                <p>Seu carrinho está vazio.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
