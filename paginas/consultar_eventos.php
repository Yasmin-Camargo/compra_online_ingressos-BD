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
            $sql = "SELECT evento.idevento, evento.titulo, evento.datahoraevento,
            evento.descricao, evento.duracao, evento.classificacao,
            evento.website, evento.precobase, 
            evento.nomecategoriaevento, categoriaevento.descricaocategoria,  -- Adicione uma vírgula aqui
            evento.nomelocal, localevento.detalhesdeacesso, localevento.capacidade,
            endereco.rua, endereco.numero, endereco.cidade, 
            endereco.cep
            FROM plataformaCompraOnlineIngressos.evento
            INNER JOIN plataformaCompraOnlineIngressos.organizador
            ON evento.cnpj = organizador.cnpj
            INNER JOIN plataformaCompraOnlineIngressos.endereco
            ON evento.idendereco = endereco.idendereco
            INNER JOIN plataformaCompraOnlineIngressos.categoriaevento
            ON evento.nomecategoriaevento = categoriaevento.nomecategoriaevento
            INNER JOIN plataformaCompraOnlineIngressos.localevento
            ON evento.nomelocal = localevento.nomelocal
            WHERE organizador.cnpj = :cnpj";

             $retorno = $conexao->prepare($sql);
             $retorno->bindParam(':cnpj', $_SESSION['cnpj_login']);
             $retorno->execute();

             $eventoCount = 0;
             if ($retorno->rowCount() > 0) {
                while ($row = $retorno->fetch(PDO::FETCH_ASSOC)) {
                $eventoCount++;
                
                $eventoID = $row['idevento']; // Adicione o ID do evento
                $titulo_evento = $row['titulo'];
                $dataHora_evento = $row['datahoraevento'];
                $descricao_evento = $row ['descricao'];
                $duracao_evento = $row['duracao'];
                $classificacao_evento = $row['classificacao'];
                $webSite_evento = $row['website'];
                $precobase_evento = $row['precobase'];

                $categoria_evento = $row['nomecategoriaevento'];
                $descricao_categoria_evento = $row["descricaocategoria"];

                $nomelocal_evento = $row['nomelocal'];
                $detalhesAcesso = $row["detalhesdeacesso"];
                $capacidadeLocal = $row["capacidade"];
                
                $rua_endereco = $row['rua'];
                $numero_endereco = $row['numero'];
                $cidade_endereco= $row['cidade'];
                $cep_endereco= $row['cep'];

            echo "<h2>Evento $eventoCount</h2>";
            echo "<p><strong>Nome:</strong> " . $titulo_evento . "</p><br>";
            echo "<p><strong>Data:</strong> " . $dataHora_evento . "</p><br>";
            echo "<p><strong>Descrição:</strong> " . $descricao_evento . "</p><br>";
            echo "<p><strong>Duração do evento:</strong> " . $duracao_evento . " horas </p><br>";
            echo "<p><strong>Classificação</strong> " . $classificacao_evento . "</p><br>";
            echo "<p><strong>Site:</strong> " . $webSite_evento . "</p><br>";
            echo "<p><strong>Preço base:</strong> " . $precobase_evento . "</p><br>";

            echo "<p><strong>Categoria:</strong> " . $categoria_evento . "</p><br>";
            echo "<p><strong>Descrição da categoria:</strong> " . $descricao_categoria_evento . "</p><br>";

            echo "<p><strong>Local:</strong> " . $nomelocal_evento . "</p><br>";
            echo "<p><strong>Detalhes do acesso ao local:</strong> " . $detalhesAcesso . "</p><br>";
            echo "<p><strong>Capacidade do local:</strong> " . $capacidadeLocal . "</p><br>";

            echo "<p><strong>Endereco:</strong> Rua " . $rua_endereco . ", " . $numero_endereco . ", Cidade: " . $cidade_endereco . ", CEP: " . $cep_endereco . "</p><br>";
            echo "<hr>";
                }
           } else {
                echo "Nenhum evento encontrado relacionado a sua conta.";
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
                        echo "<input type='hidden' name='idevento' value='$eventoID'>"; // Envie o ID do evento
                        echo "<h2>Evento $eventoCount</h2>";
                        echo '<label for="nome">Nome:</label><br>';

                        echo '<input type="text" id="titulo" name="titulo" value="' . $titulo_evento . '"><br><br>';

                        echo '<label for="datahoraevento">Data e hora:</label><br>';
                        echo '<input type="text" id="datahoraevento" name="datahoraevento" value="' . $dataHora_evento . '"><br><br>';
                        
                        echo '<label for="descricao">Descrição:</label><br>';
                        echo '<input type="text" id="descricao" name="descricao" value="' . $descricao_evento . '"><br><br>';
                        
                        echo '<label for="duracao">Duração:</label><br>';
                        echo ' <input type="text" id="duracao" name="duracao" value=' . $duracao_evento . '><br><br>';
                          
                        echo '<label for="classificacao">Classificação:</label><br>';
                        echo ' <input type="text" id="classificacao" name="classificacao" value="' . $classificacao_evento . '"><br><br>';

                        echo '<label for="website">Website:</label><br>';
                        echo ' <input type="text" id="website" name="website" value="' . $webSite_evento . '"><br><br>';

                        echo '<label for="precobase">Preço base do ingresso:</label><br>';
                        echo ' <input type="text" id="precobase" name="precobase" value="' . $precobase_evento . '"><br><br>';

                        echo '<label for="categoria">Categoria:</label><br>';
                        echo ' <input type="text" id="nomecategoriaevento" name="nomecategoriaevento" value="' . $categoria_evento . '"><br><br>';

                        echo '<label for="descricaocategoria">Descrição da categoria:</label><br>';
                        echo ' <input type="text" id="descricaocategoria" name="descricaocategoria" value="'. $descricao_categoria_evento . '"><br><br>';

                        echo '<label for="local">Local:</label><br>';
                        echo ' <input type="text" id="nomelocal" name="nomelocal"  value="' . $nomelocal_evento . '"><br><br>';
                        
                        echo '<label for="detalhesdeacesso">Detalhes de acesso:</label><br>';
                        echo ' <input type="text" id="detalhesdeacesso" name="detalhesdeacesso"  value="' . $detalhesAcesso  . '"><br><br>';
                       
                        echo '<label for="capacidade">Capacidade do local:</label><br>';
                        echo ' <input type="text" id="capacidade" name="capacidade"  value="' . $capacidadeLocal . '"><br><br>';
                        
                        echo '<label for="rua">Rua:</label><br>';
                        echo ' <input type="text" id="rua" name="rua" value="' . $rua_endereco . '"><br><br>';
                        
                        echo '<label for="numero">Número:</label><br>';
                        echo ' <input type="text" id="numero" name="numero" value=' . $numero_endereco . '><br><br>';
                        
                        echo '<label for="cidade">Cidade:</label><br>';
                        echo '<input type="text" id="cidade" name="cidade" value="' . $cidade_endereco . '"><br><br>';
                        
                        echo '<label for="cep">CEP:</label><br>';
                        echo ' <input type="text" id="cep" name="cep" value=' . $cep_endereco . '><br><br>';
                      

                    echo "<hr>";
                    ?>
                     </div>
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

<main>
    <article>
        <div id="adicionar-evento" class="login-container">
            <h1>Adicionar Novo Evento</h1>
            <form action="processar_evento.php" method="post">
                <label for="titulo">Título do Evento:</label><br>
                <input type="text" id="titulo" name="titulo" required><br><br>

                <label for="datahora">Data e Hora do Evento:</label><br>
                <input type="datetime-local" id="datahoraevento" name="datahoraevento" required><br><br>

                <label for="descricao">Descrição do Evento:</label><br>
                <input type="text" id="descricao" name="descricao"><br><br>

                <label for="duracao">Duração (horas):</label><br>
                <input type="text" id="duracao" name="duracao"><br><br>

                <label for="classificacao">Classificação:</label><br>
                <input type="text" id="classificacao" name="classificacao" required><br><br>

                <label for="website">Website:</label><br>
                <input type="text" id="website" name="website"  required><br><br>

                <label for="precobase">Preço base:</label><br>
                <input type="text" id="precobase" name="precobase"  required><br><br>

                <label for="nomecategoriaevento">Categoria:</label><br>
                <input type="text" id="nomecategoriaevento" name="nomecategoriaevento" required><br><br>

                <label for="descricaocategoria">Descrição da categoria:</label><br>
                <input type="text" id="descricaocategoria" name="descricaocategoria" required><br><br>

                <label for="nomelocal">Local:</label><br>
                <input type="text" id="nomelocal" name="nomelocal"required><br><br>

                <label for="detalhesdeacesso">Detalhes de acesso:</label><br>
                <input type="text" id="detalhesdeacesso" name="detalhesdeacesso" required><br><br>

                <label for="capacidade">Capacidade do local:</label><br>
                <input type="text" id="capacidade" name="capacidade" required><br><br>

                <label for="rua">Rua:</label><br>
                <input type="text" id="rua" name="rua" required><br><br>

                <label for="numero">Número:</label><br>
                <input type="text" id="numero" name="numero"required><br><br>

                <label for="cidade">Cidade:</label><br>
                <input type="text" id="cidade" name="cidade"required><br><br>

                <label for="cep">CEP:</label><br>
                <input type="text" id="cep" name="cep"required><br><br>

                <label for="cnpj">Confirme o seu CNPJ:</label><br>
                <input type="text" id="cnpj" name="cnpj"required><br><br>

                <button type="submit">Adicionar Evento</button>
            </form>
        </div>
    </article>
</main>
    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>

