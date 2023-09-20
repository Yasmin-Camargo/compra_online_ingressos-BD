<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <script src="javascript/javascript.js"></script>
    <title>Cadastro</title>
</head>
<body>
    <?php 
        //Conectando ao banco de dados
        include("conexao.php");
        $conexao = conectarAoBanco();
    ?>
    <header>
        <h1>TICKET VERSE</h1>
        <p>Desfrute de eventos exclusivos na nossa plataforma de compra online de ingresso</p>
        <div id="menu">
            <form id="pesquisa-esquerda" action="/search" method="get">
                <input type="text" name="q" placeholder="Digite um evento...">
                <button type="submit">Buscar </button>
            </form>
            <nav id="nav-direita">
                <a href="../index.php" target="_self">Home</a>
                <a href="descricao.php" target="_self">Descrição</a>
                <?php
                    // Verifica se o usuário está logado (para mostrar seus ingressos)
                    if ($_SESSION['usuario_login'] != NULL) {
                        echo '<a href="../paginas/compra_ingressos.php" target="_self">Ingressos</a>';
                    } 
                ?>
                <a href="../paginas/login_organizadores.php" target="_self">Organizadores</a>
                <?php
                    // Verifica se o usuário está logado (para mostrar nome dele)
                    if ($_SESSION['usuario_login'] != NULL) {
                        echo '<a href="usuario.php">Bem-vindo, '. $_SESSION['usuario_login'] .'</a>';
                    } else {
                        echo '<a href="login.php">Entrar</a>';
                    }
                ?>
            </nav>
        </div>
    </header>

    <main>
        <article class="login-container">
            <h1>Cadastro de Usuário</h1>
            <form action="processar_cadastro.php" method="post">
                <label for="cpf">CPF:</label> <br>
                <input type="text" id="cpf" name="cpf" required><br>
                
                <label for="nome">Nome:</label> <br>
                <input type="text" id="nome" name="nome" required><br>
                
                <label for="email">Email:</label> <br>
                <input type="email" id="email" name="email" required><br>
                
                <label for="senha">Senha:</label> <br>
                <input type="password" id="senha" name="senha" required><br>
                
                <label for="rua">Rua:</label> <br>
                <input type="text" id="rua" name="rua" required><br>
                
                <label for="numero">Número:</label> <br>
                <input type="text" id="numero" name="numero" required><br>
                
                <label for="cidade">Cidade:</label> <br>
                <input type="text" id="cidade" name="cidade" required><br>
                
                <label for="cep">CEP:</label> <br>
                <input type="text" id="cep" name="cep" required><br>
                
                <button type="submit">Cadastrar</button>
            </form>
        </article>
    </main>

    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>