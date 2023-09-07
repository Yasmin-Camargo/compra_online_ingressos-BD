<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Coletar os valores do formulário
        $nome = $_POST["nome"];
        $senha = $_POST["senha"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $cidade = $_POST["cidade"];
        $cep = $_POST["cep"];
        
        // Estabelecer a conexão com o banco de dados
        include("conexao.php"); 
        $conexao = conectarAoBanco();
     
       // Consulta para atualizar os dados do usuário
        $sql = "UPDATE plataformaCompraOnlineIngressos.usuario 
                SET nome = :nome, senha = :senha 
                WHERE cpf = :cpf";
        $retorno = $conexao->prepare($sql);
        $retorno->bindParam(':nome', $nome);
        $retorno->bindParam(':senha', $senha);
        $retorno->bindParam(':cpf', $_SESSION['cpf_login']);
        $retorno->execute();

        // Consulta para atualizar o endereço do usuário
        $sql = "UPDATE plataformaCompraOnlineIngressos.endereco 
        SET rua = :rua, 
            numero = :numero, 
            cidade = :cidade, 
            CEP = :cep
        WHERE idendereco IN (
            SELECT usuario.idendereco 
            FROM plataformaCompraOnlineIngressos.usuario 
            WHERE usuario.cpf = :cpf
        )";
        $retorno = $conexao->prepare($sql);
        $retorno->bindParam(':rua', $rua);
        $retorno->bindParam(':numero', $numero);
        $retorno->bindParam(':cidade', $cidade);
        $retorno->bindParam(':cep', $cep);
        $retorno->bindParam(':cpf', $_SESSION['cpf_login']);
        $retorno->execute();

        // Redirecionar para a página de perfil do usuário após a atualização
        header("Location: usuario.php");
    }
?>