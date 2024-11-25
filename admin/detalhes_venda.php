<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário é admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
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

// Consulta para obter os detalhes do pedido e seus itens
$sql_pedido = "SELECT p.id AS pedido_id, 
                      p.total, 
                      p.status, 
                      p.created_at AS data_pedido,
                      u.nome AS nome_cliente,
                      u.bairro, 
                      u.logradouro, 
                      u.numero, 
                      u.complemento,
                      ip.quantidade, 
                      pr.nome AS nome_produto, 
                      pr.preco, 
                      pr.imagem
               FROM pedidos p
               JOIN usuarios u ON p.usuario_id = u.id
               LEFT JOIN itens_pedido ip ON ip.pedido_id = p.id
               LEFT JOIN produtos pr ON pr.id = ip.produto_id
               WHERE p.id = ?";
$stmt_pedido = $conn->prepare($sql_pedido);
$stmt_pedido->bind_param("i", $pedido_id);
$stmt_pedido->execute();
$result_pedido = $stmt_pedido->get_result();

if ($result_pedido->num_rows == 0) {
  echo "<p>Pedido não encontrado ou você não tem permissão para visualizá-lo.</p>";
  include '../includes/footer.php';
  exit;
}

// Detalhes do pedido (primeiro item da consulta)
$pedido = $result_pedido->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Detalhes da Venda - Fast Food</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/detalhes_venda.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

  <div class="container">
    <div class="titulo">
      <h1>Detalhes do Pedido #<?= $pedido['pedido_id']; ?></h1>
    </div>
    <div class="info-usuario">
      <p><strong>Nome do Cliente:</strong> <?= $pedido['nome_cliente']; ?></p>
      <p><strong>Data do Pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></p>
      <p><strong>Status:</strong> <?= ucfirst($pedido['status']); ?></p>
    </div>



    <div class="titulo">
      <h1>Itens do Pedido</h1>
    </div>

    <?php
    // Exibe os itens do pedido, lembrando que a consulta retorna uma linha por item
    do {
    ?>
      <div class="item-pedido">
        <div class="detalhes">
          <p class="nome-pizza"> <?= $pedido['nome_produto']; ?></p>
          <div class="back">
            <div class="info-back">
              <p id="preco"> R$ <?= number_format($pedido['preco'], 2, ',', '.'); ?></p>
              <p><strong>QUANTIDADE:</strong> <?= $pedido['quantidade']; ?></p>
            </div>
            <img src="../imgs/produtos/<?= $pedido['imagem']; ?>" alt="<?= $pedido['nome_produto']; ?>" class="piza">

          </div>
        </div>

        <div class="total">
          <p id="total"><strong>Total:</strong> R$ <?= number_format($pedido['quantidade'] * $pedido['preco'], 2, ',', '.'); ?></p>
        </div>

        <div class="endereco">
          <h1 class="entrega">Endereço de Entrega</h1>

            <div class="detalhes-entrega">
              <p><strong>Bairro:</strong> <?= $pedido['bairro']; ?></p>
              <p><strong>Logradouro:</strong> <?= $pedido['logradouro']; ?></p>
              <p><strong>Número:</strong> <?= $pedido['numero']; ?></p>
              <p><strong>Complemento:</strong> <?= $pedido['complemento']; ?></p>
            </div>
        </div>

      </div>
      <div class="voltar">
        <a id="volta" href="../usuario/compras.php">Voltar</a>
      </div>
    <?php
    } while ($pedido = $result_pedido->fetch_assoc());  // Loop até exibir todos os itens
    ?>

  </div>

</body>

</html>