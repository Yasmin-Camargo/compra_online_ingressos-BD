<!DOCTYPE html>
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
        <article class="ingresso-container">
            <h1>Ingressos</h1>
            <?php
                // Verifica se o usuário está logado (para mostrar nome dele)
                if (isset($_SESSION['usuario_login']) && !empty($_SESSION['usuario_login'])) {
                    echo '<h3><a href="usuario.php">Olá, ' . $_SESSION['usuario_login'] . '</a></h3><br>';
                    if (!$conexao) {
                        echo "<p>Ocorreu um erro de conexão, recarregue a página.</p>\n";
                    }

                    // Verifica se houve um erro de conexão
                    if (!$conexao) {
                        echo "<p>Ocorreu um erro de conexão com o banco de dados, recarregue a página.</p>";
                    } else {

                        // Consulta para obter a quantidade total de ingressos comprados pelo usuário
                        $consultaQuantidadeIngressos = "SELECT nome, COUNT(ingresso.IDingresso) AS quantidadeingressos
                            FROM plataformaCompraOnlineIngressos.usuario
                            JOIN plataformaCompraOnlineIngressos.carrinhocompras ON usuario.cpf = carrinhocompras.cpf
                            JOIN plataformaCompraOnlineIngressos.compra ON carrinhocompras.idcarrinhoCompras = compra.idcarrinhoCompras
                            JOIN plataformaCompraOnlineIngressos.ingresso ON carrinhocompras.idcarrinhoCompras = ingresso.idcarrinhoCompras
                            JOIN plataformaCompraOnlineIngressos.evento ON ingresso.idevento = evento.idevento
                            WHERE usuario.cpf = :cpf
                            GROUP BY nome;";

                        $resultadoQuantidadeIngressos = $conexao->prepare($consultaQuantidadeIngressos);
                        $resultadoQuantidadeIngressos->bindParam(':cpf', $_SESSION['cpf_login']);
                        $resultadoQuantidadeIngressos->execute();

                        $quantidadeIngressos = 0;
                        if ($resultadoQuantidadeIngressos->rowCount() > 0) {
                            $rowQuantidade = $resultadoQuantidadeIngressos->fetch(PDO::FETCH_ASSOC);
                            $quantidadeIngressos = $rowQuantidade['quantidadeingressos'];
                        }
                        echo '<h3> Você já comprou um total de '.$quantidadeIngressos. ' ingressos </h3><br>';

                        echo '<h2>Consulte seus ingressos</h2><br>';
                        // Consulta ao banco de dados
                        $sql = "SELECT usuario.nome, usuario.cpf,
                        compra.notaFiscal, compra.valorfinal, compra.datahoracompra,
                        evento.titulo, evento.descricao,
                        ingresso.idingresso, ingresso.preco, ingresso.numassento,
                        categoriaingresso.nomecategoriaingresso, categoriaingresso.desconto,
                        cupomdesconto.codigodesconto, cupomdesconto.percentualdesconto,
                        localevento.nomelocal,
                        endereco.rua, endereco.numero, endereco.cidade
                        FROM plataformaCompraOnlineIngressos.usuario
                        JOIN plataformaCompraOnlineIngressos.carrinhocompras ON usuario.cpf = carrinhocompras.cpf
                        JOIN plataformaCompraOnlineIngressos.ingresso ON carrinhocompras.idcarrinhocompras = ingresso.idcarrinhocompras
                        JOIN plataformaCompraOnlineIngressos.evento ON ingresso.idevento = evento.idevento
                        JOIN plataformaCompraOnlineIngressos.categoriaingresso ON ingresso.nomecategoriaingresso = categoriaingresso.nomecategoriaingresso
                        JOIN plataformaCompraOnlineIngressos.compra ON carrinhocompras.idcarrinhocompras = compra.idcarrinhocompras
                        JOIN plataformaCompraOnlineIngressos.cupomdesconto ON compra.codigodesconto = cupomdesconto.codigoDesconto
                        JOIN plataformaCompraOnlineIngressos.localevento ON evento.nomelocal = localevento.nomelocal
                        JOIN plataformaCompraOnlineIngressos.endereco ON endereco.idendereco = localevento.idendereco
                        WHERE usuario.cpf = :cpf;";

                        $retorno = $conexao->prepare($sql);
                        $retorno->bindParam(':cpf', $_SESSION['cpf_login']);
                        $retorno->execute();

                        if ($retorno->rowCount() > 0) {
                            while ($row = $retorno->fetch(PDO::FETCH_ASSOC)) {
                                echo '<div class="ingresso">';
                                echo '<p><strong>Nota Fiscal:</strong> ' . $row['notafiscal'] . '</p>';
                                echo '<p><strong>Nome:</strong> ' . $row['nome'] . '</p>';
                                echo '<p><strong>CPF:</strong> ' . $row['cpf'] . '</p>';
                                echo '<p><strong>Valor Final:</strong> ' . $row['valorfinal'] . '</p>';
                                echo '<p><strong>Data/Hora da Compra:</strong> ' . $row['datahoracompra'] . '</p>';
                                echo '<p><strong>Evento:</strong> ' . $row['titulo'] . '</p>';
                                echo '<p><strong>Descrição:</strong> ' . $row['descricao'] . '</p>';
                                echo '<p><strong>ID do Ingresso:</strong> ' . $row['idingresso'] . '</p>';
                                echo '<p><strong>Preço do Ingresso:</strong> ' . $row['preco'] . '</p>';
                                echo '<p><strong>Número do Assento:</strong> ' . $row['numassento'] . '</p>';
                                echo '<p><strong>Categoria do Ingresso:</strong> ' . $row['nomecategoriaingresso'] . '</p>';
                                echo '<p><strong>Desconto na Categoria:</strong> ' . $row['desconto'] . '</p>';
                                echo '<p><strong>Código de Desconto:</strong> ' . $row['codigodesconto'] . '</p>';
                                echo '<p><strong>Percentual de Desconto:</strong> ' . $row['percentualdesconto'] . '</p>';
                                echo '<p><strong>Local do Evento:</strong> ' . $row['nomelocal'] . '</p>';
                                echo '<p><strong>Endereço do Evento:</strong> ' . $row['rua'] . ', ' . $row['numero'] . ', ' . $row['cidade'] . '</p>';
                                echo '</div>';
                                echo'<br><hr><br><br>';
                            }
                        } else {
                            echo "<p>Nenhum dado encontrado.</p>";
                        }
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
