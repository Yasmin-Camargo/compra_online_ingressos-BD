<?php
include("conexao.php");
$conexao = conectarAoBanco();

// Obtém o valor do evento selecionado do POST
$eventoSelecionado = $_POST['eventoSelecionado'];

// Consulta SQL para buscar categorias de ingresso com base no evento
$sql = "SELECT i.IDingresso, i.numAssento, i.preco, ci.nomeCategoriaIngresso, e.titulo AS nomeEvento 
FROM ingresso AS i INNER JOIN categoriaIngresso AS ci ON i.nomeCategoriaIngresso = ci.nomeCategoriaIngresso 
INNER JOIN evento AS e ON i.IDevento = e.IDevento WHERE i.IDevento = :eventoSelecionado";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':eventoSelecionado', $eventoSelecionado, PDO::PARAM_STR);
$stmt->execute();

// Constrói as opções de categoria de ingresso
$options = '<option value="">Selecione uma categoria</option>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $options .= '<option value="' . $row['nomeCategoriaIngresso'] . '">' . $row['nomeCategoriaIngresso'] . '</option>';
}

// Consulta SQL para buscar cupons de desconto com base no evento
$sqlCupons = "SELECT cupom FROM cupons_desconto WHERE evento = :eventoSelecionado";
$stmtCupons = $pdo->prepare($sqlCupons);
$stmtCupons->bindParam(':eventoSelecionado', $eventoSelecionado, PDO::PARAM_STR);
$stmtCupons->execute();

// Constrói as opções de cupons de desconto
$cupons = '<option value="">Selecione um cupom de desconto</option>';
while ($row = $stmtCupons->fetch(PDO::FETCH_ASSOC)) {
    $cupons .= '<option value="' . $row['cupom'] . '">' . $row['cupom'] . '</option>';
}

// Retorna as opções de categoria de ingresso e cupons de desconto como JSON
echo json_encode(array('categorias' => $options, 'cupons' => $cupons));
?>
