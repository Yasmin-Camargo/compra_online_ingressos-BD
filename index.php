<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <script src="javascript.js"></script>
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
            <form id="pesquisa-esquerda" action="/search" method="get">
                <input type="text" name="q" placeholder="Digite um evento...">
                <button type="submit">Buscar </button>
            </form>
            <nav id="nav-direita">
                <a href="index.php" target="_self">Home</a>
                <a href="paginas/descricao.php" target="_self">Descrição</a>
                <?php
                    // Verifica se o usuário está logado
                    if ($_SESSION['usuario_login'] != NULL) {
                        echo '<a href="paginas/login.php">Bem-vindo, '. $_SESSION['usuario_login'] .'</a>';
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
            
            
            <!-- Filtro dos eventos (entre todos e favoritos) só aparece se estiver logado -->
            <?php
                // Verifica se o usuário está logado
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
            ?>  <br>

           
            <div id="events-container">
                <!-- Mostra todos eventos do banco -->
                <?php
                $conexao = conectarAoBanco();
                $sql = "SELECT evento.*, endereco.rua, endereco.numero, endereco.cidade, endereco.cep 
                        FROM plataformaCompraOnlineIngressos.evento
                        JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco";
                $retorno = $conexao->prepare($sql);
                $retorno->execute();
                $results = $retorno->fetchAll(PDO::FETCH_ASSOC);
                $conexao = null;
                ?>
                <?php foreach ($results as $row): ?>
                    <div class="event">
                        <h2><?php echo $row['titulo']; ?></h2>
                        <p class="date"><?php echo date('d \d\e F, Y', strtotime($row['datahoraevento'])); ?></p>

                        <p><?php echo $row['descricao']; ?></p>
                        <p>Duração: <?php echo $row['duracao']; ?> horas</p>
                        <p>Local: <?php echo $row['nomelocal']; ?></p>
                        <!-- Exibe o endereço do evento -->
                        <p>Endereço: <?php echo $row['rua'] . ', ' . $row['numero'] . ', ' . $row['cidade'] . ', ' . $row['cep']; ?></p>
                        
                        <!-- Verifica se a coluna 'imagens' está definida e não está vazia -->
                        <?php if (isset($row['imagens']) && !empty($row['imagens'])): ?>
                            <img src="<?php echo $row['imagens']; ?>" alt="Imagem do evento">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>


            <!-- FAZER: Mostra eventos favoritos do usuário -->
            
            <!-- FAZER: Mostra eventos da cosulta da barra de pesquisa -->

        </article>
    </main>

    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>


</body>
</html>