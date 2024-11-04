<header>
    <div>
        <img src="" alt="">
    </div>
    <nav>
        <a href="/index.php">Home</a>
        <?php if (isset($_SESSION['role'])): ?>
            <?php if ($_SESSION['role'] === 'cliente'): ?>
                <a href="/usuario/carrinho.php">Carrinho</a>
                <a href="/usuario/compras.php">Meus Pedidos</a>
            <?php endif; ?> <!-- Corrigido de endiif para endif -->
            <a href="/perfil.php">Perfil</a>
            <?php if ($_SESSION['role'] === 'admin'): ?> <!-- Corrigido de adimin para admin -->
                <a href="/admin/vendas.php">Gerenciar produtos</a>
                <a href="/admin/adicionar_produto.php">Adicionar Produtos</a>
            <?php endif; ?> <!-- Corrigido de endiif para endif -->
            <a href="/logout.php">Sair</a>
        <?php else: ?>
            <a href="/login.php">Entrar</a>
            <a href="/cadastro.php">Cadastrar</a>
        <?php endif; ?>
    </nav>
</header>
