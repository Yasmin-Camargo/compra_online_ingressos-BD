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

        // Insere endereço no banco de dados
        $sql = "INSERT INTO plataformaCompraOnlineIngressos.organizador
        (cnpj, nome, email, telefone) VALUES ('$cnpj', '$nome_organizador', '$email_organizador', $telefone_organizador) RETURNING cnpj;";
        $retorno = $conexao->query($sql);  // salva cnpj

        // Verifica se a inserção foi bem-sucedida
        if ($retorno) {
            $row = $retorno->fetch(PDO::FETCH_ASSOC);
            $id_endereco = $row['idendereco'];

        } else {
            echo "Erro ao inserir organizador: ";
        }

    } else {
        // Se o formulário não foi submetido
        header("Location: cadastro_organizador.php");
        echo "O formulário não foi submetido.";
    }
    $conexao = null;
?>
