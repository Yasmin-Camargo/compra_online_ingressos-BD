<!-- apenas quem tiver logado como organizador pode ver essa página

vai dar pra consultar usuario, cpf e ingresso relacionado
consultar o evento, quantos ingressos foram vendidos e de que tipo cada ingresso
-->
<!DOCTYPE html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <title>Consultar cadastros</title>
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
                        echo '<a href="login.php">Bem-vindo, '. $_SESSION['usuario_login'] .'</a>';
                    } else {
                        echo '<a href="login.php">Entrar</a>';
                    }
                ?>
                 <a href="../paginas/login_organizadores.php" target="_self">Organizadores</a>
            </nav>
        </div>
    </header>

<?php

    if ($conexao) {
        $query = $conexao->query("SELECT nome FROM plataformaCompraOnlineIngressos.usuario");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            if (isset($row['nome'])) {
                echo "Nome: " . $row['nome'];
            } else {
                // A chave 'nome' não existe no array.
                echo "Nome não encontrado.";
            }
            
         }
         $query = $conexao->query("SELECT CPF FROM plataformaCompraOnlineIngressos.usuario");
         $result = $query->fetchAll(PDO::FETCH_ASSOC);

         if (isset($row['CPF'])) {
            echo "CPF: " . $row['CPF'] . "<br>";
        } else {
            // A chave 'CPF' não existe no array.
            echo "CPF não encontrado.<br>";
        }
    }
    $query = "SELECT u.CPF AS CPF_usuario,
        u.nome AS nome_usuario,
        u.email AS email_usuario,
        i.IDingresso,
        e.titulo AS nome_evento,
        i.preco AS preco_ingresso,
        ci.nomeCategoriaIngresso AS categoria_ingresso
    FROM plataformaCompraOnlineIngressos.usuario u
    JOIN plataformaCompraOnlineIngressos.carrinhoCompras cc ON u.CPF = cc.CPF
    JOIN plataformaCompraOnlineIngressos.ingresso i ON cc.IDcarrinhoCompras = i.IDcarrinhoCompras
    JOIN plataformaCompraOnlineIngressos.evento e ON i.IDevento = e.IDevento
    JOIN plataformaCompraOnlineIngressos.categoriaIngresso ci ON i.nomeCategoriaIngresso = ci.nomeCategoriaIngresso";

try {
    // Execute a consulta usando PDO
    $result = $conexao->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
       // echo "CPF do Usuário: " . $row['CPF_usuario'] . "<br>"; 
        echo "Nome do Usuário: " . $row['nome_usuario'] . "<br>";
        echo "Email do Usuário: " . $row['email_usuario'] . "<br>";
        // echo "ID do Ingresso: " . $row['IDingresso'] . "<br>";
        echo "Nome do Evento: " . $row['nome_evento'] . "<br>";
        echo "Preço do Ingresso: " . $row['preco_ingresso'] . "<br>";
        echo "Categoria do Ingresso: " . $row['categoria_ingresso'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
}
