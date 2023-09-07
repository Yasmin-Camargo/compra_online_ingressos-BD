<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <script src="javascript.js"></script>
    <title>Plataforma de compra online de ingressos</title>
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
            <form id="pesquisa-esquerda" action="" method="get">
                <input type="text" name="busca" placeholder="Digite sua pesquisa...">
                <button type="submit">Buscar </button>
            </form>
            <nav id="nav-direita">
                <a href="../index.php" target="_self">Home</a>
                <a href="descricao.php" target="_self">Descrição</a>
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
            <br>
            <a href="../index.php" target="_self">Voltar</a>
            <br><br>
           
            <!-- Mostra eventos pesquisados pelo usuário -->
            <div id="pesquisa-container">
            <?php
                if (isset($_GET['busca'])) {
                    $termoPesquisa = $_GET['busca'];

                    // Consulta SQL para buscar eventos com base no termo de pesquisa
                    $sql = "SELECT evento.titulo, evento.descricao, evento.nomelocal, evento.duracao, evento.datahoraevento, evento.imagens, 
                                   endereco.rua, endereco.numero, endereco.cidade, endereco.cep
                            FROM plataformaCompraOnlineIngressos.evento
                            JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco
                            WHERE evento.titulo LIKE :termoPesquisa 
                                OR evento.descricao LIKE :termoPesquisa 
                                OR evento.nomelocal LIKE :termoPesquisa 
                                OR evento.nomeCategoriaEvento LIKE :termoPesquisa";

                    $retorno = $conexao->prepare($sql);
                    $retorno->bindValue(':termoPesquisa', "%$termoPesquisa%", PDO::PARAM_STR);
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
                    <?php endforeach; 
                }
                ?>
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