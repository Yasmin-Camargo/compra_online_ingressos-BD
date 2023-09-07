<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <title>Entrar</title>
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
                <a href="../paginas/compra_ingressos.php" target="_self">Ingressos</a>

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
            <h1>Login</h1>
            <form action="" method="post">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" required> <br>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required> <br>
                <button type="submit" name="login">Entrar</button>
            </form>
            <br>
            <p>Não tem uma conta? <a href="cadastro.php">Cadastrar-se</a></p>
        </article>

        <?php 
            // Verificar se o formulário de login foi enviado
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $senha = $_POST['password'];
            
                // Consulta no banco o usuario 
                $sql = "SELECT nome, senha, cpf FROM plataformaCompraOnlineIngressos.usuario WHERE email = :email";
                $retorno = $conexao->prepare($sql);
                $retorno->bindParam(':email', $email);
                $retorno->execute();
                        
                 // Verifica se existe um usuário cadastrado
                if ($retorno->rowCount() > 0) {
                    $row = $retorno->fetch(PDO::FETCH_ASSOC);
                    $nome_usuario = $row['nome'];
                    $senha_usuario = $row['senha'];
                    $cpf_usuario = $row['cpf'];
                
                    //Verifica se as senhas são compativeis
                    if ($senha_usuario == $senha) {
                        $_SESSION['usuario_login'] = $nome_usuario;
                        $_SESSION['cpf_login'] = $cpf_usuario;
                        header("Location: ../index.php");   // direciona para página index
                        exit();
                    } else {
                        echo "Erro ao consultar login usuario: ";
                    }
                    
                } else {
                    header("Location: cadastro.php");   // direciona para página de cadastro
                    exit();
                }
            }
        ?>

        <?php
            if ($_SESSION['usuario_login'] != NULL) {
                echo '<a href="login.php?action=logout">Sair</a>';
            } 

            // Verificar se o usuário clicou em "Sair"
            if (isset($_GET['action']) && $_GET['action'] === 'logout') {
                $_SESSION['usuario_login'] = null;
                header("Location: login.php");
                exit();
            }
        ?>
        
    </main>

    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>