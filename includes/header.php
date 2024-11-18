<header>
    <section class="cabecario">
        <div class="cabecario1">
    <div class="logo">
        <a href="index.php">
    <img src="/imgs/2.png" alt="">
    </a>
    </div>
    <div class="icones">

    </div>
    </div>
    <nav>
        <a href="/index.php">Home</a>
        <?php if(isset($_SESSION['role'])):?>
        <?php if($_SESSION['role'] === 'cliente'):?>
            <a href="/usuario/carrinho.php">Carrinho</a>
            <a href="/usuario/compras.php">Meus pedidos</a>
        <?php endif; ?>
        <a href="/perfil.php">Perfil</a>
        <?php if($_SESSION['role'] === 'admin'):?>
            <a href="/admin/vendas.php">Gerenciar Pedidos</a>
            <a href="/admin/adicionar_produto.php">Adicionar Produtos</a>
        <?php endif; ?>
        <a href="/logout.php">Sair</a>
        <?php else: ?>
         <a href="/login.php">Entrar</a>
         <a href="/cadastro.php">Cadastrar</a>
        <?php endif; ?>
    </nav>
    </section>
</header>