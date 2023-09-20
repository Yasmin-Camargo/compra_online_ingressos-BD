<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        include("conexao.php");
        $conexao = conectarAoBanco();
 
        // Coletar os valores do formulário
        $titulo_evento = $_POST["titulo"];
        $dataHora_evento = $_POST["datahoraevento"];
        $nomelocal_evento = $_POST["nomelocal"];
        $descricao_evento = $_POST["descricao"];
        $duracao_evento = $_POST["duracao"];
        $classificacao_evento = $_POST["classificacao"];
        $categoria_evento = $_POST["nomecategoriaevento"];
        $webSite_evento = $_POST["website"];
        $rua_endereco = $_POST["rua"];
        $numero_endereco = $_POST["numero"];
        $cidade_endereco = $_POST["cidade"];
        $cep_endereco = $_POST["cep"];
        
        
       // Consulta para atualizar os dados do usuário
        $sql = "UPDATE plataformaCompraOnlineIngressos.evento 
                SET titulo = :titulo, datahoraevento = :datahoraevento,
                nomelocal = :nomelocal, descricao = :descricao,
                duracao = :duracao, classificacao = :classificacao,
                nomecategoriaevento = :nomecategoriaevento,
                website = :website
                WHERE cnpj = :cnpj";

        if (!empty($sql)) {
        $retorno = $conexao->prepare($sql);
        $retorno->bindParam(':titulo', $titulo_evento);
        $retorno->bindParam(':datahoraevento', $dataHora_evento);
        $retorno->bindParam(':nomelocal', $nomelocal_evento);
        $retorno->bindParam(':descricao', $descricao_evento);
        $retorno->bindParam(':duracao', $duracao_evento);
        $retorno->bindParam(':classificacao', $classificacao_evento);
        $retorno->bindParam(':nomecategoriaevento', $categoria_evento);
        $retorno->bindParam(':website', $webSite_evento);
        $retorno->bindParam(':cnpj', $_SESSION['cnpj_login']);
        $retorno->execute();

        // Consulta para atualizar o endereço do usuário
        $sql = "UPDATE plataformaCompraOnlineIngressos.endereco 
        SET rua = :rua, 
            numero = :numero, 
            cidade = :cidade, 
            CEP = :cep
        WHERE IDendereco IN (
            SELECT evento.IDendereco 
            FROM plataformaCompraOnlineIngressos.evento 
            WHERE evento.cnpj = :cnpj
        )";
        $retorno = $conexao->prepare($sql);
        $retorno->bindParam(':rua', $rua_endereco);
        $retorno->bindParam(':numero',  $numero_endereco);
        $retorno->bindParam(':cidade',  $cidade_endereco);
        $retorno->bindParam(':cep', $cep_endereco);
        $retorno->bindParam(':cnpj', $_SESSION['cnpj_login']);
        $retorno->execute();

        header("Location: consultar_eventos.php");
        }
        } else {
            echo "Campos obrigatórios não preenchidos.";
            
        }
?>

