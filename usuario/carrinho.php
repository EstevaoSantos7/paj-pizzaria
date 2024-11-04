<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Meu Carrinho - Fast Food</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="./css/reset.css">
</head>

<body>

  <div class="container">
    <h1>Meu Carrinho</h1>

    <div class="carrinho">

      <div class="item-carrinho">
        <div class="imagem-produto">
          <img src="../imgs/produto-exemplo.jpg" alt="Produto Exemplo" style="width: 100px; height: auto;">
        </div>
        <div class="detalhes-produto">
          <h3>Produto Exemplo</h3>
          <p>Preço Unitário: R$ 29,90</p>
          <p>Quantidade: 2</p>
          <p>Subtotal: R$ 59,80</p>
        </div>

        <div class="remover-item">
          <form action="remover_do_carrinho.php" method="POST">
            <input type="hidden" name="produto_id" value="1">
            <input type="submit" value="Remover">
          </form>
        </div>
      </div>

      <div class="total-carrinho">
        <h2>Total: R$ 59,80</h2>
      </div>

      <form action="finalizar_pedido.php" method="POST">
        <h3>Escolha o método de pagamento:</h3>
        <select name="metodo_pagamento" required>
          <option value="cartao_credito">Cartão de Crédito</option>
          <option value="cartao_debito">Cartão de Débito</option>
          <option value="pix">PIX</option>
        </select>

        <input type="submit" value="Finalizar Pedido">
      </form>

    </div>
  </div>


</body>

</html>