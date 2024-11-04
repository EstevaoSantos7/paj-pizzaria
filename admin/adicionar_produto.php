<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Adicionar Produto - Fast Food</title>
  <link rel="stylesheet" href="../css/produto.css">
  <link rel="stylesheet" href="./css/reset.css">
</head>

<body>

  <div class="container">
    <h1>Cadastrar Produto</h1>

    <form action="adicionar_produto.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" id="nome" required>
      </div>

      <div class="form-group">
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required></textarea>
      </div>

      <div class="form-group">
        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" required>
      </div>

      <div class="form-group">
        <label for="imagem">Imagem do Produto:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*" required>
      </div>

      <input type="submit" value="Cadastrar Produto">
    </form>
  </div>

</body>

</html>