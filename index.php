<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <title>Plataforma de compra online de ingressos</title>
</head>
<body>
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
                <a href="paginas/descricao.html" target="_self">Descrição</a>
                <a href="paginas/login.html">Entrar</a>
            </nav>
        </div>
    </header>

    <main>
        <article>
            <h1>Seja bem-vindo</h1>
            <p>
                Explore nosso site e comece a reservar seus ingressos hoje mesmo! Aqui você encontrará uma seleção diversificada de eventos emocionantes e cativantes
            </p> <br>
            
            <!-- CONEXÃO COM O BANCO DE DADOS -->
            <?php
                include("paginas/conexao.php");
                $conexao = conectarAoBanco();

                $query = "SELECT * FROM plataformaCompraOnlineIngressos.evento";
                $statement = $conexao->prepare($query);
                $statement->execute();
                $results = 
                $statement->fetchAll(PDO::FETCH_ASSOC);
                $conexao = null;
            ?>

            <!-- CONSULTA COM BANCO DE DADOS -->
            <div id="events-container">
                <?php foreach ($results as $row): ?>
                <div class="event">
                    <h2><?php echo $row['titulo']; ?></h2>
                    <p class="date"><?php echo date('d \d\e F, Y', strtotime($row['datahoraevento'])); ?></p>

                    <p><?php echo $row['descricao']; ?></p>
                    <p>Duração: <?php echo $row['duracao']; ?> horas</p>
                    
                    <!-- Verifica se a coluna 'imagem' está definida e não está vazia -->
                    <?php if (isset($row['imagens']) && !empty($row['imagens'])): ?>
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