<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os valores dos campos do formulário usando $_POST
    $cnpj = $_POST["cnpj"];
    $nome_organizador = $_POST["nome"];
    $email_organizador = $_POST["email"];
    $telefone_organizador = $_POST["telefone"];

    // faz a conexao com o banco de dados
    include("conexao.php");
    $conexao = conectarAoBanco();

    // Verifica se o CNPJ já existe na tabela
    $sql_verifica_cnpj = "SELECT COUNT(*) FROM plataformaCompraOnlineIngressos.organizador WHERE cnpj = :cnpj";
    $stmt_verifica_cnpj = $conexao->prepare($sql_verifica_cnpj);
    $stmt_verifica_cnpj->bindParam(':cnpj', $cnpj);
    $stmt_verifica_cnpj->execute();
    $cnpj_existente = $stmt_verifica_cnpj->fetchColumn();

    if ($cnpj_existente > 0) {
        // CNPJ já existe, mostre uma mensagem de erro
        echo "Erro: CNPJ já cadastrado. Insira um CNPJ diferente.";
    } else {
        $sql = "INSERT INTO plataformaCompraOnlineIngressos.organizador
                (cnpj, nome, email, telefone) VALUES (:cnpj, :nome, :email, :telefone) RETURNING cnpj";
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':nome', $nome_organizador);
        $stmt->bindParam(':email', $email_organizador);
        $stmt->bindParam(':telefone', $telefone_organizador);

        if ($stmt->execute()) {
            // Inserção bem-sucedida
            echo "Cadastro realizado com sucesso.";
        } else {
            // Erro ao inserir
            echo "Erro ao inserir organizador.";
        }

        $conexao = null;
    }
} else {
    // Se o formulário não foi submetido
    header("Location: cadastro_organizador.php");
    echo "O formulário não foi submetido.";
}
?>

