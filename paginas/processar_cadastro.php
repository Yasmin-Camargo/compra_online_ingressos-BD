<?php    
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera os valores dos campos do formulário usando $_POST
        $cpf = $_POST["cpf"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $cidade = $_POST["cidade"];
        $cep = $_POST["cep"];
       
        // faz a conexao com o banco de dados
        include("conexao.php");
        $conexao = conectarAoBanco();

        // Insere endereço no banco de dados
        $sql = "INSERT INTO plataformaCompraOnlineIngressos.endereco(rua, numero, cidade, CEP) VALUES ('$rua', $numero, '$cidade', '$cep') RETURNING idendereco;";
        $retorno = $conexao->query($sql);  // salva id do enreço

        // Verifica se a inserção foi bem-sucedida
        if ($retorno) {
            $row = $retorno->fetch(PDO::FETCH_ASSOC);
            $id_endereco = $row['idendereco'];

            // Insere usuario no banco de dados
            $sql = "INSERT INTO plataformaCompraOnlineIngressos.usuario(CPF, nome, email, senha, IDendereco) VALUES ('$cpf', '$nome', '$email', '$senha', $id_endereco);";
            $retorno = $conexao->query($sql);

            if ($retorno) {
                header("Location: login.html");   // direciona para página de login
            } else {
                $mensagem_erro = "Erro ao inserir usuario: " . $conexao->errorInfo()[2];
            }
        } else {
            $mensagem_erro = "Erro ao inserir endereço: " . $conexao->errorInfo()[2];
        }

    } else {
        // Se o formulário não foi submetido
        header("Location: cadastro.html");
        echo "O formulário não foi submetido.";
    }
    $conexao = null;
?>

