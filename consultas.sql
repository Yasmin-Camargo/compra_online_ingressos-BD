-- CONSULTAS QUE PODEM SER REALIZADAS EM NOSSO BANCO DE DADOS --
set search_path to plataformaCompraOnlineIngressos;

-- Recuperar nome e senha de um usuário (login)
SELECT nome, senha
FROM usuario
WHERE email = 'yasmincamargo@example.com';

-- Listar todos eventos (index)
SELECT evento.idevento, evento.titulo, evento.descricao, 
    evento.nomelocal, evento.duracao, evento.datahoraevento, 
    evento.imagens, endereco.rua, endereco.numero, endereco.cidade, 
    endereco.cep, AVG(avalia.nota) AS media_avaliacao
FROM plataformaCompraOnlineIngressos.evento
    JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco
    LEFT JOIN plataformaCompraOnlineIngressos.avalia ON evento.IDevento = avalia.IDevento
GROUP BY evento.titulo, evento.idevento, evento.descricao, evento.nomelocal, evento.duracao, evento.datahoraevento, evento.imagens, endereco.rua, endereco.numero, endereco.cidade, endereco.cep;

-- Quantidade de favoritos de um evento (index)
SELECT COUNT(*) AS numero_de_favoritos
FROM plataformaCompraOnlineIngressos.favorita
WHERE idevento = 1;

-- Todos eventos favoritos de um usuário (index)
SELECT evento.titulo, evento.descricao, evento.nomelocal, evento.duracao, 
    evento.datahoraevento, evento.imagens, endereco.rua, endereco.numero, 
    endereco.cidade, endereco.cep
FROM plataformaCompraOnlineIngressos.evento
    JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco
    JOIN plataformaCompraOnlineIngressos.favorita ON evento.idevento = favorita.idevento
WHERE favorita.cpf = '98765432109';

-- Buscar eventos -> titulo, descricao, local, categoria (pesquisa)
SELECT evento.titulo, evento.descricao, evento.nomelocal, evento.duracao, evento.datahoraevento, evento.imagens, endereco.rua, endereco.numero, endereco.cidade, endereco.cep 
FROM plataformaCompraOnlineIngressos.evento
    JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco
WHERE evento.titulo LIKE '%Show%' 
    OR evento.descricao LIKE '%Show%'  
    OR evento.nomelocal LIKE '%Show%'  
    OR evento.nomeCategoriaEvento LIKE '%Show%';

-- Mostrar informações do usuário (usuario)
SELECT usuario.nome, usuario.senha, usuario.email, endereco.rua, endereco.numero, endereco.cidade, endereco.cep 
FROM plataformaCompraOnlineIngressos.usuario, plataformaCompraOnlineIngressos.endereco 
WHERE cpf = '25478963451' AND usuario.idendereco = endereco.idendereco;

-- Recuperar informações detalhadas sobre compras de ingressos (compra_ingressos)
SELECT usuario.nome, usuario.cpf,
	compra.notaFiscal, compra.valorfinal, compra.datahoracompra,
    evento.titulo, evento.descricao, evento.precobase,
    localevento.nomelocal,
	ingresso.idingresso, ingresso.preco, ingresso.numassento,
	categoriaingresso.nomecategoriaingresso, categoriaingresso.desconto,
	cupomdesconto.codigodesconto, cupomdesconto.percentualdesconto
FROM plataformaCompraOnlineIngressos.usuario JOIN plataformaCompraOnlineIngressos.carrinhocompras ON usuario.cpf = carrinhocompras.cpf
    JOIN plataformaCompraOnlineIngressos.ingresso ON carrinhocompras.idcarrinhocompras = ingresso.idcarrinhocompras
    JOIN plataformaCompraOnlineIngressos.evento ON ingresso.idevento = evento.idevento
    JOIN plataformaCompraOnlineIngressos.categoriaingresso ON  ingresso.nomecategoriaingresso = categoriaingresso.nomecategoriaingresso
    JOIN plataformaCompraOnlineIngressos.compra ON carrinhocompras.idcarrinhocompras = compra.idcarrinhocompras
    LEFT JOIN plataformaCompraOnlineIngressos.cupomdesconto ON compra.codigodesconto = cupomdesconto.codigoDesconto
    JOIN plataformaCompraOnlineIngressos.localevento ON evento.nomelocal = localevento.nomelocal
    JOIN plataformaCompraOnlineIngressos.endereco ON endereco.idendereco = localevento.idendereco
ORDER BY nome;

