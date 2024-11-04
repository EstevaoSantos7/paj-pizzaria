
<?php
session_start();

if (!isset($_SESSION['role'])) { // não tem regra se for adm
    header('Location: usuario/index.php');
    exit;
}

if ($_SESSION['role'] === "admin") { // se for admin
    header('Location: admin/index.php');
    exit;
} else if ($_SESSION['role'] === "cliente") {
    header('Location: usuario/index.php');
    exit;
} else {
    echo "Erro: Tipo de Usuário desconhecido";
    exit;
}

