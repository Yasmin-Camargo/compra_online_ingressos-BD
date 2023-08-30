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
                <a href="descricao.html" target="_self">Descrição</a>
                <a href="login.html">Entrar</a>
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
                $host = "localhost";
                $port = "5432 ";
                $dbname = "aulabd1";
                $user = "postgres";
                $password = "root";

                try {
                    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Erro na conexão: " . $e->getMessage());
                }
                
                $query = "SELECT * FROM plataformaCompraOnlineIngressos.evento";
                $statement = $pdo->prepare($query);
                $statement->execute();
                $results = 
                $statement->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <!-- CONSULTA COM BANCO DE DADOS -->
            <table>
                <tr>
                    <th>idevento</th>
                    <th>titulo</th>
                    <th>datahoraevento</th>
                    <th>descricao</th>
                    <th>duracao</th>
                    <th>classificacao</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo $row['idevento']; ?></td>
                        <td><?php echo $row['titulo']; ?></td>
                        <td><?php echo $row['datahoraevento']; ?></td>
                        <td><?php echo $row['descricao']; ?></td>
                        <td><?php echo $row['duracao']; ?></td>
                        <td><?php echo $row['classificacao']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
        </article>
    </main>

    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>