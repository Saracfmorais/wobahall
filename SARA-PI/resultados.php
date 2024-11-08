<?php
// Supondo que as datas de check-in e checkout foram recebidas via GET
$data_inicio = $_GET['data_inicio'];
$data_fim = $_GET['data_fim'];

// Conectar ao banco de dados para buscar chácaras disponíveis
$conn = new mysqli($host, $user, $password, $dbname);

$sql = "SELECT c.CHA_INT_ID, c.CHA_VAR_NOME, c.CHA_DEC_PRECO 
        FROM chacaras c
        JOIN disponibilidade_chacara d ON c.CHA_INT_ID = d.CHA_INT_ID
        WHERE d.DISP_DAT_INICIO <= ? 
          AND d.DISP_DAT_FIM >= ? 
          AND d.DISP_BOOL_DISPONIVEL = TRUE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $data_inicio, $data_fim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='chacara'>";
        echo "<h2>" . $row['CHA_VAR_NOME'] . "</h2>";
        echo "<p>Preço: R$ " . number_format($row['CHA_DEC_PRECO'], 2, ',', '.') . "</p>";
        echo "</div>";
    }
} else {
    echo "Nenhuma chácara disponível para as datas selecionadas.";
}

$conn->close();
?>
