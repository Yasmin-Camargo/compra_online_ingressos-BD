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
            <h1>Compre seus ingressos</h1>
            <p> Nesta página você pode conferir os ingressos disponíveis e os ingressos que você já comprou</p> <br> 
         
            <!DOCTYPE html>
<html>
<head>
    <title>Exemplo de Filtro Dinâmico</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form action="" method="post">
        <div class="filter-item">
            <label for="evento">Selecione o evento:</label>
            <select name="evento" id="evento">
                <option value="Dua Lipa - Rock In Rio">Dua Lipa - Rock In Rio</option>
                <option value="Dua Lipa - The Town">Dua Lipa - The Town</option>
                <option value="Workshop sobre Banco de Dados">Workshop - Banco de Dados</option>    
                <option value="Palestra IA">Palestra IA</option> 
                <option value="Concerto de Música">Concerto de Música</option>
                <option value="Exposição de Arte">Exposição de Arte</option>
            </select>
        </div>

        <div class="filter-item" id="categoria-container">
            <label for="categoria">Selecione a categoria do seu ingresso:</label>
            <select name="categoria" id="categoria">
                <!-- As opções de categoria de ingresso serão carregadas dinamicamente aqui -->
            </select>
        </div>
    </form>

    <script>
    $(document).ready(function() {
        // Quando o evento selecionado mudar
        $('#evento').change(function() {
            var eventoSelecionado = $(this).val();

            // Simule uma solicitação AJAX para buscar as categorias de ingresso
            // Substitua este trecho pelo código de solicitação AJAX real no seu projeto
            setTimeout(function() {
                // Resultado simulado da solicitação AJAX
                var categorias = [];

                // Defina as categorias com base no evento selecionado
                switch (eventoSelecionado) {
                    case 'Dua Lipa - Rock In Rio':
                    case 'Dua Lipa - The Town':
                        categorias = ['VIP', 'Normal', 'Meia Entrada'];
                        break;
                    case 'Workshop sobre Banco de Dados':
                        categorias = ['Normal Workshop', 'Professor Workshop'];
                        break;
                    default:
                        categorias = ['Selecione uma categoria'];
                        break;
                }
                // Limpe as opções existentes
                $('#categoria').empty();

                // Adicione as novas opções de categoria de ingresso
                for (var i = 0; i < categorias.length; i++) {
                    $('#categoria').append('<option value="' + categorias[i] + '">' + categorias[i] + '</option>');
                }
            }, 500); // Simula um atraso de 500ms, como uma solicitação AJAX real

        });
    });
    </script>
</body>
</html>

    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>


<script>
function atualizarCategorias() {
    var eventoSelecionado = document.getElementById('evento').value;
    // Realiza uma solicitação AJAX para buscar as categorias de ingresso
    $.ajax({
        type: 'POST',
            url: 'cd C:\Program Files\compra_online_ingressos-BD\paginas\processar_compra_ingresso.php', // Substitua pelo caminho correto para o seu arquivo PHP
            data: { evento: eventoSelecionado },
        success: function(data) {
            // Atualiza o campo de categoria de ingresso com as opções retornadas
            $('#categoria').html(data);
        }
    });
}
$('#evento').change(atualizarCategorias);
</script>
