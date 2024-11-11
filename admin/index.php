<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Painel Admin - Fast Food</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="./css/reset.css">
</head>

<body>
<?php include '../includes/header.php'; ?>
  <div class="container">
    <h1>Produtos</h1>

    <div class="produtos">
      <div class="produto">
        <img src="../imgs/produtos/exemplo1.jpg" alt="Produto Exemplo 1" style="width: 200px; height: auto;">
        <h3>Produto Exemplo 1</h3>
        <p>Descrição: Descrição do produto exemplo 1</p>
        <p>Preço: R$ 29,90</p>
        <p>Status: Ativo</p>

        <a href="editar-produto.html?id=1">Editar</a> |
        <a href="index.html?remover_id=1" onclick="return confirm('Tem certeza que deseja remover este produto?')">Remover</a>
      </div>


      <div class="produto">
        <img src="../imgs/produtos/exemplo2.jpg" alt="Produto Exemplo 2" style="width: 200px; height: auto;">
        <h3>Produto Exemplo 2</h3>
        <p>Descrição: Descrição do produto exemplo 2</p>
        <p>Preço: R$ 49,90</p>
        <p>Status: Inativo</p>


        <a href="editar-produto.html?id=2">Editar</a> |
        <a href="index.html?remover_id=2" onclick="return confirm('Tem certeza que deseja remover este produto?')">Remover</a>
      </div>
    </div>
  </div>


</body>

</html>