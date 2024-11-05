<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Perfil - Fast Food</title>
  <link rel="stylesheet" href="./css/perfil.css">
</head>

<body>
<main>
  <div class="container">
    <h1>MEU PERFIL</h1>

    <form action="perfil.php" method="POST">
      <div class="perfil">
        <div class="imgperfil">
      <img src="/imgs/perfil.jpg" alt="">
      </div>
      <div class="perfil1">
      <input type="text" name="nome" value="Exemplo Nome" required>

    
      <input type="email" name="email" value="exemplo@email.com" required>
      </div>
      </div>
  
      <div class="endereco">
      <h1 class="titulo">MEU ENDEREÇO</h1>
      <div class="endereco1">
      <input type="text" name="bairro" id="bairro" value="Exemplo Bairro" required>

      <input type="text" name="logradouro" id="logradouro" value="Exemplo Logradouro" required>
      </div>
      
      <div class="endereco2">
      <input type="text" name="numero" id="numero" value="123" required>

      <input type="text" name="complemento" id="complemento" value="Exemplo Complemento">
      </div>
      </div>
     
      <div class="botoes">
      <input id="editar" type="submit" value="EDITAR PERFIL">
      <input id="voltar" type="button" value="VOLTAR">
      </div>
    </form>
  </div>
  </main>
</body>

</html>