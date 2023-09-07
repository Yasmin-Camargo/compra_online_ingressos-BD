<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <script src="javascript/javascript.js"></script>
    <title>Plataforma de compra online de ingressos</title>
</head>
<body>
    <?php 
        //Conectando ao banco de dados
        include("paginas/conexao.php");
        $conexao = conectarAoBanco();
    ?>
    <header>
        <h1>TICKET VERSE</h1>
        <p>Desfrute de eventos exclusivos na nossa plataforma de compra online de ingresso</p>
        <div id="menu">
            <form id="pesquisa-esquerda" action="/paginas/pesquisa.php" method="get">
                <input type="text" name="busca" placeholder="Digite sua pesquisa...">
                <button type="submit">Buscar </button>
            </form>
            <nav id="nav-direita">
                <a href="index.php" target="_self">Home</a>
                <a href="paginas/descricao.php" target="_self">Descrição</a>
                <a href="../paginas/compra_ingressos.php" target="_self">Ingressos</a>
                <?php
                    // Verifica se o usuário está logado (para mostrar nome dele)
                    if ($_SESSION['usuario_login'] != NULL) {
                        echo '<a href="paginas/usuario.php">Bem-vindo, '. $_SESSION['usuario_login'] .'</a>';
                    } else {
                        echo '<a href="paginas/login.php">Entrar</a>';
                    }
                ?>
            </nav>
        </div>
    </header>

    <main>
        <article>
            <h1>Seja bem-vindo</h1>
            <p>
                Explore nosso site e comece a reservar seus ingressos hoje mesmo! Aqui você encontrará uma seleção diversificada de eventos emocionantes e cativantes
            </p> <br>
            
            <!-- Filtro dos eventos (todos e favoritos) -->
            <?php
                // Verifica se o usuário está logado, se sim mostra filtro
                if ($_SESSION['usuario_login'] != NULL) {
            ?>
            <div class="filter-section">
                <label for="filter">Filtrar por:</label>
                <form action="" method="post">
                <select id="filter">
                    <option value="todos">Todos</option>
                    <option value="favoritos">Favoritos</option>
                </select>
            </div> <br>
            <?php
                } 
            ?>  
            <br>
           
            <div id="events-container">
                <!-- Mostra todos eventos do banco -->
                <?php
                $conexao = conectarAoBanco();
                $sql = "SELECT  evento.titulo, evento.descricao, evento.nomelocal, evento.duracao, evento.datahoraevento, evento.imagens, 
                                endereco.rua, endereco.numero, endereco.cidade, endereco.cep 
                        FROM plataformaCompraOnlineIngressos.evento
                        JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco";
                $retorno = $conexao->prepare($sql);
                $retorno->execute();
                $results = $retorno->fetchAll(PDO::FETCH_ASSOC);
                $conexao = null;
                ?>
                <?php foreach ($results as $row): 
                    //Coleta dados
                    $titulo = $row['titulo'];
                    $datahoraevento = $row['datahoraevento'];
                    $descricao = $row['descricao'];
                    $duracao = $row['duracao'];
                    $nomelocal = $row['nomelocal'];
                    $rua = $row['rua'];
                    $numero = $row['numero'];
                    $cidade = $row['cidade'];
                    $cep = $row['cep'];
                    $imagens = $row['imagens'];
                    ?>
                    <div class="event">
                        <h2><?php echo $titulo; ?></h2>
                        <p class="date"><?php echo date('d \d\e F, Y', strtotime($datahoraevento)); ?></p>

                        <p><?php echo $descricao; ?></p>
                        <p>Duração: <?php echo $duracao ?> horas</p>
                        <p>Local: <?php echo $nomelocal; ?></p>
                        <!-- Exibe o endereço do evento -->
                        <p>Endereço: <?php echo $rua . ', ' . $numero . ', ' . $cidade . ', ' . $cep; ?></p>
                        
                        <!-- Verifica se a coluna 'imagens' está definida e não está vazia -->
                        <?php if (isset($imagens) && !empty($imagens)): ?>
                            <img src="<?php echo $row['imagens']; ?>" alt="Imagem do evento">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>


            <!-- Mostra eventos favoritos do usuário -->
            <div id="favoritos-container">
                <!-- Mostra todos eventos do banco -->
                <?php
                $conexao = conectarAoBanco();
                $sql = "SELECT evento.titulo, evento.descricao, evento.nomelocal, evento.duracao, evento.datahoraevento, evento.imagens, 
                               endereco.rua, endereco.numero, endereco.cidade, endereco.cep
                        FROM plataformaCompraOnlineIngressos.evento
                        JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco
                        JOIN plataformaCompraOnlineIngressos.favorita ON evento.idevento = favorita.idevento
                        WHERE favorita.cpf = :cpf";

                $retorno = $conexao->prepare($sql);
                $retorno->bindParam(':cpf', $_SESSION['cpf_login'], PDO::PARAM_STR);
                $retorno->execute();
                $results = $retorno->fetchAll(PDO::FETCH_ASSOC);
                $conexao = null;
                ?>
                <?php foreach ($results as $row): 
                    //Coleta dados
                    $titulo = $row['titulo'];
                    $datahoraevento = $row['datahoraevento'];
                    $descricao = $row['descricao'];
                    $duracao = $row['duracao'];
                    $nomelocal = $row['nomelocal'];
                    $rua = $row['rua'];
                    $numero = $row['numero'];
                    $cidade = $row['cidade'];
                    $cep = $row['cep'];
                    $imagens = $row['imagens'];
                    ?>
                    <div class="event">
                        <h2><?php echo $titulo; ?></h2>
                        <p class="date"><?php echo date('d \d\e F, Y', strtotime($datahoraevento)); ?></p>

                        <p><?php echo $descricao; ?></p>
                        <p>Duração: <?php echo $duracao ?> horas</p>
                        <p>Local: <?php echo $nomelocal; ?></p>
                        <!-- Exibe o endereço do evento -->
                        <p>Endereço: <?php echo $rua . ', ' . $numero . ', ' . $cidade . ', ' . $cep; ?></p>
                        
                        <!-- Verifica se a coluna 'imagens' está definida e não está vazia -->
                        <?php if (isset($imagens) && !empty($imagens)): ?>
                            <img src="<?php echo $row['imagens']; ?>" alt="Imagem do evento">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
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