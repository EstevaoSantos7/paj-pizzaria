<?php
session_start();
include './config/conexao.php';

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * usuarios where id = ?";
$stmt = $conn ->prepare($sql);
$stmt->bind_param("i,$usuario_id");
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();


if($_SERVER['REQUEST_METHOD']==='post'){
$bairro = $_POST['bairro'];
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$usuario_id = $_SESSION['usuario_id'];

$sql = "UPDATE usuarios SET bairro = ?, logradouro = ?, numero = ?, complemento = ? WHERE id=?";}
$stmt->$conn->prepare($sql);
$stmt->bind_param("ssssi", $bairro, $logradouro, $numero, $complemento, $usuario_id);

if($stmt->execute()){
    echo "Perfil atualizado com sucesso!";
}
else {
    echo "Erro ao atualizar perfil";
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

  <div class="container">
    <h1>Perfil</h1>

    <form action="perfil.php" method="POST">
      <label for="nome">Nome:</label>
      <input type="text" name="nome" value="<?= $usuario['nome'] ?>" required>

      <label for="email">Email:</label>
      <input type="email" name="email" value="<?= $usuario['email'] ?>" required>

      <label for="senha">Senha (deixe em branco para não alterar):</label>
      <input type="password" name="senha">

      <label for="bairro">Bairro:</label>
      <input type="text" name="bairro" id="bairro" value="<?= $usuario['bairro'] ?>" required>

      <label for="logradouro">Logradouro:</label>
      <input type="text" name="logradouro" id="logradouro" value="<?= $usuario['logradouro'] ?>" required>

      <label for="numero">Número:</label>
      <input type="text" name="numero" id="numero" value="<?= $usuario['numero'] ?>" required>

      <label for="complemento">Complemento:</label>
      <input type="text" name="complemento" id="complemento" value="<?= $usuario['complemento'] ?>">

      <input type="submit" value="Atualizar Perfil">
    </form>
  </div>

</body>

</html>