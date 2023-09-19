<!DOCTYPE html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <title>Comprar Ingresso</title>
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
        <article class="ingresso-container">
            <h1>Ingressos</h1>
            <p> Nesta página você pode conferir os ingressos disponíveis e os ingressos que você já comprou</p> <br> 
            <a href="#" id="toggleConsultarIngressos" class="toggleSession">Consulte seus ingressos</a>
            <div class="sessao-expansivel" id="sessionContent">

             <?php

                if(!isset ($_SESSION['usuario_login'])) {
                    header("Location: login.php");
                    exit();
                }
                // Verifica se o usuário está logado (para mostrar nome dele)
                if (isset($_SESSION['usuario_login']) && !empty($_SESSION['usuario_login'])) {
                    echo '<a href="usuario.php">Bem-vindo, ' . $_SESSION['usuario_login'] . '</a>';
                    if (!$conexao) {
                        echo "Ocorreu um erro de conexão, recarregue a página.\n";
                    }
                    
                    // Verifica se houve um erro de conexão
                    if (!$conexao) {
                        echo "Ocorreu um erro de conexão com o banco de dados, recarregue a página.";
                    }else  {
                        
                        // Consulta ao banco de dados
                        $sql = "SELECT usuario.nome, usuario.cpf,
                        ingresso.preco, ingresso.numassento, 
                        categoriaIngresso.nomeCategoriaIngresso,
                        evento.titulo,
                        evento.descricao,
                        localevento.nomelocal,
                        endereco.rua, 
                        endereco.numero,
                        endereco.cidade
                        FROM plataformacompraOnlineIngressos.usuario
                        INNER JOIN plataformaCompraOnlineIngressos.carrinhoCompras
                            ON usuario.cpf = carrinhoCompras.cpf
                        INNER JOIN plataformaCompraOnlineIngressos.ingresso
                            ON carrinhoCompras.IDcarrinhoCompras = ingresso.IDcarrinhoCompras
                        INNER JOIN plataformaCompraOnlineIngressos.categoriaIngresso 
                            ON ingresso.nomeCategoriaIngresso = categoriaIngresso.nomeCategoriaIngresso
                        INNER JOIN plataformaCompraOnlineIngressos.evento
                            ON evento.idevento = ingresso.idevento
                        INNER JOIN plataformaCompraOnlineIngressos.localevento
                            ON evento.idendereco = localevento.idendereco
                        INNER JOIN plataformaCompraOnlineIngressos.endereco
                            ON localEvento.idendereco = endereco.idendereco
                        WHERE usuario.cpf = :cpf;";

                    $retorno = $conexao->prepare($sql);
                    $retorno->bindParam(':cpf', $_SESSION['cpf_login']);
                    $retorno->execute();

                    if ($retorno->rowCount() > 0) {
                        $row = $retorno->fetch(PDO::FETCH_ASSOC);
                        $nome_usuario = $row['nome'];
                        $cpf_usuario = $row['cpf'];
                        $titulo_evento = $row['titulo'];
                        $descricao_evento = $row['descricao'];
                        $preco_ingresso = $row['preco'];
                        $numAssento_ingresso = $row['numassento'];
                        $categoria_ingresso = $row['nomecategoriaingresso'];
                        $nome_local = $row['nomelocal'];
                        $rua_evento = $row['rua'];
                        $numero_evento = $row ['numero'];
                        $cidade_evento = $row ['cidade'];

                        echo "<p><strong>Nome:</strong> " . $nome_usuario . "</p><br>";
                        echo "<p><strong>CPF:</strong> " . $cpf_usuario . "</p><br>";
                        echo "<p><strong>Evento:</strong> " . $titulo_evento . "</p><br>";
                        echo "<p><strong>Descrição:</strong> " . $descricao_evento . "</p><br>";
                        echo "<p><strong>Preço:</strong> " . $preco_ingresso . "</p><br>";
                        echo "<p><strong>Assento:</strong> " . $numAssento_ingresso . "</p><br>";
                        echo "<p><strong>Categoria do ingresso:</strong> " . $categoria_ingresso . "</p><br>";
                        echo "<p><strong>Endereco:</strong> " . $rua_evento . "," . $numero_evento . ", " . $cidade_evento . "</p><br>";
                    } else {
                        echo "Nenhum dado encontrado.";
                    }
                }
            }
            
            ?> 

            <script>
                const mostrarConsultaSQL = document.getElementById("mostrarConsultaSQL");
                const consultaSQL = document.getElementById("consultaSQL");
                mostrarConsultaSQL.addEventListener("click", function (e) {
                    e.preventDefault();
                    // Defina o conteúdo do elemento "consultaSQL" com a consulta
                    consultaSQL.textContent = consulta;

                    // Torna o elemento "consultaSQL" visível
                    consultaSQL.style.display = "block";
                });
                </script>
            </article>

            <a href="#" id="toggleCompraIngressos" class="toggleSession">Compra de ingressos</a>
            <div class="sessao-expansivel" id="sessionContent">


    </main>

    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Referece a parte expansível de compra de ingressos
        const toggleCompraIngressos = document.getElementById("toggleCompraIngressos");
        const toggleConsultarIngressos = document.getElementById("toggleConsultarIngressos");
        const sessionContent = document.getElementById("sessionContent");
        const consultaSql = document.getElementById("consultaSql"); // Elemento para exibir a consulta SQL

        toggleCompraIngressos.addEventListener("click", function (e) {
            //e.preventDefault();
            sessionContent.classList.toggle("expandido");

            // Adicione aqui o código para definir o conteúdo da consulta SQL no elemento "consultaSql"
            consultaSql.style.display = "block"; // Torna o elemento visível
        });

        toggleConsultarIngressos.addEventListener("click", function (e) {
            e.preventDefault();
            sessionContent.classList.toggle("expandido");

            // Adicione aqui o código para definir o conteúdo da consulta SQL no elemento "consultaSql"
            //consultaSql.style.display = "block"; // Torna o elemento visível
        });
</script>