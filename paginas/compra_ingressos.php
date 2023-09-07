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
                        echo '<a href="login.php">Bem-vindo, '. $_SESSION['usuario_login'] .'</a>';
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
         
<body>
  <a href="#" id="toggleSession">Compra de ingressos</a>
     <!--  <div class="sessao-expansivel" id="sessionContent">
    <label for="evento">Selecione o evento:</label>
            <select name="evento" id="evento">
                <option value="Dua Lipa - Rock In Rio">Dua Lipa - Rock In Rio</option>
                <option value="Dua Lipa - The Town">Dua Lipa - The Town</option>
                <option value="Workshop sobre Banco de Dados">Workshop - Banco de Dados</option>    
                <option value="Palestra IA">Palestra IA</option> 
                <option value="Concerto de Música">Concerto de Música</option>
                <option value="Exposição de Arte">Exposição de Arte</option>
            </select>
        <div class="filter-item" id="categoria-container">
            <label for="categoria">Selecione a categoria do seu ingresso:</label>
            <select name="categoria" id="categoria">
            -As opções de categoria de ingresso serão carregadas dinamicamente aqui 
            </select>
    </div>
    <div class="filter-item" id="cupom-desconto-container">
            <label for="categoria">Selecione um cupom de desconto:</label>
            <select name="categoria" id="categoria">
            As opções de categoria de ingresso serão carregadas dinamicamente aqui
            </select>
    <script src="script.js"></script>
    </div>  -->
    
    <a href="#" id="toggleSession">Consulte seus ingressos</a>
    <div class="sessao-expansivel" id="sessionContent">
    <h2>Consulta de Usuários</h2>
    <?php

    $result = pg_query($dbcon, "SELECT CPF, nome FROM usuario");

    if (!$result) {
        echo "Erro na consulta.<br>";
        exit;
    }

    while ($row = pg_fetch_row($result)) {
        echo "CPF: $row[0]  Nome: $row[1]";
        echo "<br />\n";
    }

    // Fechar a conexão com o banco de dados
    pg_close($dbcon);
    ?>
    <script>
     $(document).ready(function() {
            // Quando o evento selecionado mudar
            $('#evento').change(function() {
                var eventoSelecionado = $(this).val();

                // Realize uma solicitação AJAX para buscar as categorias de ingresso e cupons de desconto
                $.ajax({
                    type: 'POST',
                    url: 'C:\Program Files\compra_online_ingressos-BD\paginas\processar_compra_ingresso.php', // Caminho correto para o seu arquivo PHP
                    data: { eventoSelecionado: eventoSelecionado },
                    dataType: 'json',
                    success: function(data) {
                        // Atualize o campo de categoria de ingresso com as opções retornadas
                        $('#categoria-container select').html(data.categorias);

                        // Atualize o campo de cupons de desconto com as opções retornadas
                        $('#cupom-desconto-container select').html(data.cupons);
                    }
                });
            });

            // Referece a parte expandível de compra de ingressos
            const toggleSession = document.getElementById("toggleSession");
            const sessionContent = document.getElementById("sessionContent");

            toggleSession.addEventListener("click", function(e) {
                e.preventDefault();
                if (sessionContent.classList.contains("expandido")) {
                    sessionContent.classList.remove("expandido");
                } else {
                    sessionContent.classList.add("expandido");
                }
            });
        });
</script>
    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>
