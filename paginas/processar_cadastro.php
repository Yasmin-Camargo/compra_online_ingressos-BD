<?php
try {
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

        // Validação simples dos campos obrigatórios
        if (empty($cpf) || empty($nome) || empty($email) || empty($senha) || empty($rua) || empty($numero) || empty($cidade) || empty($cep)) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        // Faz a conexão com o banco de dados
        include("conexao.php");
        $conexao = conectarAoBanco();

        // Insere endereço no banco de dados
        $sql = "INSERT INTO plataformaCompraOnlineIngressos.endereco(rua, numero, cidade, CEP) VALUES ('$rua', $numero, '$cidade', '$cep') RETURNING idendereco;";
        $retorno = $conexao->query($sql);

        // Verifica se a inserção do endereço foi bem-sucedida
        if (!$retorno) {
            throw new Exception("Erro ao inserir endereço.");
        }

        $row = $retorno->fetch(PDO::FETCH_ASSOC);
        $id_endereco = $row['idendereco'];

        // Insere usuário no banco de dados
        $sql = "INSERT INTO plataformaCompraOnlineIngressos.usuario(CPF, nome, email, senha, IDendereco) VALUES ('$cpf', '$nome', '$email', '$senha', $id_endereco);";
        $retorno = $conexao->query($sql);

        // Verifica se a inserção do usuário foi bem-sucedida
        if (!$retorno) {
            throw new Exception("Erro ao inserir usuário.");
        }

        // Redireciona para a página de login
        header("Location: login.php");
        exit();
    } else {
        // Se o formulário não foi submetido
        header("Location: cadastro.php");
        exit();
    }
} catch (Exception $e) {
    // Exibe uma mensagem de erro usando JavaScript e volta para a tela inicial
    echo "<script>
            alert('ERRO NO CADASTRO:  " . $e->getMessage() . "');
            window.location.href = '../paginas/cadastro.php';
          </script>";
}


?>
