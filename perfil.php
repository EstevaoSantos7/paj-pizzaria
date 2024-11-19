<?php
session_start();
include './config/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
  header('Location: ../login.php');
  exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * from usuarios where id =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bairro = $_POST['bairro'];
  $logradouro = $_POST['logradouro'];
  $numero = $_POST['numero'];
  $complemento = $_POST['complemento'];
  $usuario_id = $_SESSION['usuario_id'];

  // Corrigido: Removida vírgula extra e corrigido erro no prepare
  $sql = "UPDATE usuarios SET bairro = ?, logradouro = ?, numero = ?, complemento = ? WHERE id = ?";
  $stmt = $conn->prepare($sql); // Corrigido a sintaxe
  $stmt->bind_param("ssssi", $bairro, $logradouro, $numero, $complemento, $usuario_id);

  if ($stmt->execute()) {
    echo "Perfil atualizado com sucesso!";
  } else {
    echo "Erro ao atualizar perfil";
  }
}
?>
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
      <label for="nome">Nome:</label>
            <input type="name" name="nome" id="nome" value="<?= $usuario['nome'] ?>" required>

            <label for="email">Email:</label> 

      <input type=" email" name="email" value="<?= $usuario['email'] ?>" required>
      </div>
      </div>
  
      <div class="endereco">
      <h1 class="titulo">MEU ENDEREÇO</h1>
      <div class="endereco1">
        <div class="space">
      <label for="bairro">Bairro:</label>
            <input type="text" name="bairro" id="bairro" value="<?= $usuario['bairro'] ?>" required>
            </div>
            <div class="space">
      <label for="logradouro">Endereço:</label>
      <input type="text" name="logradouro" value="<?= $usuario['logradouro'] ?>" required>
      </div>

      </div>  
      
      <div class="endereco2">
     
      <div class="space">
      <label for="numero">Número:</label>
      <input type="number" name="numero" id="numero" value="<?= $usuario['numero'] ?>" required>
      </div>
      <div class="space">
      <label for="complemento">Complemento:</label><input type="text" name="complemento" id="complemento" value="<?= $usuario['complemento'] ?>" required>
      </div>  

      </div>
      </div>
     
      <div class="botoes">
      <input id="editar" type="submit" value="EDITAR PERFIL">
      <div class="btn-voltar">
      <a id="voltar" href="../index.php">VOLTAR</a>
      </div>
      </div>
    </form>
  </div>
  </main>
</body>

</html>