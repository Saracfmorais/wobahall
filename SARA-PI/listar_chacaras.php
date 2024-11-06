<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "usuario", "senha", "nome_do_banco");

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
session_start();
// Consulta as chácaras
$sql = "SELECT CHA_INT_ID, CHA_DEC_PRECO, CHA_INT_HOSPEDES, CHA_VAR_CAPA FROM chácara";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Chácaras</title>
</head>
<body>

<h1>Chácaras Disponíveis</h1>

<div class="chacaras-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="chacara-card">
            <img src="<?php echo $row['CHA_VAR_CAPA']; ?>" alt="Capa da Chácara">
            <p>Preço: R$ <?php echo number_format($row['CHA_DEC_PRECO'], 2, ',', '.'); ?></p>
            <p>Hóspedes: <?php echo $row['CHA_INT_HOSPEDES']; ?></p>
            <!-- Link para a página de detalhes -->
            <a href="detalhes_chacara.php?id=<?php echo $row['CHA_INT_ID']; ?>">Ver detalhes</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>
