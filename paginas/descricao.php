<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/icons8-claquete-64.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <title>Descricao</title>
</head>
<body>
    <?php 
        //Conectando ao banco de dados
        include("conexao.php");
        $conexao = conectarAoBanco();
    ?>
    <header>
        <h1>TICKET VERSE</h1>
        <p>Desfrute de eventos exclusivos na nossa plataforma de compra online de ingresso</p>
        <div id="menu">
            <form id="pesquisa-esquerda" action="/search" method="get">
                <input type="text" name="q" placeholder="Digite um evento...">
                <button type="submit">Buscar </button>
            </form>
            <nav id="nav-direita">
                <a href="../index.php" target="_self">Home</a>
                <a href="descricao.php" target="_self">Descrição</a>
                <?php
                    // Verifica se o usuário está logado
                    if ($_SESSION['usuario_login'] != NULL) {
                        echo '<a href="login.php">Bem-vindo, '. $_SESSION['usuario_login'] .'</a>';
                    } else {
                        echo '<a href="login.php">Entrar</a>';
                    }
                ?>
            </nav>
        </div>
    </header>

    <main>
        <article> 
            <h1>Sobre o trabalho</h1>
            <p>Este site faz parte de um Projeto Prático que compõe a avaliação da disciplina de Banco de Dados. </p> <br> 

            <h2> Pré-projeto – descrição do problema a ser resolvido</h2>
            <p>Deseja-se armazenar dados referentes a compra de ingressos de eventos oferecidos pelas empresas parceiras.</p>
            <p>A <strong>Plataforma</strong> deseja armazenar informações sobre seus eventos. Os <strong>administradores</strong> gerenciam a plataforma. Sobre cada <strong>Administrador</strong>, deseja-se armazenar nome, endereço de e-mail e senha. O administrador gerencia a plataforma. O <strong>Organizador</strong> cria e gerencia o evento. Sobre cada organizador, deseja-se armazenar nome e informações de contato. Cada evento tem um ou mais organizadores e um mesmo organizador pode planejar mais de um evento.</p>
            <p>Sobre os <strong>Eventos</strong>, deseja-se armazenar o organizador responsável, categoria do evento, localização, título, data e hora, descrição, duração, classificação e imagens. Cada evento está classificado em apenas uma categoria.Sobre as <strong>Categorias</strong>, é necessário armazenar nome e descrição. As categorias representam os diferentes tipos ou gêneros aos quais os eventos podem pertencer (Show, Festas, Teatro, Espetáculos, Balada, etc.).Uma <strong>Agenda de eventos</strong> armazena uma lista ou calendário de eventos que estão disponíveis para compra. Uma agenda de eventos poderá possuir os eventos associados, data, local e links para os detalhes de cada evento. Sobre a localização do evento, deseja-se armazenar nome, endereço, capacidade, detalhes de acesso ao local. Diferentes eventos podem ser marcados na mesma localização em horários diferentes. Diferentes eventos podem ser marcados no mesmo horário em diferentes lugares.</p>
            <p>Sobre cada <strong>Usuário</strong> devem ser armazenados CPF, nome, endereço de e-mail, senha e favoritos. Um usuário pode comprar um ou mais ingressos. Um usuário pode comprar ingressos para diferentes eventos.Cada <strong>Ingresso</strong> representa um ingresso específico para um evento. Sobre o ingresso, armazena-se o evento associado, a categoria referente do ingresso, preço e número do assento (se disponível). <strong>Categoria do ingresso</strong> representa as diferentes categorias às quais um ingresso pode pertencer (Platéia, VIP, Pista, Camarote, Arquibancada, Meia-entrada, etc.). Sobre cada categoria do ingresso, devem ser armazenados nome, descrição, restrições, disponibilidade e preço.</p>
            <p>O <strong>Carrinho de compras</strong> representa quais ingressos o usuário selecionou para comprar, mas ainda não efetuou o pagamento. Sobre cada carrinho de compras, deseja-se armazenar o usuário que está realizando a compra, o evento associado e o total. A <strong>Compra</strong> representa um pedido de compra de ingresso para um evento. Sobre a compra, deseja-se armazenar Número Nota fiscal, usuário que realizou a compra, evento relacionado, ingressos adquiridos, forma de pagamento, cupom de Desconto (caso aplicado), Data e Hora da Compra, total e status. As <strong>Formas de pagamento</strong> representam os diferentes métodos pelos quais os usuários podem efetuar o pagamento ao realizar uma compra (boleto, pix, cartão, etc). Sobre as formas de pagamento, devem ser armazenados o tipo de pagamento e as informações adicionais. O <strong>Cupom de desconto</strong> permite reduzir o valor do total da compra. Deseja-se armazenar código de desconto, porcentagem de desconto, data de início, data de término e restrições.</p>
            <p>Além dessas informações, deseja-se armazenar quais são os <strong>eventos favoritos</strong> do usuário e quais são as <strong>avaliações</strong> dos mesmos sobre o processo de compra na plataforma. Os <strong>Favoritos</strong> permitem que os usuários salvem eventos de seu interesse para acessá-los posteriormente. Deseja-se armazenar o respectivo usuário, os eventos adicionados e data de adição. A <strong>Avaliação</strong> representa as avaliações e comentários deixados pelos usuários em relação aos eventos que eles frequentaram. É necessário armazenar o usuário que realizou a avaliação, qual evento foi avaliado, pontuação e texto do comentário. A <strong>Plataforma</strong> é a representação do local onde serão disponibilizados os ingressos. Sobre a plataforma, deseja-se armazenar Nome, Redes sociais, Website, informações de contato e a taxa de conveniência aplicada sobre os ingressos.</p>


            <h2> Projeto Lógico - definição do modelo ER e do esquema lógico</h2>
            <h3> Modelo Entidade Relacionamento (ER)</h3>
            <img src="../imagens/ER-1.png" alt="Imagem modelo Entidade Relacionamento 1">
            <img src="../imagens/ER-2.png" alt="Imagem modelo Entidade Relacionamento 2">
            
            <h3> Modelo Lógico</h3>
            <p><strong>Administrador</strong> (nome, email, senha, website)</p>
            <p>website referencia Plataforma (website)</p><br>
            <p><strong>Plataforma</strong> (nome, website, taxaConveniencia, telefone, email, IDredesSociais)</p>
            <p>IDredesSociais referencia RedesSociais (IDredesSociais)</p><br>
            <p><strong>RedesSociais</strong> (IDredesSociais, nome, link)</p><br>
            <p><strong>Eventos</strong> (IDevento, titulo, data, hora, descricao, duracao, classificacao, imagens, hora,  website CNPJ, nomeCategoriaEvento, nomeLocal)</p>
            <p>website referencia Plataforma (website)</p>
            <p>CNPJ referencia Organizador (CNPJ)</p>
            <p>nomeCategoriaEvento referencia CategoriaEvento (nomeCategoriaEvento)</p>
            <p>nomeLocal referencia Local(nomeLocal)</p><br>
            <p><strong>Organizador</strong> (CNPJ, nome, email, telefone)</p><br>
            <p><strong>CategoriaEvento</strong> (nomeCategoriaEvento, descricao)</p><br>
            <p><strong>Local</strong> (nomeLocal, detalhesDeAcesso, capacidade, IDendereco)</p>
            <p>IDendereco referencia Endereco (IDendereco)</p><br>
            <p><strong>Endereco</strong> (IDendereco, rua, numero, cidade, CEP )</p><br>
            <p><strong>Avalia</strong> (CPF, IDevento, comentario, nota, data)</p>
            <p>CPF referencia Usuario (CPF)</p>
            <p>IDevento referencia Evento (IDevento)</p><br>
            <p><strong>Favorita</strong> (CPF, IDevento, dataAdicao)</p>
            <p>CPF referencia Usuario (CPF)</p>
            <p>IDevento referencia Evento (IDevento)</p><br>
            <p><strong>Usuario</strong> (CPF, nome, email, senha, IDendereco)</p>
            <p>IDendereco referencia Endereco (IDendereco)</p><br>
            <p><strong>Ingresso</strong> (IDingresso, numAssento, total, IDevento, IDcarrinhoCompras, nomeCategoriaIngresso, preco)</p>
            <p>IDevento referencia Evento (IDevento)</p>
            <p>IDcarrinhoCompras referencia CarrinhoCompras (IDcarrinhoCompras)</p>
            <p>nomeCategoriaIngresso referencia CategoriaIngresso (nomeCategoriaIngresso)</p><br>
            <p><strong>CategoriaIngresso</strong> (nomeCategoriaIngresso, descricao, restricao, desconto)</p><br>
            <p><strong>CarrinhoDeCompras</strong> (IDcarrinhoCompras, total, CPF)</p>
            <p>CPF referencia Usuario (CPF)</p><br>
            <p><strong>Compra</strong> (notaFiscal, data, hora, valorFinal, IDcarrinhoCompras, codigoDesconto, CPF, IDpagamento)</p>
            <p>IDcarrinhoCompras referencia CarrinhoDeCompras (IDcarrinhoCompras)</p>
            <p>codigoDesconto referencia Usuario (codigoDesconto)</p>
            <p>CPF referencia Usuario (CPF)</p>
            <p>IDpagamento referencia Pagamento (IDpagamento)</p><br>
            <p><strong>CupomDesconto</strong> (codigoDesconto, porcentagemDesconto, restricoes, dataInicio, dataTermino)</p><br>
            <p><strong>Pagamento</strong> (IDpagamento)</p><br>
            <p><strong>Pix</strong> (codigoPix, IDpagamento)</p>
            <p>IDpagamento referencia Pagamento (IDpagamento)</p><br>
            <p><strong>Boleto</strong> (codigoBarras, IDpagamento)</p>
            <p>IDpagamento referencia Pagamento (IDpagamento)</p><br>
            <p><strong>Cartao</strong> (numeroCartao, nome, dataVencimento, CVV, IDpagamento)</p>
            <p>IDpagamento referencia Pagamento (IDpagamento)</p><br>


            <h2> Esquema físico SQL</h2>
            <h3> Script para Criação das tabelas</h3>
            <pre>
    -- Excluir o esquema e seus objetos
    DROP SCHEMA IF EXISTS plataformaCompraOnlineIngressos CASCADE;
    
    -- Exclua os tipos de dados
    DROP DOMAIN IF EXISTS tipoCNPJ CASCADE;
    DROP DOMAIN IF EXISTS tipoCPF CASCADE;
    DROP DOMAIN IF EXISTS tipoTelefone CASCADE;
    DROP DOMAIN IF EXISTS tipoNumeroCartao CASCADE;
    DROP DOMAIN IF EXISTS tipoPorcentagem CASCADE;
    DROP DOMAIN IF EXISTS tipoValorPreco CASCADE;
    DROP DOMAIN IF EXISTS tipoEmail CASCADE;
    
    -- Criando schema
    CREATE SCHEMA plataformaCompraOnlineIngressos;
    
    -- Entrando no schema
    set search_path to plataformaCompraOnlineIngressos;
    
    -- Criando tipos válidos:
    CREATE DOMAIN tipoCNPJ AS CHAR(14);
    
    CREATE DOMAIN tipoCPF AS CHAR(11);
    
    CREATE DOMAIN tipoTelefone AS VARCHAR(11)
        CHECK (VALUE ~ '^\d{9,11}$');
    
    CREATE DOMAIN tipoNumeroCartao AS CHAR(16);
    
    CREATE DOMAIN tipoPorcentagem AS INT
        CHECK (VALUE >= 0 AND VALUE <= 100);
    
    CREATE DOMAIN tipoValorPreco AS DECIMAL(10, 2);
    
    CREATE DOMAIN tipoEmail AS VARCHAR(50)
        CHECK (VALUE ~* '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$');
    
    
    -- Criando as tabelas:
    CREATE TABLE redesSociais (
        IDredesSociais SERIAL NOT NULL, 
        nome VARCHAR(30) NOT NULL, 
        linkSite VARCHAR(50) NOT NULL UNIQUE,
        
        PRIMARY KEY(IDredesSociais)
    );
    
    CREATE TABLE plataforma (
        website VARCHAR(50) NOT NULL, 
        nome VARCHAR(30) NOT NULL DEFAULT 'Ticket Verse', 
        taxaConveniencia tipoValorPreco NOT NULL DEFAULT 5.00, 
        telefone tipoTelefone NOT NULL UNIQUE, 
        email tipoEmail NOT NULL UNIQUE, 
        IDredesSociais INT,
        
        PRIMARY KEY(website),
        FOREIGN KEY(IDredesSociais) REFERENCES redesSociais(IDredesSociais)
            ON DELETE SET NULL ON UPDATE CASCADE
    );
    
    
    CREATE TABLE administrador (
        email tipoEmail NOT NULL, 
        nome VARCHAR(30) NOT NULL DEFAULT 'root', 
        senha VARCHAR(20) NOT NULL DEFAULT 'root', 
        website VARCHAR(50) NOT NULL,
        
        PRIMARY KEY(email),
        FOREIGN KEY(website) REFERENCES plataforma(website)
            ON UPDATE CASCADE
    );
    
    CREATE TABLE organizador(
        CNPJ tipoCNPJ NOT NULL, 
        nome VARCHAR(30) NOT NULL, 
        email tipoEmail NOT NULL UNIQUE, 
        telefone tipoTelefone UNIQUE,
        
        PRIMARY KEY(CNPJ)
    );
    
    CREATE TABLE categoriaEvento(
        nomeCategoriaEvento VARCHAR(30) NOT NULL,
        descricao TEXT NOT NULL,
        
        PRIMARY KEY(nomeCategoriaEvento)
    );
    
    CREATE TABLE endereco(
        IDendereco SERIAL NOT NULL, 
        rua VARCHAR(30) NOT NULL, 
        numero INT NOT NULL, 
        cidade VARCHAR(30) NOT NULL, 
        CEP VARCHAR(8) NOT NULL,
        
        PRIMARY KEY(IDendereco)
    );
    
    CREATE TABLE localEvento(
        nomeLocal VARCHAR(30) NOT NULL,
        IDendereco INT NOT NULL,
        detalhesDeAcesso TEXT NOT NULL DEFAULT 'Acesso pelo portão principal', 
        capacidade INT NOT NULL,  
        
        PRIMARY KEY(nomeLocal, IDendereco),
        FOREIGN KEY(IDendereco) REFERENCES endereco(IDendereco)
    );
    
    
    CREATE TABLE usuario(
        CPF tipoCPF NOT NULL, 
        nome VARCHAR(30) NOT NULL, 
        email tipoEmail NOT NULL UNIQUE, 
        senha VARCHAR(20) NOT NULL, 
        IDendereco INT NOT NULL,
        
        PRIMARY KEY(CPF),
        FOREIGN KEY(IDendereco) REFERENCES endereco(IDendereco)
            ON UPDATE CASCADE
    );
    
    CREATE TABLE categoriaIngresso(
        nomeCategoriaIngresso VARCHAR(30) NOT NULL, 
        descricao TEXT, 
        restricao TEXT NOT NULL DEFAULT 'Nenhuma restrição', 
        desconto INT NOT NULL,
        
        PRIMARY KEY(nomeCategoriaIngresso)
    );
    
    CREATE TABLE carrinhoCompras(
        IDcarrinhoCompras SERIAL NOT NULL, 
        total tipoValorPreco NOT NULL, 
        CPF tipoCPF NOT NULL,
        
        PRIMARY KEY(IDcarrinhoCompras),
        FOREIGN KEY(CPF) REFERENCES usuario(CPF)
            ON DELETE CASCADE ON UPDATE CASCADE
    );
    
    CREATE TABLE cupomDesconto(
        codigoDesconto VARCHAR(20) NOT NULL,
        porcentagemDesconto tipoPorcentagem NOT NULL, 
        restricoes TEXT NOT NULL DEFAULT 'Nenhuma restrição', 
        dataInicio TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        dataTermino TIMESTAMP NOT NULL,
        
        PRIMARY KEY(codigoDesconto)
    );
    
    CREATE TABLE pagamento(
        idPagamento SERIAL NOT NULL,
        
        PRIMARY KEY(idPagamento)
    );
    
    
    CREATE TABLE pix(
        codigoPix VARCHAR(100) NOT NULL, 
        IDpagamento INT NOT NULL,
        
        PRIMARY KEY(codigoPix),
        FOREIGN KEY(IDpagamento) REFERENCES pagamento(idPagamento)
            ON DELETE CASCADE ON UPDATE CASCADE
    );
    
    CREATE TABLE boleto(
        codigoBarras VARCHAR(100) NOT NULL, 
        IDpagamento INT NOT NULL,
        
        PRIMARY KEY(codigoBarras),
        FOREIGN KEY(IDpagamento) REFERENCES pagamento(idPagamento)
            ON DELETE CASCADE ON UPDATE CASCADE
    );
    
    CREATE TABLE cartao(
        numeroCartao tipoNumeroCartao NOT NULL, 
        nome VARCHAR(30) NOT NULL, 
        dataVencimento DATE NOT NULL, 
        CVV SMALLINT NOT NULL, 
        IDpagamento INT NOT NULL,
        
        PRIMARY KEY(numeroCartao),
        FOREIGN KEY(IDpagamento) REFERENCES pagamento(idPagamento)
            ON DELETE CASCADE ON UPDATE CASCADE
    );
    
    CREATE TABLE compra(
        notaFiscal VARCHAR(44) NOT NULL, 
        dataHoraCompra TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        valorFinal tipoValorPreco NOT NULL, 
        IDcarrinhoCompras INT NOT NULL, 
        codigoDesconto VARCHAR(20),
        IDPagamento INT NOT NULL,
        
        PRIMARY KEY(notaFiscal),
        FOREIGN KEY(IDcarrinhoCompras) REFERENCES carrinhoCompras(IDcarrinhoCompras),
        FOREIGN KEY(codigoDesconto) REFERENCES cupomDesconto(codigoDesconto),
        FOREIGN KEY(IDpagamento) REFERENCES pagamento(idPagamento)
            ON UPDATE CASCADE
    );
    
    
    
    CREATE TABLE evento(
        IDevento SERIAL NOT NULL, 
        titulo VARCHAR(30) NOT NULL, 
        dataHoraEvento TIMESTAMP NOT NULL,  
        descricao TEXT NOT NULL, 
        duracao INT, 
        classificacao VARCHAR(30) NOT NULL DEFAULT 'Livre', 
        imagens VARCHAR(50), 
        website VARCHAR(50) NOT NULL UNIQUE, 
        CNPJ tipoCNPJ NOT NULL, 	
        nomeCategoriaEvento VARCHAR(30) NOT NULL, 
        nomeLocal VARCHAR(30) NOT NULL,
        IDendereco INT NOT NULL,
        
        PRIMARY KEY(IDevento),
        FOREIGN KEY(CNPJ) REFERENCES organizador(CNPJ)
            ON UPDATE CASCADE,
        FOREIGN KEY(nomeCategoriaEvento) REFERENCES categoriaEvento(nomeCategoriaEvento)
            ON UPDATE CASCADE,
        FOREIGN KEY(nomeLocal, IDendereco) REFERENCES localEvento(nomeLocal, IDendereco)
    );
    
    CREATE TABLE avalia(
        CPF tipoCPF NOT NULL,  
        IDevento INT NOT NULL, 
        comentario TEXT NOT NULL, 
        nota SMALLINT NOT NULL, 
        dataAvalia DATE NOT NULL DEFAULT CURRENT_DATE,
        
        PRIMARY KEY(CPF, IDevento),
        FOREIGN KEY(CPF) REFERENCES usuario(CPF)
            ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(IDevento) REFERENCES evento(IDevento)
            ON DELETE CASCADE ON UPDATE CASCADE 
    );
    
    CREATE TABLE favorita(
        CPF tipoCPF NOT NULL, 
        IDevento INT NOT NULL,  
        dataAdicao DATE NOT NULL DEFAULT CURRENT_DATE,
        
        PRIMARY KEY(CPF, IDevento),
        FOREIGN KEY(CPF) REFERENCES usuario(CPF)
            ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(IDevento) REFERENCES evento(IDevento)
            ON DELETE CASCADE ON UPDATE CASCADE
    );
    
    CREATE TABLE ingresso(
        IDingresso SERIAL NOT NULL, 
        numAssento INT NOT NULL, 
        preco tipoValorPreco NOT NULL,
        IDevento INT NOT NULL,  
        IDcarrinhoCompras INT, 
        nomeCategoriaIngresso VARCHAR(30) NOT NULL,
        
        FOREIGN KEY(IDevento) REFERENCES evento(IDevento)
            ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(IDcarrinhoCompras) REFERENCES carrinhoCompras(IDcarrinhoCompras)
            ON DELETE SET NULL ON UPDATE SET NULL,
        FOREIGN KEY(nomeCategoriaIngresso) REFERENCES categoriaIngresso(nomeCategoriaIngresso)
            ON UPDATE CASCADE
    );                
            </pre>

            <h3> Script para Inserção de dados na tabela</h3>
            <pre>
    INSERT INTO redesSociais (nome, linkSite)
    VALUES ('Instagram', 'https://www.instagram.com/ticketverse'),
                ('Youtube', 'https://www.youtube.com/ticketverse'),
                ('Twitter', 'https://twitter.com/ticketverse');
    
    INSERT INTO plataforma (website, telefone, email, IDredesSociais)
    VALUES ('ticketverse.com', '97232317485', 'ticketverse@minhaplataforma.com', 1);
            </pre><br>

            <p> O código fonte desenvolvido desenvolvido para simular a interface com o usuário (este site) pode ser consultado <u><a href="https://github.com/Yasmin-Camargo/compra_online_ingressos-BD">aqui</a></u>. Foi escolhida a linguagem de marcação HTML, para fazer a estilização o CSS e para fazer a comunicação com o banco de dados foi utilizada a linguagem de programação PHP</p><br>
    </main>


    <footer>
        <p>
            Site criado por <a href="https://github.com/Caroline-Camargo">Caroline Souza Camargo</a>, <a href="https://github.com/majudlorenzoni">Maria Júlia Duarte Lorenzoni</a> e <a href="https://github.com/Yasmin-Camargo">Yasmin Souza Camargo</a> para a disciplina de banco de dados.
        </p>
    </footer>
</body>
</html>