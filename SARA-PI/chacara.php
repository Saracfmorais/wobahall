<?php
// Configurações de conexão
$host = 'localhost';
$user = 'root';          // Usuário padrão do XAMPP
$password = '';          // Senha padrão do XAMPP é vazia
$dbname = 'wobahall';     // Nome do banco de dados

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Seu código aqui para consultas e exibição

// Consulta para buscar chácaras
$sql = "SELECT 
            c.CHA_INT_ID,  -- Incluímos o ID da chácara para o link
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
<head>
    <meta charset="UTF-8">
    <title>Lista de Chácaras</title>
    <!-- Adicione estilos conforme necessário -->
</head>
<body>
    <?php while ($row = $result->fetch_assoc()): ?>
        <!-- Link para a página de detalhes envolvendo o card -->
        <a href="detalhes_chacara.php?id=<?php echo $row['CHA_INT_ID']; ?>" style="text-decoration: none; color: inherit;">
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
        </a>
    <?php endwhile; ?>
</body>
</html>

<?php
$conn->close();
?>
