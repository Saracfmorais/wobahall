<?php
// Conectar ao banco de dados
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

// Consulta para buscar chácaras
$sql = "SELECT 
            c.CHA_VAR_CAPA,
            e.END_VAR_BAIRRO,
            e.END_VAR_CIDADE,
            c.CHA_INT_HOSPEDES,
            c.CHA_INT_QUARTOS,
            c.CHA_INT_BANHEIROS,
            c.CHA_DEC_PRECO
        FROM chacaras c
        JOIN enderecos e ON c.CHA_INT_ENDERECO_ID = e.END_INT_ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
   
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?php echo $row['CHA_VAR_CAPA']; ?>" alt="Imagem da Chácara" class="card-img">
                <h3><?php echo $row['END_VAR_BAIRRO'] . ", " . $row['END_VAR_CIDADE']; ?></h3>
                <p>
                    <?php echo $row['CHA_INT_HOSPEDES']; ?> hóspedes 
                    <?php echo $row['CHA_INT_QUARTOS']; ?> quartos 
                    <?php echo $row['CHA_INT_BANHEIROS']; ?> banheiros<br>
                    <?php echo $row['CHA_DEC_PRECO']; ?>m² construídos
                </p>
                <div class="faixa-botoes">
                    <button class="fav-btn"><i class="fa-regular fa-heart"></i></button>
                    <div class="card-preco">R$<?php echo $row['CHA_DEC_PRECO']; ?> diária</div>
                </div>
            </div>
        <?php endwhile; ?>
    
</html>
