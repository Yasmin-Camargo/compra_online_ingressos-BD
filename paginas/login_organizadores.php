<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <title>Organizadores</title>
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
            <h1>Login dos organizadores</h1>
                    <?php if (isset($mensagemErro)) { ?>
                            <div class="mensagem-erro">
                        <?php echo $mensagemErro; ?>
                    </div>
                <?php } ?>
            <form action="" method="post">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" required> <br>
                <label for="cnpj">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" required> <br>
                <button type="submit" name="login">Entrar</button></a>
            </form>
            <br>
            <p>Não tem uma conta? <a href="cadastro_organizador.php">Cadastrar-se</a></p>
        </article>

            <?php 
            // Verificar se o formulário de login foi enviado
            if (isset($_POST['login'])) {
                $cnpj = $_POST["cnpj"];
                $email_organizador = $_POST["email"];

            
            // Consulta no banco o usuario 
            $sql = "SELECT cnpj, email, telefone, nome
                    FROM plataformaCompraOnlineIngressos.organizador 
                    WHERE cnpj = :cnpj";
                $retorno = $conexao->prepare($sql);
                $retorno->bindParam(':cnpj',  $cnpj);
                $retorno->execute();

                 // Verifica se existe um organizador cadastrado
                if ($retorno->rowCount() > 0) {
                    $row = $retorno->fetch(PDO::FETCH_ASSOC);
                    $nome_organizador = $row['nome'];
                    $telefone_organizador = $row['telefone'];
                    $cnpj = $_POST["cnpj"];

                    $_SESSION['cnpj_login'] = $cnpj;
                    // Redireciona o usuário para a página consultar_eventos.php
                    header("Location: consultar_eventos.php");

                } else {
                $mensagemErro = "Nenhum organizador encontrado com o CNPJ fornecido.";
                }
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
