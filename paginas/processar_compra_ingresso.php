<?php

// Obtém o valor do evento selecionado
$eventoSelecionado = $_POST['evento'];

// Consulta SQL para buscar categorias de ingresso com base no evento
$sql = "SELECT categoria FROM categorias WHERE evento = :evento";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':evento', $eventoSelecionado, PDO::PARAM_STR);
$stmt->execute();

// Constrói as opções de categoria de ingresso
$options = '<option value="">Selecione uma categoria</option>';
switch ($eventoSelecionado) {
    case 'Dua Lipa - Rock In Rio':
    case 'Dua Lipa - The Town':
        // Categorias comuns para os eventos da Dua Lipa
        $options .= '<option value="VIP">VIP</option>';
        $options .= '<option value="Normal">Normal</option>';
        $options .= '<option value="Meia Entrada">Meia Entrada</option>';
        break;

    case 'Workshop sobre Banco de Dados':
        // Categorias específicas para o Workshop de Banco de Dados
        $options .= '<option value="Normal Workshop">Normal Workshop</option>';
        $options .= '<option value="Professor Workshop">Professor Workshop</option>';
        break;
}

// Retorna as opções de categoria de ingresso
echo $options;
?>

<?php
// Conexão com o banco de dados (substitua com suas configurações)
$pdo = new PDO('mysql:host=seu_host;dbname=sua_base_de_dados', 'seu_usuario', 'sua_senha');

// Obtém o valor do evento selecionado do POST
$eventoSelecionado = $_POST['evento'];

// Consulta SQL para buscar categorias de ingresso com base no evento
$sql = "SELECT categoria FROM categorias WHERE evento = :evento";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':evento', $eventoSelecionado, PDO::PARAM_STR);
$stmt->execute();

// Constrói as opções de categoria de ingresso
$options = '<option value="">Selecione uma categoria</option>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $options .= '<option value="' . $row['categoria'] . '">' . $row['categoria'] . '</option>';
}

// Retorna as opções de categoria de ingresso
echo $options;
?>
