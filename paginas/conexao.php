<?php

function conectarAoBanco() {
    // ALTERAR INFORMAÇÕES DO BANCO AQUI ----------------
    $host = "localhost";
    $port = "5432 ";
    $dbname = "aulabd1";  
    $user = "postgres";
    $password = "root";

    // -------------------------------------------------
    try {
        $conexao = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /* SE QUISER REINICIAR O QUE TEM NO BANCO (colocar os dados padrão)
            1) Descomente as duas linhas abaixo "$sqlScript =..." e "$conexao->..."
            2) Recarregue a página de index
            3) Comente as duas linhas novamente (se não vai ficar apagando e reiniciando BD sempre)*/
        
        //$sqlScript = file_get_contents('script.sql'); // Carregar o script SQL de inicialização
        //$conexao->exec($sqlScript);  
        
        return $conexao;

    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}
session_start();

// Verifica se a variável de sessão está definida
if (!isset($_SESSION['usuario_login'])) {
    $_SESSION['usuario_login'] = null; // Define um valor padrão, neste caso, nulo
    $_SESSION['cpf_login'] = null; // Define um valor padrão, neste caso, nulo
}

?>
