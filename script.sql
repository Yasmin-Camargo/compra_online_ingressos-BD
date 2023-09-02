set search_path to plataformaCompraOnlineIngressos;
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
    linkSite text NOT NULL UNIQUE,
   
    PRIMARY KEY(IDredesSociais)
);

CREATE TABLE plataforma (
    website text NOT NULL,
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
    website text NOT NULL,
   
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
    imagens text,
    website text NOT NULL UNIQUE,
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

-- Inserindo Dados
INSERT INTO redessociais (nome, linkSite)
VALUES ('Instagram', 'https://www.instagram.com/ticketverse'),
       ('Youtube', 'https://www.youtube.com/ticketverse'),
      ('Twitter', 'https://twitter.com/ticketverse');

INSERT INTO plataforma (website, telefone, email, IDredesSociais)
VALUES ('ticketverse.com', '97232317485', 'ticketverse@minhaplataforma.com', 1);

INSERT INTO administrador (email, nome, senha, website)
VALUES ('admin@dualipa.com', 'Admin', 'senha123', 'ticketverse.com'),
  ('admin2@dualipa.com', 'Admin', 'senha456', 'ticketverse.com');

INSERT INTO organizador (CNPJ, nome, email, telefone)
VALUES ( '1321220000120', 'Empresa Rock In Rio', 'contato@rockInRio.com', '9876543210'),
       ('50678706000185', 'Empresa The Town', 'contato@theTown.com', '1234567890');

INSERT INTO categoriaEvento (nomeCategoriaEvento, descricao)
VALUES ('Show', 'Apresentação musical ao vivo');

INSERT INTO endereco (rua, numero, cidade, CEP)
VALUES ('Parque Olimpico', 123, 'Rio de Janeiro', '20211901'),
       ('Av. Senador Teotônio Vilela', 261, 'São Paulo', '98765432');

INSERT INTO localEvento (nomeLocal, IDendereco, detalhesDeAcesso, capacidade)
VALUES ('Cidade do Rock', 1, 'Acesso pela entrada norte', 700000),
       ('Interlagos', 2, 'Acesso pelo portão lateral', 500000);

INSERT INTO usuario (CPF, nome, email, senha, IDendereco)
VALUES ('12345678901', 'Louise Queiroz', 'louisequeiroz@example.com', 'louise1405', 1),
       ('98765432109', 'Carol Camargo', 'carolcamargo@example.com', 'girlvitech12', 2),
       ('78541265497', 'Yasmin Camargo', 'yasmincamargo@example.com', 'vitechgir12l', 1),
       ('25478963451', 'Bianca Beppler', 'biancabeppler@example.com', 'petcomp123', 2),
       ('21548631074', 'Maria Lorenzoni', 'marialorenzoni@example.com', 'petcomp493', 1);

INSERT INTO categoriaIngresso (nomeCategoriaIngresso, descricao, restricao, desconto)
VALUES ('VIP', 'Ingresso com acesso privilegiado', 'Idade mínima 18 anos', 0),
       ('Normal', 'Ingresso padrão', 'Nenhuma restrição', 10),
       ('Meia Entrada', 'Ingresso destinado a estudantes, idosos e pessoas com deficiência', 'Apresentar documento que comprove o direito ao ingresso', 50);

INSERT INTO carrinhoCompras (total, CPF)
VALUES  (1000.00, '12345678901'),
        (700, '98765432109'),
        (1000, '78541265497'),
        (700, '25478963451'),
        (1000, '21548631074');

INSERT INTO cupomDesconto (codigoDesconto, porcentagemDesconto, restricoes, dataInicio, dataTermino)
VALUES ('DUALOVE', 15, 'Válido para compras acima de R$3000', '2023-08-01', '2023-08-31');
 
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;


INSERT INTO pix (codigoPix, IDpagamento) VALUES ('ABCDE', 1);
INSERT INTO pix (codigoPix, IDpagamento) VALUES ('XYZ123', 2);

INSERT INTO boleto (codigoBarras, IDpagamento) VALUES ('1234567890', 3);

INSERT INTO cartao (numeroCartao, nome, dataVencimento, CVV, IDpagamento)
VALUES ('1234567890', 'Bianca B', '2023-12-31', 123, 4);

INSERT INTO cartao (numeroCartao, nome, dataVencimento, CVV, IDpagamento)
VALUES ('9876543210987654', 'Maria Duarte', '2024-06-30', 456, 5);

INSERT INTO compra (notaFiscal, valorFinal, IDcarrinhoCompras, codigoDesconto, IDPagamento)
VALUES ('NF2023001', 1000.00, 1, NULL, 1),
       ('NF2023002', 700.00, 2, NULL, 2),
       ('NF2023003', 1000.00, 3, NULL, 3),
       ('NF2023004', 700.00, 4, NULL, 4),
       ('NF2023005', 1000.00, 5, NULL, 5);

INSERT INTO evento (titulo, dataHoraEvento, descricao, duracao, website, imagens, CNPJ, nomeCategoriaEvento, nomeLocal, IDendereco)
VALUES ('Show da Dua Lipa - Rock In Rio', '2023-09-27 21:00:00', 'Dua Lipa apresenta as suas principais cancoes no Rio de Janeiro', 3, 'dualipaRIR.com', 'https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2021/06/19318_93C917483777B85E.jpg?w=876&h=484&crop=1', '1321220000120', 'Show', 'Cidade do Rock', 1),
       ('Show da Dua Lipa - The Town', '2023-09-30 23:00:00', 'Dua Lipa apresenta as suas principais cancoes em Sao Paulo', 3, 'dualipaTT.com', 'https://jpimg.com.br/uploads/2022/05/000_32a77az.jpg', '50678706000185', 'Show', 'Interlagos', 2);

INSERT INTO avalia (CPF, IDevento, comentario, nota)
VALUES  ('21548631074', 1, 'Amei o show! Muito bem organizado.', 5),
        ('98765432109', 2, 'Ótimo show! Adorei a energia.', 5),
        ('12345678901', 1, 'ADOREIII!!!', 5);

INSERT INTO favorita (CPF, IDevento)
VALUES ('21548631074', 1),
       ('98765432109', 1);

INSERT INTO ingresso (numAssento, preco, IDevento, IDcarrinhoCompras, nomeCategoriaIngresso)
VALUES  (101, 1000, 1, 1, 'VIP'),
        (203, 700, 1, 2, 'Normal'),
        (103, 1000, 1, 1, 'VIP'),
        (204, 700, 1, 2, 'Normal'),
        (105, 1000, 1, 1, 'VIP');


INSERT INTO categoriaEvento (nomeCategoriaEvento, descricao)
VALUES ('Workshop', 'Workshop educacional sobre Banco de Dados');

INSERT INTO organizador (CNPJ, nome, email, telefone)
VALUES ('4578912345678', 'Coordenacao Computacao', 'comp@ufpel.com', '539987456');

INSERT INTO endereco (rua, numero, cidade, CEP)
VALUES ('Gomes Carneiro', 1, 'Pelotas', '96010610');

INSERT INTO localEvento (nomeLocal, IDendereco, detalhesDeAcesso, capacidade)
VALUES ('Campus Anglo', 3, 'Sala 328 - 3 Andar', 10);

INSERT INTO usuario (CPF, nome, email, senha, IDendereco)
VALUES ('11223344556', 'Joao Silva', 'joaosilva@example.com', 'joaosilva11', 3),
       ('44556677889', 'Daniela Santos', 'danisantos@example.com', 'daniss22', 3),
       ('99885522116', 'Paulo Duarte', 'pauloduarte@example.com', 'pauloduart33', 3),
       ('22661155887', 'Beatriz Machado', 'beatrizmachado@example.com', 'biamachado44', 3),
       ('88557722991', 'Eduardo Campos', 'eduardocampos@example.com', 'eduardoc55', 3),
       ('99224466883', 'Francisco Ferreira', 'franciscoferreira@example.com', 'franciscoferreira66', 3),
       ('00115522447', 'Gustavo Gomez', 'gustavogomez@example.com', 'gustavogomez77', 3),
       ('77224455998', 'Heitor Henrique', 'heitorhenrique@example.com', 'heitorhenrique88', 3),
       ('99227744883', 'Igor Costa', 'igorcosta@example.com', 'igorCosta99', 3),
       ('99227788220', 'Katlyn Swift', 'katyinswift@example.com', 'katlynswift10', 3);


INSERT INTO usuario (CPF, nome, email, senha, IDendereco)
VALUES  ('14227765883', 'Luis Lourenco', 'luislourenco@example.com', 'luislourenco', 3);

INSERT INTO categoriaIngresso (nomeCategoriaIngresso, descricao, restricao, desconto)
VALUES  ('Normal Workshop', 'Ingresso padrão', 'Nenhuma restrição', 0),
        ('Professor Workshop', 'Ingresso docente', 'Apenas professores tem direito', 100);

INSERT INTO carrinhoCompras (total, CPF)
VALUES (10.00, '11223344556'),
       (10.00, '44556677889'),
       (10.00, '99885522116'),
       (10.00, '22661155887'),
       (10.00, '88557722991'),
       (10.00, '99224466883'),
       (10.00, '00115522447'),
       (10.00, '77224455998'),
       (10.00, '99227744883'),
       (10.00, '99227788220');


INSERT INTO cupomDesconto (codigoDesconto, porcentagemDesconto, restricoes, dataInicio, dataTermino)
VALUES  ('EstudanteUFPEL', 100, 'Valido para os estudantes que apresentarem o comprovante', '2023-09-01', '2023-09-07'),
        ('EstudanteUFSM', 50, 'Valido para os estudantes que apresentarem o comprovante', '2023-09-01', '2023-09-07'),
        ('EstudanteUFRGS', 50, 'Valido para os estudantes que apresentarem o comprovante', '2023-09-01', '2023-09-07');

INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;
INSERT INTO pagamento DEFAULT VALUES;


INSERT INTO pix (codigoPix, IDpagamento) VALUES ('FSDFJHKSDF', 6);
INSERT INTO pix (codigoPix, IDpagamento) VALUES ('FDHFKJKSDF', 7);
INSERT INTO pix (codigoPix, IDpagamento) VALUES ('IRTURETSL3498', 8);
INSERT INTO pix (codigoPix, IDpagamento) VALUES ('ASLFIAF', 9);

INSERT INTO boleto (codigoBarras, IDpagamento) VALUES ('4578123690', 10);
INSERT INTO boleto (codigoBarras, IDpagamento) VALUES ('8765432015', 11);
INSERT INTO boleto (codigoBarras, IDpagamento) VALUES ('1204578963', 12);

INSERT INTO cartao (numeroCartao, nome, dataVencimento, CVV, IDpagamento)
VALUES ('4578962548', 'Igor C', '2027-09-10', 852, 13);  

INSERT INTO cartao (numeroCartao, nome, dataVencimento, CVV, IDpagamento)
VALUES ('4320987658', 'Gustavo G', '2028-10-11', 527, 14);  

INSERT INTO cartao (numeroCartao, nome, dataVencimento, CVV, IDpagamento)
VALUES ('9517453268', 'Beatriz Machado', '2026-04-06', 721, 15);  

INSERT INTO compra (notaFiscal, valorFinal, IDcarrinhoCompras, codigoDesconto, IDPagamento)
VALUES ('NF2023006', 10.00, 6, 'EstudanteUFPEL', 6),
       ('NF2023007', 10.00, 7, NULL, 7),
       ('NF2023008', 10.00, 8, 'EstudanteUFSM', 8),
       ('NF2023009', 10.00, 9, NULL, 9),
       ('NF2023010',10.00, 10, 'EstudanteUFRGS', 10),
       ('NF2023011',10.00, 11, NULL, 11),
       ('NF2023012',10.00, 12, 'EstudanteUFPEL', 12),
       ('NF2023013',10.00, 13, NULL, 13),
       ('NF2023014', 10.00, 14, 'EstudanteUFSM', 14),
       ('NF2023015',10.00, 15, NULL, 15);

INSERT INTO evento (titulo, dataHoraEvento, descricao, duracao, website, imagens, CNPJ, nomeCategoriaEvento, nomeLocal, IDendereco)
VALUES ('Workshop sobre Banco de Dados', '2023-09-27 21:00:00', 'UFPEL apresenta os principais conceitos sobre banco de dados', 4, 'bancodedadosUFPEL.com', 'https://wp.ufpel.edu.br/empauta/files/2019/09/ufpel.jpg', '4578912345678', 'Workshop', 'Campus Anglo', 3);

INSERT INTO avalia (CPF, IDevento, comentario, nota)
VALUES  ('11223344556', 3, 'Evento de muito aprendizado.', 5),
        ('44556677889', 3, 'Compreendi melhor banco de dados apos o evento', 5),
        ('99227744883', 3, 'Super interessante', 5),
        ('77224455998', 3, 'Interessante', 5);

INSERT INTO favorita (CPF, IDevento)
VALUES ('00115522447', 3),
       ('44556677889', 3),
       ('88557722991', 3),
       ('77224455998', 3),
       ('99227744883', 3);

INSERT INTO ingresso (numAssento, preco, IDevento, IDcarrinhoCompras, nomeCategoriaIngresso)
VALUES (1, 10, 3, 6, 'Normal Workshop'),
       (2, 0, 3, 7, 'Professor Workshop'),
       (3, 10, 3, 8, 'Normal Workshop'),
       (10, 0, 3, 9, 'Professor Workshop'),
       (4, 10, 3, 10, 'Normal Workshop'),
       (5, 10, 3, 11, 'Normal Workshop'),
       (6, 10, 3, 12, 'Normal Workshop'),
       (7, 10, 3, 13, 'Normal Workshop'),
       (8, 10, 3, 14, 'Normal Workshop'),
       (9, 10, 3, 15, 'Normal Workshop');



-- OUTROS EVENTOS
INSERT INTO endereco (rua, numero, cidade, CEP)
VALUES ('Rua das Flores', 123, 'Pelotas', '96020100');

INSERT INTO localEvento (nomeLocal, IDendereco, detalhesDeAcesso, capacidade)
VALUES ('Centro de Convenções', 1, 'Sala 1 - 2º Andar', 200),
       ('Teatro Municipal', 1, 'Setor A - Plateia', 500),
       ('Galeria de Arte Moderna', 1, 'Salão Principal', 100);

INSERT INTO organizador (CNPJ, nome, email, telefone)
VALUES ('12345678901234', 'EventoTech', 'contato@eventotech.com', '53987654321');

INSERT INTO categoriaEvento (nomeCategoriaEvento, descricao)
VALUES ('Palestra', 'Eventos de palestras e apresentações educacionais'),
       ('Concerto', 'Apresentações musicais ao vivo'),
       ('Exposição de Arte', 'Exibições de obras de arte e exposições');

INSERT INTO evento (titulo, dataHoraEvento, descricao, duracao, website, imagens, CNPJ, nomeCategoriaEvento, nomeLocal, IDendereco)
VALUES ('Palestra IA', '2023-10-15 18:30:00', 'Venha conhecer as aplicações da IA no mundo atual', 2, 'iaevent.com', 'https://www.tjto.jus.br/images/2023/08/17/eventogartnerhodirley.jpeg', '12345678901234', 'Palestra', 'Centro de Convenções', 1),
       ('Concerto de Música', '2023-11-20 19:00:00', 'Apresentação de músicas clássicas de renomados compositores', 3, 'concertoclassico.com', 'https://tribunadejundiai.com.br/wp-content/uploads/2023/08/orquestra-sinfonica-municipal-de-jundiai.jpg', '12345678901234', 'Concerto', 'Teatro Municipal', 1),
       ('Exposição de Arte', '2023-12-05 14:00:00', 'Explore uma variedade de obras de arte contemporânea', 4, 'artecontemporaneaexpo.com', 'https://ccs2.ufpel.edu.br/wp/wp-content/uploads/2023/04/Exposicao_Obras_restauradas_Palacio_Piratini_no_MALG_09_03_23-37-1.jpg', '12345678901234', 'Exposição de Arte', 'Galeria de Arte Moderna', 1);