-- Consultar quantidade de ingressos que um usuário já comprou até o momento por evento (compra_ingressos)
SELECT nome, titulo, COUNT(ingresso.IDingresso) AS quantidadeDeIngressos
FROM usuario
    JOIN carrinhoCompras ON usuario.CPF = carrinhoCompras.CPF
    JOIN compra ON carrinhoCompras.IDcarrinhoCompras = compra.IDcarrinhoCompras
    JOIN ingresso ON carrinhoCompras.IDcarrinhoCompras = ingresso.IDcarrinhoCompras
    JOIN evento ON ingresso.IDevento = evento.IDevento
WHERE usuario.cpf = '98765432109'
GROUP BY (nome, titulo);

-- Alterar dados do usuário: nome e senha (atualizar_usuario)
UPDATE usuario
SET nome = 'Bianca Dullius', senha = '1234'
WHERE cpf = '25478963451';

-- Alterar endereço de um usuário (atualizar_usuario)
UPDATE endereco
SET rua= 'Dom Pedro', numero = 122, cidade = 'Pelotas', CEP = '96015000'
WHERE idendereco IN (
	SELECT idendereco
	FROM usuario
	WHERE cpf = '25478963451'
);

-- Atualizar os dados do evento (atualizar_evento)
UPDATE plataformaCompraOnlineIngressos.evento 
SET titulo = 'Palestra IA - 2 LOTE', datahoraevento = '2023-12-27 21:00:00',
    nomelocal = 'Centro de Convenções', descricao = 'Nova oportunidade, não perca',
    duracao = 2, classificacao = 'Livre',
    nomecategoriaevento = 'Palestra',
    website = 'iaevent.com'
WHERE cnpj='12345678901234' AND idevento=4;

-- Atualizar o endereço de um evento (atualizar_evento)
UPDATE plataformaCompraOnlineIngressos.endereco 
SET rua = 'Centro de Eventos Fenadoce', 
    numero = '22', 
    cidade = 'Pelotas', 
    CEP = '96015000'
WHERE IDendereco IN (
    SELECT evento.IDendereco 
    FROM plataformaCompraOnlineIngressos.evento 
    WHERE evento.cnpj = '12345678901234' AND idevento=4
);

-- Consultar eventos relacionados a um Organizador especifico (consultar_eventos)
SELECT evento.titulo, evento.datahoraevento,
    evento.descricao, evento.duracao, evento.classificacao,
    evento.website, evento.nomecategoriaevento,
    evento.nomelocal, 
    endereco.rua, endereco.numero, endereco.cidade, 
    endereco.cep
FROM plataformaCompraOnlineIngressos.evento
    INNER JOIN plataformaCompraOnlineIngressos.organizador ON evento.cnpj = organizador.cnpj
    INNER JOIN plataformaCompraOnlineIngressos.endereco ON evento.idendereco = endereco.idendereco
WHERE organizador.cnpj = '12345678901234';

-- Consultar informações de um organizador (login_organizadores)
SELECT cnpj, email, telefone, nome
FROM plataformaCompraOnlineIngressos.organizador 
WHERE cnpj = '12345678901234';

-- Filtrar evento por  titulo
SELECT titulo
FROM evento
    JOIN categoriaEvento ON evento.nomeCategoriaEvento = categoriaevento.nomeCategoriaEvento 
WHERE categoriaEvento.nomeCategoriaEvento = 'Show';

-- Filtrar evento por data
SELECT titulo
FROM evento
WHERE date(datahoraevento) = '2023-09-27';

-- Filtrar evento por  mes/ano
SELECT titulo
FROM evento
WHERE EXTRACT(YEAR FROM datahoraevento) = 2023 AND EXTRACT(MONTH FROM datahoraevento) = 9;

-- Filtrar evento por local
SELECT titulo
FROM evento
JOIN localevento ON evento.nomeLocal = localevento.nomeLocal
WHERE localevento.IDendereco = evento.IDendereco AND evento.nomeLocal = 'Campus Anglo';

-- Consultar todos cupons de desconto ativos
SELECT * 
FROM cupomdesconto
WHERE CURRENT_TIMESTAMP BETWEEN dataInicio AND dataTermino;

--Consultar histórico de compras  
SELECT nome, dataHoraCompra, valorFinal 
FROM usuario
    JOIN carrinhoCompras ON usuario.CPF = carrinhoCompras.CPF
    JOIN compra ON carrinhoCompras.IDcarrinhoCompras = compra.IDcarrinhoCompras
WHERE usuario.cpf = '98765432109';