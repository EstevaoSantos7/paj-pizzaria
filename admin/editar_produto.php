<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Editar Produto - Fast Food</title>
  <link rel="stylesheet" href="../css/editar-produto.css">
  <link rel="stylesheet" href="./css/reset.css">
</head>

<body>

  <div class="container">
    <h1>Editar Produto</h1>

    <form action="editar_produto.php?id=1" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" id="nome" value="Produto Exemplo" required>
      </div>

      <div class="form-group">
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required>Descrição do produto exemplo</textarea>
      </div>

      <div class="form-group">
        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" value="29.90" required>
      </div>

      <div class="form-group">
        <label for="status">Status do Produto:</label>
        <select name="status" id="status" required>
          <option value="ativo" selected>Ativo</option>
          <option value="inativo">Inativo</option>
        </select>
      </div>

      <div class="form-group">
        <label for="imagem">Imagem do Produto (deixe vazio para manter a atual):</label>
        <input type="file" name="imagem" id="imagem" accept="image/*">
        <p>Imagem atual:</p>
        <img src="../imgs/produtos/exemplo.jpg" alt="Produto Exemplo" style="width: 150px;">
      </div>

      <input type="submit" value="Atualizar Produto">
    </form>
  </div>

</body>

</html>