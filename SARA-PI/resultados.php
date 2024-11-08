<?php
session_start();

// Conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'wobahall';
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Capturar os parâmetros de filtro
$cidade = $_GET['cidade'] ?? '';
$data_inicio = $_GET['data_inicio'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';
$hospedes = $_GET['hospedes'] ?? '';

// Montar a consulta SQL com filtros
$sql = "SELECT c.*, e.END_VAR_CIDADE FROM chacaras c 
        JOIN enderecos e ON c.CHA_INT_ENDERECO_ID = e.END_INT_ID
        WHERE 1=1";

if (!empty($cidade)) {
    $sql .= " AND e.END_VAR_CIDADE = '$cidade'";
}
if (!empty($hospedes)) {
    $sql .= " AND c.CHA_INT_HOSPEDES >= $hospedes";
}

// Consultar os resultados no banco de dados
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Pesquisa</title>
</head>
<body>
    <h1>Resultados da Pesquisa</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <h3><?php echo $row['END_VAR_CIDADE']; ?></h3>
                <p><?php echo $row['CHA_INT_HOSPEDES']; ?> hóspedes, <?php echo $row['CHA_INT_QUARTOS']; ?> quartos</p>
                <p>Preço: R$ <?php echo $row['CHA_DEC_PRECO']; ?> por diária</p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nenhuma chácara encontrada para os critérios de pesquisa.</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
