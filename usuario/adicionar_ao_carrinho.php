<?php
session_start();
include '../config/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
  header('Location: ./index.php');
  exit;
}

$usuario_id = $_SESSION['usuario_id'];
$produto_id = $_POST['produto_id'];

// Definir a quantidade automaticamente como 1
$quantidade = 1;

// Verifica se o produto já está no carrinho
$sql_verifica = "SELECT * FROM carrinho WHERE usuario_id = ? AND produto_id = ?";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("ii", $usuario_id, $produto_id);
$stmt_verifica->execute();
$result_verifica = $stmt_verifica->get_result();

if ($result_verifica->num_rows > 0) {
  // Se o produto já estiver no carrinho, atualiza a quantidade
  $sql_update = "UPDATE carrinho SET quantidade = quantidade + ? WHERE usuario_id = ? AND produto_id = ?";
  $stmt_update = $conn->prepare($sql_update);
  $stmt_update->bind_param("iii", $quantidade, $usuario_id, $produto_id);
  $stmt_update->execute();
} else {
  // Se o produto não estiver no carrinho, insere um novo item com a quantidade 1
  $sql_insert = "INSERT INTO carrinho (usuario_id, produto_id, quantidade) VALUES (?, ?, ?)";
  $stmt_insert = $conn->prepare($sql_insert);
  $stmt_insert->bind_param("iii", $usuario_id, $produto_id, $quantidade);
  $stmt_insert->execute();
}

// Redireciona de volta para a página do carrinho ou página inicial
header('Location: carrinho.php');
exit;
