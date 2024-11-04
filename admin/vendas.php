<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vendas - Fast Food</title>
  <link rel="stylesheet" href="../css/vendas.css">
  <link rel="stylesheet" href="./css/reset.css">
</head>

<body>

  <div class="container">
    <h1>Gerenciar Vendas</h1>

    <div class="lista-vendas">
      <div class="pedido-item">
        <div class="pedido-info">
          <h3>Pedido #123 - João Silva</h3>
          <p><strong>Data do Pedido:</strong> 21/10/2024 14:30</p>
          <p><strong>Total:</strong> R$ 89,90</p>
          <p><strong>Status:</strong> Pendente</p>
        </div>
        <div class="pedido-acoes">
          <form action="vendas.php" method="POST">
            <input type="hidden" name="pedido_id" value="123">
            <label for="status">Alterar Status:</label>
            <select name="status" required>
              <option value="pendente" selected>Pendente</option>
              <option value="em-andamento">Em andamento</option>
              <option value="saiu-para-entrega">Saiu para entrega</option>
              <option value="entregue">Entregue</option>
              <option value="cancelado">Cancelado</option>
            </select>
            <input type="submit" value="Atualizar Status">
          </form>
          <a href="detalhes_venda.php?id=123" class="btn-detalhes">Ver Detalhes</a>
        </div>
      </div>


      <div class="pedido-item">
        <div class="pedido-info">
          <h3>Pedido #124 - Maria Souza</h3>
          <p><strong>Data do Pedido:</strong> 20/10/2024 12:45</p>
          <p><strong>Total:</strong> R$ 59,90</p>
          <p><strong>Status:</strong> Em andamento</p>
        </div>
        <div class="pedido-acoes">
          <form action="vendas.php" method="POST">
            <input type="hidden" name="pedido_id" value="124">
            <label for="status">Alterar Status:</label>
            <select name="status" required>
              <option value="pendente">Pendente</option>
              <option value="em-andamento" selected>Em andamento</option>
              <option value="saiu-para-entrega">Saiu para entrega</option>
              <option value="entregue">Entregue</option>
              <option value="cancelado">Cancelado</option>
            </select>
            <input type="submit" value="Atualizar Status">
          </form>
          <a href="detalhes_venda.php?id=124" class="btn-detalhes">Ver Detalhes</a>
        </div>
      </div>
    </div>

  </div>


</body>

</html>