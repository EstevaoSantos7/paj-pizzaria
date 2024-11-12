<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
  header('Location: ../login.php');
  exit;
}

// Obtém os pedidos do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY created_at DESC"; // Usei `created_at` para ordem correta, caso seja essa a coluna que você deseja

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    // Verifica se a preparação da query falhou
    die('Erro ao preparar a query: ' . $conn->error);
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se a consulta retornou resultados
if ($result === false) {
    die('Erro ao executar a query: ' . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Minhas Compras - Fast Food</title>
  <link rel="stylesheet" href="../css/compras.css">


</head>

<body>

  <div class="container">
    <h1>Minhas Compras</h1>

    <?php if ($result->num_rows > 0): ?>
      <div class="lista-compras">
        <?php while ($pedido = $result->fetch_assoc()): ?>
          <div class="compra-item">
            <div class="compra-info">
              <div class="titulo-pedido">
              <h3>Pedido #<?= htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?></h3>
              </div>
              <div class="pedido-text">
              <p><strong>Data do Pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['created_at'])); ?></p>
              <p><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.'); ?></p>
              <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($pedido['status'], ENT_QUOTES, 'UTF-8')); ?></p>
              </div>
            
            <div class="compra-detalhes">
              <a id="ver-detalhes" href="detalhes-pedido.php?id=<?= htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn-detalhes">Ver Mais</a>
            </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p id="nenhuma">Você ainda não fez nenhuma compra.</p>
    <?php endif; ?>
  </div>
  <section class="voltar">
    <a href="index.php">Voltar</a>
  </section>
  <?php include '../includes/footer.php'; ?>

</body>

</html>
