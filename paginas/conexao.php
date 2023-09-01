<?php
function conectarAoBanco() {
    // ALTERAR INFORMAÇÕES DO BANCO AQUI
    $host = "localhost";
    $port = "5432 ";
    $dbname = "aulabd1";  
    $user = "postgres";
    $password = "root";

    try {
        $conexao = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sqlScript = file_get_contents('../script.sql'); // Carregar o script SQL de inicialização

        // ---------- SE QUISER REINICIAR O QUE TEM NO BANCO DESCOMENTAR LINHA ABAIXO ------------------
        //$conexao->exec($sqlScript);  // obs.: toda vez que entrar na página index vai reiniciar

        return $conexao;

    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}
?>
