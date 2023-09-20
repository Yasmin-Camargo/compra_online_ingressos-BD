<?php    
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera os valores dos campos do formulário usando $_POST
        $titulo_evento = $_POST["titulo"];
        $dataHora_evento = $_POST["datahoraevento"];
        $descricao_evento = $_POST["descricao"];
        $duracao_evento = $_POST["duracao"];
        $classificacao_evento = $_POST["classificacao"];
        $webSite_evento = $_POST["website"];
        $cnpj_organizador_evento = $_POST["cnpj"];

        $categoria_evento = $_POST["nomecategoriaevento"];
        $descricao_categoria_evento = $_POST["descricaocategoria"];

        $nomelocal_evento = $_POST["nomelocal"];
        $detalhesAcesso = $_POST["detalhesdeacesso"];
        $capacidadeLocal = $_POST["capacidade"];

        $rua_endereco = $_POST["rua"];
        $numero_endereco = $_POST["numero"];
        $cidade_endereco = $_POST["cidade"];
        $cep_endereco = $_POST["cep"];

        include("conexao.php");
        $conexao = conectarAoBanco();

        $sql = "INSERT INTO plataformaCompraOnlineIngressos.endereco(rua, numero, cidade, CEP) 
        VALUES ('$rua_endereco', $numero_endereco, ' $cidade_endereco', '$cep_endereco') RETURNING idendereco;";
        $retorno = $conexao->query($sql);  // salva id do endereço

        // Verifica se a inserção foi bem-sucedida
        if ($retorno) {
            $row = $retorno->fetch(PDO::FETCH_ASSOC);
            $id_endereco = $row['idendereco'];

            $sql = "INSERT INTO plataformaCompraOnlineIngressos.categoriaevento(nomecategoriaevento, descricao)
            VALUES ('$categoria_evento', '$descricao_categoria_evento');";
            $retorno_categoria = $conexao->query($sql);

            if ($retorno_categoria) {
                $sql = "INSERT INTO plataformaCompraOnlineIngressos.evento
                (titulo, datahoraevento, descricao, duracao, classificacao, website, cnpj, nomecategoriaevento, nomelocal, IDendereco)
                 VALUES ('$titulo_evento', '$dataHora_evento', 
                 '$descricao_evento',  '$duracao_evento', '$classificacao_evento',
                 '$webSite_evento', ' $cnpj_organizador_evento', '$categoria_evento', '$nomelocal_evento', $id_endereco);";
                $retorno_evento = $conexao->query($sql);

                if ($retorno_evento) {
                    header("Location: consultar_eventos.php");   // direciona para página de login
                    exit();
                } else {
                    echo "Erro ao inserir evento. ";
                }
            } else {
                echo "Erro ao inserir categoria de evento. ";
            }
        } else {
            echo "Erro ao inserir endereço do evento. ";
        }
    } else {
        // Se o formulário não foi submetido
        echo "O formulário não foi submetido.";
    }   

    $conexao = null;
?>
