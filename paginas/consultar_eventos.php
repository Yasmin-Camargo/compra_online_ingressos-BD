<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../javascript/javascript.js"></script>
    <title>Consulte eventos</title>
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
            <a href="../paginas/login_organizadores.php" target="_self">Organizadores</a>
            </nav>
        </div>
    </header>
    <main>
        <article class="login-container">
            <h1>Confira os eventos que você está organizando</h1>
            <div class="InformacoesEvento">
            <?php
            if (isset($_SESSION['cnpj_login'])) {
                $cnpj = $_SESSION['cnpj_login'];
            // Consulta eventos relacionados ao CNPJ desse organizador
            $sql = "SELECT evento.titulo, evento.datahoraevento,
            evento.descricao, evento.duracao, evento.classificacao,
            evento.website, evento.nomecategoriaevento,
            evento.nomelocal, 
            endereco.rua, endereco.numero, endereco.cidade, 
            endereco.cep
            FROM plataformaCompraOnlineIngressos.evento
            INNER JOIN plataformaCompraOnlineIngressos.organizador
            ON evento.cnpj = organizador.cnpj
            INNER JOIN plataformaCompraOnlineIngressos.endereco
            ON evento.idendereco = endereco.idendereco
            WHERE organizador.cnpj = :cnpj";

             $retorno = $conexao->prepare($sql);
             $retorno->bindParam(':cnpj', $_SESSION['cnpj_login']);
             $retorno->execute();

             // Mostra dados
             if ($retorno->rowCount() > 0) {
                $row = $retorno->fetch(PDO::FETCH_ASSOC);
                $titulo_evento = $row['titulo'];
                $dataHora_evento = $row['datahoraevento'];
                $nomelocal_evento = $row['nomelocal'];
                $descricao_evento = $row ['descricao'];
                $duracao_evento = $row['duracao'];
                $classificacao_evento = $row['classificacao'];
                $categoria_evento = $row['nomecategoriaevento'];
                $webSite_evento = $row['website'];
                $rua_endereco = $row['rua'];
                $numero_endereco = $row['numero'];
                $cidade_endereco= $row['cidade'];
                $cep_endereco= $row['cep'];

            echo "<p><strong>Nome:</strong> " . $titulo_evento . "</p><br>";
            echo "<p><strong>Descrição:</strong> " . $descricao_evento . "</p><br>";
            echo "<p><strong>Data:</strong> " . $dataHora_evento . "</p><br>";
            echo "<p><strong>Local:</strong> " . $nomelocal_evento . "</p><br>";
            echo "<p><strong>Duração do evento:</strong> " . $duracao_evento . " horas </p><br>";
            echo "<p><strong>Classificação</strong> " . $classificacao_evento . "</p><br>";
            echo "<p><strong>Categoria:</strong> " . $categoria_evento . "</p><br>";
            echo "<p><strong>Site:</strong> " . $webSite_evento . "</p><br>";
            echo "<p><strong>Endereco:</strong> Rua " . $rua_endereco . ", " . $numero_endereco . ", Cidade: " . $cidade_endereco . ", CEP: " . $cep_endereco . "</p><br>";
            } else {
                echo "Nenhum dado encontrado."; 
            } 
        }
    ?>
        <button id="botaoEditar" onclick="editInfoOrganizador()">Editar evento</button>
        </div> <br>


        <div id="editar-info2" class="login-container" style="display: none;">
                <h1>Editar Informações</h1>
                <form action="atualizar_evento.php" method="post">
                    <?php
                        //Formulario para alterar os dados
                        echo '<label for="nome">Nome:</label><br>';
                        echo '<input type="text" id="titulo" name="titulo" value="' . $titulo_evento . '"><br><br>';
                        
                        echo '<label for="descricao">Descrição:</label><br>';
                        echo '<input type="text" id="descricao" name="descricao" value="' . $descricao_evento . '"><br><br>';
                        
                        
                        echo '<label for="datahoraevento">Data e hora:</label><br>';
                        echo '<input type="text" id="datahoraevento" name="datahoraevento" value="' . $dataHora_evento . '"><br><br>';
                        
                        echo '<label for="duracao">Duração:</label><br>';
                        echo ' <input type="text" id="duracao" name="duracao" value=' . $duracao_evento . '><br><br>';
                          
                        echo '<label for="classificacao">Classificação:</label><br>';
                        echo ' <input type="text" id="classificacao" name="classificacao" value=' . $classificacao_evento . '><br><br>';

                        echo '<label for="categoria">Categoria:</label><br>';
                        echo ' <input type="text" id="nomecategoriaevento" name="nomecategoriaevento" value=' . $categoria_evento . '><br><br>';

                        echo '<label for="website">Website:</label><br>';
                        echo ' <input type="text" id="website" name="website" value=' . $webSite_evento . '><br><br>';

                        echo '<label for="numero">Local:</label><br>';
                        echo ' <input type="text" id="nomelocal" name="nomelocal"  value="' . $nomelocal_evento . '"><br><br>';
                        
                        echo '<label for="rua">Rua:</label><br>';
                        echo ' <input type="text" id="rua" name="rua" value="' . $rua_endereco . '"><br><br>';
                        
                        echo '<label for="numero">Numero:</label><br>';
                        echo ' <input type="text" id="numero" name="numero" value=' . $numero_endereco . '><br><br>';
                        
                        echo '<label for="cidade">Cidade:</label><br>';
                        echo '<input type="text" id="cidade" name="cidade" value="' . $cidade_endereco . '"><br><br>';
                        
                        echo '<label for="cep">CEP:</label><br>';
                        echo ' <input type="text" id="cep" name="cep" value=' . $cep_endereco . '><br><br>';
                    ?>
                    <button type="submit">Atualizar Cadastro</button>
                </form>
            </div>
            <?php
                if ($_SESSION['cnpj_login'] != NULL) {
                    echo '<br><a href="login_organizadores.php">Sair</a>';
                } 

                // Verificar se o usuário clicou em "Sair"
                if (isset($_GET['action']) && $_GET['action'] === 'logout') {
                    $_SESSION['cnpj_login'];
                    header("Location: index.php");
                    exit();
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

