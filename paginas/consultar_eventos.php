<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
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
            // Consulta eventos relacionados ao CNPJ desse organizador
            $sql = "SELECT evento.titulo
            FROM plataformaCompraOnlineIngressos.evento
            INNER JOIN plataformaCompraOnlineIngressos.organizador
            ON evento.cnpj = organizador.cnpj
            WHERE organizador.cnpj = :cnpj";

             $retorno = $conexao->prepare($sql);
             $retorno->bindParam(':cnpj', $_SESSION['cnpj_login']);
             $retorno->execute();

             // Mostra dados
             if ($retorno->rowCount() > 0) {
                $row = $retorno->fetch(PDO::FETCH_ASSOC);
                $titulo_evento = $row['titulo'];

            echo "<p><strong>Nome:</strong> " . $titulo_evento . "</p><br>";
            } else {
                echo "Nenhum dado encontrado.";
            }
            ?>

            <button id="botaoEditar" onclick="editInfoUsuario()">Editar Dados</button> 
                        </div> <br> 