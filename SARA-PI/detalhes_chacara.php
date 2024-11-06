<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");  // Redireciona para a página de login se não estiver logado
    exit();
}

// Conectar ao banco de dados
$host = 'localhost';    
$user = 'root';
$password = '';
$dbname = 'wobahall';
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verificar se o ID da chácara foi passado pela URL
if (isset($_GET['id'])) {
    $chacara_id = (int)$_GET['id'];
    
    // Consulta para buscar os detalhes da chácara, incluindo endereço e dados do usuário
    $sql = "SELECT 
                c.CHA_VAR_CAPA,
                c.CHA_DEC_PRECO,
                c.CHA_INT_HOSPEDES,
                c.CHA_INT_QUARTOS,
                c.CHA_INT_BANHEIROS,
                c.CHA_TXT_INFO_ADICIONAIS,
                c.CHA_DEC_AVALIACAO_MEDIA,
                c.CHA_DEC_TAMANHO,
                c.CHA_DAT_CRIADO,
                u.USU_VAR_NOME,
                u.USU_VAR_EMAIL,
                e.END_VAR_RUA,
                e.END_VAR_NUMERO,
                e.END_VAR_BAIRRO,
                e.END_VAR_CIDADE,
                e.END_VAR_ESTADO,
                e.END_VAR_COMPLEMENTO
            FROM chacaras c
            JOIN usuarios u ON c.CHA_INT_USUARIO_ID = u.USU_INT_ID
            JOIN enderecos e ON c.CHA_INT_ENDERECO_ID = e.END_INT_ID
            WHERE c.CHA_INT_ID = ?";
    
    // Preparar a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $chacara_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se a chácara foi encontrada
    if ($result->num_rows > 0) {
        $chacara = $result->fetch_assoc();
    } else {
        die("Chácara não encontrada.");
    }
} else {
    die("ID da chácara não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Chácara</title>
</head>
<body>

<h1>Detalhes da Chácara</h1>

<div class="chacara-detalhes">
    <img src="<?php echo $chacara['CHA_VAR_CAPA']; ?>" alt="Capa da Chácara" class="chacara-img">
    <p><strong>Preço:</strong> R$ <?php echo number_format($chacara['CHA_DEC_PRECO'], 2, ',', '.'); ?> por diária</p>
    <p><strong>Hóspedes:</strong> <?php echo $chacara['CHA_INT_HOSPEDES']; ?></p>
    <p><strong>Quartos:</strong> <?php echo $chacara['CHA_INT_QUARTOS']; ?></p>
    <p><strong>Banheiros:</strong> <?php echo $chacara['CHA_INT_BANHEIROS']; ?></p>
    <p><strong>Informações Adicionais:</strong> <?php echo $chacara['CHA_TXT_INFO_ADICIONAIS']; ?></p>
    <p><strong>Avaliação Média:</strong> <?php echo $chacara['CHA_DEC_AVALIACAO_MEDIA']; ?></p>
    <p><strong>Tamanho:</strong> <?php echo $chacara['CHA_DEC_TAMANHO']; ?> m²</p>
    <p><strong>Data de Criação:</strong> <?php echo date('d/m/Y', strtotime($chacara['CHA_DAT_CRIADO'])); ?></p>
    
    <h2>Endereço</h2>
    <p><?php echo $chacara['END_VAR_RUA'] . ", " . $chacara['END_VAR_NUMERO']; ?></p>
    <p><?php echo $chacara['END_VAR_BAIRRO'] . ", " . $chacara['END_VAR_CIDADE'] . " - " . $chacara['END_VAR_ESTADO']; ?></p>
    <p><?php echo $chacara['END_VAR_COMPLEMENTO']; ?></p>

    <h2>Proprietário</h2>
    <p><strong>Nome:</strong> <?php echo $chacara['USU_VAR_NOME']; ?></p>
    <p><strong>Email:</strong> <?php echo $chacara['USU_VAR_EMAIL']; ?></p>
</div>

</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
