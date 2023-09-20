<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../javascript/javascript.js"></script>
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
            <form id="pesquisa-esquerda" action="pesquisa.php" method="get">
                <input type="text" name="busca" placeholder="Digite sua pesquisa...">
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
        <article>
            <h1>Dados do Usuário</h1>
            <div class="InformacoesUsuario">
                <img id="img-usuario" src="../imagens/usuario.png" alt="Imagem padrão Usuário"> <br>
                <?php
                    // Consulta no banco o usuario 
                    $sql = "SELECT usuario.nome, usuario.cpf, usuario.senha, usuario.email, 
                                   endereco.rua, endereco.numero, endereco.cidade, endereco.cep 
                            FROM plataformaCompraOnlineIngressos.usuario, plataformaCompraOnlineIngressos.endereco 
                            WHERE cpf = :cpf and usuario.idendereco = endereco.idendereco";
                    $retorno = $conexao->prepare($sql);
                    $retorno->bindParam(':cpf', $_SESSION['cpf_login']);
                    $retorno->execute();

                    // Mostra dados
                    if ($retorno->rowCount() > 0) {
                        $row = $retorno->fetch(PDO::FETCH_ASSOC);
                        $nome_usuario = $row['nome'];
                        $senha_usuario = $row['senha'];
                        $cpf_usuario = $row['cpf'];
                        $email_usuario = $row['email'];
                        $rua_endereco = $row['rua'];
                        $numero_endereco = $row['numero'];
                        $cidade_endereco= $row['cidade'];
                        $cep_endereco= $row['cep'];

                        echo "<p><strong>Nome:</strong> " . $nome_usuario . "</p><br>";
                        echo "<p><strong>CPF:</strong> " . $cpf_usuario . "</p><br>";
                        echo "<p><strong>Email:</strong> " . $email_usuario . "</p><br>";
                        echo "<p><strong>Senha:</strong> " . $senha_usuario . "</p><br>";
                        echo "<p><strong>Endereco:</strong> " . $rua_endereco . ", " . $numero_endereco . ", " . $cidade_endereco . ", " . $cep_endereco . "</p><br>";
                    } else {
                        echo "Nenhum dado encontrado.";
                    }
                ?>
                <button id="botaoEditar" onclick="editInfoUsuario()">Editar Dados</button> 
            </div> <br> 

            
            <div id="editar-info" class="login-container" style="display: none;">
                <h1>Editar Informações</h1>
                <form action="atualizar_usuario.php" method="post">
                    <?php
                        //Formulario para alterar os dados
                        echo '<label for="nome">Nome:</label><br>';
                        echo ' <input type="text" id="nome" name="nome" value=' . $nome_usuario . '><br><br>';

                        echo '<label for="senha">Senha:</label><br>';
                        echo ' <input type="text" id="senha" name="senha" value=' . $senha_usuario . '><br><br>';
                        
                        echo '<label for="rua">Rua:</label><br>';
                        echo ' <input type="text" id="rua" name="rua" value=' . $rua_endereco . '><br><br>';
                        
                        echo '<label for="numero">Numero:</label><br>';
                        echo ' <input type="text" id="numero" name="numero" value=' . $numero_endereco . '><br><br>';
                        
                        echo '<label for="cidade">Cidade:</label><br>';
                        echo ' <input type="text" id="cidade" name="cidade" value=' . $cidade_endereco . '><br><br>';
                        
                        echo '<label for="cep">CEP:</label><br>';
                        echo ' <input type="text" id="cep" name="cep" value=' . $cep_endereco . '><br><br>';
                    ?>
                    <button type="submit">Atualizar Cadastro</button>
                </form>
            </div>
            <?php
                // Verifica se o usuário está logado
                if ($_SESSION['usuario_login'] != NULL) {
                    // Usuário está logado, exiba o link de logout e lide com o logout no mesmo arquivo
                    echo '<a href="?logout=1">Sair</a>';

                    // Verifique se o parâmetro "logout" está definido na URL
                    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
                        // Limpa as variáveis de sessão
                        $_SESSION['usuario_login'] = null;
                        $_SESSION['cpf_login'] = null;

                        // Redireciona para a página de login
                        header("Location: login.php");
                        exit(); // Certifique-se de sair do script após o redirecionamento
                    }
                }
            ?>
        </article>
    </main>

    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>
